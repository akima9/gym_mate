<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\SendChatRequest;
use App\Models\Board;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use App\Services\BoardService;
use App\Services\ChatRoomService;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatController extends Controller
{
    private $chatService;
    private $chatRoomService;
    private $boardService;

    public function __construct(ChatService $chatService, ChatRoomService $chatRoomService, BoardService $boardService)
    {
        $this->chatService = $chatService;
        $this->chatRoomService = $chatRoomService;
        $this->boardService = $boardService;
        $this->middleware(['auth', 'verified']);
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
        $request->validated();
        $chatRoom = $this->chatRoomService->findChatRoom($request->user()->id, $request['receive_user_id']);
        $chat = $this->chatService->save($chatRoom, $request);
        broadcast(new ChatSent($chat, $request->user()->nickname, now()));
        return response()->json($chat);
    }

    public function detail(Request $request)
    {
        $user = auth()->user();
        $boardId = $request->boardId;
        $chatPartnerId = $request->chatPartner;
        $chatRoom = $this->chatRoomService->findChatRoom($user->id, $chatPartnerId);
        if (empty($chatRoom)) {
            $chatRoom = $this->chatRoomService->save($user->id, $chatPartnerId, $boardId);
        }
        $chats = $this->chatService->findByChatRoomId($chatRoom->id);
        $board = $this->boardService->findById($chatRoom->board_id);
        session()->forget('first_chat_id');
        return view('chat.detail', compact('chats', 'chatPartnerId', 'chatRoom', 'board'));
    }

    public function load(Request $request)
    {
        $page = $request->page;
        $chatRoomId = $request->chatRoomId;
        $chats = $this->chatService->getChats($chatRoomId, $page);
        return response()->json($chats);
    }
}
