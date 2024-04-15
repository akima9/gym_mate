<?php

namespace App\Http\Controllers;

use App\Dtos\BoardDto;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Services\BoardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoardController extends Controller
{
    private $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
        $this->middleware(['auth', 'verified'])->except(['index', 'show', 'search']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $boards = $this->boardService->getBoardsPerPage($request);
        return view('board.index', compact('boards'));
    }

    public function search(Request $request)
    {
        return view('board.search');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if (empty($user->gym_id)) {
            return redirect()->route('profile.edit')->with('from', 'board-create');
        }
        return view('board.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request): RedirectResponse
    {
        $request->validated();
        $boardDto = new BoardDto($request);
        $board = $this->boardService->save($boardDto);

        if (empty($board)) {
            return redirect()->route('profile.edit');
        }
        return redirect()->route('boards.show', compact('board'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board): View
    {
        $board->trainingParts = json_decode($board->trainingParts);
        return view('board.show', compact('board'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board): View
    {
        $this->authorize('update', $board);
        $board->trainingParts = json_decode($board->trainingParts);
        return view('board.edit', compact('board'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board): RedirectResponse
    {
        $this->authorize('update', $board);
        $request->validated();
        
        $boardDto = new BoardDto($request);
        $updatedCount = $this->boardService->update($board, $boardDto);
        if ($updatedCount !== 1) return back()->withInput()->with('status', 'board-update-failed');

        $updatedBoard = $this->boardService->findById($board->id);

        return redirect()->route('boards.show', ['board' => $updatedBoard]);
    }

    public function confirmMate(Request $request)
    {
        $boardId = $request->boardId;
        $mateId = $request->mateId;

        $board = $this->boardService->findById($boardId);
        $updatedCount = $this->boardService->addMateId($board, $mateId);
        
        return response()->json($updatedCount);
    }

    public function off(Request $request)
    {
        $boardId = $request->boardId;
        $board = $this->boardService->findById($boardId);
        $updateCount = $this->boardService->off($board);
        return response()->json($updateCount);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board): RedirectResponse
    {
        $this->authorize('delete', $board);
        $this->boardService->delete($board->id);
        return redirect()->route('boards.index');
    }
}
