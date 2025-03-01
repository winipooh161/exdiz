<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'chat_id',
        'message',
        'is_read',
        'read_at',
        'message_type',
        'attachments',
        'is_pinned',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_pinned'   => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public static function markAsReadByChat($chatId, $userId)
    {
        self::where('chat_id', $chatId)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
    }
}
