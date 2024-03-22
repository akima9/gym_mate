<?php

namespace App\Services;

use App\Dtos\BoardDto;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Repositories\BoardRepository;
use Illuminate\Http\Request;

class BoardService
{
    private $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function findById(int $id): Board
    {
        return $this->boardRepository->findById($id);
    }

    public function getBoardsPerPage(Request $request): Board
    {
        $boards = $this->boardRepository->getBoardsPerPage($request);
        foreach ($boards as $board) {
            $board->trainingParts = json_decode($board->trainingParts);
        }
        return $boards;
    }

    public function save(StoreBoardRequest $request): Board
    {
        if (empty($request->user()->gym_id)) {
            return null;
        }
        
        $boardDto = new BoardDto($request);
        return $this->boardRepository->save($boardDto);
    }

    public function update(Board $board, UpdateBoardRequest $request): int
    {
        $boardDto = new BoardDto($request);
        return $this->boardRepository->update($board, $boardDto);
        // $request['trainingParts'] = json_encode($request['trainingParts'], JSON_UNESCAPED_UNICODE);
        // return $this->boardRepository->update($board, $request);
    }

    public function delete(int $id): void
    {
        $this->boardRepository->delete($id);
    }
}
