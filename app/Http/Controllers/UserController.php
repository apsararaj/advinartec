<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        return view('users.index', [
            'users' => User::query()
                ->withCount('tasks')
                ->orderBy('is_approved')
                ->orderBy('name')
                ->paginate(12),
            'analytics' => $this->taskService->analytics($request->user()),
        ]);
    }

    public function approve(Request $request, User $user): RedirectResponse
    {
        $this->authorize('approve', $user);

        if (! $user->isAdmin()) {
            $user->forceFill([
                'is_approved' => true,
                'approved_at' => now(),
            ])->save();
        }

        return back()->with('success', "{$user->name} has been approved.");
    }
}
