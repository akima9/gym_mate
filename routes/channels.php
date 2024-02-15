<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chats.{chatRoomId}', function ($user, $chatRoomId) {
    $chatRoom = ChatRoom::findOrNew($chatRoomId);
    return ($user->id === $chatRoom->admin_user_id || $user->id === $chatRoom->member_user_id);
});
