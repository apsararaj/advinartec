<?php

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('priority', array_column(TaskPriority::cases(), 'value'))->default(TaskPriority::Medium->value);
            $table->enum('status', array_column(TaskStatus::cases(), 'value'))->default(TaskStatus::Pending->value);
            $table->date('due_date')->nullable();
            $table->foreignId('assigned_to')->constrained('users')->cascadeOnDelete();
            $table->text('ai_summary')->nullable();
            $table->enum('ai_priority', array_column(TaskPriority::cases(), 'value'))->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
