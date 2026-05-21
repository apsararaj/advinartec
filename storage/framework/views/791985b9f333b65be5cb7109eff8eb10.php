<?php $__env->startSection('title', 'Task List'); ?>

<?php $__env->startSection('content'); ?>
    <div class="task-grid">
        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="task-card">
                <div class="card-top">
                    <span class="check-dot">✓</span>
                    <span class="status-pill"><?php echo e($task->status->label()); ?></span>
                    <span class="dots">••••</span>
                </div>
                <h2><?php echo e($task->title); ?></h2>
                <div class="badges">
                    <span>Status</span>
                    <b class="priority <?php echo e($task->priority->value); ?>">Priority <?php echo e($task->priority->label()); ?></b>
                </div>
                <p><?php echo e($task->description); ?></p>
                <dl>
                    <div><dt>Assignee</dt><dd><?php echo e($task->user->name); ?></dd></div>
                    <div><dt>Due</dt><dd><?php echo e($task->due_date?->format('Y-m-d') ?? 'No date'); ?></dd></div>
                    <div><dt>AI Suggested Priority</dt><dd><?php echo e($task->ai_priority?->label() ?? $task->priority->label()); ?></dd></div>
                </dl>
                <div class="card-actions">
                    <a class="soft-button" href="<?php echo e(route('tasks.edit', $task)); ?>">Edit</a>
                    <a class="blue-button" href="<?php echo e(route('tasks.show', $task)); ?>">View</a>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <section class="empty-state">
                <h2>No tasks yet</h2>
                <p>Create the first task and the mock AI summary will be generated automatically.</p>
            </section>
        <?php endif; ?>
    </div>

    <?php echo e($tasks->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aslam\Documents\New project 2\adheena-machhine-test\resources\views/tasks/index.blade.php ENDPATH**/ ?>