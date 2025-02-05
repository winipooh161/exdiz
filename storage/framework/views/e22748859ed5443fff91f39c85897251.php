<?php $__env->startSection('content'); ?>
    <div class="container-auth">
        <div class="auth__body flex center">
            <div class="auth__form">
                <h1>Зарегистрироваться</h1>
                <form action="<?php echo e(route('register.post')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <label for="name">
                        <p>Имя:</p>
                        <input type="text" name="name" id="name" placeholder="Ваше имя"  class="form-control" value="<?php echo e(old('name')); ?>"
                           maxlength="50" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label for="phone">
                        <p>phone:</p>
                        <input type="phone" name="phone" id="phone" class="form-control maskphone" placeholder="+7 (___) ___-__-__"  value="<?php echo e(old('phone')); ?>"
                            required>
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label for="password">
                        <p>Пароль:</p>
                        <input type="password" name="password" id="password" class="form-control" placeholder="********"  maxlength="50" required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label for="password_confirmation">
                        <p>Подтвердите пароль:</p>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="********"  maxlength="50" class="form-control"
                            required>
                    </label>
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                    <ul class="auth__form__link">
                        <li><a href="<?php echo e(route('login.code')); ?>">Войти по коду</a></li>
                        <li style="text-align: center">Нажимая на "Зарегистрироваться" вы соглашаетесь с<a href=""> политикой конфиденциальности</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\dlk\resources\views\auth\register.blade.php ENDPATH**/ ?>