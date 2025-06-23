<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;

class TaskRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'parent_id',
        'title',
        'description',
        'priority',
        'completed_at',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Task::class;
    }
}
