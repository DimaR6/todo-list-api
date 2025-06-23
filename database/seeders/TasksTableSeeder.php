<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create();

        Task::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        // Create nested tasks
        $parent = Task::factory()->create(['user_id' => $user->id]);
        Task::factory()
            ->count(3)
            ->create([
                'user_id' => $user->id,
                'parent_id' => $parent->id,
            ]);
    }
}
