<?php

namespace App\Services;

use App\Repositories\ChatRepository;

class ChatService
{
    private $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function findChats($id)
    {
        return $this->chatRepository->findChats($id);
    }

    public function findChatPartners($chats, $user)
    {
        return $chats->flatMap(function ($chat) use ($user) {
            return ($chat->send_user_id === $user->id) ? [$chat->receiveUser] : [$chat->sendUser];
        })->unique('id');
    }

    public function findLastMessages($chats, $chatPartners)
    {
        $latestMessages = [];
        foreach ($chatPartners as $partner) {
            $latestMessages[$partner->id] = $chats->filter(function ($chat) use ($partner) {
                return $chat->send_user_id === $partner->id || $chat->receive_user_id === $partner->id;
            })->first();
        }
        return $latestMessages;
    }

    public function save($chatRoom, $request)
    {
        return $this->chatRepository->save($chatRoom, $request);
    }

    public function findByChatRoomId($chatRoomId)
    {
        return $this->chatRepository->findByChatRoomId($chatRoomId);
    }

    public function getChats($chatRoomId, $page)
    {
        return $this->chatRepository->findByChatRoomIdAndPage($chatRoomId, $page);
    }
}
