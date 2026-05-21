@extends('layouts.app')

@section('title', 'Users')
@section('hide_filters', true)
@section('header_action')
    <a class="primary-action" href="{{ route('tasks.index') }}">Back to Tasks</a>
@endsection

@section('content')
    <section class="panel users-panel">
        <div class="section-head">
            <div>
                <h2>User Approval</h2>
                <p>Review new registrations and approve access for task management.</p>
            </div>
        </div>

        <div class="user-list">
            @foreach ($users as $user)
                <article class="user-row">
                    <div class="avatar">{{ str($user->name)->substr(0, 1)->upper() }}</div>
                    <div class="user-meta">
                        <h3>{{ $user->name }}</h3>
                        <p>{{ $user->email }}</p>
                    </div>
                    <span class="role-badge">{{ ucfirst($user->role) }}</span>
                    <span class="approval-badge {{ $user->isApproved() ? 'approved' : 'pending' }}">
                        {{ $user->isApproved() ? 'Approved' : 'Pending Approval' }}
                    </span>
                    <span class="task-count">{{ $user->tasks_count }} {{ str('task')->plural($user->tasks_count) }}</span>
                    @can('approve', $user)
                        @if (! $user->isApproved())
                            <form method="POST" action="{{ route('users.approve', $user) }}">
                                @csrf
                                @method('PATCH')
                                <button class="blue-button" type="submit">Approve</button>
                            </form>
                        @endif
                    @endcan
                </article>
            @endforeach
        </div>

        {{ $users->links() }}
    </section>
@endsection
