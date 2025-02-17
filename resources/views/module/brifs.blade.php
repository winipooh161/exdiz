@if ($activeBrifs->isEmpty() && $inactiveBrifs->isEmpty())
    {{-- Если пользователь не имеет никаких брифов --}}

    <form action="{{ route('brifs.store') }}" method="POST" class="div__create_form" id="step-3" >
        @csrf
        <div class="div__create_block">
            <h1>
                <span class="Jikharev">Добро пожаловать!</span>
            </h1>
            <p><strong>Дорогой клиент,</strong> для продолжения требуется пройти <strong>бриф-опросник</strong> </p>
            <div class="button__create__brifs flex gap3" id="step-8">
            <!-- Две кнопки. Каждая «говорит» контроллеру, какой именно бриф нужно создать. -->
            <button type="submit" name="brif_type" value="common">Создать Общий бриф</button>
            <button type="submit" name="brif_type" value="commercial">Создать Коммерческий бриф</button>
        </div>
        </div>
    </form>
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
                                intro: 'Вкладка Мой профиль.',
                                position: 'top'
                            },
                            {
                                element: '#step-7',
                                intro: 'Вкладка Поддержка.',
                                position: 'top'
                            },
                            {
                                element: '#step-8',
                                intro: 'Кнопки которые отвечают за зполнение бриф-опросника.',
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
                                element: '#step-3',
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
                                intro: 'Вкладка Мой профиль.',
                                position: 'top'
                            },
                            {
                                element: '#step-mobile-7',
                                intro: 'Вкладка Поддержка.',
                                position: 'top'
                            }
                            ,
                            {
                                element: '#step-8',
                                intro: 'Кнопки которые отвечают за зполнение бриф-опросника.',
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
@else
    {{-- Если у пользователя есть хотя бы один бриф --}}

    <div class="brifs wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s" id="brifs">
        <h1 class="flex">
            Ваши брифы
        </h1>

        <div class="brifs__button__create flex">
            <button onclick="window.location.href='{{ route('common.create') }}'">Создать Общий бриф</button>
            <button onclick="window.location.href='{{ route('commercial.create') }}'">Создать Коммерческий бриф</button>
        </div>
    </div>

    <div class="brifs__body wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
        <!-- Активные брифы -->
        <div class="brifs__section">
            <h2>Активные брифы</h2>

            @if ($activeBrifs->isEmpty())
                <ul class="brifs__list brifs__list__null">
                    <li class="brif" onclick="window.location.href='{{ route('common.create') }}'">
                        <p>Создать Общий бриф</p>
                    </li>
                </ul>
            @else
                <ul class="brifs__list">
                    @foreach ($activeBrifs as $brif)
                        <li class="brif"
                            onclick="window.location.href='{{ route(
                                $brif instanceof \App\Models\Common
                                    ? 'common.questions'
                                    : 'commercial.questions',
                                [
                                    'id'   => $brif->id,
                                    'page' => $brif->current_page
                                ]
                            ) }}'">
                            
                            <h4>{{ $brif->title }} #{{ $brif->id }}</h4>
                            <div class="brif__body flex">
                                <ul>
                                    @foreach (
                                        ($brif instanceof \App\Models\Common
                                            ? $pageTitlesCommon
                                            : $pageTitlesCommercial)
                                        as $index => $title
                                    )
                                        <li class="{{ $index + 1 <= $brif->current_page ? 'completed' : '' }}">
                                            {{ $title }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="button__brifs flex">
                                <button class="button__variate2"><img src="/storage/icon/create__info.svg" alt=""> <span>Заполнить</span></button>
                                <button class="button__variate2 icon"><img src="/storage/icon/close__info.svg" alt=""></button>
                            </div>
                            <p class="flex wd100 between">
                                <span>{{ $brif->created_at->format('H:i') }}</span>
                                <span>{{ $brif->created_at->format('d.m.Y') }}</span>
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Завершенные брифы --}}
        <div class="brifs__section brifs__section__finished">
            <h2>Завершенные брифы</h2>

            @if ($inactiveBrifs->isEmpty())
                <p>У вас нет завершенных брифов.</p>
            @else
                <ul class="brifs__list">
                    @foreach ($inactiveBrifs as $brif)
                        <li class="brif"
                            onclick="window.location.href='{{ route(
                                $brif instanceof \App\Models\Common
                                    ? 'common.show'
                                    : 'commercial.show',
                                $brif->id
                            ) }}'">
                            
                            <h4>{{ $brif->title }} #{{ $brif->id }}</h4>
                            <p class="flex wd100 between">
                                <span>{{ $brif->created_at->format('H:i') }}</span>
                                <span>{{ $brif->created_at->format('d.m.Y') }}</span>
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endif
