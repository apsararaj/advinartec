<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Advinartec Machine Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="app-shell">
        <section class="workspace">
            <div class="workspace-header">
                <h1>@yield('title')</h1>
                @hasSection('header_action')
                    @yield('header_action')
                @else
                    <a class="primary-action" href="{{ route('tasks.create') }}">+ New Task</a>
                @endif
            </div>

            @if (session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            @hasSection('hide_filters')
            @else
                <form class="filters" method="GET" action="{{ route('tasks.index') }}">
                    <label class="search-field">
                        <span>Search</span>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search tasks">
                    </label>
                    <label>
                        <span>Status</span>
                        <select name="status" onchange="this.form.submit()">
                            <option value="">All statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Assignee</span>
                        <select name="assigned_to" onchange="this.form.submit()">
                            <option value="">All members</option>
                            @isset($users)
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected((string) request('assigned_to') === (string) $user->id)>{{ $user->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </label>
                    <label>
                        <span>Priority</span>
                        <select name="priority" onchange="this.form.submit()">
                            <option value="">All priorities</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->value }}" @selected(request('priority') === $priority->value)>{{ $priority->label() }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="ghost-submit" type="submit">Filter Tasks</button>
                </form>
            @endif

            <div class="content-grid">
                <div class="content-main">
                    @yield('content')
                </div>
                @include('tasks.partials.sidebar')
            </div>
        </section>
    </main>
</body>
</html>
