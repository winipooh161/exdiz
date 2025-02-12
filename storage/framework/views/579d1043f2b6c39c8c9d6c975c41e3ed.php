<header class="flex  between">
    <div class="header__body flex between">
        
        <div class="header__user flex center">
            <?php if(auth()->guard()->guest()): ?>
                <?php if(Route::has('auth.login-code')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('auth.login-code')); ?>"><?php echo e(__('auth.login-code')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(Route::has('register')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
              
                <div class="header__user__name flex exit">
                    <span><?php echo e(Auth::user()->name); ?></span>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <img src="/storage/icon/exit.svg" alt="">
                 </a>
                 
                </div>
                <div class="header__user__logo">
                    <a href="<?php echo e(url('/profile')); ?>">
                        <img src="<?php echo e($user->avatar_url ? asset($user->avatar_url) : asset('user/avatar/default-avatar.png')); ?>"
                            alt="Фото пользователя">
                        </a>
                </div>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
                
            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views/layouts/header.blade.php ENDPATH**/ ?>