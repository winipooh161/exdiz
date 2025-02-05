
    <div class="main__flex">
        <div class="main__ponel">
        
        </div>
        <div class="main__module">
      
            <h1>Все жалобы</h1>
            <div class="support_adm">
                <?php $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="support_adm__card">
                        <div class="complaint">
                            <div class="complaint__user">
                                <h3><?php echo e($complaint->title); ?></h3>
                                <p><?php echo e($complaint->description); ?></p>
                                <p>Ответ: <?php echo e($complaint->response ?? 'Ответ еще не предоставлен'); ?></p>
                            </div>
            
                            <div class="complaint__support">
                                <a href="<?php echo e(route('support.chat', ['complaintId' => $complaint->id])); ?>">Перейти в чат</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
        </div>
    </div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\support\module\complaints.blade.php ENDPATH**/ ?>