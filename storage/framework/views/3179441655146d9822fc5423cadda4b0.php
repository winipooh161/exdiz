<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="main__flex">
        <div class="main__ponel">
            <?php echo $__env->make('layouts/ponel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="main__module">
            <?php echo $__env->make('layouts/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('chats.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<!-- Скрытый скрипт для передачи данных Laravel в JS -->
<script>
    window.Laravel = {
        user: <?php echo json_encode([
            'id' => $user->id, 'name' => $user->name, // Добавьте другие необходимые данные
        ]) ?>,
    };
</script>

<!-- Подключение основного JS-файла с атрибутом defer для асинхронной загрузки -->
<script src="<?php echo e(asset('js/chat.js')); ?>" defer></script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\dlk\resources\views\chats.blade.php ENDPATH**/ ?>