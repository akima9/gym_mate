<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use Illuminate\View\View;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $boards = Board::orderBy('id', 'desc')->paginate(10);

        return view('board.index', ['boards' => $boards]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('board.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request)
    {
        $validated = $request->validated();
        
        $board = Board::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $request->user()->id,
            'gym_id' => $request->user()->gym_id,
        ]);

        return redirect()->route('boards.show', ['board' => $board]);        
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        return view('board.show', ['board' => $board]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        return view('board.edit', ['board' => $board]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        $validated = $request->validated();
        
        $updatedBoard = Board::where('id', $board->id)->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('boards.show', ['board' => $updatedBoard]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        Board::destroy($board->id);

        return redirect()->route('boards.index');
    }
}
