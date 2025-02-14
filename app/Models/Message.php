<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id', 'chat_id', 'message', 'is_read', 'read_at'
    ];

    /**
     * Связь с отправителем.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Связь с получателем.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Связь с чатом.
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    /**
     * Метод для маркировки сообщений как прочитанных по чату.
     */
    public static function markAsReadByChat($chatId, $userId)
    {
        self::where('chat_id', $chatId)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
    }
}
