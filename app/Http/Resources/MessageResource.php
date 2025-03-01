<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'sender_id'          => $this->sender_id,
            'receiver_id'        => $this->receiver_id,
            'chat_id'            => $this->chat_id,
            'message'            => $this->message,
            'is_read'            => $this->is_read,
            'read_at'            => $this->read_at,
            'sender_name'        => $this->sender->name ?? 'Unknown',
            'sender_avatar'      => $this->sender->avatar_url ?? '/user/avatar/default.png',
            'is_pinned'          => $this->is_pinned,
            'message_type'       => $this->message_type, // ('text' или 'file')
            'attachments'        => $this->attachments ?? [],
            'created_at'         => $this->created_at->toDateTimeString(),
        ];
    }
}
