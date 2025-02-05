<?php $__env->startSection('content'); ?>
    <div class="container-auth">
        <div class="auth__body flex center">
            <div class="auth__form">
                <h1>Войти</h1>
                <p class="auth__title_sub">Мы рады видеть вас! </br>
                    Войдите в свою учетную запись</p>
                <form action="<?php echo e(route('login.post')); ?>" method="POST" id="login-form">
                    <?php echo csrf_field(); ?>
                    <label for="phone" id="phone-label">
                        <p>Телефон:</p>
                        <input type="text" name="phone" id="phone" class="form-control maskphone" placeholder="+7 (___) ___-__-__" value="<?php echo e(old('phone')); ?>" required>
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
                    <!-- Код для входа (спрятан по умолчанию) -->   
                    <div id="code-fields" style="display: none;">
                        <label for="code">
                            <p>Введите код:</p>
                            <div class="code-inputs">
                                <input type="text" id="code1" maxlength="1"placeholder="X" class="form-control code-input" oninput="moveFocus(this, 'code2')" required>
                                <input type="text" id="code2" maxlength="1"placeholder="X" class="form-control code-input" oninput="moveFocus(this, 'code3')" required>
                                <input type="text" id="code3" maxlength="1"placeholder="X" class="form-control code-input" oninput="moveFocus(this, 'code4')" required>
                                <input type="text" id="code4" maxlength="1"placeholder="X" class="form-control code-input" required>
                            </div>
                            <?php $__errorArgs = ['code'];
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
                    </div>
                    <!-- Ссылка для отправки кода -->
                    <a href="#" id="send-code-btn" class="btn btn-secondary">Отправить код</a>
                    <p id="timer" style="display:none; color: red; margin-top: 10px;">Повторная отправка доступна через <span id="time-remaining">60</span> секунд</p>
                    <!-- Пароль (по умолчанию скрыт) -->
                    <div id="password-fields" style="display: none;">
                        <label for="password">
                            <p>Пароль:</p>
                            <input type="password" name="password" id="password" placeholder="********"class="form-control" required>
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
                    </div>
                    <button type="submit" class="btn btn-primary" id="login-btn" style="display: none;">Войти</button>
                    <ul class="auth__form__link">
                        <li><a href="<?php echo e(url('/registration')); ?>">Регистрация</a></li>
                        <li><a href="#" id="toggle-login-method">Войти по паролю</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Функция для переключения фокуса между полями ввода
        function moveFocus(currentInput, nextInputId) {
            if (currentInput.value.length === 1) {
                const nextInput = document.getElementById(nextInputId);
                if (nextInput) {
                    nextInput.focus();
                }
            }
        }
        // Таймер для отсчета времени до повторной отправки кода
        let timeRemaining = 60;
        let timerInterval;
        // Функция для запуска таймера
        function startTimer() {
            document.getElementById('timer').style.display = 'block';
            document.getElementById('send-code-btn').style.pointerEvents = 'none'; // Отключаем кнопку отправки
            timerInterval = setInterval(function() {
                timeRemaining--;
                document.getElementById('time-remaining').textContent = timeRemaining;
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('send-code-btn').style.pointerEvents = 'auto'; // Включаем кнопку обратно
                    document.getElementById('send-code-btn').textContent = 'Отправить код';
                    timeRemaining = 60;
                    document.getElementById('timer').style.display = 'none';
                }
            }, 1000);
        }
        // Показываем блок с кодом и скрываем поле телефона при нажатии на кнопку "Отправить код"
        document.getElementById('send-code-btn').addEventListener('click', function(event) {
            event.preventDefault();
            const phoneLabel = document.getElementById('phone-label');
            const codeFields = document.getElementById('code-fields');
            const sendCodeBtn = document.getElementById('send-code-btn');
            // Скрываем поле телефона
            phoneLabel.style.display = 'none';
            // Показываем блок для ввода кода
            codeFields.style.display = 'block';
            // Запуск таймера и отправка кода
            startTimer();
            // Здесь можно отправить AJAX запрос для получения кода (опционально)
            // Например, через fetch() или axios для асинхронного запроса
        });
        // Переключение метода входа (по коду или по паролю)
        document.getElementById('toggle-login-method').addEventListener('click', function(event) {
            event.preventDefault();
            const passwordFields = document.getElementById('password-fields');
            const codeFields = document.getElementById('code-fields');
            const toggleButton = document.getElementById('toggle-login-method');
            const loginBtn = document.getElementById('login-btn');
            // Переключаем метод входа
            if (codeFields.style.display === 'block') {
                // Показываем вход по паролю
                passwordFields.style.display = 'block';
                codeFields.style.display = 'none';
                toggleButton.textContent = 'Зайти по коду'; // Меняем текст ссылки
                loginBtn.style.display = 'inline'; // Показываем кнопку "Войти"
            } else {
                // Показываем вход по коду
                passwordFields.style.display = 'none';
                codeFields.style.display = 'block';
                toggleButton.textContent = 'Войти по паролю'; // Меняем текст ссылки
                loginBtn.style.display = 'none'; // Скрываем кнопку "Войти"
            }
        });
        // Автоматическая отправка формы, если все поля заполнены
        document.querySelectorAll('.code-input').forEach(input => {
            input.addEventListener('input', function() {
                // Проверка, что все поля для кода заполнены
                const allFilled = Array.from(document.querySelectorAll('.code-input')).every(input => input.value.length === 1);
                if (allFilled) {
                    // Отправка формы
                    document.getElementById('login-form').submit();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\dlk\resources\views\auth\login.blade.php ENDPATH**/ ?>