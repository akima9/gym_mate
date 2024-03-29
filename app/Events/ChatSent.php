<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatRoomId;
    public $sender;
    public $nickname;
    public $message;
    public $sentAt;

    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat, $nickname, $sentAt)
    {
        $this->chatRoomId = $chat->chat_room_id;
        $this->sender = $chat->send_user_id;
        $this->nickname = $nickname;
        $this->message = $chat->message;
        $this->sentAt = $sentAt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new Channel('chat'),
            new PrivateChannel('chats.' . $this->chatRoomId),
        ];
    }
}
