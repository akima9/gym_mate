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
        return $this->boardRepository->getBoardsPerPage($listCount);
    }

    public function save($request)
    {
        return $this->boardRepository->save($request);
    }

    public function update($board, $request)
    {
        return $this->boardRepository->update($board, $request);
    }

    public function delete($id)
    {
        return $this->boardRepository->delete($id);
    }
}
