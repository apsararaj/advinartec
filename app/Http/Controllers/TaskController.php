<?php

namespace App\Http\Controllers;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Task::class);

        return view('tasks.index', [
            'tasks' => $this->taskService->list($request->only(['search', 'status', 'priority', 'assigned_to']), $request->user()),
            'analytics' => $this->taskService->analytics($request->user()),
            'users' => User::query()->where('is_approved', true)->orderBy('name')->get(),
            'statuses' => TaskStatus::cases(),
            'priorities' => TaskPriority::cases(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Task::class);

        return view('tasks.form', [
            'task' => new Task([
                'priority' => TaskPriority::Medium,
                'status' => TaskStatus::Pending,
                'assigned_to' => $request->user()->id,
            ]),
            'users' => $this->assignableUsers($request->user()),
            'statuses' => TaskStatus::cases(),
            'priorities' => TaskPriority::cases(),
            'analytics' => $this->taskService->analytics($request->user()),
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = $this->taskService->store($request->validated());

        return redirect()->route('tasks.show', $task)->with('success', 'Task created with mock AI summary.');
    }

    public function show(Request $request, Task $task): View
    {
        $this->authorize('view', $task);

        return view('tasks.show', [
            'task' => $task->load('user'),
            'analytics' => $this->taskService->analytics($request->user()),
            'statuses' => TaskStatus::cases(),
            'priorities' => TaskPriority::cases(),
        ]);
    }

    public function edit(Request $request, Task $task): View
    {
        $this->authorize('update', $task);

        return view('tasks.form', [
            'task' => $task->load('user'),
            'users' => $this->assignableUsers($request->user()),
            'statuses' => TaskStatus::cases(),
            'priorities' => TaskPriority::cases(),
            'analytics' => $this->taskService->analytics($request->user()),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task = $this->taskService->update($task, $request->validated());

        return redirect()->route('tasks.show', $task)->with('success', 'Task saved and mock AI refreshed.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);
        $this->taskService->delete($task);

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }

    public function apiIndex(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        return TaskResource::collection(
            $this->taskService->list($request->only(['search', 'status', 'priority', 'assigned_to']), $request->user())
        );
    }

    public function apiStore(StoreTaskRequest $request)
    {
        return (new TaskResource($this->taskService->store($request->validated())))
            ->response()
            ->setStatusCode(201);
    }

    public function apiUpdateStatus(UpdateTaskStatusRequest $request, Task $task): TaskResource
    {
        $status = TaskStatus::from($request->validated('status'));

        return new TaskResource($this->taskService->updateStatus($task, $status));
    }

    public function aiSummary(Request $request, Task $task): TaskResource|RedirectResponse
    {
        $this->authorize('view', $task);
        $task = $this->taskService->refreshAiSummary($task);

        if ($request->expectsJson()) {
            return new TaskResource($task);
        }

        return back()->with('success', 'Mock AI summary refreshed.');
    }

    private function assignableUsers(User $viewer)
    {
        return $viewer->isAdmin()
            ? User::query()->where('is_approved', true)->orderBy('name')->get()
            : User::query()->whereKey($viewer->id)->get();
    }
}
