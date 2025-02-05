<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title_site); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/ponel.js', 'resources/css/style.css', 'resources/css/font.css', 'resources/css/element.css', 'resources/css/animation.css', 'resources/css/mobile.css', 'resources/js/app.js', 'resources/js/modal.js', 'resources/js/success.js', 'resources/js/mask.js', 'resources/js/login.js']); ?>
</head>
<body> 
    <div id="loading-screen">
        <img src="/storage/icon/fool_logo.svg" alt="Loading">
    </div>
    <?php if(session('success')): ?>
        <div id="success-message" class="success-message">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div id="error-message" class="error-message">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
    <main class="py-4">
        
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\estimate\layouts\appCreate.blade.php ENDPATH**/ ?>