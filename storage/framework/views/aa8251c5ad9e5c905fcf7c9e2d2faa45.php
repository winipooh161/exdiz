<div class="profile flex between">
    <div class="profile__info center   bgfff flex wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
        <div class="profile__avatar " >
            <form id="update-avatar-form" action="<?php echo e(route('profile.update_avatar')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <label for="avatar-input">
                    <img 
                        src="<?php echo e($user->avatar_url ? asset($user->avatar_url) : asset('user/avatar/default-avatar.png')); ?>" 
                        alt="Фото пользователя" 
                        style="">
                </label>
                <input id="avatar-input" type="file" name="avatar" accept="image/*" style="display: none;" onchange="document.getElementById('update-avatar-form').submit();">
                
                <!-- Вывод ошибок -->
                <?php if($errors->has('avatar')): ?>
                    <div class="error-message">
                        <?php $__currentLoopData = $errors->get('avatar'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($message); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </form>
            
            <div class="hover__create">
                <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.1464 1.14645C12.3417 0.951184 12.6583 0.951184 12.8535 1.14645L14.8535 3.14645C15.0488 3.34171 15.0488 3.65829 14.8535 3.85355L10.9109 7.79618C10.8349 7.87218 10.7471 7.93543 10.651 7.9835L6.72359 9.94721C6.53109 10.0435 6.29861 10.0057 6.14643 9.85355C5.99425 9.70137 5.95652 9.46889 6.05277 9.27639L8.01648 5.34897C8.06455 5.25283 8.1278 5.16507 8.2038 5.08907L12.1464 1.14645ZM12.5 2.20711L8.91091 5.79618L7.87266 7.87267L8.12731 8.12732L10.2038 7.08907L13.7929 3.5L12.5 2.20711ZM9.99998 2L8.99998 3H4.9C4.47171 3 4.18056 3.00039 3.95552 3.01877C3.73631 3.03668 3.62421 3.06915 3.54601 3.10899C3.35785 3.20487 3.20487 3.35785 3.10899 3.54601C3.06915 3.62421 3.03669 3.73631 3.01878 3.95552C3.00039 4.18056 3 4.47171 3 4.9V11.1C3 11.5283 3.00039 11.8194 3.01878 12.0445C3.03669 12.2637 3.06915 12.3758 3.10899 12.454C3.20487 12.6422 3.35785 12.7951 3.54601 12.891C3.62421 12.9309 3.73631 12.9633 3.95552 12.9812C4.18056 12.9996 4.47171 13 4.9 13H11.1C11.5283 13 11.8194 12.9996 12.0445 12.9812C12.2637 12.9633 12.3758 12.9309 12.454 12.891C12.6422 12.7951 12.7951 12.6422 12.891 12.454C12.9309 12.3758 12.9633 12.2637 12.9812 12.0445C12.9996 11.8194 13 11.5283 13 11.1V6.99998L14 5.99998V11.1V11.1207C14 11.5231 14 11.8553 13.9779 12.1259C13.9549 12.407 13.9057 12.6653 13.782 12.908C13.5903 13.2843 13.2843 13.5903 12.908 13.782C12.6653 13.9057 12.407 13.9549 12.1259 13.9779C11.8553 14 11.5231 14 11.1207 14H11.1H4.9H4.87934C4.47686 14 4.14468 14 3.87409 13.9779C3.59304 13.9549 3.33469 13.9057 3.09202 13.782C2.7157 13.5903 2.40973 13.2843 2.21799 12.908C2.09434 12.6653 2.04506 12.407 2.0221 12.1259C1.99999 11.8553 1.99999 11.5231 2 11.1207V11.1206V11.1V4.9V4.87935V4.87932V4.87931C1.99999 4.47685 1.99999 4.14468 2.0221 3.87409C2.04506 3.59304 2.09434 3.33469 2.21799 3.09202C2.40973 2.71569 2.7157 2.40973 3.09202 2.21799C3.33469 2.09434 3.59304 2.04506 3.87409 2.0221C4.14468 1.99999 4.47685 1.99999 4.87932 2H4.87935H4.9H9.99998Z"
                            fill="#000000"></path>
                    </g>
                </svg>
            </div>
        </div>
        <div class="profile__link flex "  >
            <a href="<?php echo e(route('logout')); ?>"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти из акаунта</a>
            <a href="#"
                onclick="event.preventDefault(); document.getElementById('delete-account-form').submit();"> <svg
                    width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.2782 2.59644H2.72192C2.21663 2.59735 1.7323 2.79895 1.37501 3.15707C1.01771 3.5152 0.816583 4.00067 0.815674 4.50713V4.95192C0.815921 5.03491 0.848924 5.11444 0.907476 5.17313C0.966028 5.23182 1.04537 5.2649 1.12817 5.26515H14.8719C14.9547 5.2649 15.0341 5.23182 15.0926 5.17313C15.1512 5.11444 15.1842 5.03491 15.1844 4.95192V4.50713C15.1835 4.00067 14.9824 3.5152 14.6251 3.15707C14.2678 2.79895 13.7835 2.59735 13.2782 2.59644ZM10.5375 1.96998V1.76951C10.5375 1.51531 10.4368 1.27152 10.2575 1.09177C10.0781 0.912018 9.83491 0.811035 9.5813 0.811035H6.33442C6.08096 0.811532 5.83802 0.912674 5.6588 1.09232C5.47958 1.27196 5.37867 1.51546 5.37817 1.76951V1.96998H10.5375ZM1.74067 5.8916L2.60317 16.7794C2.63851 17.2068 2.83237 17.6053 3.14651 17.8964C3.46065 18.1875 3.87224 18.35 4.30005 18.3518H11.6375C12.0654 18.35 12.4769 18.1875 12.7911 17.8964C13.1052 17.6053 13.2991 17.2068 13.3344 16.7794L14.2 5.8916H1.74067ZM10.3938 11.442C10.4032 9.04582 10.4219 6.65275 10.4219 6.65275C10.4221 6.61181 10.4303 6.5713 10.4461 6.53355C10.4619 6.4958 10.485 6.46154 10.514 6.43274C10.543 6.40393 10.5774 6.38115 10.6153 6.36569C10.6531 6.35024 10.6936 6.34241 10.7344 6.34265H10.7375C10.8204 6.34373 10.8994 6.3776 10.9573 6.43688C11.0153 6.49615 11.0475 6.57601 11.0469 6.65901C11.0188 10.2361 10.9938 15.6518 11.0344 16.1718C11.0474 16.2182 11.0494 16.2671 11.0404 16.3145C11.0315 16.3619 11.0117 16.4066 10.9827 16.4451C10.9536 16.4836 10.9161 16.5149 10.8731 16.5364C10.83 16.558 10.7826 16.5694 10.7344 16.5696C10.6926 16.5691 10.6512 16.5606 10.6125 16.5445C10.375 16.4443 10.375 16.4443 10.3938 11.442ZM7.6563 6.65588C7.6563 6.57281 7.68922 6.49314 7.74783 6.4344C7.80643 6.37565 7.88592 6.34265 7.9688 6.34265C8.05168 6.34265 8.13116 6.37565 8.18977 6.4344C8.24837 6.49314 8.2813 6.57281 8.2813 6.65588V16.2563C8.2813 16.3394 8.24837 16.4191 8.18977 16.4778C8.13116 16.5366 8.05168 16.5696 7.9688 16.5696C7.88592 16.5696 7.80643 16.5366 7.74783 16.4778C7.68922 16.4191 7.6563 16.3394 7.6563 16.2563V6.65588ZM4.87817 6.65588C4.87817 6.57281 4.9111 6.49314 4.9697 6.4344C5.02831 6.37565 5.10779 6.34265 5.19067 6.34265C5.27355 6.34265 5.35304 6.37565 5.41164 6.4344C5.47025 6.49314 5.50317 6.57281 5.50317 6.65588V16.2563C5.50317 16.3394 5.47025 16.4191 5.41164 16.4778C5.35304 16.5366 5.27355 16.5696 5.19067 16.5696C5.10779 16.5696 5.02831 16.5366 4.9697 16.4778C4.9111 16.4191 4.87817 16.3394 4.87817 16.2563V6.65588Z"
                        fill="#FD1B44" />
                </svg>Удалить
                акаунт</a>
            <form id="delete-account-form" action="<?php echo e(route('delete_account')); ?>" method="POST" style="display:none;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>
            </form>
            <table class="profile-table">
                <thead>
                    <tr>
                        <th>Поле</th>
                        <th>Значение</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Имя</td>
                        <td><?php echo e($user->name); ?></td>
                    </tr>
                    <tr>
                        <td>Номер телефона</td>
                        <td><?php echo e($user->phone ?? 'Не указан'); ?></td>
                    </tr>
                    <tr>
                        <td>Почта</td>
                        <td><?php echo e($user->email); ?></td>
                    </tr>
                    <tr>
                        <td>Статус</td>
                        <td><?php echo e($user->status ?? 'Не установлен'); ?></td>
                    </tr>
                    <tr>
                        <td>Дата регистрации</td>
                        <td><?php echo e($user->created_at->format('d.m.Y H:i')); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>  

    <div class="profile__modules wow fadeInLeft" data-wow-duration="2s" data-wow-delay="2s">
        <div class="profile__info profile__info__table">
            <!-- Изменение пароля -->
            <div class="password__new" id="change-password">
                <h3>Изменение пароля</h3>
                <form id="change-password-form">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="new_password">Новый пароль</label>
                        <input type="password" id="new_password" name="new_password" placeholder="********" required>
                    </div>
                    
                    <div>
                        <label for="new_password_confirmation">Подтверждение пароля</label>
                        <input type="password" id="new_password_confirmation"placeholder="********" name="new_password_confirmation" required>
                    </div>
                
                    <div id="error-message" style="color: red; display: none;"></div>
                
                    <button type="submit">Изменить пароль</button>
                </form>
                
                
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            
          
            
        </div>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
 

        <div class="profile__form ">
            <div class="form-section" id="change-phone-section">
                <h3>Смена номера телефона</h3>
                <form id="change-phone-form">
                    <label for="new-phone">Новый номер телефона:</label>
                    <input type="text" id="new-phone" name="new-phone" placeholder="+7 (___) ___-____" required>
                    <button type="button" id="send-code">Отправить код</button>
                </form>
                <form id="verify-code-form" style="display: none;">
                    <label for="verification-code">Введите код подтверждения:</label>
                    <input type="text" id="verification-code" placeholder="Код из SMS" required>
                    <button type="button" id="confirm-code">Подтвердить</button>
                </form>
            </div>
            <!-- Изменение имени и электронной почты -->
            <div class="form-section  "  id="edit-name-email">
                <h3>Изменение имени и электронной почты</h3>
                <form id="update-profile-form">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" placeholder="Ваше имя" value="<?php echo e($user->name); ?>">
        
                    <label for="email">Электронная почта:</label>
                    <input type="email" id="email" value="<?php echo e($user->email); ?>" placeholder="example@mail.com">
        
                    <button type="submit">Сохранить изменения</button>
                </form>
                <div id="error-message" style="color: red; display: none;"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Отправка кода подтверждения
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
                        $('#success-message').text(response.message).show();
                        $('#error-message').hide();
                        $('#change-phone-form').hide();
                        $('#verify-code-form').show();
                    } else {
                        $('#error-message').text(response.message).show();
                        $('#success-message').hide();
                    }
                },
                error: function() {
                    $('#error-message').text('Ошибка при отправке кода. Попробуйте позже.')
                        .show();
                }
            });
        });
        // Подтверждение кода
        $('#confirm-code').click(function() {
            var phone = $('#new-phone').val();
            var code = $('#verification-code').val();
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
                        $('#success-message').text(response.message).show();
                        $('#error-message').hide();
                        $('#verify-code-form').hide();
                        $('#change-phone-form').show(); // Вернуться к форме смены телефона
                    } else {
                        $('#error-message').text(response.message).show();
                        $('#success-message').hide();
                    }
                },
                error: function() {
                    $('#error-message').text('Ошибка при проверке кода. Попробуйте позже.')
                        .show();
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
    $('#update-profile-form').on('submit', function (e) {
        e.preventDefault();

        // Получаем значения полей
        var name = $('#name').val();
        var email = $('#email').val();

        // Отправляем запрос на сервер
        $.ajax({
            url: '/profile/update', // Здесь должен быть путь к вашему методу контроллера
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                name: name,
                email: email
            },
            success: function (response) {
                if (response.success) {
                    alert('Данные успешно обновлены!');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (const [field, messages] of Object.entries(errors)) {
                        errorMessages += messages.join(', ') + '<br>';
                    }
                    $('#error-message').html(errorMessages).show();
                } else {
                    $('#error-message').text('Произошла ошибка. Попробуйте позже.').show();
                }
            }
        });
    });
});

</script>

<script>
$(document).ready(function () {
    $('#change-password-form').on('submit', function (e) {
        e.preventDefault();

        var newPassword = $('#new_password').val();
        var newPasswordConfirmation = $('#new_password_confirmation').val();

        // Проверка на совпадение паролей
        if (newPassword !== newPasswordConfirmation) {
            $('#error-message').text('Пароли не совпадают').show();
            return;
        }

        // Проверка на минимальную длину пароля
        if (newPassword.length < 8) {
            $('#error-message').text('Пароль должен содержать минимум 8 символов').show();
            return;
        }

        $.ajax({
            url: '/profile/change-password',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                new_password: newPassword,
                new_password_confirmation: newPasswordConfirmation
            },
            success: function (response) {
                if (response.success) {
                    alert('Пароль успешно изменен!');
                } else {
                    $('#error-message').text(response.message).show();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (const [field, messages] of Object.entries(errors)) {
                        errorMessages += messages.join(', ') + '<br>';
                    }
                    $('#error-message').html(errorMessages).show();
                } else {
                    $('#error-message').text('Ошибка при изменении пароля. Попробуйте позже.').show();
                }
            }
        });
    });
});

           </script>
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\module\profile.blade.php ENDPATH**/ ?>