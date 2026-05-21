@extends('layouts.app')

@section('title', 'Task Detail + AI Summary')

@section('content')
    <section class="panel detail-panel">
        <span class="dots panel-dots">••••</span>
        <h2>{{ $task->title }}</h2>
        <div class="meta-row">
            <span>Status <b>{{ $task->status->label() }}</b></span>
            <span>Priority <b>{{ $task->priority->label() }}</b></span>
        </div>

        <div class="glass-form">
            <h3>Description</h3>
            <p><strong>Assigned to:</strong> {{ $task->user->name }}</p>
            <div class="readonly-input">Due Date: {{ $task->due_date?->format('Y-m-d') ?? 'No due date' }}</div>
            <p>{{ $task->description }}</p>

            <section class="summary-box">
                <h3>AI-Generated Summary</h3>
                <p>{{ $task->ai_summary }}</p>
            </section>
            <section class="summary-box compact">
                <p><strong>AI Summary:</strong> {{ $task->ai_summary }}</p>
                <p><strong>AI Suggested Priority:</strong> {{ $task->ai_priority?->label() ?? 'Medium' }}</p>
            </section>
        </div>

        <div class="detail-actions">
            <a class="save-button" href="{{ route('tasks.edit', $task) }}">Save Changes</a>
            <form method="POST" action="{{ route('tasks.ai-summary', $task) }}">
                @csrf
                <button class="refresh-button" type="submit">Refresh AI Summary</button>
            </form>
        </div>
    </section>
@endsection
