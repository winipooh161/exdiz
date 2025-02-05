<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewChatMessage extends Notification implements ShouldQueue
{
    use Queueable;

    private $message;
    private $dealId;

    public function __construct($message, $dealId)
    {
        $this->message = $message;
        $this->dealId = $dealId;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'deal_id' => $this->dealId,
            'message' => $this->message,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'deal_id' => $this->dealId,
            'message' => $this->message,
        ];
    }
}
