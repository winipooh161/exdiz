<?php
namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\MessageResource;
use App\Models\User;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $user = Auth::user();
        $title_site = "Поддержка | Личный кабинет Экспресс-дизайн";
        
        // Жестко задаем ID пользователя поддержки
        $supportUserId = 55;
        
        // Проверяем существование пользователя поддержки
        $supportUser = User::find($supportUserId);
        
        if (!$supportUser) {
            Log::warning('Support user (ID: 55) not found');
            return redirect()->back()->with('error', 'Служба поддержки временно недоступна');
        }

        // Создаем или получаем существующий чат между текущим пользователем и поддержкой
        $chatMessages = Message::where(function ($query) use ($user, $supportUserId) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $supportUserId)
                  ->orWhere('sender_id', $supportUserId)
                  ->where('receiver_id', $user->id);
        })->exists();

        return view('support', [
            'supportChat' => true,
            'supportUserId' => $supportUserId,
            'title_site' => $title_site,
            'chatExists' => $chatMessages
        ]);
    }
    
    // Другие методы поддержки (например, создание тикета) можно добавить здесь

    public function getNewMessages(Request $request, $id)
    {
        $validated = $request->validate([
            'last_message_id' => 'nullable|integer',
        ]);

        $currentUserId = Auth::id();
        $lastMessageId = $validated['last_message_id'] ?? 0;

        try {
            $query = Message::where('chat_id', $id)
                ->where('id', '>', $lastMessageId)
                ->orderBy('created_at', 'asc')
                ->with('sender');

            $newMessages = $query->get();

            $newMessages->each(function ($message) {
                $message->sender_name = optional($message->sender)->name;
            });
        } catch (\Exception $e) {
            Log::error('Ошибка при получении новых сообщений: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Ошибка получения сообщений.'], 500);
        }

        return response()->json([
            'current_user_id' => $currentUserId,
            'messages'        => MessageResource::collection($newMessages),
        ], 200);
    }

    public function markMessagesAsRead(Request $request, $id)
    {
        $currentUserId = Auth::id();

        try {
            Message::where('chat_id', $id)
                ->where('receiver_id', $currentUserId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } catch (\Exception $e) {
            Log::error('Ошибка при пометке сообщений как прочитанных: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Ошибка пометки сообщений.'], 500);
        }

        return response()->json(['success' => true], 200);
    }

    public function sendMessage(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => 55, // ID поддержки
                'message' => $validated['message'],
                'message_type' => 'text',
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => new MessageResource($message)
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка отправки сообщения: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Не удалось отправить сообщение. Пожалуйста, попробуйте позже.'
            ], 500);
        }
    }

    public function getSupportChatMessages()
    {
        $supportUserId = 55;
        $currentUserId = Auth::id();

        try {
            $messages = Message::with('sender')
                ->where(function ($query) use ($supportUserId, $currentUserId) {
                    $query->where('sender_id', $currentUserId)
                          ->where('receiver_id', $supportUserId);
                })
                ->orWhere(function ($query) use ($supportUserId, $currentUserId) {
                    $query->where('sender_id', $supportUserId)
                          ->where('receiver_id', $currentUserId);
                })
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get()
                ->reverse();

            $messages->each(function ($message) {
                $message->sender_name = optional($message->sender)->name ?? 'Unknown';
            });

            $formattedMessages = MessageResource::collection($messages);
            return response()->json([
                'messages' => $formattedMessages,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Ошибка при загрузке сообщений: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Ошибка загрузки сообщений.'], 500);
        }
    }

    public function chat()
    {
        $user = Auth::user();
        $title_site = "Чат поддержки | Личный кабинет Экспресс-дизайн";

        // Жестко задаем ID пользователя поддержки
        $supportUserId = 55;

        // Проверяем существование пользователя поддержки
        $supportUser = User::find($supportUserId);

        if (!$supportUser) {
            Log::warning('Support user (ID: 55) not found');
            return redirect()->back()->with('error', 'Служба поддержки временно недоступна');
        }

        // Создаем или получаем существующий чат между текущим пользователем и поддержкой
        $chatMessages = Message::where(function ($query) use ($user, $supportUserId) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $supportUserId)
                  ->orWhere('sender_id', $supportUserId)
                  ->where('receiver_id', $user->id);
        })->exists();

        return view('chats.index', [
            'supportChat' => true,
            'supportUserId' => $supportUserId,
            'title_site' => $title_site,
            'chatExists' => $chatMessages
        ]);
    }
}
