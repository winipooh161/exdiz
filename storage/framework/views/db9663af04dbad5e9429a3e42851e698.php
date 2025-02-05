<div class="admin__module admin__body">
    <h1>Панель администратора</h1>
   <?php echo $__env->make('admin.module.fast_link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="information_admin">
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Тип данных</th>
                    <th>Количество</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Количество пользователей</td>
                    <td><?php echo e($usersCount); ?></td>
                </tr>
                <tr>
                    <td>Количество общих брифов</td>
                    <td><?php echo e($commonsCount); ?></td>
                </tr>
                <tr>
                    <td>Количество коммерческих брифов</td>
                    <td><?php echo e($commercialsCount); ?></td>
                </tr>
                <tr>
                    <td>Количество сделок</td>
                    <td><?php echo e($dealsCount); ?></td>
                </tr>
                <tr>
                    <td>Количество смет</td>
                    <td><?php echo e($estimatesCount); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
   
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views/admin/home.blade.php ENDPATH**/ ?>