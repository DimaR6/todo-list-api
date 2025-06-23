<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('tasks')
                ->onDelete('set null');

            $table->string('title', 255);
            $table->text('description');
            $table->enum('status', ['todo', 'done']);
            $table->unsignedTinyInteger('priority');
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

