<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\MessageSent;
use App\Events\MessagesRead;
use App\Http\Resources\MessageResource;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Отображает список чатов, доступных пользователю.
     */
    public function index()
    {
        $title_site = "Чаты | Личный кабинет Экспресс-дизайн";
        $user = Auth::user();
        $userId = $user->id;
    
        $chats = collect();
    
        /***********************************************
         * 1) Групповые чаты
         ***********************************************/
        $groupChats = collect();
    
        switch ($user->status) {
            case 'admin':
                // Админ видит все групповые чаты с выборкой последних 50 сообщений
                $groupChats = Chat::where('type', 'group')
                    ->with([
                        'messages' => fn($q) => $q->orderBy('created_at', 'desc')->limit(50),
                        'users',
                    ])
                    ->get();
                break;
    
            case 'coordinator':
            case 'user':
                // coordinator/user видят групповые чаты, в которых они состоят
                $groupChats = Chat::where('type', 'group')
                    ->whereHas('users', fn($q) => $q->where('users.id', $userId))
                    ->with([
                        'messages' => fn($q) => $q->orderBy('created_at', 'desc')->limit(50),
                        'users',
                    ])
                    ->get();
                break;
    
            case 'support':
                // support – групповые чаты не показываем
                break;
        }
    
        // Формирование данных для каждого группового чата
        foreach ($groupChats as $chat) {
            $pivotData   = $chat->users->find($userId)?->pivot;
            $lastReadAt  = $pivotData?->last_read_at;
            $unreadCount = 0;
    
            if ($lastReadAt) {
                $unreadCount = $chat->messages->where('created_at', '>', $lastReadAt)->count();
            } else {
                $unreadCount = $user->status === 'admin' ? 0 : $chat->messages->count();
            }
    
            $lastMessage = $chat->messages->first();
    
            $chats->push([
                'id'                => $chat->id,
                'type'              => 'group',
                'name'              => $chat->name,
                'avatar_url'        => $chat->avatar_url,
                'unread_count'      => $unreadCount,
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
            ]);
        }
    
        /***********************************************
         * 2) Личные чаты
         ***********************************************/
        $personalUsers = collect();
    
        switch ($user->status) {
            case 'admin':
            case 'coordinator':
                $personalUsers = User::where('id', '<>', $userId)
                    ->where('status', '<>', 'user')
                    ->with([
                        'chats' => fn($q) => $q->where('type', 'personal'),
                    ])
                    ->get();
                break;
    
            case 'support':
                $personalUsers = User::where('id', '<>', $userId)
                    ->with([
                        'chats' => fn($q) => $q->where('type', 'personal'),
                    ])
                    ->get();
                break;
    
            case 'user':
                $relatedDealIds = $user->deals()->pluck('deals.id');
                $personalUsers = User::whereIn('status', ['support', 'coordinator'])
                    ->whereHas('deals', fn($q) => $q->whereIn('deals.id', $relatedDealIds))
                    ->where('id', '<>', $userId)
                    ->with([
                        'chats' => fn($q) => $q->where('type', 'personal')
                    ])
                    ->get();
                break;
        }
    
        // Преобразуем пользователей в данные для отображения чата
        foreach ($personalUsers as $chatUser) {
            $unreadCount = Message::where('sender_id', $chatUser->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
    
            $lastMessage = Message::where(function ($query) use ($chatUser, $userId) {
                    $query->where('sender_id', $userId)
                          ->where('receiver_id', $chatUser->id);
                })
                ->orWhere(function ($query) use ($chatUser, $userId) {
                    $query->where('sender_id', $chatUser->id)
                          ->where('receiver_id', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->first();
    
            $chats->push([
                'id'                => $chatUser->id,
                'type'              => 'personal',
                'name'              => $chatUser->name,
                'avatar_url'        => $chatUser->avatar_url,
                'unread_count'      => $unreadCount,
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
            ]);
        }
    
        // Сортировка чатов: сначала с непрочитанными, затем по дате последнего сообщения
        $chats = $chats->sortByDesc(function ($chat) {
            return $chat['unread_count'] > 0 ? 1 : 0;
        })->sortByDesc('last_message_time')->values();
    
        return view('chats', compact('chats', 'user', 'title_site'));
    }
    

    /**
     * Загружает сообщения для указанного чата.
     * Для оптимизации выбирается только 50 последних сообщений.
     */
    public function chatMessages($type, $id)
    {
        $currentUserId = Auth::id();

        if (!in_array($type, ['personal', 'group'])) {
            return response()->json(['error' => 'Invalid chat type provided.'], 400);
        }

        try {
            if ($type === 'personal') {
                $recipient = User::findOrFail($id);

                $messages = Message::where(function ($query) use ($recipient, $currentUserId) {
                        $query->where('sender_id', $currentUserId)
                              ->where('receiver_id', $recipient->id);
                    })
                    ->orWhere(function ($query) use ($recipient, $currentUserId) {
                        $query->where('sender_id', $recipient->id)
                              ->where('receiver_id', $currentUserId);
                    })
                    ->orderBy('created_at', 'desc')
                    ->limit(50) // Ограничение выборки последних 50 сообщений
                    ->get()
                    ->reverse(); // Инвертируем порядок для показа от старых к новым

                // Помечаем сообщения как прочитанные
                Message::where('sender_id', $recipient->id)
                    ->where('receiver_id', $currentUserId)
                    ->whereNull('read_at')
                    ->update(['is_read' => true, 'read_at' => now()]);

            } else { // group
                $chat = Chat::where('type', 'group')->findOrFail($id);

                if (!$chat->users->contains($currentUserId)) {
                    return response()->json(['error' => 'You are not a member of this group chat.'], 403);
                }

                $messages = $chat->messages()
                    ->with('sender')
                    ->orderBy('created_at', 'desc')
                    ->limit(50)
                    ->get()
                    ->reverse();

                Message::where('chat_id', $chat->id)
                    ->where('sender_id', '!=', $currentUserId)
                    ->whereNull('read_at')
                    ->update(['is_read' => true, 'read_at' => now()]);
            }

            // Добавляем имя отправителя для каждого сообщения
            $messages->each(function ($message) {
                $message->sender_name = optional($message->sender)->name ?? 'Unknown';
            });
            $formattedMessages = MessageResource::collection($messages);

            return response()->json([
                'current_user_id' => $currentUserId,
                'messages'        => $formattedMessages,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in chatMessages:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Отправляет сообщение в указанный чат.
     */
    public function sendMessage(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        if (!in_array($type, ['personal', 'group'])) {
            return response()->json(['error' => 'Invalid chat type provided.'], 400);
        }

        $currentUserId = Auth::id();

        try {
            if ($type === 'personal') {
                $receiver = User::findOrFail($id);

                $message = Message::create([
                    'sender_id'   => $currentUserId,
                    'receiver_id' => $receiver->id,
                    'message'     => $validated['message'],
                ]);

                broadcast(new MessageSent($message))->toOthers();

            } else { // group
                $chat = Chat::where('type', 'group')->findOrFail($id);

                if (!$chat->users->contains($currentUserId)) {
                    return response()->json(['error' => 'You are not a member of this group chat.'], 403);
                }

                $message = Message::create([
                    'sender_id' => $currentUserId,
                    'chat_id'   => $chat->id,
                    'message'   => $validated['message'],
                ]);
                broadcast(new MessageSent($message))->toOthers();
            }

            $message->sender_name = optional($message->sender)->name ?? 'Unknown';

            return response()->json(['message' => $message], 201);
        } catch (\Exception $e) {
            Log::error('Error in sendMessage:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Возвращает новые сообщения, у которых id больше, чем указанный.
     * Это позволяет передавать только разницу (дельта-запрос).
     */
    public function getNewMessages(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'last_message_id' => 'nullable|integer',
        ]);

        if (!in_array($type, ['personal', 'group'])) {
            return response()->json(['error' => 'Invalid chat type provided.'], 400);
        }

        $currentUserId = Auth::id();
        $lastMessageId = $validated['last_message_id'] ?? 0;

        try {
            if ($type === 'personal') {
                $otherUser = User::findOrFail($id);

                $query = Message::where(function ($q) use ($otherUser, $currentUserId) {
                        $q->where('sender_id', $currentUserId)
                          ->where('receiver_id', $otherUser->id);
                    })
                    ->orWhere(function ($q) use ($otherUser, $currentUserId) {
                        $q->where('sender_id', $otherUser->id)
                          ->where('receiver_id', $currentUserId);
                    });
            } else { // group
                $chat = Chat::where('type', 'group')->findOrFail($id);
                if (!$chat->users->contains($currentUserId)) {
                    return response()->json(['error' => 'You are not a member of this group chat.'], 403);
                }

                $query = Message::where('chat_id', $chat->id);
            }

            if ($lastMessageId) {
                $query->where('id', '>', $lastMessageId);
            }

            $newMessages = $query->orderBy('created_at', 'asc')
                ->with('sender')
                ->get();

            $newMessages->each(function ($message) {
                $message->sender_name = optional($message->sender)->name;
            });

            return response()->json([
                'current_user_id' => $currentUserId,
                'messages'        => $newMessages,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in getNewMessages:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Возвращает количество непрочитанных сообщений по личным и групповым чатам.
     */
    public function getUnreadCounts()
    {
        try {
            $userId = Auth::id();

            $personalUnread = Message::where('receiver_id', $userId)
                ->where('is_read', false)
                ->groupBy('sender_id')
                ->select('sender_id', DB::raw('count(*) as unread_count'))
                ->pluck('unread_count', 'sender_id');

            $groupUnread = Message::whereHas('chat.users', fn($query) => $query->where('users.id', $userId))
                ->whereNotNull('chat_id')
                ->with(['chat' => fn($query) => $query->whereHas('users', fn($q) => $q->where('users.id', $userId))])
                ->get()
                ->groupBy('chat_id')
                ->map(function ($messages, $chatId) use ($userId) {
                    $lastReadAt = Chat::find($chatId)->users->find($userId)->pivot->last_read_at ?? null;
                    return $messages->where('created_at', '>', $lastReadAt)->count();
                });

            return response()->json([
                'personal' => $personalUnread,
                'group'    => $groupUnread,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in getUnreadCounts:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    
    /**
     * Помечает сообщения как прочитанные.
     * Для группового чата дополнительно обновляется поле last_read_at в pivot-таблице.
     */
    public function markMessagesAsRead($type, $id)
    {
        $userId = Auth::id();
    
        if (!in_array($type, ['personal', 'group'])) {
            return response()->json(['error' => 'Некорректный тип чата.'], 400);
        }
    
        DB::beginTransaction();
    
        try {
            if ($type === 'personal') {
                $otherUser = User::findOrFail($id);
    
                Message::where('sender_id', $otherUser->id)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->update(['is_read' => true, 'read_at' => now()]);
    
            } else { // group
                $chat = Chat::where('type', 'group')->findOrFail($id);
                
                if (!$chat->users->contains($userId)) {
                    return response()->json(['error' => 'Вы не являетесь участником данного чата.'], 403);
                }
    
                Message::where('chat_id', $chat->id)
                    ->where('sender_id', '!=', $userId)
                    ->where('is_read', false)
                    ->update(['is_read' => true, 'read_at' => now()]);
    
                DB::table('chat_user')
                    ->where('chat_id', $chat->id)
                    ->where('user_id', $userId)
                    ->update(['last_read_at' => now()]);
            }
    
            event(new MessagesRead($id, $userId, $type));
    
            DB::commit();
    
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка при пометке сообщений как прочитанных:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Внутренняя ошибка сервера.'], 500);
        }
    }
    
    /**
     * Возвращает все чаты пользователя (и групповые, и личные).
     */
    public function getUserChats($userId = null)
    {
        if (!$userId) {
            $userId = Auth::id();
        }
        $user = User::find($userId);

        if (!$user) {
            return collect();
        }

        $groupChats = Chat::where('type', 'group')
            ->whereHas('users', fn($query) => $query->where('users.id', $userId))
            ->with(['messages' => fn($query) => $query->orderBy('created_at', 'desc')->limit(50), 'users'])
            ->get();

        if ($user->status === 'user') {
            $relatedDealIds = $user->deals()->pluck('deals.id');
            $personalChats = User::whereIn('status', ['support', 'coordinator'])
                ->whereHas('deals', fn($query) => $query->whereIn('deals.id', $relatedDealIds))
                ->where('id', '<>', $userId)
                ->with(['chats' => fn($query) => $query->where('type', 'personal')])
                ->get();
        } else {
            $personalChats = User::where('id', '<>', $userId)
                ->with(['chats' => fn($query) => $query->where('type', 'personal')])
                ->get();
        }

        $chats = collect();

        foreach ($groupChats as $chat) {
            $lastReadAt = $chat->users->find($userId)->pivot->last_read_at ?? null;
            $unreadCount = $chat->messages->where('created_at', '>', $lastReadAt)->count();
            $lastMessage = $chat->messages->first();
    
            $chats->push([
                'id'                => $chat->id,
                'type'              => 'group',
                'name'              => $chat->name,
                'avatar_url'        => $chat->avatar_url,
                'unread_count'      => $unreadCount,
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
            ]);
        }
    
        foreach ($personalChats as $chatUser) {
            $unreadCount = Message::where('sender_id', $chatUser->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
    
            $lastMessage = Message::where(function ($query) use ($chatUser, $userId) {
                    $query->where('sender_id', $userId)
                          ->where('receiver_id', $chatUser->id);
                })
                ->orWhere(function ($query) use ($chatUser, $userId) {
                    $query->where('sender_id', $chatUser->id)
                          ->where('receiver_id', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->first();
    
            $chats->push([
                'id'                => $chatUser->id,
                'type'              => 'personal',
                'name'              => $chatUser->name,
                'avatar_url'        => $chatUser->avatar_url,
                'unread_count'      => $unreadCount,
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
            ]);
        }
    
        $sorted = $chats->sortByDesc(function ($chat) {
            return $chat['unread_count'] > 0 ? 1 : 0;
        })->sortByDesc('last_message_time')->values();
    
        return $sorted;
    }
}
