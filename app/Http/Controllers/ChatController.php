<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\SendChatRequest;
use App\Models\Board;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatController extends Controller
{
    private $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = auth()->user();
        $chats = $this->chatService->findChats($user->id);
        $chatPartners = $this->chatService->findChatPartners($chats, $user);
        $latestMessages = $this->chatService->findLastMessages($chats, $chatPartners);
        return view('chat.index', compact('user', 'chatPartners', 'latestMessages'));
    }

    public function send(SendChatRequest $request)
    {
        $validated = $request->validated();


        $chatRoom = ChatRoom::whereIn('admin_user_id', [$request->user()->id, $validated['receive_user_id']])
                            ->whereIn('member_user_id', [$request->user()->id, $validated['receive_user_id']])
                            ->first();

        // $chat = Chat::create([
        //     'chat_room_id' => $chatRoom->id,
        //     'message' => $validated['message'],
        //     'send_user_id' => $request->user()->id,
        //     'receive_user_id' => $validated['receive_user_id'],
        // ]);
        $chat = $this->chatService->save($chatRoom, $request);

        broadcast(new ChatSent($chat, $request->user()->nickname, now()));
        return response()->json($chat);
    }

    public function detail(Request $request)
    {
        $user = auth()->user();
        $chatPartnerId = $request->chatPartner;

        //select chatRoom
        $chatRoom = ChatRoom::whereIn('admin_user_id', [$user->id, $chatPartnerId])
                            ->whereIn('member_user_id', [$user->id, $chatPartnerId])
                            ->first();

        if (empty($chatRoom)) {
            $chatRoom = ChatRoom::create([
                'admin_user_id' => $user->id,
                'member_user_id' => $chatPartnerId,
            ]);
        }

        // $chats = Chat::where('chat_room_id', $chatRoom->id)
        //                 ->with('sendUser', 'receiveUser')
        //                 ->get();
        $chats = $this->chatService->findByChatRoomId($chatRoom->id);

        return view('chat.detail', compact('chats', 'chatPartnerId', 'chatRoom'));
    }
}
