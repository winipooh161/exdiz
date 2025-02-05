
    <h1>Брифы пользователя: <?php echo e($user->name); ?></h1>
    <div>
        <h2>Общие брифы</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $commonBriefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($brief->id); ?></td>
                        <td><?php echo e($brief->title); ?></td>
                        <td><?php echo e($brief->status); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.brief.editCommon', $brief->id)); ?>">Редактировать</a>


                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div>
        <h2>Коммерческие брифы</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $commercialBriefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($brief->id); ?></td>
                        <td><?php echo e($brief->title); ?></td>
                        <td><?php echo e($brief->status); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.brief.editCommercial', $brief->id)); ?>">Редактировать</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php /**PATH C:\OSPanel\domains\dlk\resources\views/admin/module/user_briefs.blade.php ENDPATH**/ ?>