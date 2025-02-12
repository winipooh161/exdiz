<div class="deals-list">
    <h1 class=" flex" >
        Ваша  <span class="Jikharev">сделка</span>  
      
    </h1>
    <?php if($userDeals->isNotEmpty()): ?>
        <?php $__currentLoopData = $userDeals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="deal" id="deal-<?php echo e($deal->id); ?>">
                <div class="deal__body">
                    <!-- Информация о сделке -->
                    <div class="deal__info">
                        <div class="deal__info__profile">
                            <div class="deal__avatar">
                                <img src="<?php echo e(asset('' . $deal->avatar_path)); ?>" alt="Avatar">
                            </div>
                            <div class="deal__info__title">
                                <h3><?php echo e($deal->name); ?></h3>
                                <p> <?php echo e($deal->description ?? 'Описание отсутствует'); ?></p>
                               
                            </div>
                        </div>
                        
                        <div class="faq_question__deal__status">
                            <p><?php echo e($deal->status); ?></p>
                            <h3><br> <?php echo e($deal->total_sum ?? 'Отсутствует'); ?></h3>
                            <?php if($deal->link): ?>
                                <p>Привязанный бриф <br>
                                    <a href="<?php echo e($deal->link); ?>">
                                        <?php echo e($deal->link); ?>

                                    </a>
                                </p>
                            <?php else: ?>
                                <p>Бриф не прикреплен</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="deal__container">
                        <div class="deal__info__point">
                        
                            
                            <?php
                                // Найдём конкретный групповой чат для этой сделки:
                                $groupChatForDeal = \App\Models\Chat::where('deal_id', $deal->id)
                                    ->where('type', 'group')
                                    ->first();
                            ?>
                        
                            <?php echo $__env->make('chats.index', [
                                'dealChat' => $groupChatForDeal, // передаём объект
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                       
                        
                            
                        </div>
                        <!-- Секция ответственных за сделку -->
                        <div class="deal__responsible">
                            <ul>
                                <h4>Ответственные за сделку:</h4>
                                <?php if($deal->users->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $deal->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="deal__responsible__user">
                                            <div class="deal__responsible__avatar">
                                                <img src="<?php echo e($user->avatar_url ?? '/images/default-avatar.png'); ?>"
                                                    alt="Аватар <?php echo e($user->name); ?>">
                                            </div>
                                            <div class="deal__responsible__info">
                                                <h5><?php echo e($user->name); ?></h5>
                                                <p><?php echo e($user->status); ?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <li class="deal__responsible__user">
                                        <p>Ответственные не назначены</p>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <p>У вас пока нет сделок.</p>
    <?php endif; ?>
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views/deals/user.blade.php ENDPATH**/ ?>