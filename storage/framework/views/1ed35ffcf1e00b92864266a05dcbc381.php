
<h1 class="flex">
    Детали  <span class="Jikharev">брифа </span> 
</h1>
<table class="table table-bordered" style="">
    <thead>
        <tr style="">
            <th style="">Поле</th>
            <th style="">ОТВЕТ</th>
        </tr>
    </thead>
    <tbody style="margin-bottom: 30px;">
        <tr>
            <td style="">Артикль</td>
            <td style=""><?php echo e($brif->article); ?></td>
        </tr>
        <tr>
            <td style="">Название</td>
            <td style=""><?php echo e($brif->title); ?></td>
        </tr>
        <tr>
            <td style="">Общая сумма</td>
            <td style=""><?php echo e($brif->price); ?> руб</td>
        </tr>
        <tr>
            <td style="">Описание</td>
            <td style=""><?php echo e($brif->description); ?></td>
        </tr>
        <tr>
            <td style="">Статус</td>
            <td style=""><?php echo e($brif->status); ?></td>
        </tr>
        <tr>
            <td style="">Создатель брифа</td>
            <td style=""><?php echo e($user->name); ?></td>
        </tr>
        <tr>
            <td style="">Номер клиента</td>
            <td style=""><?php echo e($user->phone); ?></td>
        </tr>
    </tbody>
    <tbody>
        
        <?php for($i = 1; $i <= 15; $i++): ?>
            <tr>
                <td colspan="2" style=" ">
                    <h3 style="font-size: 16px; margin: 0; text-align:left;"><?php echo e($pageTitlesCommon[$i - 1]); ?></h3>
                </td>
            </tr>
            <?php $__currentLoopData = $questions[$i]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $field = $question['key'];
                ?>
                <?php if(isset($brif->$field)): ?>
                    <tr>
                        <td style=""><?php echo e($question['title']); ?></td>
                        <td style=""><?php echo e($brif->$field); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endfor; ?>
    </tbody>

    <table class="table table-bordered" style="">
        <thead>
            <tr style="">
                <th style="">Название файла</th>
                <th style="">Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php if($brif->documents && is_array(json_decode($brif->documents, true))): ?>
                <?php $__empty_1 = true; $__currentLoopData = json_decode($brif->documents, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style=""><?php echo e(basename($document)); ?></td>
                        <td style="">
                            <a href="<?php echo e(asset($document)); ?>" target="_blank">Скачать</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" style=" text-align: center;">Документов не найдено</td>
                    </tr>
                <?php endif; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style=" text-align: center;">Документов не найдено</td>
                </tr>
            <?php endif; ?>
        </tbody>
        
    </table>
    <tbody>
        <tr>
            <td style="">Дата создания</td>
            <td style=""><?php echo e($brif->created_at); ?></td>
        </tr>
        <tr>
            <td style="">Дата обновления</td>
            <td style=""><?php echo e($brif->updated_at); ?></td>
        </tr>
    </tbody>
</table>

<style>
   

    table {
        border: 1px solid #ddd;
      
        width: 100%;
    }

    th, td {
      
        border: 1px solid #ddd;
    }

    th {
       
        font-weight: bold;
    }

 
</style>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views/common/module/show.blade.php ENDPATH**/ ?>