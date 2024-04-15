<?php

namespace App\Repositories;

use App\Models\ChatRoom;

class ChatRoomRepository
{
    public function findChatRoom(int $sendUserId, int $receivedUserId): ?ChatRoom
    {
        return ChatRoom::whereIn('admin_user_id', [$sendUserId, $receivedUserId])
                        ->whereIn('member_user_id', [$sendUserId, $receivedUserId])
                        ->first();
    }

    public function save(int $adminUserId, int $memberUserId, int $boardId): ChatRoom
    {
        return ChatRoom::create([
            'admin_user_id' => $adminUserId,
            'member_user_id' => $memberUserId,
            'board_id' => $boardId,
        ]);
    }
}
