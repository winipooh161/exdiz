<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title_site); ?></title>
    <!-- Scripts -->
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
 
    <?php echo app('Illuminate\Foundation\Vite')([ 'resources/css/style.css', 'resources/css/font.css', 'resources/css/element.css', 'resources/css/animation.css', 'resources/css/mobile.css', 'resources/js/app.js', 'resources/js/modal.js', 'resources/js/success.js', 'resources/js/mask.js', 'resources/js/login.js']); ?>
<body>
   
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
    <div id="loading-screen">
        <img src="/storage/icon/fool_logo.svg" alt="Loading">
    </div>
    <div class="back__fon">
        <svg class="animate-on-visibility"  width="619" height="681" viewBox="0 0 619 681" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M818.928 819.954C880.972 736.59 915.945 636.49 919.594 532.433C921.115 491.056 918.378 449.677 911.08 408.905C903.779 363.269 891.007 318.544 873.06 276.254C845.689 212.662 806.152 157.594 752.321 114.084C665.643 43.8014 565.278 8.20375 454.57 1.20603C392.526 -2.74919 331.397 3.33582 270.265 14.8975C177.201 32.5441 89.9128 73.3141 16.3117 132.948C12.9665 135.686 9.01275 138.12 7.188 142.38C8.70851 146.335 10.8375 150.29 13.8789 153.637L132.795 324.933C134.316 327.365 136.143 329.801 137.965 331.93C139.486 334.06 142.529 334.366 144.656 333.146C148.915 330.714 152.869 327.977 156.823 325.235C170.51 316.108 183.892 306.373 198.186 297.854C279.694 248.566 367.286 227.877 462.176 243.087C488.331 247.045 513.27 255.258 536.687 267.735C571.665 286.597 599.947 315.5 618.5 350.49C634.315 379.699 658.647 403.735 688.149 418.946C736.506 444.809 783.646 473.41 831.091 501.097C833.523 502.313 836.87 503.227 837.477 507.181C834.743 510.832 829.874 512.354 825.921 514.786C771.784 546.431 717.953 578.68 663.512 610.019C647.091 619.452 633.708 633.752 625.191 650.485C599.646 700.992 555.24 739.63 501.408 757.276C449.098 774.926 393.136 779.488 338.695 770.361C299.157 763.666 261.446 750.279 226.469 730.809C203.963 718.332 182.371 704.337 160.471 690.645C153.479 686.385 146.483 682.126 139.791 677.866C134.316 680.302 132.189 684.867 129.451 688.821C88.6962 745.109 47.9421 801.394 7.188 857.988C5.05901 860.726 3.23389 863.463 1.10526 866.201C-0.41561 868.025 -0.415612 870.461 1.40914 872.285C1.40914 872.285 1.40914 872.285 1.71338 872.285C2.01763 872.591 2.01762 872.591 2.3215 872.591C9.01274 877.764 15.3994 882.632 22.0906 887.499C50.9835 909.711 81.701 929.487 114.243 946.525C195.449 988.815 282.126 1009.81 373.367 1012.85C405.607 1013.46 437.539 1012.24 469.473 1008.59C502.93 1005.25 536.081 999.162 568.622 990.337C654.083 966.909 727.988 924.008 787.904 858.29"
                fill="white"stroke-dasharray="5000"
                stroke-dashoffset="5000" />
            <path
                d="M743 508.189L464.977 667.47C463.459 668.378 461.64 669.586 459.513 668.678C457.085 666.562 457.995 663.543 457.995 660.819V621.833C457.995 618.509 457.995 615.182 457.694 611.858C457.694 609.439 455.567 607.323 453.14 607.323C448.89 607.023 444.339 607.023 440.089 607.023H157.816C136.569 607.023 139.301 609.138 139 588.585V424.769C139 419.33 139.301 414.191 139.909 409.055C139.909 406.032 142.641 403.612 145.674 403.916H159.029C245.835 403.916 332.645 403.916 419.451 403.612C431.893 403.612 444.339 406.032 456.781 401.8C459.817 390.014 457.39 377.924 457.995 365.833C458.299 360.998 457.995 356.163 458.299 351.327C458.299 349.512 459.817 348 461.64 348C462.245 348 462.854 348 463.154 348.304C465.886 349.512 468.318 350.723 470.745 352.231L732.985 502.446C736.627 503.958 739.964 506.073 743 508.189Z"
                fill="white" stroke-dasharray="5000"
                stroke-dashoffset="5000"/>
        </svg>
    </div>
        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>  <?php echo $__env->make('layouts/mobponel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </main>
    </div>
    <script>
        const unreadCounter = document.getElementById('unread-count');

        async function fetchUnreadMessagesCount() {
            try {
                const response = await fetch('/messages/unread-total');
                if (response.ok) {
                    const data = await response.json();
                    unreadCounter.textContent = data.total_unread_count || 0;
                } else {
                    console.error('Ошибка получения данных о непрочитанных сообщениях');
                }
            } catch (error) {
                console.error('Ошибка запроса:', error);
            }
        }

        // Обновляем данные каждые 10 секунд
        setInterval(fetchUnreadMessagesCount, 2000);

        // Первый вызов для немедленного обновления
        fetchUnreadMessagesCount();
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    // Анимация появления сообщения об успехе
    if (successMessage) {
        successMessage.classList.add('show');
        setTimeout(() => {
            successMessage.classList.remove('show');
        }, 5000);
        successMessage.addEventListener('click', () => {
            successMessage.classList.remove('show');
        });
    }
    // Анимация появления сообщения об ошибке
    if (errorMessage) {
        errorMessage.classList.add('show');
        setTimeout(() => {
            errorMessage.classList.remove('show');
        }, 5000);
        errorMessage.addEventListener('click', () => {
            errorMessage.classList.remove('show');
        });
    }
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
document.addEventListener('DOMContentLoaded', function () {
    const nameInputs = document.querySelectorAll('input[name="name"]');
    nameInputs.forEach(input => {
        input.addEventListener('input', function () {
            // Удаляем все символы, которые не являются русскими буквами
            this.value = this.value.replace(/[^А-Яа-яЁё\s\-]/g, '');
        });
    });
});
window.addEventListener('load', () => {
    const loadingScreen = document.getElementById('loading-screen');
    const content = document.getElementById('content');
    setTimeout(() => {
        loadingScreen.classList.add('hidden'); // Применяем класс для анимации исчезновения
        document.body.style.overflow = 'auto'; // Включаем прокрутку
        setTimeout(() => {
            loadingScreen.style.display = 'none'; // Полностью убираем загрузку после анимации
            content.style.opacity = '1'; // Плавно показываем содержимое (контент уже анимируется в CSS)
        }, 1000); // Длительность анимации исчезновения (совпадает с fadeOut)
    }, 1000); // Задержка до начала исчезновения
});
document.addEventListener("DOMContentLoaded", () => {
    // Находим все textarea на странице
    const textareas = document.querySelectorAll("textarea");
    // Применяем обработчик ко всем textarea
    textareas.forEach((textarea) => {
        textarea.addEventListener("input", (event) => {
            // Разрешенные символы: английские, русские буквы, цифры, пробелы, запятые, точки, тире и символ рубля (₽)
            const allowedChars = /^[a-zA-Zа-яА-ЯёЁ0-9\s,.\-₽]*$/;
            const value = event.target.value;
            // Если введены запрещенные символы, удаляем их
            if (!allowedChars.test(value)) {
                event.target.value = value.replace(/[^a-zA-Zа-яА-ЯёЁ0-9\s,.\-₽]/g, "");
            }
        });
    });
});

</script>

<script>
    // Функция для сохранения состояния полей и чекбоксов
function saveFormState() {
    const currentURL = window.location.href; // Получаем текущий URL страницы
    const formState = {};

    // Проходим по всем полям формы и чекбоксам на странице
    document.querySelectorAll('input, select, textarea').forEach(el => {
        // Пропускаем элементы с пустыми значениями или с неактивными полями
        if (!el.name || el.disabled || el.type === 'submit') return;

        // Сохраняем значения полей в объект
        if (el.type === 'checkbox' || el.type === 'radio') {
            formState[el.name] = el.checked; // Для чекбоксов и радио кнопок сохраняем состояние
        } else {
            formState[el.name] = el.value; // Для других элементов сохраняем значение
        }
    });

    // Сохраняем состояние в localStorage в зависимости от URL
    localStorage.setItem(currentURL, JSON.stringify(formState));
}

// Функция для загрузки состояния формы
function loadFormState() {
    const currentURL = window.location.href; // Получаем текущий URL страницы
    const formState = localStorage.getItem(currentURL); // Получаем сохранённые данные для текущего URL

    if (formState) {
        const state = JSON.parse(formState);

        // Проходим по всем полям и восстанавливаем их состояние
        document.querySelectorAll('input, select, textarea').forEach(el => {
            if (!el.name || el.disabled || el.type === 'submit') return;

            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = state[el.name] || false; // Восстанавливаем для чекбоксов и радио кнопок
            } else {
                el.value = state[el.name] || ''; // Восстанавливаем для других элементов
            }
        });
    }
}

// Слушаем события для сохранения состояния при изменении полей
document.addEventListener('input', saveFormState);
document.addEventListener('change', saveFormState);

// Загружаем сохранённое состояние при загрузке страницы
window.addEventListener('load', loadFormState);
    
</script>
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
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\layouts\brifapp.blade.php ENDPATH**/ ?>