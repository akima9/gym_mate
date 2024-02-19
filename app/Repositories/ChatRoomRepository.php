<?php

namespace App\Repositories;

use App\Models\ChatRoom;

class ChatRoomRepository
{
    public function findChatRoom($sendUserId, $receivedUserId)
    {
        return ChatRoom::whereIn('admin_user_id', [$sendUserId, $receivedUserId])
                        ->whereIn('member_user_id', [$sendUserId, $receivedUserId])
                        ->first();
    }

    public function save($adminUserId, $memberUserId)
    {
        return ChatRoom::create([
            'admin_user_id' => $adminUserId,
            'member_user_id' => $memberUserId,
        ]);
    }
}
