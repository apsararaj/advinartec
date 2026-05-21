<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Advinartec Machine Test</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body>
    <main class="auth-shell">
        <section class="login-panel">
            <p class="eyebrow">Advinartec Machine Test</p>
            <h1>Sign in</h1>
            <p class="login-copy">Use the seeded admin or assigned user account to manage tasks securely.</p>

            <?php if(session('success')): ?>
                <div class="flash"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <label>
                    <span>Email</span>
                    <input type="email" name="email" value="<?php echo e(old('email', '')); ?>" required autofocus>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" value="" required>
                </label>
                <label class="remember-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>

                <?php if($errors->any()): ?>
                    <div class="error-box"><?php echo e($errors->first()); ?></div>
                <?php endif; ?>

                <button class="primary-action" type="submit">Login</button>
            </form>

            <p class="auth-switch">Need an account? <a href="<?php echo e(route('register')); ?>">Register for approval</a></p>

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
<?php /**PATH C:\Users\Aslam\Documents\New project 2\adheena-machhine-test\resources\views/auth/login.blade.php ENDPATH**/ ?>