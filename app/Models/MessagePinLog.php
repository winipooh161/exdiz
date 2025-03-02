<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessagePinLog extends Model
{
    protected $fillable = [
        'message_id',
        'user_id',
        'action'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
