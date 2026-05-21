<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Adheena Machine Test</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <main class="auth-shell">
        <section class="login-panel">
            <p class="eyebrow">Adheena Machine Test</p>
            <h1>Create account</h1>
            <p class="login-copy">New accounts are reviewed by an admin before they can access tasks.</p>

            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>
                <label>
                    <span>Name</span>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                </label>
                <label>
                    <span>Email</span>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required>
                </label>
                <label>
                    <span>Confirm Password</span>
                    <input type="password" name="password_confirmation" required>
                </label>

                <?php if($errors->any()): ?>
                    <div class="error-box"><?php echo e($errors->first()); ?></div>
                <?php endif; ?>

                <button class="primary-action" type="submit">Request Approval</button>
            </form>

            <p class="auth-switch">Already approved? <a href="<?php echo e(route('login')); ?>">Login</a></p>
        </section>
    </main>
</body>
</html>
<?php /**PATH C:\Users\Aslam\Documents\New project 2\adheena-machhine-test\resources\views/auth/register.blade.php ENDPATH**/ ?>