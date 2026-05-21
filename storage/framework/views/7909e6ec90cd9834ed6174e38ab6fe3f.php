<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Advinartec Machine Test</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <main class="app-shell">
        <section class="workspace">
            <div class="workspace-header">
                <h1><?php echo $__env->yieldContent('title'); ?></h1>
                <?php if (! empty(trim($__env->yieldContent('header_action')))): ?>
                    <?php echo $__env->yieldContent('header_action'); ?>
                <?php else: ?>
                    <a class="primary-action" href="<?php echo e(route('tasks.create')); ?>">+ New Task</a>
                <?php endif; ?>
            </div>

            <?php if(session('success')): ?>
                <div class="flash"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if (! empty(trim($__env->yieldContent('hide_filters')))): ?>
            <?php else: ?>
                <form class="filters" method="GET" action="<?php echo e(route('tasks.index')); ?>">
                    <label class="search-field">
                        <span>Search</span>
                        <input type="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search tasks">
                    </label>
                    <label>
                        <span>Status</span>
                        <select name="status" onchange="this.form.submit()">
                            <option value="">All statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status->value); ?>" <?php if(request('status') === $status->value): echo 'selected'; endif; ?>><?php echo e($status->label()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        <span>Assignee</span>
                        <select name="assigned_to" onchange="this.form.submit()">
                            <option value="">All members</option>
                            <?php if(isset($users)): ?>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php if((string) request('assigned_to') === (string) $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </label>
                    <label>
                        <span>Priority</span>
                        <select name="priority" onchange="this.form.submit()">
                            <option value="">All priorities</option>
                            <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($priority->value); ?>" <?php if(request('priority') === $priority->value): echo 'selected'; endif; ?>><?php echo e($priority->label()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <button class="ghost-submit" type="submit">Filter Tasks</button>
                </form>
            <?php endif; ?>

            <div class="content-grid">
                <div class="content-main">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <?php echo $__env->make('tasks.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </section>
    </main>
</body>
</html>
<?php /**PATH C:\Users\Aslam\Documents\New project 2\adheena-machhine-test\resources\views/layouts/app.blade.php ENDPATH**/ ?>