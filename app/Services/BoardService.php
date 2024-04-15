<?php

namespace App\Services;

use App\Dtos\BoardDto;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Repositories\BoardRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getBoardsPerPage(Request $request): LengthAwarePaginator
    {
        $boards = $this->boardRepository->getBoardsPerPage($request);
        foreach ($boards as $board) {
            $board->trainingParts = json_decode($board->trainingParts);
        }
        return $boards;
    }

    public function save(BoardDto $dto): Board
    {
        if (empty($dto->getGymId())) return null;
        
        return $this->boardRepository->save($dto);
    }
    // public function save(StoreBoardRequest $request): Board
    // {
    //     if (empty($request->user()->gym_id)) {
    //         return null;
    //     }
        
    //     $boardDto = new BoardDto($request);
    //     return $this->boardRepository->save($boardDto);
    // }

    public function update(Board $board, BoardDto $dto): int
    {
        return $this->boardRepository->update($board, $dto);
    }
    // public function update(Board $board, UpdateBoardRequest $request): int
    // {
    //     $boardDto = new BoardDto($request);
    //     return $this->boardRepository->update($board, $boardDto);
    // }

    public function delete(int $id): void
    {
        $this->boardRepository->delete($id);
    }

    public function addMateId($board, $mateId)
    {
        return $this->boardRepository->addMateId($board, $mateId);
    }

    public function off($board)
    {
        return $this->boardRepository->off($board);
    }
}
