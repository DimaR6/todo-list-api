<?php

namespace App\Repositories;

use App\Models\LuckyDraw;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class LuckyDrawRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'random_number',
        'result',
        'win_amount'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return LuckyDraw::class;
    }

    public function latestThree($userId)
    {
        return $this->model->orderBy('created_at', 'desc')
            ->where('user_id', $userId)
            ->limit(3)
            ->get();
    }

    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->where('id', $id)
            ->where('user_id', Auth::id())
            ->first($columns);
    }
}
