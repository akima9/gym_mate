<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\SendChatRequest;
use App\Models\Board;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $board = Board::find($request->board);
        return view('chat.create', ['board' => $board]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        $validated = $request->validated();
        
        // $chat = Chat::create([
        //     'message' => $validated['message'],
        //     'send_user_id' => $request->user()->id,
        //     'receive_user_id' => $request->receive_user_id,
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function send(SendChatRequest $request)
    {
        $validated = $request->validated();

        $chat = Chat::create([
            'message' => $validated['message'],
            'send_user_id' => $request->user()->id,
            'receive_user_id' => $validated['receive_user_id'],
        ]);

        broadcast(new ChatSent($request->user()->id, $validated['message'], now()));
        return response()->json($chat);
    }

    public function load(Request $request)
    {
        $chat = Chat::where('send_user_id', $request->send_user_id)
            ->where('receive_user_id', $request->receive_user_id)
            ->first();
        
        $chats = Chat::where('send_user_id', $request->send_user_id)
            ->where('receive_user_id', $request->receive_user_id)
            ->get();

        return response()->json([
            'chats' => $chats, 
            'sendUser' => $chat->sendUser,
            'receiveUser' => $chat->receiveUser,
        ]);
    }
}
