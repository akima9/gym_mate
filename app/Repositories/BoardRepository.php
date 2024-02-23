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
        if (empty($request['content'])) {
            return Board::create([
                'title' => $request['title'],
                'trainingDate' => $request['trainingDate'],
                'trainingStartTime' => $request['trainingStartTime'],
                'trainingEndTime' => $request['trainingEndTime'],
                'trainingParts' => $request['trainingParts'],
                'user_id' => $request->user()->id,
                'gym_id' => $request->user()->gym_id,
            ]);
        } else {
            return Board::create([
                'title' => $request['title'],
                'trainingDate' => $request['trainingDate'],
                'trainingStartTime' => $request['trainingStartTime'],
                'trainingEndTime' => $request['trainingEndTime'],
                'trainingParts' => $request['trainingParts'],
                'content' => $request['content'],
                'user_id' => $request->user()->id,
                'gym_id' => $request->user()->gym_id,
            ]);
        }
    }

    public function update($board, $request)
    {
        if (empty($request['content'])) {
            return Board::where('id', $board->id)
                    ->update([
                        'title' => $request['title'],
                        'trainingDate' => $request['trainingDate'],
                        'trainingStartTime' => $request['trainingStartTime'],
                        'trainingEndTime' => $request['trainingEndTime'],
                        'trainingParts' => $request['trainingParts'],
                        'status' => $request['status'],
                    ]);
        } else {
            return Board::where('id', $board->id)
                    ->update([
                        'title' => $request['title'],
                        'trainingDate' => $request['trainingDate'],
                        'trainingStartTime' => $request['trainingStartTime'],
                        'trainingEndTime' => $request['trainingEndTime'],
                        'trainingParts' => $request['trainingParts'],
                        'status' => $request['status'],
                        'content' => $request['content'],
                    ]);
        }
    }

    public function delete($id)
    {
        Board::destroy($id);
    }
}
