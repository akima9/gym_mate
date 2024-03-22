<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\User;
use App\Repositories\ChatRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class ChatService
{
    private $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function findChats(int $id): Collection
    {
        return $this->chatRepository->findChats($id);
    }

    public function findChatPartners(Collection $chats, User $user): SupportCollection
    {
        return $chats->flatMap(function ($chat) use ($user) {
            return ($chat->send_user_id === $user->id) ? [$chat->receiveUser] : [$chat->sendUser];
        })->unique('id');
    }

    public function findLastMessages(Collection $chats, SupportCollection $chatPartners): array
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
