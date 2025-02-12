<h1>Детали брифа</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Поле</th>
            <th>Значение</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ID</td>
            <td><?php echo e($brif->id); ?></td>
        </tr>
        <tr>
            <td>Название</td>
            <td><?php echo e($brif->title); ?></td>
        </tr>
        <tr>
            <td>Описание</td>
            <td><?php echo e($brif->description); ?></td>
        </tr>
        <tr>
            <td>Статус</td>
            <td><?php echo e($brif->status); ?></td>
        </tr>
        <tr>
            <td>User ID</td>
            <td><?php echo e($brif->user_id); ?></td>
        </tr>
        <tr>
            <td>Дата создания</td>
            <td><?php echo e($brif->created_at); ?></td>
        </tr>
        <tr>
            <td>Дата обновления</td>
            <td><?php echo e($brif->updated_at); ?></td>
        </tr>
    </tbody>
</table>

<!-- Отображаем общий бюджет -->
<h2><strong>Общий бюджет:</strong> <?php echo e(number_format($brif->price, 2, ',', ' ')); ?> ₽</h2>

<!-- Если бюджет разбивается по зонам -->
<?php if($zones): ?>
    <h3>Бюджет по зонам</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Зона</th>
                <th>Бюджет</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($zone['name'] ?? 'Без названия'); ?></td>
                    <td>
                        <?php if(isset($price[$index])): ?>
                            <?php echo e(number_format($price[$index], 2, ',', ' ')); ?> ₽ <!-- Форматируем цену для каждой зоны -->
                        <?php else: ?>
                            0 ₽
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>

<h2>Зоны</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Описание</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($zone['name'] ?? 'Без названия'); ?></td>
                <td><?php echo e($zone['description'] ?? ''); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php $__currentLoopData = $preferencesFormatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zoneName => $zonePreferences): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <h3>Предпочтения для <?php echo e($zoneName); ?></h3> <!-- Здесь выводится название зоны -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Вопрос</th>
                <th>Ответ</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $zonePreferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $preference): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($preference['question']); ?></td>
                    <td><?php echo e($preference['answer']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Документы -->
<h2 style="margin-top: 30px;">Документы</h2>
<table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f7f7f7; font-weight: bold;">
            <th style="padding: 15px; text-align: left;">Название файла</th>
            <th style="padding: 15px; text-align: left;">Действие</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $documents = json_decode($brif->documents, true) ?? [];
    ?>
    
    <?php if(!empty($documents) && is_array($documents)): ?>
        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="padding: 10px;"><?php echo e(basename($document)); ?></td>
                <td style="padding: 10px;">
                    <a href="<?php echo e(asset($document)); ?>" target="_blank">Скачать</a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <tr>
            <td colspan="2" style="padding: 10px; text-align: center;">Документов не найдено</td>
        </tr>
    <?php endif; ?>
    
    </tbody>
</table>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\commercial\module\show.blade.php ENDPATH**/ ?>