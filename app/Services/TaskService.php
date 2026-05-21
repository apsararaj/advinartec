<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $tasks,
        private readonly AIService $aiService,
    ) {
    }

    public function list(array $filters, User $viewer)
    {
        return $this->tasks->all([...$filters, 'viewer' => $viewer]);
    }

    public function find(int $id): Task
    {
        return $this->tasks->find($id);
    }

    public function store(array $data): Task
    {
        return DB::transaction(function () use ($data) {
            $task = $this->tasks->create($data);
            $aiData = $this->aiService->generateSummary($task);

            return $this->tasks->update($task->id, $aiData);
        });
    }

    public function update(Task $task, array $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $updated = $this->tasks->update($task->id, $data);

            if ($this->shouldRefreshAi($data)) {
                $updated = $this->tasks->update($updated->id, $this->aiService->generateSummary($updated));
            }

            return $updated;
        });
    }

    public function updateStatus(Task $task, TaskStatus $status): Task
    {
        return $this->tasks->update($task->id, ['status' => $status->value]);
    }

    public function refreshAiSummary(Task $task): Task
    {
        return $this->tasks->update($task->id, $this->aiService->generateSummary($task));
    }

    public function delete(Task $task): bool
    {
        return $this->tasks->delete($task->id);
    }

    public function analytics(User $viewer): array
    {
        $tasks = Task::query()->visibleTo($viewer)->get();

        return [
            'total' => $tasks->count(),
            'completed' => $tasks->where('status', TaskStatus::Completed)->count(),
            'pending' => $tasks->where('status', TaskStatus::Pending)->count(),
            'high' => $tasks->where('priority', \App\Enums\TaskPriority::High)->count(),
            'monthly' => [12, 34, 48, 56, 7],
        ];
    }

    private function shouldRefreshAi(array $data): bool
    {
        return array_key_exists('title', $data)
            || array_key_exists('description', $data)
            || array_key_exists('priority', $data);
    }
}
