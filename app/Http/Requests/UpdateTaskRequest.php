<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('task')) ?? false;
    }

    public function rules(): array
    {
        $allowedAssignees = $this->user()->isAdmin()
            ? User::query()->where('is_approved', true)->pluck('id')->all()
            : [$this->user()->id];

        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'priority' => ['required', Rule::enum(TaskPriority::class)],
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'assigned_to' => ['required', 'integer', Rule::in($allowedAssignees)],
        ];
    }

    public function messages(): array
    {
        return [
            'assigned_to.in' => 'You are not allowed to assign this task to that user.',
            'due_date.after_or_equal' => 'The due date cannot be in the past.',
        ];
    }
}
