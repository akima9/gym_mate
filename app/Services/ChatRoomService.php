<?php

namespace App\Services;

use App\Repositories\ChatRoomRepository;

class ChatRoomService
{
    private $chatRoomRepository;

    public function __construct(ChatRoomRepository $chatRoomRepository)
    {
        $this->chatRoomRepository = $chatRoomRepository;
    }

    public function findChatRoom($sendUserId, $receivedUserId)
    {
        return $this->chatRoomRepository->findChatRoom($sendUserId, $receivedUserId);
    }

    public function save($adminUserId, $memberUserId)
    {
        return $this->chatRoomRepository->save($adminUserId, $memberUserId);
    }
}
