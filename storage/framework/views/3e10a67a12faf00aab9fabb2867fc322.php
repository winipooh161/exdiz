<h1><?php echo e($title_site); ?></h1>

<form action="<?php echo e(route('admin.brief.updateCommon', $brief->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <table>
        <tr>
            <td><label for="title">Название:</label></td>
            <td><input type="text" name="title" value="<?php echo e($brief->title); ?>" required></td>
        </tr>

        <tr>
            <td><label for="description">Описание:</label></td>
            <td><textarea name="description"><?php echo e($brief->description); ?></textarea></td>
        </tr>

        <tr>
            <td><label for="price">Общая сумма:</label></td>
            <td><input type="number" name="price" value="<?php echo e($brief->price); ?>"></td>
        </tr>

        <tr>
            <td><label for="status">Статус:</label></td>
            <td>
                <select name="status" required>
                    <option value="active" <?php echo e($brief->status == 'Активный' ? 'selected' : ''); ?>>Активный</option>
                    <option value="inactive" <?php echo e($brief->status == 'Завершенный' ? 'selected' : ''); ?>>Неактивный</option>
                    <option value="completed" <?php echo e($brief->status == 'completed' ? 'selected' : ''); ?>>Завершен</option>
                </select>
            </td>
        </tr>
    </table>

    <button type="submit">Сохранить</button>
</form>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\admin\module\brief_edit_common.blade.php ENDPATH**/ ?>