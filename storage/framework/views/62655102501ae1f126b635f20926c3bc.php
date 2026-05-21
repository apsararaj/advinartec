<?php $__env->startSection('title', $task->exists ? 'Edit Task' : 'Create Task'); ?>

<?php $__env->startSection('content'); ?>
    <section class="panel form-panel">
        <span class="dots panel-dots">••••</span>
        <h2><?php echo e($task->exists ? $task->title : 'Launch New Marketing Campaign'); ?></h2>

        <form method="POST" action="<?php echo e($task->exists ? route('tasks.update', $task) : route('tasks.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if($task->exists): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="glass-form">
                <label>
                    <span>Title</span>
                    <input name="title" value="<?php echo e(old('title', $task->title)); ?>" placeholder="e.g. Launch New Campaign" required>
                </label>
                <label>
                    <span>Description</span>
                    <textarea name="description" rows="4" required><?php echo e(old('description', $task->description)); ?></textarea>
                </label>

                <div class="segmented">
                    <strong>Priority</strong>
                    <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label>
                            <input type="radio" name="priority" value="<?php echo e($priority->value); ?>" <?php if(old('priority', $task->priority?->value ?? 'medium') === $priority->value): echo 'checked'; endif; ?>>
                            <span><?php echo e($priority->label()); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <label>
                    <span>Status</span>
                    <select name="status">
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status->value); ?>" <?php if(old('status', $task->status?->value ?? 'pending') === $status->value): echo 'selected'; endif; ?>><?php echo e($status->label()); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    <span>Due Date</span>
                    <input type="date" name="due_date" value="<?php echo e(old('due_date', $task->due_date?->format('Y-m-d'))); ?>">
                </label>
                <label>
                    <span>Assign To</span>
                    <select name="assigned_to" required>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php if((int) old('assigned_to', $task->assigned_to) === $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
            </div>

            <?php if($errors->any()): ?>
                <div class="error-box"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>

            <button class="save-button" type="submit"><?php echo e($task->exists ? 'Save Changes' : 'Create Task'); ?></button>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Aslam\Documents\New project 2\adheena-machhine-test\resources\views/tasks/form.blade.php ENDPATH**/ ?>