<?php $__env->startSection('content'); ?>
    <div class="container-auth">
        <div class="auth__body flex center">
            <div class="auth__form">
     
                <h1><?php echo e($title_site); ?></h1>

                <form action="<?php echo e(route('auth.complete_registration_by_deal', ['token' => $deal->registration_token])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                
                        <label for="name">Имя
                        <input type="text" id="name" name="name"placeholder="Ваше имя" class="form-control" required>
                    </label>
                
                
                        <label for="phone">Номер телефона
                        <input type="text" id="phone" name="phone" class="form-control maskphone"placeholder="+7 (___) ___-__-__"  value="<?php echo e(old('phone')); ?>" required>
                    </label>
                
                  
                        <label for="password">Пароль
                        <input type="password" id="password" name="password" placeholder="********" class="form-control" required>
             
                    </label>
                
                        <label for="password_confirmation">Подтверждение пароля
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********"  class="form-control" required>
                    </label>
                
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\dlk\resources\views\auth\register_by_deal.blade.php ENDPATH**/ ?>