<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('hide_filters', true); ?>
<?php $__env->startSection('header_action'); ?>
    <a class="primary-action" href="<?php echo e(route('tasks.index')); ?>">Back to Tasks</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="panel users-panel">
        <div class="section-head">
            <div>
                <h2>User Approval</h2>
                <p>Review new registrations and approve access for task management.</p>
            </div>
        </div>

        <div class="user-list">
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="user-row">
                    <div class="avatar"><?php echo e(str($user->name)->substr(0, 1)->upper()); ?></div>
                    <div class="user-meta">
                        <h3><?php echo e($user->name); ?></h3>
                        <p><?php echo e($user->email); ?></p>
                    </div>
                    <span class="role-badge"><?php echo e(ucfirst($user->role)); ?></span>
                    <span class="approval-badge <?php echo e($user->isApproved() ? 'approved' : 'pending'); ?>">
                        <?php echo e($user->isApproved() ? 'Approved' : 'Pending Approval'); ?>

                    </span>
                    <span class="task-count"><?php echo e($user->tasks_count); ?> <?php echo e(str('task')->plural($user->tasks_count)); ?></span>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $user)): ?>
                        <?php if(! $user->isApproved()): ?>
                            <form method="POST" action="<?php echo e(route('users.approve', $user)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button class="blue-button" type="submit">Approve</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php echo e($users->links()); ?>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aslam\Documents\New project 2\adheena-machhine-test\resources\views/users/index.blade.php ENDPATH**/ ?>