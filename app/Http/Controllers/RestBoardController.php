<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        //
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
}
