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
     * Display the list of chats available to the user.
     */
    public function index()
    {
        $title_site = "Чаты | Личный кабинет Экспресс-дизайн";
        $user = Auth::user();
        $userId = $user->id;
    
        // Пустая коллекция для дальнейшего наполнения
        $chats = collect();
    
        /***********************************************
         * 1) ГРУППОВЫЕ ЧАТЫ
         ***********************************************/
        $groupChats = collect();
    
        switch ($user->status) {
            case 'admin':
                // Админ видит все групповые чаты
                $groupChats = Chat::where('type', 'group')
                    ->with([
                        'messages' => fn($q) => $q->orderBy('created_at', 'desc'),
                        'users',
                    ])
                    ->get();
                break;
    
            case 'coordinator':
            case 'user':
                // coordinator/user видит только групповые чаты, где он(а) состоит
                $groupChats = Chat::where('type', 'group')
                    ->whereHas('users', fn($q) => $q->where('users.id', $userId))
                    ->with([
                        'messages' => fn($q) => $q->orderBy('created_at', 'desc'),
                        'users',
                    ])
                    ->get();
                break;
    
            case 'support':
                // support — групповые чаты НЕ показываем (по заданию)
                break;
        }
    
        // Обрабатываем (подсчитываем непрочитанные, время последнего сообщения и т.д.)
        foreach ($groupChats as $chat) {
            // Для admin тоже хотим считать непрочитанные? 
            // Если admin не состоит в чате, pivot может отсутствовать,
            // но в условии "admin все group" — решите, нужно ли считать unread.
            // Предположим, если admin не в pivot, last_read_at = null => всё будет "непрочитанное".
            $pivotData   = $chat->users->find($userId)?->pivot;
            $lastReadAt  = $pivotData?->last_read_at; // может быть null
            $unreadCount = 0;
    
            if ($lastReadAt) {
                $unreadCount = $chat->messages->where('created_at', '>', $lastReadAt)->count();
            } else {
                // если вообще нет pivot (admin) — считаем все? Или 0?
                $unreadCount = $user->status === 'admin'
                    ? 0 // Допустим, админу не имеет смысла считать непрочитанные, если он не состоит в чате
                    : $chat->messages->count();
            }
    
            $lastMessage = $chat->messages->first(); // самое новое сообщение (DESC)
    
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
         * 2) ЛИЧНЫЕ ЧАТЫ
         ***********************************************/
        // Будем собирать в коллекцию объекты User, а потом "превращать" их в массив чата,
        // как в вашем исходном коде, чтобы всё было единообразно.
        $personalUsers = collect();
    
        switch ($user->status) {
            case 'admin':
            case 'coordinator':
                // Личные чаты только с теми пользователями, у которых status != 'user'
                // (и исключая самого себя)
                $personalUsers = User::where('id', '<>', $userId)
                    ->where('status', '<>', 'user')
                    ->with([
                        'chats' => fn($q) => $q->where('type', 'personal'),
                    ])
                    ->get();
                break;
    
            case 'support':
                // Показываем все личные чаты, где support участвует.
                // Т.е. нам нужно получить всех пользователей, с кем у support есть personal-чат.
                // Проще всего получить вообще всех, кроме себя, 
                // и дальше уже при выводе проверять, есть ли хоть одно личное сообщение?
                // Или же можно жёстко: "все personal, где sender_id = supportId OR receiver_id = supportId".
                // Пример (как у вас изначально):
                $personalUsers = User::where('id', '<>', $userId)
                    ->with([
                        'chats' => fn($q) => $q->where('type', 'personal'),
                    ])
                    ->get();
                break;
    
            case 'user':
                // (ваша старая логика) — личные чаты со 'support' или 'coordinator', связанными с его сделками
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
    
        // Превращаем $personalUsers в итоговые данные для $chats
        foreach ($personalUsers as $chatUser) {
            // Подсчёт непрочитанных
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
    
        /***********************************************
         * 3) СОРТИРОВКА
         * Сначала непрочитанные (desc), потом по дате
         ***********************************************/
        $chats = $chats->sortByDesc(function ($chat) {
            return $chat['unread_count'] > 0 ? 1 : 0;
        })->sortByDesc('last_message_time')->values();
    
        return view('chats', compact('chats', 'user', 'title_site'));
    }
    

    /**
     * Fetch all messages for a specific chat.
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
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Mark messages as read
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
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Mark messages as read
                Message::where('chat_id', $chat->id)
                    ->where('sender_id', '!=', $currentUserId)
                    ->whereNull('read_at')
                    ->update(['is_read' => true, 'read_at' => now()]);
            }

            // Add sender's name
            $messages->each(function ($message) {
                $message->sender_name = optional($message->sender)->name ?? 'Unknown';
            });
            $formattedMessages = MessageResource::collection($messages);

            return response()->json([
                'current_user_id' => $currentUserId,
                'messages'        => $formattedMessages,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in chatMessages:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Send a message to a specific chat.
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

                // Create personal message
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

            // Add sender's name
            $message->sender_name = optional($message->sender)->name ?? 'Unknown';

            return response()->json(['message' => $message], 201);
        } catch (\Exception $e) {
            Log::error('Error in sendMessage:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Fetch new messages after a specific message ID.
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

            // Add sender's name
            $newMessages->each(function ($message) {
                $message->sender_name = optional($message->sender)->name;
            });

            return response()->json([
                'current_user_id' => $currentUserId,
                'messages'        => $newMessages,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in getNewMessages:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Get unread message counts for all chats.
     */
    public function getUnreadCounts()
    {
        try {
            $userId = Auth::id();

            // Personal chats: group by sender_id
            $personalUnread = Message::where('receiver_id', $userId)
                ->where('is_read', false)
                ->groupBy('sender_id')
                ->select('sender_id', DB::raw('count(*) as unread_count'))
                ->pluck('unread_count', 'sender_id');

            // Group chats: get unread counts based on last_read_at
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
            Log::error('Error in getUnreadCounts:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    
    /**
     * Пометить сообщения как прочитанные
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
    
                // Обновление поля last_read_at в pivot-таблице
                DB::table('chat_user')
                    ->where('chat_id', $chat->id)
                    ->where('user_id', $userId)
                    ->update(['last_read_at' => now()]);
            }
    
            // Вызов события с тремя аргументами
            event(new MessagesRead($id, $userId, $type));
    
            DB::commit();
    
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка при пометке сообщений как прочитанных:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Внутренняя ошибка сервера.'], 500);
        }
    }
    // App\Http\Controllers\ChatController.php

public function getUserChats($userId = null)
{
    if (!$userId) {
        $userId = Auth::id();
    }
    $user = User::find($userId);

    if (!$user) {
        return collect();
    }

    // 1. Получаем групповые чаты
    $groupChats = Chat::where('type', 'group')
        ->whereHas('users', fn($query) => $query->where('users.id', $userId))
        ->with(['messages' => fn($query) => $query->orderBy('created_at', 'desc'), 'users'])
        ->get();

    // 2. Получаем персональные чаты
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

    // 3. Собираем воедино
    $chats = collect();

    // а) Групповые
    foreach ($groupChats as $chat) {
        $lastReadAt = $chat->users->find($userId)->pivot->last_read_at ?? null;
        $unreadCount = $chat->messages->where('created_at', '>', $lastReadAt)->count();
        $lastMessage = $chat->messages->first(); // последнее по дате

        $chats->push([
            'id'                => $chat->id,
            'type'              => 'group',
            'name'              => $chat->name,
            'avatar_url'        => $chat->avatar_url,
            'unread_count'      => $unreadCount,
            'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
        ]);
    }

    // б) Персональные
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

    // 4. Сортируем чаты (непрочитанные вверх, потом по дате последнего сообщения)
    $sorted = $chats->sortByDesc(function ($chat) {
        return $chat['unread_count'] > 0 ? 1 : 0;
    })->sortByDesc('last_message_time')->values();

    return $sorted;
}

    }
