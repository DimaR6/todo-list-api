<?php

namespace App\Repositories;

use App\Models\MagicLink;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class MagicLinkRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'hash',
        'user_id',
        'expires_at',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return MagicLink::class;
    }

    public function getMagicLinksByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->paginate(10);
    }

    public function getFirtsActiveMagicLinkByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)
            ->where('is_active', true)
            ->where('expires_at', '>=', now())
            ->orderBy('expires_at', 'desc')
            ->first();
    }

    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->where('id', $id)
            ->where('user_id', Auth::id())
            ->first($columns);
    }
}
