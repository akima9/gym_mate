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
}
