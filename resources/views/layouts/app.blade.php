<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title_site }}</title>
    <link rel="stylesheet" href="{{ asset('/css/introjs.min.css') }}">
    @vite([ 'resources/css/style.css', 'resources/css/font.css', 'resources/css/element.css', 'resources/css/animation.css', 'resources/css/mobile.css', 'resources/js/app.js', 'resources/js/modal.js', 'resources/js/success.js', 'resources/js/mask.js'])
    <link rel="stylesheet" href="{{ asset('/css/animate.css') }}">



    <script src="{{ asset('/js/wow.js') }}"></script>
    <!-- Подключаем стили Intro.js -->

    <script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('/js/intro.min.js') }}"></script>


    <!-- Обязательный (и достаточный) тег для браузеров -->
    <link type="image/x-icon" rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

    <!-- Дополнительные иконки для десктопных браузеров -->
    <link type="image/png" sizes="16x16" rel="icon" href="{{ asset('/icons/favicon-16x16.png') }}">
    <link type="image/png" sizes="32x32" rel="icon" href="{{ asset('/icons/favicon-32x32.png') }}">
    <link type="image/png" sizes="96x96" rel="icon" href="{{ asset('/icons/favicon-96x96.png') }}">
    <link type="image/png" sizes="120x120" rel="icon" href="{{ asset('/icons/favicon-120x120.png') }}">

    <!-- Иконки для Android -->
    <link type="image/png" sizes="72x72" rel="icon" href="{{ asset('/icons/android-icon-72x72.png') }}">
    <link type="image/png" sizes="96x96" rel="icon" href="{{ asset('/icons/android-icon-96x96.png') }}">
    <link type="image/png" sizes="144x144" rel="icon" href="{{ asset('/icons/android-icon-144x144.png') }}">
    <link type="image/png" sizes="192x192" rel="icon" href="{{ asset('/icons/android-icon-192x192.png') }}">
    <link type="image/png" sizes="512x512" rel="icon" href="{{ asset('/icons/android-icon-512x512.png') }}">
    <link rel="manifest" href="./manifest.json">

    <!-- Иконки для iOS (Apple) -->
    <link sizes="57x57" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-57x57.png') }} ">
    <link sizes="60x60" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-60x60.png') }} ">
    <link sizes="72x72" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-72x72.png') }} ">
    <link sizes="76x76" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-76x76.png') }} ">
    <link sizes="114x114" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-114x114.png') }} ">
    <link sizes="120x120" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-120x120.png') }} ">
    <link sizes="144x144" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-144x144.png') }} ">
    <link sizes="152x152" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-152x152.png') }} ">
    <link sizes="180x180" rel="apple-touch-icon" href="{{ asset('/icons/apple-touch-icon-180x180.png') }} ">

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
</head>

<body>

    <div id="loading-screen">
        <img src="/storage/icon/fool_logo.svg" alt="Loading">
    </div>
    @if (session('success'))
        <div id="success-message" class="success-message">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div id="error-message" class="error-message">
            {{ session('error') }}
        </div>
    @endif
    <div id="messages"></div>

    <main class="py-4">
        
        @yield('content')
        @include('layouts/mobponel')
    </main>

</body>

<script>
    window.onload = function() {
        console.log("Размер экрана:", window.innerWidth);

        if (window.innerWidth > 768) {
            console.log("Проверка обучения для десктопа...");
            if (!localStorage.getItem('tutorial_seen_desktop')) {
                console.log("Запуск обучения для десктопа...");
                const intro = introJs();
                intro.setOptions({
                    steps: [{
                            element: '#step-1',
                            intro: 'Модульный контент - это основная часть интерфейса.',
                            position: 'bottom'
                        },
                        {
                            element: '#step-2',
                            intro: 'Панель вкладок.',
                            position: 'right'
                        },
                        {
                            element: '#step-3',
                            intro: 'Главная страница.',
                            position: 'right'
                        },
                        {
                            element: '#step-4',
                            intro: 'Вкладка БРИФЫ.',
                            position: 'right'
                        },
                        {
                            element: '#step-5',
                            intro: 'Вкладка Сделка.',
                            position: 'right'
                        },
                        {
                            element: '#step-6',
                            intro: 'Вкладка Чаты.',
                            position: 'top'
                        },
                        {
                            element: '#step-7',
                            intro: 'Вкладка Мой профиль.',
                            position: 'top'
                        },
                        {
                            element: '#step-8',
                            intro: 'Вкладка Поддержка.',
                            position: 'top'
                        }
                    ],
                    showStepNumbers: true,
                    exitOnOverlayClick: false,
                    showButtons: true,
                    nextLabel: 'Далее',
                    prevLabel: 'Назад',
                });
                intro.start();
                localStorage.setItem('tutorial_seen_desktop', 'true');
            }
        } else {
            console.log("Проверка обучения для мобильных устройств...");
            if (!localStorage.getItem('tutorial_seen_mobile')) {
                console.log("Запуск обучения для мобильных устройств...");
                const intro = introJs();
                intro.setOptions({
                    steps: [{
                            element: '#step-mobile-1',
                            intro: 'Это основная часть интерфейса.',
                            position: 'bottom'
                        },
                        {
                            element: '#step-mobile-2',
                            intro: 'Панель навигации.',
                            position: 'bottom'
                        },
                        {
                            element: '#step-mobile-3',
                            intro: 'Главная страница.',
                            position: 'right'
                        },
                        {
                            element: '#step-mobile-4',
                            intro: 'Вкладка БРИФЫ.',
                            position: 'right'
                        },
                        {
                            element: '#step-mobile-5',
                            intro: 'Вкладка Сделка.',
                            position: 'right'
                        },
                        {
                            element: '#step-mobile-6',
                            intro: 'Вкладка Чаты.',
                            position: 'top'
                        },
                        {
                            element: '#step-mobile-7',
                            intro: 'Вкладка Мой профиль.',
                            position: 'top'
                        },
                        {
                            element: '#step-mobile-8',
                            intro: 'Вкладка Поддержка.',
                            position: 'top'
                        }
                    ],
                    showStepNumbers: true,
                    exitOnOverlayClick: false,
                    showButtons: true,
                    nextLabel: 'Далее',
                    prevLabel: 'Назад',
                });
                intro.start();
                localStorage.setItem('tutorial_seen_mobile', 'true');
            }
        }
    };

    // Функция для сброса обучения
    function clearTutorialData() {
        console.log('Очистка данных обучения...');
        localStorage.removeItem('tutorial_seen_desktop');
        localStorage.removeItem('tutorial_seen_mobile');

        location.reload();
    }
</script>

<!-- Кнопка сброса -->
<div class="question_class-button">
    <button onclick="clearTutorialData()">
        <img src="/storage/icon/qustion.svg" alt="Сбросить обучение">
    </button>
</div>
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
</html>
