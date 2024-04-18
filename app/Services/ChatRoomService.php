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

    public function save(int $adminUserId, int $memberUserId, int $boardId): ChatRoom
    {
        return $this->chatRoomRepository->save($adminUserId, $memberUserId, $boardId);
    }

    public function delete(ChatRoom $chatRoom)
    {
        $this->chatRoomRepository->delete($chatRoom);
    }
}
