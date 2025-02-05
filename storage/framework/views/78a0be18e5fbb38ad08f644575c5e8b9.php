<h1 style="">Детали брифа</h1>
<table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f7f7f7; font-weight: bold;">
            <th style="padding: 15px; text-align: left;">Поле</th>
            <th style="padding: 15px; text-align: left;">ОТВЕТ</th>
        </tr>
    </thead>
    <tbody style="margin-bottom: 30px;">
        <tr>
            <td style="padding: 10px; font-weight: bold;">Артикль</td>
            <td style="padding: 10px;"><?php echo e($brif->article); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Название</td>
            <td style="padding: 10px;"><?php echo e($brif->title); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Общая сумма</td>
            <td style="padding: 10px;"><?php echo e($brif->price); ?> руб</td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Описание</td>
            <td style="padding: 10px;"><?php echo e($brif->description); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Статус</td>
            <td style="padding: 10px;"><?php echo e($brif->status); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Создатель брифа</td>
            <td style="padding: 10px;"><?php echo e($user->name); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Номер клиента</td>
            <td style="padding: 10px;"><?php echo e($user->phone); ?></td>
        </tr>
    </tbody>
    <tbody>
        
        <?php for($i = 1; $i <= 15; $i++): ?>
            <tr>
                <td colspan="2" style="background-color: rgb(233, 233, 233); padding: 10px;">
                    <h3 style="font-size: 16px; margin: 0; text-align:left;"><?php echo e($pageTitlesCommon[$i - 1]); ?></h3>
                </td>
            </tr>
            <?php $__currentLoopData = $questions[$i]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $field = $question['key'];
                ?>
                <?php if(isset($brif->$field)): ?>
                    <tr>
                        <td style="padding: 10px; font-weight: bold;"><?php echo e($question['title']); ?></td>
                        <td style="padding: 10px;"><?php echo e($brif->$field); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endfor; ?>
    </tbody>

    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f7f7f7; font-weight: bold;">
                <th style="padding: 15px; text-align: left;">Название файла</th>
                <th style="padding: 15px; text-align: left;">Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php if($brif->documents && is_array(json_decode($brif->documents, true))): ?>
                <?php $__empty_1 = true; $__currentLoopData = json_decode($brif->documents, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="padding: 10px;"><?php echo e(basename($document)); ?></td>
                        <td style="padding: 10px;">
                            <a href="<?php echo e(asset($document)); ?>" target="_blank">Скачать</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" style="padding: 10px; text-align: center;">Документов не найдено</td>
                    </tr>
                <?php endif; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="padding: 10px; text-align: center;">Документов не найдено</td>
                </tr>
            <?php endif; ?>
        </tbody>
        
    </table>
    <tbody>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Дата создания</td>
            <td style="padding: 10px;"><?php echo e($brif->created_at); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold;">Дата обновления</td>
            <td style="padding: 10px;"><?php echo e($brif->updated_at); ?></td>
        </tr>
    </tbody>
</table>

<style>
    h1 {
        font-size: 28px;
        color: #333;
    }

    table {
        border: 1px solid #ddd;
        margin: 0 auto;
        width: 95%;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    td[colspan="2"] {
        text-align: center;
    }

    h3 {
        font-size: 18px;
        margin: 0;
        padding: 0;
    }
</style>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\common\module\show.blade.php ENDPATH**/ ?>