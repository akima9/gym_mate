<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Services\BoardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoardController extends Controller
{
    private $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $boards = $this->boardService->getBoardsPerPage(10);
        return view('board.index', ['boards' => $boards]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if (empty($user->gym_id)) {
            return redirect()->route('profile.edit');
        }
        return view('board.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request): RedirectResponse
    {
        $request->validated();
        $board = $this->boardService->save($request);
        if (empty($board)) {
            return redirect()->route('profile.edit');
        }
        return redirect()->route('boards.show', ['board' => $board]);        
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board): View
    {
        $board->trainingParts = json_decode($board->trainingParts);
        return view('board.show', ['board' => $board]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board): View
    {
        $this->authorize('update', $board);
        $board->trainingParts = json_decode($board->trainingParts);
        return view('board.edit', ['board' => $board]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board): RedirectResponse
    {
        $this->authorize('update', $board);
        $request->validated();
        $this->boardService->update($board, $request);
        $updatedBoard = $this->boardService->findById($board->id);
        $board->trainingParts = json_decode($board->trainingParts);
        return redirect()->route('boards.show', ['board' => $updatedBoard]);
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
