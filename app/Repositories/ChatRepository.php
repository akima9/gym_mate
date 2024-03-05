<?php

namespace App\Repositories;

use App\Models\Chat;

class ChatRepository
{
    public function findChats($id)
    {
        return Chat::where('send_user_id', $id)
                    ->orWhere('receive_user_id', $id)
                    ->with('sendUser', 'receiveUser')
                    ->latest('created_at')
                    ->get();
    }

    public function save($chatRoom, $request)
    {
        return Chat::create([
            'chat_room_id' => $chatRoom->id,
            'message' => $request['message'],
            'send_user_id' => $request->user()->id,
            'receive_user_id' => $request['receive_user_id'],
        ]);
    }

    public function findByChatRoomId($chatRoomId)
    {
        $totalCount = Chat::where('chat_room_id', $chatRoomId)
            ->with('sendUser', 'receiveUser')
            ->count();

        $chats = Chat::where('chat_room_id', $chatRoomId)
                    ->with('sendUser', 'receiveUser')
                    ->skip($totalCount - 10)
                    ->take(10)
                    ->get();
        return $chats;
        //dd($totalCount); //26
        // return Chat::where('chat_room_id', $chatRoomId)
        //             ->with('sendUser', 'receiveUser')
        //             ->get();
    }

    public function findByChatRoomIdAndPage($chatRoomId, $page)
    {
        $countPerPage = 10;

        $totalCount = Chat::where('chat_room_id', $chatRoomId)
            ->with('sendUser', 'receiveUser')
            ->count();

        $chats = Chat::where('chat_room_id', $chatRoomId)
                    ->with('sendUser', 'receiveUser')
                    ->skip(($totalCount - $page * $countPerPage) >= 0 ? $totalCount - $page * $countPerPage : 0)
                    ->take($countPerPage)
                    ->get();

        return $chats;
    }
}
