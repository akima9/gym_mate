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
use Illuminate\View\View;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = auth()->user();

        $chats = Chat::where('send_user_id', $user->id)
                        ->orWhere('receive_user_id', $user->id)
                        ->with('sendUser', 'receiveUser')
                        ->latest('created_at')
                        ->get();

        $chatPartners = $chats->flatMap(function ($chat) use ($user) {
            return ($chat->send_user_id === $user->id) ? [$chat->receiveUser] : [$chat->sendUser];
        })->unique('id');

        $latestMessages = [];
        foreach ($chatPartners as $partner) {
            $latestMessages[$partner->id] = $chats->filter(function ($chat) use ($partner) {
                return $chat->send_user_id === $partner->id || $chat->receive_user_id === $partner->id;
            })->first();
        }

        return view('chat.index', compact('user', 'chatPartners', 'latestMessages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $board = Board::find($request->board);
        // return view('chat.create', ['board' => $board]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        // $validated = $request->validated();
        
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

        // broadcast(new ChatSent($request->user()->id, $validated['message'], now()));
        broadcast(new ChatSent($request->user()->id, $request->user()->nickname, $validated['message'], now()));
        return response()->json($chat);
    }

    public function load(Request $request)
    {
        // $chat = Chat::where('send_user_id', $request->send_user_id)
        //     ->where('receive_user_id', $request->receive_user_id)
        //     ->first();
        
        // $chats = Chat::where('send_user_id', $request->send_user_id)
        //     ->where('receive_user_id', $request->receive_user_id)
        //     ->get();

        // return response()->json([
        //     'chats' => $chats, 
        //     'sendUser' => $chat->sendUser,
        //     'receiveUser' => $chat->receiveUser,
        // ]);
    }

    public function detail(Request $request)
    {
        $user = auth()->user();
        $chatPartnerId = $request->chatPartner;

        $chats = Chat::where([['send_user_id', $user->id], ['receive_user_id', $chatPartnerId]])
                        ->orWhere([['send_user_id', $chatPartnerId], ['receive_user_id', $user->id]])
                        ->with('sendUser', 'receiveUser')
                        ->get();

        return view('chat.detail', compact('chats', 'chatPartnerId'));
    }
}
