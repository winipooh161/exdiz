<div class="brifs wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s" id="brifs">
    <h1 class=" flex" >
        Ваши брифы
        <img class="px20" src="/storage/icon/brif_classic.svg" alt="">
    </h1>

    <div class="brifs__button__create flex  ">
        <button onclick="window.location.href='<?php echo e(route('common.create')); ?>'">Создать Общий бриф</button>
        <button onclick="window.location.href='<?php echo e(route('commercial.create')); ?>'">Создать Коммерческий бриф</button>
    </div>
</div>

<div class="brifs__body wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">

    
    <div class="brifs__section">
        <h2 class="" >
            Активные брифы
            <img class="px20" src="/storage/icon/brif_active.svg" alt="">
        </h2>

        <?php if($activeBrifs->isEmpty()): ?>
            <ul class="brifs__list brifs__list__null">
                <li class="brif" onclick="window.location.href='<?php echo e(route('common.create')); ?>'">
                    <p>Создать Общий бриф</p>
                </li>
            </ul>
        <?php else: ?>
            <ul class="brifs__list">
                <?php $__currentLoopData = $activeBrifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="brif  " 
                        onclick="window.location.href='<?php echo e(route($brif instanceof \App\Models\Common ? 'common.questions' : 'commercial.questions', ['page' => $brif->current_page])); ?>'">
                        
                        <h3><strong>Начатый бриф</strong></h3>
                        <p class="name__brif"><?php echo e($brif->title); ?> <?php echo e($brif->article); ?></p>
                        
                        <div class="brif__body flex">
                            <ul>
                                <?php $__currentLoopData = ($brif instanceof \App\Models\Common ? $pageTitlesCommon : $pageTitlesCommercial); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="<?php echo e($index + 1 <= $brif->current_page ? 'completed' : ''); ?>">
                                        <?php echo e($title); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <p class="flex wd100 between">
                            <span><?php echo e($brif->created_at->format('H:i')); ?></span>
                            <span><?php echo e($brif->created_at->format('Y-m-d')); ?></span>
                        </p>

                        <span class="brif__status">Продолжить</span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

    
    <div class="brifs__section brifs__section__finished " >
        <h2>Завершенные брифы <img class="px20" src="/storage/icon/brif_inactive.svg" alt=""></h2>

        <?php if($inactiveBrifs->isEmpty()): ?>
            <p>У вас нет завершенных брифов.</p>
        <?php else: ?>
            <ul class="brifs__list">
                <?php $__currentLoopData = $inactiveBrifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="brif" onclick="window.location.href='<?php echo e(route($brif instanceof \App\Models\Common ? 'common.show' : 'commercial.show', $brif->id)); ?>'">
                        <h3><strong>Законченный бриф</strong></h3>
                        <p class="name__brif"><?php echo e($brif->title); ?> <?php echo e($brif->article); ?></p>
                        <p class="flex wd100 between">
                            <span><?php echo e($brif->created_at->format('H:i')); ?></span>
                            <span><?php echo e($brif->created_at->format('Y-m-d')); ?></span>
                        </p>
                        <span class="brif__status">Подробнее</span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\module\brifs.blade.php ENDPATH**/ ?>