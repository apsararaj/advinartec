<aside class="sidebar">
    <section class="profile-card">
        <div class="profile-head">
            <div class="avatar">{{ str(auth()->user()->name)->substr(0, 1)->upper() }}</div>
            <strong>{{ auth()->user()->name }}</strong>
        </div>
        <nav class="side-nav">
            <a class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">Tasks</a>
            @can('viewAny', \App\Models\User::class)
                <a class="{{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a>
            @endcan
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
        <div class="rings">
            <div><b>{{ $analytics['total'] }}</b><span>Total Tasks</span></div>
            <div><b>{{ $analytics['completed'] }}</b><span>Completed</span></div>
            <div><b>{{ $analytics['high'] }}</b><span>High Priority</span></div>
        </div>
        <p class="mini-title">Monthly Task Completion</p>
        <div class="mini-bars">
            @foreach ($analytics['monthly'] as $month => $height)
                <i></i>
            @endforeach
        </div>
    </section>

    <section class="chart-card">
        <h3>Monthly Task Completion</h3>
        <div class="axis-chart">
            @foreach ($analytics['monthly'] as $height)
                <i></i>
            @endforeach
        </div>
        <div class="chart-labels"><span>Jan</span><span>Feb</span><span>Apr</span><span>May</span></div>
    </section>
</aside>
