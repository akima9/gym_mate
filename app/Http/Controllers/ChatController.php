<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send()
    {
        $sender = request('sender');
        $message = request('message');

        broadcast(new ChatSent($sender, $message, now()));
    }
}
