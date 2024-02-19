<?php

namespace App\Repositories;

use App\Models\Board;

class BoardRepository
{
    public function findById($id)
    {
        return Board::find($id);
    }

    public function getBoardsPerPage($listCount)
    {
        return Board::orderBy('id', 'desc')->paginate($listCount);
    }

    public function save($request)
    {
        return Board::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'user_id' => $request->user()->id,
            'gym_id' => $request->user()->gym_id,
        ]);
    }

    public function update($board, $request)
    {
        return Board::where('id', $board->id)
                    ->update([
                        'title' => $request['title'],
                        'content' => $request['content'],
                    ]);
    }

    public function delete($id)
    {
        Board::destroy($id);
    }
}
