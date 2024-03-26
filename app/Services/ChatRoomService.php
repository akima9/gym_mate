<?php

namespace App\Services;

use App\Models\ChatRoom;
use App\Repositories\ChatRoomRepository;

class ChatRoomService
{
    private $chatRoomRepository;

    public function __construct(ChatRoomRepository $chatRoomRepository)
    {
        $this->chatRoomRepository = $chatRoomRepository;
    }

    public function findChatRoom(int $sendUserId, int $receivedUserId): ?ChatRoom
    {
        return $this->chatRoomRepository->findChatRoom($sendUserId, $receivedUserId);
    }

    public function save(int $adminUserId, int $memberUserId): ChatRoom
    {
        return $this->chatRoomRepository->save($adminUserId, $memberUserId);
    }
}
