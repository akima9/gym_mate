<?php

namespace App\Repositories;

use App\Models\Board;

class BoardRepository
{
    public function findById($id)
    {
        return Board::find($id);
    }
}
