@if ($activeBrifs->isEmpty() && $inactiveBrifs->isEmpty())
    {{-- Если пользователь не имеет никаких брифов --}}

    <form action="{{ route('brifs.store') }}" method="POST" class="div__create_form">
        @csrf
        <div class="div__create_block">
            <h1>
                <span class="Jikharev">Уважаемый клиент,</span>
                мы подготовили для Вас бриф
            </h1>
            <p>
                Вам необходимо заполнить все поля. Чем больше мы получим информации,
                тем более точный результат мы сможем гарантировать!
            </p>
            <div class=" flex gap3">
            <!-- Две кнопки. Каждая «говорит» контроллеру, какой именно бриф нужно создать. -->
            <button type="submit" name="brif_type" value="common">Создать Общий бриф</button>
            <button type="submit" name="brif_type" value="commercial">Создать Коммерческий бриф</button>
        </div>
        </div>
    </form>

@else
    {{-- Если у пользователя есть хотя бы один бриф --}}

    <div class="brifs wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s" id="brifs">
        <h1 class="flex">
            Ваши <span class="Jikharev">брифы</span>
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
                            
                            <h4><strong>{{ $brif->title }} #{{ $brif->id }}</strong></h4>
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
                                <button class="button__variate2">Заполнить</button>
                                <button class="button__variate2">Удалить</button>
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
                            
                            <h4><strong>{{ $brif->title }} #{{ $brif->id }}</strong></h4>
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
