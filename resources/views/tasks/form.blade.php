@extends('layouts.app')

@section('title', $task->exists ? 'Edit Task' : 'Create Task')

@section('content')
    <section class="panel form-panel">
        <span class="dots panel-dots">••••</span>
        <h2>{{ $task->exists ? $task->title : 'Launch New Marketing Campaign' }}</h2>

        <form method="POST" action="{{ $task->exists ? route('tasks.update', $task) : route('tasks.store') }}">
            @csrf
            @if ($task->exists)
                @method('PUT')
            @endif

            <div class="glass-form">
                <label>
                    <span>Title</span>
                    <input name="title" value="{{ old('title', $task->title) }}" placeholder="e.g. Launch New Campaign" required>
                </label>
                <label>
                    <span>Description</span>
                    <textarea name="description" rows="4" required>{{ old('description', $task->description) }}</textarea>
                </label>

                <div class="segmented">
                    <strong>Priority</strong>
                    @foreach ($priorities as $priority)
                        <label>
                            <input type="radio" name="priority" value="{{ $priority->value }}" @checked(old('priority', $task->priority?->value ?? 'medium') === $priority->value)>
                            <span>{{ $priority->label() }}</span>
                        </label>
                    @endforeach
                </div>

                <label>
                    <span>Status</span>
                    <select name="status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $task->status?->value ?? 'pending') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span>Due Date</span>
                    <input type="date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                </label>
                <label>
                    <span>Assign To</span>
                    <select name="assigned_to" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected((int) old('assigned_to', $task->assigned_to) === $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            @if ($errors->any())
                <div class="error-box">{{ $errors->first() }}</div>
            @endif

            <button class="save-button" type="submit">{{ $task->exists ? 'Save Changes' : 'Create Task' }}</button>
        </form>
    </section>
@endsection
