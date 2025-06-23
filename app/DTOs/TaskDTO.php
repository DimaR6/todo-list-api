<?php

namespace App\DTOs;

use App\Enums\TaskStatusEnum;

class TaskDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public TaskStatusEnum $status,
        public int $priority,
        public ?int $parentId = null,
        public ?int $userId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            status: TaskStatusEnum::from($data['status']),
            priority: $data['priority'],
            parentId: $data['parent_id'] ?? null,
            userId: $data['user_id'] ?? null,
        );
    }
}