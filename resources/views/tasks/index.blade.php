@extends('layouts.app')

@section('title', 'Task List')

@section('content')
    <div class="task-grid">
        @forelse ($tasks as $task)
            <article class="task-card">
                <div class="card-top">
                    <span class="check-dot">✓</span>
                    <span class="status-pill">{{ $task->status->label() }}</span>
                    <span class="dots">••••</span>
                </div>
                <h2>{{ $task->title }}</h2>
                <div class="badges">
                    <span>Status</span>
                    <b class="priority {{ $task->priority->value }}">Priority {{ $task->priority->label() }}</b>
                </div>
                <p>{{ $task->description }}</p>
                <dl>
                    <div><dt>Assignee</dt><dd>{{ $task->user->name }}</dd></div>
                    <div><dt>Due</dt><dd>{{ $task->due_date?->format('Y-m-d') ?? 'No date' }}</dd></div>
                    <div><dt>AI Suggested Priority</dt><dd>{{ $task->ai_priority?->label() ?? $task->priority->label() }}</dd></div>
                </dl>
                <div class="card-actions">
                    <a class="soft-button" href="{{ route('tasks.edit', $task) }}">Edit</a>
                    <a class="blue-button" href="{{ route('tasks.show', $task) }}">View</a>
                </div>
            </article>
        @empty
            <section class="empty-state">
                <h2>No tasks yet</h2>
                <p>Create the first task and the mock AI summary will be generated automatically.</p>
            </section>
        @endforelse
    </div>

    {{ $tasks->links() }}
@endsection
