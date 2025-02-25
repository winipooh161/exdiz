<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'sender_id'         => $this->sender_id,
            'receiver_id'       => $this->receiver_id,
            'chat_id'           => $this->chat_id,
            'message'           => $this->message,
            'is_read'           => $this->is_read,
            'read_at'           => $this->read_at,
            'sender_name'       => $this->sender->name ?? 'Unknown',
            'created_at'        => $this->created_at->toDateTimeString(),
            'file_path'         => $this->file_path,
            'original_file_name'=> $this->original_file_name ?? null,
            'attachments'       => $this->attachments ?? [], // всегда возвращаем массив
        ];
    }
}
