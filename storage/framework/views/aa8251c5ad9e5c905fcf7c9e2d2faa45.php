<h1 class="flex">
    Ваш <span class="Jikharev">профиль</span>
</h1>

<div class="profile flex between">
    <!-- Левая колонка: Аватар, информация о пользователе -->
    <div class="profile__info center bgfff flex wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
        <!-- Аватар -->
        <div class="profile__avatar">
            <form 
                id="update-avatar-form" 
                action="<?php echo e(route('profile.update_avatar')); ?>" 
                method="POST" 
                enctype="multipart/form-data"
            >
                <?php echo csrf_field(); ?>

                <label for="avatar-input">
                    <img 
                        src="<?php echo e($user->avatar_url ? asset($user->avatar_url) : asset('user/avatar/default-avatar.png')); ?>" 
                        alt="Фото пользователя"
                    >
                </label>

                <input 
                    id="avatar-input" 
                    type="file" 
                    name="avatar" 
                    accept="image/*" 
                    style="display: none;" 
                    onchange="document.getElementById('update-avatar-form').submit();"
                >

                <?php if($errors->has('avatar')): ?>
                    <div class="error-message">
                        <?php $__currentLoopData = $errors->get('avatar'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($message); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </div>
                <?php endif; ?>
            </form>

            <div class="hover__create">
                <!-- Иконка, например, карандаш -->
                <svg viewBox="0 0 15 15" fill="none" ...>
                    <!-- ваш SVG-код -->
                </svg>
            </div>
        </div>

        <!-- Информация о пользователе (имя, телефон, email, статус, дата регистрации) -->
        <div class="profile__link flex">
            <!-- Форма для удаления аккаунта (скрытая, вызывается по нажатию) -->
            <form 
                id="delete-account-form" 
                action="<?php echo e(route('delete_account')); ?>" 
                method="POST" 
                style="display:none;"
            >
                <?php echo csrf_field(); ?>
            </form> 

            <div class="class-border-profile">
                <h3><?php echo e($user->name); ?></h3>
                <label>
                    <p>Номер телефона</p>
                    <a href=""><?php echo e($user->phone ?? 'Не указан'); ?></a>
                </label>
                <label>
                    <p>Почта</p>
                    <a href=""><?php echo e($user->email); ?></a>
                </label>
                <label>
                    <p>Статус</p>
                    <a href=""><?php echo e($user->status ?? 'Не установлен'); ?></a>
                </label>
                <label>
                    <p>Дата регистрации</p>
                    <a href=""><?php echo e($user->created_at->format('d.m.Y H:i')); ?></a>
                </label>
            </div>

            <div class="button__a__profile">
                <!-- Кнопка выхода -->
                <a href="<?php echo e(route('logout')); ?>"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Выйти из аккаунта
                </a>

                <!-- Кнопка удаления аккаунта -->
                <a class="buttonred" href="#"
                   onclick="event.preventDefault(); document.getElementById('delete-account-form').submit();">
                   Удалить аккаунт
                </a>
            </div>
        </div>
    </div>

    <!-- Правая колонка: Форма изменения данных -->
    <div class="profile__modules wow fadeInLeft" data-wow-duration="2s" data-wow-delay="2s">
        <!-- Блок с формой для изменения имени, почты, пароля (одна форма) -->
        <div class="profile__info profile__info__table">
            <div class="password__new" id="update-all-section">
                <h3>Изменение имени, почты, пароля</h3>

                <!-- ОДНА форма -->
                <form id="update-all-form">
                    <?php echo csrf_field(); ?>

                    <!-- Имя -->
                    <div>
                        <label for="name">Имя:</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="<?php echo e($user->name); ?>" 
                            placeholder="Ваше имя"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email">Электронная почта:</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo e($user->email); ?>" 
                            placeholder="example@mail.com"
                        >
                    </div>

                    <!-- Новый пароль -->
                    <div>
                        <label for="new_password">Новый пароль</label>
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            placeholder="********"
                        >
                    </div>

                    <!-- Подтверждение пароля -->
                    <div>
                        <label for="new_password_confirmation">Подтверждение пароля</label>
                        <input 
                            type="password" 
                            id="new_password_confirmation"
                            name="new_password_confirmation" 
                            placeholder="********"
                        >
                    </div>

                    <!-- Ошибки валидации (AJAX) -->
                    <div id="error-message" style="color: red; display: none;"></div>

                    <!-- Кнопка отправки -->
                    <button type="submit">Сохранить изменения</button>
                </form>
            </div>
        </div>

        <!-- Блок для смены номера телефона (с отправкой кода и подтверждением) -->
        <div class="profile__form">
            <div class="form-section" id="change-phone-section">
                <h3>Смена номера телефона</h3>
                <form id="change-phone-form">
                    <label for="new-phone">Новый номер телефона:</label>
                    <input 
                        type="text" 
                        id="new-phone" 
                        name="new-phone" 
                        placeholder="+7 (___) ___-____" 
                        required
                    class="maskphone">
                    <button type="button" id="send-code">Отправить код</button>
                </form>

                <!-- Форма подтверждения кода -->
                <form id="verify-code-form" style="display: none;">
                    <label for="verification-code">Введите код подтверждения:</label>
                    <input 
                        type="text" 
                        id="verification-code" 
                        placeholder="Код из SMS" 
                        required
                    >
                    <button type="button" id="confirm-code">Подтвердить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Скрытая форма для logout -->
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>

<!-- Подключаем jQuery, если ещё не подключён -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Логика AJAX для смены номера телефона -->
<script>
    $(document).ready(function() {
        // Отправка кода
        $('#send-code').click(function() {
            var phone = $('#new-phone').val();
            $.ajax({
                url: '/profile/send-code',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    phone: phone
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#change-phone-form').hide();
                        $('#verify-code-form').show();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Ошибка при отправке кода. Попробуйте позже.');
                }
            });
        });

        // Подтверждение кода
        $('#confirm-code').click(function() {
            var phone = $('#new-phone').val();
            var code  = $('#verification-code').val();

            $.ajax({
                url: '/profile/verify-code',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    phone: phone,
                    verification_code: code
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#verify-code-form').hide();
                        $('#change-phone-form').show();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Ошибка при проверке кода. Попробуйте позже.');
                }
            });
        });
    });
</script>

<!-- Логика AJAX для ОБЩЕЙ формы (имя, email, пароль) -->
<script>
    $(document).ready(function() {
        $('#update-all-form').on('submit', function(e) {
            e.preventDefault();

            var formData = {
                _token: '<?php echo e(csrf_token()); ?>',
                name: $('#name').val(),
                email: $('#email').val(),
                new_password: $('#new_password').val(),
                new_password_confirmation: $('#new_password_confirmation').val()
            };

            $.ajax({
                url: '<?php echo e(route("profile.update_all")); ?>', // маршрут из web.php
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        // Допустим, перезагрузим страницу, чтобы увидеть изменения
                        // location.reload();
                    } else {
                        $('#error-message').text(response.message).show();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Ошибки валидации
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (const field in errors) {
                            errorMessages += errors[field].join(', ') + '<br>';
                        }
                        $('#error-message').html(errorMessages).show();
                    } else {
                        $('#error-message')
                            .text('Произошла ошибка. Попробуйте позже.')
                            .show();
                    }
                }
            });
        });
    });

    
document.addEventListener("DOMContentLoaded", function () {
    var inputs = document.querySelectorAll("input.maskphone");
    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        input.addEventListener("input", mask);
        input.addEventListener("focus", mask);
        input.addEventListener("blur", mask);
    }
    function mask(event) {
        var blank = "+_ (___) ___-__-__";
        var i = 0;
        var val = this.value.replace(/\D/g, "").replace(/^8/, "7").replace(/^9/, "79");
        this.value = blank.replace(/./g, function (char) {
            if (/[_\d]/.test(char) && i < val.length) return val.charAt(i++);
            return i >= val.length ? "" : char;
        });
        if (event.type == "blur") {
            if (this.value.length == 2) this.value = "";
        } else {
            setCursorPosition(this, this.value.length);
        }
    }
    function setCursorPosition(elem, pos) {
        elem.focus();
        if (elem.setSelectionRange) {
            elem.setSelectionRange(pos, pos);
            return;
        }
        if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.collapse(true);
            range.moveEnd("character", pos);
            range.moveStart("character", pos);
            range.select();
            return;
        }
    }
});
</script>
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\module\profile.blade.php ENDPATH**/ ?>