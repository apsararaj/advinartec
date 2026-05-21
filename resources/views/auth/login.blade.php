<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Advinartec Machine Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main class="auth-shell">
        <section class="login-panel">
            <p class="eyebrow">Advinartec Machine Test</p>
            <h1>Sign in</h1>
            <p class="login-copy">Use the seeded admin or assigned user account to manage tasks securely.</p>

            @if (session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label>
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email', '') }}" required autofocus>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" value="" required>
                </label>
                <label class="remember-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>

                @if ($errors->any())
                    <div class="error-box">{{ $errors->first() }}</div>
                @endif

                <button class="primary-action" type="submit">Login</button>
            </form>

            <p class="auth-switch">Need an account? <a href="{{ route('register') }}">Register for approval</a></p>

            <div class="demo-accounts">
                <strong>Demo accounts</strong>
                <span>Admin: admin@advinartec.test / password</span>
                <span>User: jane@advinartec.test / password</span>
                <span>User: sammy@advinartec.test / password</span>
            </div>
        </section>
    </main>
</body>

</html>
