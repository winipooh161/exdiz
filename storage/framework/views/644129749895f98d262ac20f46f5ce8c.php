<?php if($activeBrifs->isEmpty() && $inactiveBrifs->isEmpty()): ?>
    

    <form action="<?php echo e(route('brifs.store')); ?>" method="POST" class="div__create_form">
        <?php echo csrf_field(); ?>
        <div class="div__create_block">
            <h1>
                <span class="Jikharev">Уважаемый клиент,</span>
                мы подготовили для Вас бриф
            </h1>
            <p>
                Вам необходимо заполнить все поля. Чем больше мы получим информации,
                тем более точный результат мы сможем гарантировать!
            </p>
            <div class=" flex gap3">
            <!-- Две кнопки. Каждая «говорит» контроллеру, какой именно бриф нужно создать. -->
            <button type="submit" name="brif_type" value="common">Создать Общий бриф</button>
            <button type="submit" name="brif_type" value="commercial">Создать Коммерческий бриф</button>
        </div>
        </div>
    </form>

<?php else: ?>
    

    <div class="brifs wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s" id="brifs">
        <h1 class="flex">
            Ваши <span class="Jikharev">брифы</span>
        </h1>

        <div class="brifs__button__create flex">
            <button onclick="window.location.href='<?php echo e(route('common.create')); ?>'">Создать Общий бриф</button>
            <button onclick="window.location.href='<?php echo e(route('commercial.create')); ?>'">Создать Коммерческий бриф</button>
        </div>
    </div>

    <div class="brifs__body wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
        <!-- Активные брифы -->
        <div class="brifs__section">
            <h2>Активные брифы</h2>

            <?php if($activeBrifs->isEmpty()): ?>
                <ul class="brifs__list brifs__list__null">
                    <li class="brif" onclick="window.location.href='<?php echo e(route('common.create')); ?>'">
                        <p>Создать Общий бриф</p>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="brifs__list">
                    <?php $__currentLoopData = $activeBrifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="brif"
                            onclick="window.location.href='<?php echo e(route(
                                $brif instanceof \App\Models\Common
                                    ? 'common.questions'
                                    : 'commercial.questions',
                                [
                                    'id'   => $brif->id,
                                    'page' => $brif->current_page
                                ]
                            )); ?>'">
                            
                            <h4><strong><?php echo e($brif->title); ?> #<?php echo e($brif->id); ?></strong></h4>
                            <div class="brif__body flex">
                                <ul>
                                    <?php $__currentLoopData = ($brif instanceof \App\Models\Common
                                            ? $pageTitlesCommon
                                            : $pageTitlesCommercial); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php echo e($index + 1 <= $brif->current_page ? 'completed' : ''); ?>">
                                            <?php echo e($title); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>

                            <div class="button__brifs flex">
                                <button class="button__variate2">Заполнить</button>
                                <button class="button__variate2">Удалить</button>
                            </div>
                            <p class="flex wd100 between">
                                <span><?php echo e($brif->created_at->format('H:i')); ?></span>
                                <span><?php echo e($brif->created_at->format('d.m.Y')); ?></span>
                            </p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>

        
        <div class="brifs__section brifs__section__finished">
            <h2>Завершенные брифы</h2>

            <?php if($inactiveBrifs->isEmpty()): ?>
                <p>У вас нет завершенных брифов.</p>
            <?php else: ?>
                <ul class="brifs__list">
                    <?php $__currentLoopData = $inactiveBrifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="brif"
                            onclick="window.location.href='<?php echo e(route(
                                $brif instanceof \App\Models\Common
                                    ? 'common.show'
                                    : 'commercial.show',
                                $brif->id
                            )); ?>'">
                            
                            <h4><strong><?php echo e($brif->title); ?> #<?php echo e($brif->id); ?></strong></h4>
                            <p class="flex wd100 between">
                                <span><?php echo e($brif->created_at->format('H:i')); ?></span>
                                <span><?php echo e($brif->created_at->format('d.m.Y')); ?></span>
                            </p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\module\brifs.blade.php ENDPATH**/ ?>