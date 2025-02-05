<?php

// app/Events/MessageSent.php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    /**
     * Создание нового события.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message->load('sender');
    }

    /**
     * Получение канала на который будет транслироваться событие.
     *
     * @return Channel|PrivateChannel
     */
    public function broadcastOn()
    {
        if ($this->message->chat_id) {
            return new PrivateChannel('chat.' . $this->message->chat_id);
        } else {
            return new PrivateChannel('user.' . $this->message->receiver_id);
        }
    }

    /**
     * Имя события для фронтенда.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'message.sent';
    }
}
