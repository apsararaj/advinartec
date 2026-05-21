<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Advinartec Machine Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="auth-shell">
        <section class="login-panel">
            <p class="eyebrow">Advinartec Machine Test</p>
            <h1>Create account</h1>
            <p class="login-copy">New accounts are reviewed by an admin before they can access tasks.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <label>
                    <span>Name</span>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus>
                </label>
                <label>
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required>
                </label>
                <label>
                    <span>Confirm Password</span>
                    <input type="password" name="password_confirmation" required>
                </label>

                @if ($errors->any())
                    <div class="error-box">{{ $errors->first() }}</div>
                @endif

                <button class="primary-action" type="submit">Request Approval</button>
            </form>

            <p class="auth-switch">Already approved? <a href="{{ route('login') }}">Login</a></p>
        </section>
    </main>
</body>
</html>
