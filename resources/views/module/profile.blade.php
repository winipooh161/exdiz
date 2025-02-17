
<h1 class="flex">
    Ваш <span class="Jikharev">профиль</span>
</h1>

<div class="profile flex between">
    <!-- Левая колонка: Аватар и базовая информация -->
    <div class="profile__info center bgfff flex wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
        <div class="profile__avatar">
            <form id="update-avatar-form" action="{{ route('profile.update_avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="avatar-input">
                    <img src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('user/avatar/default-avatar.png') }}" alt="Фото пользователя">
                </label>
                <input id="avatar-input" type="file" name="avatar" accept="image/*" style="display: none;" onchange="document.getElementById('update-avatar-form').submit();">
                @if ($errors->has('avatar'))
                    <div class="error-message">
                        @foreach ($errors->get('avatar') as $message)
                            <p>{{ $message }}</p>
                        @endforeach 
                    </div>
                @endif
            </form>
            <div class="hover__create">
                <!-- SVG-иконка карандаша -->
                <svg viewBox="0 0 15 15" fill="none">
                    <!-- ваш SVG-код -->
                </svg>
            </div>
        </div>

        <div class="profile__link flex">
            <form id="delete-account-form" action="{{ route('delete_account') }}" method="POST" style="display:none;">
                @csrf
            </form> 
            <div class="class-border-profile">
                <h3>{{ $user->name }}</h3>
                <label>
                    <p>Номер телефона</p>
                    <a href="">{{ $user->phone ?? 'Не указан' }}</a>
                </label>
                <label>
                    <p>Почта</p>
                    <a href="">{{ $user->email }}</a>
                </label>
                <label>
                    <p>Статус</p>
                    <a href="">{{ $user->status ?? 'Не установлен' }}</a>
                </label>
                <label>
                    <p>Дата регистрации</p>
                    <a href="">{{ $user->created_at->format('d.m.Y H:i') }}</a>
                </label>
                
                <!-- Дополнительные данные в зависимости от статуса -->
                @if($user->status == 'user')
                    <label>
                        <p>Город</p>
                        <a href="">{{ $user->city ?? 'Не указан' }}</a>
                    </label>
                @elseif($user->status == 'partner')
                    <label>
                        <p>Город</p>
                        <a href="">{{ $user->city ?? 'Не указан' }}</a>
                    </label>
                    <label>
                        <p>Номер договора</p>
                        <a href="">{{ $user->contract_number ?? 'Не указан' }}</a>
                    </label>
                    <label>
                        <p>Комментарий</p>
                        <a href="">{{ $user->comment ?? 'Не указан' }}</a>
                    </label>
                @elseif($user->status == 'executor')
                    <label>
                        <p>Город/Часовой пояс</p>
                        <a href="">{{ $user->city ?? 'Не указан' }}</a>
                    </label>
                    <label>
                        <p>Ссылка на портфолио</p>
                        <a href="{{ $user->portfolio_link }}">{{ $user->portfolio_link ?? 'Не указана' }}</a>
                    </label>
                    <label>
                        <p>Стаж</p>
                        <a href="">{{ $user->experience ?? 'Не указан' }}</a>
                    </label>
                    <label>
                        <p>Рейтинг в ЭД</p>
                        <a href="">{{ $user->rating ?? 'Не указан' }}</a>
                    </label>
                    <label>
                        <p>Проекты в работе</p>
                        <a href="">{{ $user->active_projects_count ?? '0' }}</a>
                    </label>
                @elseif($user->status == 'coordinator')
                    <label>
                        <p>Стаж</p>
                        <a href="">{{ $user->experience ?? 'Не указан' }}</a>
                    </label>
                    <label>
                        <p>Рейтинг в ЭД</p>
                        <a href="">{{ $user->rating ?? 'Не указан' }}</a>
                    </label>
                @endif
            </div>
            <div class="button__a__profile">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти из аккаунта</a>
                <a class="buttonred" href="#" onclick="event.preventDefault(); document.getElementById('delete-account-form').submit();">Удалить аккаунт</a>
            </div>
        </div>
    </div>

    <!-- Правая колонка: Форма редактирования профиля -->
    <div class="profile__modules wow fadeInLeft" data-wow-duration="2s" data-wow-delay="2s">
        <div class="profile__info profile__info__table">
            <div class="password__new" id="update-all-section">
                <h3>Изменение имени, почты, пароля и дополнительных данных</h3>
                <form id="update-all-form">
                    @csrf
                    <div>
                        <label for="name">Имя:</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" placeholder="Имя и фамилия">
                    </div>
                    <div>
                        <label for="email">Электронная почта:</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" placeholder="example@mail.com">
                    </div>
                    <div>
                        <label for="new_password">Новый пароль</label>
                        <input type="password" id="new_password" name="new_password" placeholder="********">
                    </div>
                    <div>
                        <label for="new_password_confirmation">Подтверждение пароля</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="********">
                    </div>
                    
                    <!-- Дополнительные поля в зависимости от статуса -->
                    @if($user->status == 'user')
                        <div>
                            <label for="city">Город:</label>
                            <input type="text" id="city" name="city" value="{{ $user->city }}" placeholder="Ваш город">
                        </div>
                    @elseif($user->status == 'partner')
                        <div>
                            <label for="city">Город:</label>
                            <input type="text" id="city" name="city" value="{{ $user->city }}" placeholder="Ваш город">
                        </div>
                        <div>
                            <label for="contract_number">Номер договора:</label>
                            <input type="text" id="contract_number" name="contract_number" value="{{ $user->contract_number }}" placeholder="Номер договора">
                        </div>
                        <div>
                            <label for="comment">Комментарий:</label>
                            <textarea id="comment" name="comment" placeholder="Дополнительная информация">{{ $user->comment }}</textarea>
                        </div>
                    @elseif($user->status == 'executor')
                        <div>
                            <label for="city">Город/Часовой пояс:</label>
                            <input type="text" id="city" name="city" value="{{ $user->city }}" placeholder="Ваш город или часовой пояс">
                        </div>
                        <div>
                            <label for="portfolio_link">Ссылка на портфолио:</label>
                            <input type="url" id="portfolio_link" name="portfolio_link" value="{{ $user->portfolio_link }}" placeholder="Ссылка на портфолио">
                        </div>
                        <div>
                            <label for="experience">Стаж:</label>
                            <input type="text" id="experience" name="experience" value="{{ $user->experience }}" placeholder="Ваш стаж">
                        </div>
                        <div>
                            <label for="rating">Рейтинг в ЭД:</label>
                            <input type="text" id="rating" name="rating" value="{{ $user->rating }}" placeholder="Ваш рейтинг">
                        </div>
                        <div>
                            <label for="active_projects_count">Проекты в работе:</label>
                            <input type="number" id="active_projects_count" name="active_projects_count" value="{{ $user->active_projects_count }}" placeholder="Количество проектов">
                        </div>
                    @elseif($user->status == 'coordinator')
                        <div>
                            <label for="experience">Стаж:</label>
                            <input type="text" id="experience" name="experience" value="{{ $user->experience }}" placeholder="Ваш стаж">
                        </div>
                        <div>
                            <label for="rating">Рейтинг в ЭД:</label>
                            <input type="text" id="rating" name="rating" value="{{ $user->rating }}" placeholder="Ваш рейтинг">
                        </div>
                    @endif

                    <div id="error-message" style="color: red; display: none;"></div>
                    <button type="submit">Сохранить изменения</button>
                </form>
            </div>
        </div>
        
        <!-- Форма смены номера телефона -->
        <div class="profile__form">
            <div class="form-section" id="change-phone-section">
                <h3>Смена номера телефона</h3>
                <form id="change-phone-form">
                    <label for="new-phone">Новый номер телефона:</label>
                    <input type="text" id="new-phone" name="new-phone" placeholder="+7 (___) ___-____" required class="maskphone">
                    <button type="button" id="send-code">Отправить код</button>
                </form>
                <form id="verify-code-form" style="display: none;">
                    <label for="verification-code">Введите код подтверждения:</label>
                    <input type="text" id="verification-code" placeholder="Код из SMS" required>
                    <button type="button" id="confirm-code">Подтвердить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Подключение jQuery и скрипты для AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Логика AJAX для смены номера телефона
$(document).ready(function() {
    $('#send-code').click(function() {
        var phone = $('#new-phone').val();
        $.ajax({
            url: '/profile/send-code',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
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

    $('#confirm-code').click(function() {
        var phone = $('#new-phone').val();
        var code  = $('#verification-code').val();
        $.ajax({
            url: '/profile/verify-code',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
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

// Логика AJAX для обновления профиля
$(document).ready(function() {
    $('#update-all-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '{{ route("profile.update_all") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                } else {
                    $('#error-message').text(response.message).show();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (const field in errors) {
                        errorMessages += errors[field].join(', ') + '<br>';
                    }
                    $('#error-message').html(errorMessages).show();
                } else {
                    $('#error-message').text('Произошла ошибка. Попробуйте позже.').show();
                }
            }
        });
    });
});

// Маска для ввода телефона
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

