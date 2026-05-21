<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(array $filters = [])
    {
        return Task::query()
            ->with('user')
            ->visibleTo($filters['viewer'])
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function find(int $id): Task
    {
        return Task::query()->with('user')->findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): Task
    {
        $task = $this->find($id);
        $task->update($data);

        return $task->refresh()->load('user');
    }

    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }
}
