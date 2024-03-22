<?php

namespace App\Repositories;

use App\Dtos\BoardDto;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardRepository
{
    public function findById(int $id): Board
    {
        return Board::find($id);
    }

    public function getBoardsPerPage(Request $request): Board
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

        $boards = $query->orderBy('id', 'desc')->paginate(10);

        return $boards;
    }

    public function save(BoardDto $dto): Board
    {
        if (empty($dto->getContent())) {
            return Board::create([
                'title' => $dto->getTitle(),
                'trainingDate' => $dto->getTrainingDate(),
                'trainingStartTime' => $dto->getTrainingStartTime(),
                'trainingEndTime' => $dto->getTrainingEndTime(),
                'trainingParts' => $dto->getTrainingParts(),
                'user_id' => $dto->getUserId(),
                'gym_id' => $dto->getGymId(),
            ]);
        }

        return Board::create([
            'title' => $dto->getTitle(),
            'trainingDate' => $dto->getTrainingDate(),
            'trainingStartTime' => $dto->getTrainingStartTime(),
            'trainingEndTime' => $dto->getTrainingEndTime(),
            'trainingParts' => $dto->getTrainingParts(),
            'content' => $dto->getContent(),
            'user_id' => $dto->getUserId(),
            'gym_id' => $dto->getGymId(),
        ]);
    }

    public function update(Board $board, BoardDto $dto): int
    {
        if (empty($dto->getContent())) {
            return Board::where('id', $board->id)
                        ->update([
                            'title' => $dto->getTitle(),
                            'trainingDate' => $dto->getTrainingDate(),
                            'trainingStartTime' => $dto->getTrainingStartTime(),
                            'trainingEndTime' => $dto->getTrainingEndTime(),
                            'trainingParts' => $dto->getTrainingParts(),
                            'status' => $dto->getStatus(),
                        ]);
        }

        return Board::where('id', $board->id)
                    ->update([
                        'title' => $dto->getTitle(),
                        'trainingDate' => $dto->getTrainingDate(),
                        'trainingStartTime' => $dto->getTrainingStartTime(),
                        'trainingEndTime' => $dto->getTrainingEndTime(),
                        'trainingParts' => $dto->getTrainingParts(),
                        'status' => $dto->getStatus(),
                        'content' => $dto->getContent(),
                    ]);
    }

    public function delete(int $id): void
    {
        Board::destroy($id);
    }
}
