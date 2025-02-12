<h1><?php echo e($title_site); ?></h1>

<form action="<?php echo e(route('admin.brief.updateCommercial', $brief->id)); ?>" method="POST">
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

        <!-- Loop through the questions (questions, preferences, zones) if available -->
        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $questionGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="2">
                    <fieldset>
                        <legend>Раздел <?php echo e($section); ?></legend>
                        <table>
                            <?php $__currentLoopData = $questionGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><label for="<?php echo e($question['key']); ?>"><?php echo e($question['title']); ?></label></td>
                                    <td>
                                        <?php if($question['type'] === 'textarea'): ?>
                                            <textarea name="questions[<?php echo e($section); ?>][<?php echo e($question['key']); ?>]" placeholder="<?php echo e($question['placeholder']); ?>">
                                                <?php echo e(old('questions.' . $section . '.' . $question['key'], $brief->questions[$section][$question['key']] ?? '')); ?>

                                            </textarea>
                                        <?php elseif($question['type'] === 'checkbox'): ?>
                                            <input type="checkbox" name="questions[<?php echo e($section); ?>][<?php echo e($question['key']); ?>]"
                                                <?php echo e(old('questions.' . $section . '.' . $question['key'], $brief->questions[$section][$question['key']] ?? false) ? 'checked' : ''); ?>>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if(!empty($question['subtitle'])): ?>
                                    <tr>
                                        <td colspan="2">
                                            <small><?php echo e($question['subtitle']); ?></small>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                    </fieldset>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>

    <button type="submit">Сохранить</button>
</form>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\admin\module\brief_edit_commercial.blade.php ENDPATH**/ ?>