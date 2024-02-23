<?php

namespace App\Services;

use App\Repositories\BoardRepository;

class BoardService
{
    private $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function findById($id)
    {
        return $this->boardRepository->findById($id);
    }

    public function getBoardsPerPage($listCount)
    {
        $boards = $this->boardRepository->getBoardsPerPage($listCount);
        foreach ($boards as $board) {
            $board->trainingParts = json_decode($board->trainingParts);
        }
        return $boards;
    }

    public function save($request)
    {
        if (empty($request->user()->gym_id)) {
            return null;
        }
        $request['trainingParts'] = json_encode($request['trainingParts'], JSON_UNESCAPED_UNICODE);
        return $this->boardRepository->save($request);
    }

    public function update($board, $request)
    {
        $request['trainingParts'] = json_encode($request['trainingParts'], JSON_UNESCAPED_UNICODE);
        return $this->boardRepository->update($board, $request);
    }

    public function delete($id)
    {
        return $this->boardRepository->delete($id);
    }
}
