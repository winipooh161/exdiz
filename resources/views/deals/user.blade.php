<div class="deals-list">
    <h1 class=" flex" >
        Ваша  <span class="Jikharev">сделка</span>  
      
    </h1>
    @if ($userDeals->isNotEmpty())
        @foreach ($userDeals as $deal)
            <div class="deal" id="deal-{{ $deal->id }}">
                <div class="deal__body">
                    <!-- Информация о сделке -->
                    <div class="deal__info">
                        <div class="deal__info__profile">
                            <div class="deal__avatar">
                                <img src="{{ asset('' . $deal->avatar_path) }}" alt="Avatar">
                            </div>
                            <div class="deal__info__title">
                                <h3>{{ $deal->name }}</h3>
                                <p> {{ $deal->description ?? 'Описание отсутствует' }}</p>
                               
                            </div>
                        </div>
                        
                        <div class="faq_question__deal__status">
                            <p>{{ $deal->status }}</p>
                            <h3><br> {{ $deal->total_sum ?? 'Отсутствует' }}</h3>
                            @if ($deal->link)
                                <p>Привязанный бриф <br>
                                    <a href="{{ $deal->link }}">
                                        {{ $deal->link }}
                                    </a>
                                </p>
                            @else
                                <p>Бриф не прикреплен</p>
                            @endif
                        </div>
                    </div>
                    <div class="deal__container">
                        <div class="deal__info__point">
                        
                            
                            @php
                                // Найдём конкретный групповой чат для этой сделки:
                                $groupChatForDeal = \App\Models\Chat::where('deal_id', $deal->id)
                                    ->where('type', 'group')
                                    ->first();
                            @endphp
                        
                            @include('chats.index', [
                                'dealChat' => $groupChatForDeal, // передаём объект
                            ])
                       
                        
                            
                        </div>
                        <!-- Секция ответственных за сделку -->
                        <div class="deal__responsible">
                            <ul>
                                <h4>Ответственные за сделку:</h4>
                                @if ($deal->users->isNotEmpty())
                                    @foreach ($deal->users as $user)
                                        <li class="deal__responsible__user">
                                            <div class="deal__responsible__avatar">
                                                <img src="{{ $user->avatar_url ?? '/images/default-avatar.png' }}"
                                                    alt="Аватар {{ $user->name }}">
                                            </div>
                                            <div class="deal__responsible__info">
                                                <h5>{{ $user->name }}</h5>
                                                <p>{{ $user->status }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="deal__responsible__user">
                                        <p>Ответственные не назначены</p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>У вас пока нет сделок.</p>
    @endif
</div>
