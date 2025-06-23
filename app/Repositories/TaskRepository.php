<?php

namespace App\Repositories;

use App\Models\Task;
use App\Enums\TaskStatusEnum as TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskRepository
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

    public function query(): Builder
    {
        return Task::where('user_id', Auth::id());
    }

    public function findOrFail(int $id): Task
    {
        return $this->query()->findOrFail($id);
    }

    public function find(int $id): ?Task
    {
        return $this->query()->find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }

    public function hasIncompleteSubtasks(int $taskId): bool
    {
        return Task::where('parent_id', $taskId)
            ->where('status', TaskStatus::TODO->value)
            ->exists();
    }

    public function applyFilters(Builder $query, array $filters): Builder
    {
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        if (isset($filters['search'])) {
            $query->whereFullText(['title', 'description'], $filters['search']);
        }

        return $query;
    }

    public function applySorting(Builder $query, ?string $sort): Builder
    {
        if (!$sort) {
            return $query;
        }

        foreach (explode(',', $sort) as $sortField) {
            [$field, $direction] = explode(':', $sortField);
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}
