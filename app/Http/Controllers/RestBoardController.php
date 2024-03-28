<?php

namespace App\Http\Controllers;

use App\Dtos\BoardDto;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Services\BoardService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RestBoardController extends Controller
{
    private $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $boards = $this->boardService->getBoardsPerPage($request);
        return $boards;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request)
    {
        $request->validated();
        $boardDto = new BoardDto($request);
        $board = $this->boardService->save($boardDto);
        return $board;
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        $board->trainingParts = json_decode($board->trainingParts);
        return $board;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        $this->authorize('update', $board);
        $board->trainingParts = json_decode($board->trainingParts);
        return $board;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        /**
         * TO-DO
         * update 실패 경우 추가해야함.
         */
        $this->authorize('update', $board);
        $request->validated();
        
        $boardDto = new BoardDto($request);
        // $updatedCount = $this->boardService->update($board, $boardDto);
        $updatedBoard = $this->boardService->findById($board->id);
        return $updatedBoard;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);
        $this->boardService->delete($board->id);
    }
}
