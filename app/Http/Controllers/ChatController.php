<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\MessageSent;
use App\Events\MessagesRead;
use App\Http\Resources\MessageResource;

class ChatController extends Controller
{
    /**
     * Отображает список чатов (личных и групповых), в которых участвует пользователь.
     */
    public function index()
    {
        $title_site = "Чаты | Личный кабинет Экспресс-дизайн";
        $user = Auth::user();
        $userId = $user->id;

        $chats = collect();

        // Личные чаты
        switch ($user->status) {
            case 'admin':
            case 'coordinator':
                $personalUsers = User::where('id', '<>', $userId)
                    ->where('status', '<>', 'user')
                    ->with(['chats' => function($q) {
                        $q->where('type', 'personal');
                    }])
                    ->get();
                break;
            case 'support':
                $personalUsers = User::where('id', '<>', $userId)
                    ->with(['chats' => function($q) {
                        $q->where('type', 'personal');
                    }])
                    ->get();
                break;
            case 'user':
                $relatedDealIds = $user->deals()->pluck('deals.id');
                $personalUsers = User::whereIn('status', ['support', 'coordinator'])
                    ->whereHas('deals', function($q) use ($relatedDealIds) {
                        $q->whereIn('deals.id', $relatedDealIds);
                    })
                    ->where('id', '<>', $userId)
                    ->with(['chats' => function($q) {
                        $q->where('type', 'personal');
                    }])
                    ->get();
                break;
            default:
                $personalUsers = collect();
        }

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

        // Групповые чаты
        $groupChats = Chat::where('type', 'group')
            ->whereHas('users', function($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['messages' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(50);
            }])
            ->get();

        foreach ($groupChats as $chat) {
            $pivot = $chat->users->find($userId)->pivot;
            $lastReadAt = $pivot->last_read_at ?? null;
            $unreadCount = $lastReadAt
                ? $chat->messages->where('created_at', '>', $lastReadAt)->count()
                : $chat->messages->count();
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

        // Сортировка: сначала чаты с непрочитанными сообщениями, затем по времени последнего сообщения
        $sorted = $chats->sortByDesc(function ($chat) {
            return $chat['unread_count'] > 0 ? 1 : 0;
        })->sortByDesc('last_message_time')->values();

        return view('chats', compact('chats', 'user', 'title_site'));
    }

    /**
     * Загружает сообщения для выбранного чата (личного или группового).
     */
    public function chatMessages($type, $id)
    {
        $currentUserId = Auth::id();

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
                ->limit(50)
                ->get()
                ->reverse();

            // Пометка сообщений как прочитанных
            Message::where('sender_id', $recipient->id)
                ->where('receiver_id', $currentUserId)
                ->whereNull('read_at')
                ->update(['is_read' => true, 'read_at' => now()]);
        } elseif ($type === 'group') {
            $chat = Chat::where('type', 'group')->findOrFail($id);
            if (!$chat->users->contains($currentUserId)) {
                $chat->users()->attach($currentUserId);
            }
            $messages = $chat->messages()
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get()
                ->reverse();

            Message::where('chat_id', $chat->id)
                ->where('sender_id', '!=', $currentUserId)
                ->whereNull('read_at')
                ->update(['is_read' => true, 'read_at' => now()]);
        } else {
            return response()->json(['error' => 'Неверный тип чата.'], 400);
        }

        $messages->each(function ($message) {
            $message->sender_name = optional($message->sender)->name ?? 'Unknown';
        });

        $formattedMessages = MessageResource::collection($messages);
        return response()->json([
            'current_user_id' => $currentUserId,
            'messages'        => $formattedMessages,
        ], 200);
    }

    /**
     * Отправляет сообщение (текст или файл) в чат.
     */
    public function sendMessage(Request $request, $type, $id)
    {
        if (!in_array($type, ['personal', 'group'])) {
            return response()->json(['error' => 'Неверный тип чата.'], 400);
        }

        $validated = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $currentUserId = Auth::id();
        $attachments = [];
        $messageType = 'text';

        if ($request->hasFile('file')) {
            $files = $request->file('file');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePathStored = $file->storeAs('uploads', $fileName, 'public');
                $url = asset('storage/'.$filePathStored);
                $attachments[] = [
                    'url' => $url,
                    'original_file_name' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                ];
            }
            $messageType = 'file';
        }

        DB::beginTransaction();
        try {
            if ($type === 'personal') {
                $receiver = User::findOrFail($id);
                $message = Message::create([
                    'sender_id'    => $currentUserId,
                    'receiver_id'  => $receiver->id,
                    'chat_id'      => null,
                    'message'      => $validated['message'] ?? '',
                    'message_type' => $messageType,
                    'attachments'  => $attachments,
                ]);
            } elseif ($type === 'group') {
                $chat = Chat::where('type', 'group')->findOrFail($id);
                if (!$chat->users->contains($currentUserId)) {
                    $chat->users()->attach($currentUserId);
                }
                $message = Message::create([
                    'sender_id'    => $currentUserId,
                    'chat_id'      => $chat->id,
                    'message'      => $validated['message'] ?? '',
                    'message_type' => $messageType,
                    'attachments'  => $attachments,
                ]);
            }
            DB::commit();

            // Оповещение через событие (реaltime)
            broadcast(new MessageSent($message))->toOthers();
            $message->sender_name = optional($message->sender)->name ?? 'Unknown';

            return response()->json(['message' => new MessageResource($message)], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in sendMessage:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Возвращает новые сообщения, отправленные после указанного ID.
     */
    public function getNewMessages(Request $request, $type, $id)
    {
        if (!in_array($type, ['personal', 'group'])) {
            return response()->json(['error' => 'Неверный тип чата.'], 400);
        }
        $validated = $request->validate([
            'last_message_id' => 'nullable|integer',
        ]);
        $currentUserId = Auth::id();
        $lastMessageId = $validated['last_message_id'] ?? 0;

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
        } elseif ($type === 'group') {
            $chat = Chat::where('type', 'group')->findOrFail($id);
            if (!$chat->users->contains($currentUserId)) {
                $chat->users()->attach($currentUserId);
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
    }

    /**
     * Помечает сообщения как прочитанные в выбранном чате.
     */
    public function markMessagesAsRead($type, $id)
    {
        $currentUserId = Auth::id();

        if ($type === 'personal') {
            $otherUser = User::findOrFail($id);
            try {
                Message::where('sender_id', $otherUser->id)
                    ->where('receiver_id', $currentUserId)
                    ->where('is_read', false)
                    ->update(['is_read' => true, 'read_at' => now()]);
                event(new MessagesRead($id, $currentUserId, $type));
                return response()->json(['success' => true], 200);
            } catch (\Exception $e) {
                Log::error('Ошибка при пометке личных сообщений как прочитанных:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['error' => 'Внутренняя ошибка сервера.'], 500);
            }
        } elseif ($type === 'group') {
            $chat = Chat::where('type', 'group')->findOrFail($id);
            if (!$chat->users->contains($currentUserId)) {
                $chat->users()->attach($currentUserId);
            }
            try {
                Message::where('chat_id', $chat->id)
                    ->where('sender_id', '!=', $currentUserId)
                    ->where('is_read', false)
                    ->update(['is_read' => true, 'read_at' => now()]);
                $chat->users()->updateExistingPivot($currentUserId, ['last_read_at' => now()]);
                event(new MessagesRead($id, $currentUserId, $type));
                return response()->json(['success' => true], 200);
            } catch (\Exception $e) {
                Log::error('Ошибка при пометке групповых сообщений как прочитанных:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['error' => 'Внутренняя ошибка сервера.'], 500);
            }
        } else {
            return response()->json(['error' => 'Неверный тип чата.'], 400);
        }
    }

    /**
     * Поиск по чатам и сообщениям.
     */
    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $userId = Auth::id();

        // Поиск по чатам с использованием уже реализованной логики
        $allChats = $this->getUserChats($userId);
        $matchedChats = $allChats->filter(function ($chat) use ($query) {
            return stripos($chat['name'], $query) !== false;
        })->values();

        // Поиск по сообщениям
        $matchedMessages = Message::where('message', 'like', "%{$query}%")
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId)
                  ->orWhereHas('chat.users', function ($q2) use ($userId) {
                      $q2->where('users.id', $userId);
                  });
            })
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $matchedMessages->each(function ($message) {
            $message->sender_name = optional($message->sender)->name;
        });

        return response()->json([
            'chats'    => $matchedChats,
            'messages' => $matchedMessages,
        ], 200);
    }

    /**
     * Возвращает все чаты пользователя (используется для поиска).
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
        $personalChats = User::where('id', '<>', $userId)
            ->with(['chats' => function($query) {
                $query->where('type', 'personal');
            }])
            ->get();

        $chats = collect();
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

        $groupChats = Chat::where('type', 'group')
            ->whereHas('users', function($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['messages' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(50);
            }])
            ->get();

        foreach ($groupChats as $chat) {
            $pivot = $chat->users->find($userId)->pivot;
            $lastReadAt = $pivot->last_read_at ?? null;
            $unreadCount = $lastReadAt
                ? $chat->messages->where('created_at', '>', $lastReadAt)->count()
                : $chat->messages->count();
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

        $sorted = $chats->sortByDesc(function ($chat) {
            return $chat['unread_count'] > 0 ? 1 : 0;
        })->sortByDesc('last_message_time')->values();

        return $sorted;
    }
}
