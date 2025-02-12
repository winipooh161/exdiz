<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title_site); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')([ 'resources/css/style.css', 'resources/css/font.css', 'resources/css/element.css', 'resources/css/animation.css', 'resources/css/mobile.css', 'resources/js/app.js', 'resources/js/modal.js', 'resources/js/success.js', 'resources/js/mask.js', 'resources/js/login.js']); ?></head>
    <link rel="stylesheet" href="resources/css/animate.css">
    <script src="resources/js/wow.js"></script>
     <!-- Обязательный (и достаточный) тег для браузеров -->
     <link type="image/x-icon" rel="shortcut icon" href="<?php echo e(asset('/favicon.ico')); ?>">

     <!-- Дополнительные иконки для десктопных браузеров -->
     <link type="image/png" sizes="16x16" rel="icon" href="<?php echo e(asset('/icons/favicon-16x16.png')); ?>">
     <link type="image/png" sizes="32x32" rel="icon" href="<?php echo e(asset('/icons/favicon-32x32.png')); ?>">
     <link type="image/png" sizes="96x96" rel="icon" href="<?php echo e(asset('/icons/favicon-96x96.png')); ?>">
     <link type="image/png" sizes="120x120" rel="icon" href="<?php echo e(asset('/icons/favicon-120x120.png')); ?>">
 
     <!-- Иконки для Android -->
     <link type="image/png" sizes="72x72" rel="icon" href="<?php echo e(asset('/icons/android-icon-72x72.png')); ?>">
     <link type="image/png" sizes="96x96" rel="icon" href="<?php echo e(asset('/icons/android-icon-96x96.png')); ?>">
     <link type="image/png" sizes="144x144" rel="icon" href="<?php echo e(asset('/icons/android-icon-144x144.png')); ?>">
     <link type="image/png" sizes="192x192" rel="icon" href="<?php echo e(asset('/icons/android-icon-192x192.png')); ?>">
     <link type="image/png" sizes="512x512" rel="icon" href="<?php echo e(asset('/icons/android-icon-512x512.png')); ?>">
     <link rel="manifest" href="./manifest.json">
 
     <!-- Иконки для iOS (Apple) -->
     <link sizes="57x57" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-57x57.png')); ?> ">
     <link sizes="60x60" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-60x60.png')); ?> ">
     <link sizes="72x72" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-72x72.png')); ?> ">
     <link sizes="76x76" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-76x76.png')); ?> ">
     <link sizes="114x114" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-114x114.png')); ?> ">
     <link sizes="120x120" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-120x120.png')); ?> ">
     <link sizes="144x144" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-144x144.png')); ?> ">
     <link sizes="152x152" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-152x152.png')); ?> ">
     <link sizes="180x180" rel="apple-touch-icon" href="<?php echo e(asset('/icons/apple-touch-icon-180x180.png')); ?> ">
 
     <!-- Иконки для MacOS (Apple) -->
     <link color="#e52037" rel="mask-icon" href="./safari-pinned-tab.svg">
 
     <!-- Иконки и цвета для плиток Windows -->
     <meta name="msapplication-TileColor" content="#2b5797">
     <meta name="msapplication-TileImage" content="./mstile-144x144.png">
     <meta name="msapplication-square70x70logo" content="./mstile-70x70.png">
     <meta name="msapplication-square150x150logo" content="./mstile-150x150.png">
     <meta name="msapplication-wide310x150logo" content="./mstile-310x310.png">
     <meta name="msapplication-square310x310logo" content="./mstile-310x150.png">
     <meta name="application-name" content="My Application">
     <meta name="msapplication-config" content="./browserconfig.xml">
     <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <script>
        wow = new WOW({
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 0, // default
            mobile: true, // default
            live: true // default
        })
        wow.init();
    </script>
<body>
  
      <div id="loading-screen" class="wow fadeInleft" data-wow-duration="1s" data-wow-delay="1s"">
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
        <?php echo $__env->make('layouts/mobponel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('toggle-panel');
    const panel = document.querySelector('.main__ponel');
    // Проверяем сохраненное состояние панели в localStorage
    const isCollapsed = localStorage.getItem('panelCollapsed') === 'true';
    if (isCollapsed) {
        panel.classList.add('collapsed');
    }
    // Обработчик клика по кнопке переключения
    toggleButton.addEventListener('click', () => {
        panel.classList.toggle('collapsed');
        // Сохраняем текущее состояние панели в localStorage
        const collapsed = panel.classList.contains('collapsed');
        localStorage.setItem('panelCollapsed', collapsed);
    });
});

</script>
</body>

</html>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\layouts\admin.blade.php ENDPATH**/ ?>