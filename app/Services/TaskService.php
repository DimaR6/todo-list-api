<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\Enums\TaskStatusEnum;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use App\Models\Task;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    public function create(TaskDTO $dto): Task
    {
        if ($dto->parentId) {
            $parent = $this->taskRepository->find($dto->parentId);
            if (!$parent || $parent->user_id !== Auth::id()) {
                throw new InvalidArgumentException('Invalid parent task');
            }
        }

        return $this->taskRepository->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'status' => $dto->status->value,
            'priority' => $dto->priority,
            'user_id' => Auth::id(),
            'parent_id' => $dto->parentId,
        ]);
    }

    public function update(int $id, TaskDTO $dto): Task
    {
        $task = $this->taskRepository->findOrFail($id);
        if ($task->user_id !== Auth::id()) {
            throw new InvalidArgumentException('Unauthorized');
        }

        return $this->taskRepository->update($task, [
            'title' => $dto->title,
            'description' => $dto->description,
            'status' => $dto->status->value,
            'priority' => $dto->priority,
            'parent_id' => $dto->parentId,
        ]);
    }

    public function markAsCompleted(int $id): Task
    {
        $task = $this->taskRepository->findOrFail($id);
        if ($task->user_id !== Auth::id()) {
            throw new InvalidArgumentException('Unauthorized');
        }

        if ($this->taskRepository->hasIncompleteSubtasks($id)) {
            throw new InvalidArgumentException('Cannot complete task with incomplete subtasks');
        }

        return $this->taskRepository->update($task, [
            'status' => TaskStatusEnum::DONE->value,
            'completed_at' => now(),
        ]);
    }

    public function delete(int $id): void
    {
        $task = $this->taskRepository->findOrFail($id);
        if ($task->user_id !== Auth::id()) {
            throw new InvalidArgumentException('Unauthorized');
        }
        if ($task->status === TaskStatusEnum::DONE->value) {
            throw new InvalidArgumentException('Cannot delete completed task');
        }

        $this->taskRepository->delete($task);
    }
}