<?php

namespace App\Repositories;

use App\Models\Board;

class BoardRepository
{
    public function findById($id)
    {
        return Board::find($id);
    }

    public function getBoardsPerPage($request)
    {
        $status = (empty($request->status)) ? '' : $request->status;
        $trainingDate = (empty($request->trainingDate)) ? '' : $request->trainingDate;
        $keyword = (empty($request->keyword)) ? '' : $request->keyword;

        $query = Board::join('gyms', 'boards.gym_id', '=', 'gyms.id')
                        ->select('boards.*', 'gyms.title as gym_title');

        if (!empty($status)) {
            $query->where('boards.status', $status);
        }
        if (!empty($trainingDate)) {
            $query->where('boards.trainingDate', $trainingDate);
        }
        if (!empty($keyword)) {
            $query->where(function($query) use ($keyword) {
                $query->where('boards.title', 'like', '%' . $keyword . '%')
                ->orWhere('boards.content', 'like', '%' . $keyword . '%')
                ->orWhere('gyms.title', 'like', '%' . $keyword . '%');
            });
        }

        $boards = $query->orderBy('id', 'desc')->paginate(1);

        return $boards;
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
