<div class="brifs" id="brifs">
  <h1 class="flex">Ваши <span class="Jikharev">сделки</span></h1>
  <div class="filter">
    <form method="GET" action="{{ route('deal.cardinator') }}">
      <div class="search">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Поиск (имя, телефон, email, № проекта, примечание, город, сумма, даты)">
        <select name="status">
          <option value="">Все статусы</option>
          @foreach([
            'Ждем ТЗ','Планировка','Коллажи','Визуализация','Рабочка/сбор ИП',
            'Проект готов','Проект завершен','Проект на паузе','Возврат','В работе',
            'Завершенный','На потом','Регистрация','Бриф прикриплен','Поддержка','Активный'
          ] as $option)
            <option value="{{ $option }}" {{ $status === $option ? 'selected' : '' }}>
              {{ $option }}
            </option>
          @endforeach
        </select>
        <button type="submit">
          <img src="/storage/icon/search.svg" alt="Поиск">
        </button>
      </div>
      <div class="variate__view">
        <button type="submit" name="view_type" value="blocks" class="{{ $viewType === 'blocks' ? 'active-button' : '' }}">
          <img src="/storage/icon/blocks.svg" alt="Блоки">
        </button>
        <button type="submit" name="view_type" value="table" class="{{ $viewType === 'table' ? 'active-button' : '' }}">
          <img src="/storage/icon/burger.svg" alt="Таблица">
        </button>
      </div>
    </form>
  </div>
  @if (in_array(Auth::user()->status, ['coordinator', 'admin']))
    <div class="brifs__button__create flex">
      <button onclick="window.location.href='{{ route('deals.create') }}'">
        <img src="/storage/icon/add.svg" alt="Создать сделку">
      </button>
    </div>
  @endif
</div>

<div class="deal" id="deal">
  <div class="deal__body">
    <div class="deal__cardinator__lists">
      @if ($viewType === 'table')
        <table id="dealTable" border="1" class="deal-table">
          <thead>
            <tr>
              <th>Имя клиента</th>
              <th>Номер клиента</th>
              <th>Сумма сделки</th>
              <th>Статус</th>
              <th>Действия</th>
            </tr>
          </thead>
          <tbody class="flex_table__format_table">
            @foreach ($deals->filter(fn($deal) => $deal->users->contains('id', Auth::id())) as $deal)
              <tr>
                <td>{{ $deal->name }}</td>
                <td><a href="tel:{{ $deal->client_phone }}">{{ $deal->client_phone }}</a></td>
                <td>{{ $deal->total_sum ?? 'Отсутствует' }}</td>
                <td>{{ $deal->status }}</td>
                <td class="link__deistv">
                  <a href="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}">
                    <img src="/storage/icon/write-link.svg" alt="Ссылка">
                  </a>
                  <a href="{{ url('/chats') }}">
                    <img src="/storage/icon/write-chat.svg" alt="Чат">
                  </a>
                  <a href="{{ $deal->link ? url($deal->link) : '#' }}">
                    <img src="/storage/icon/write-brif.svg" alt="Бриф">
                  </a>
                  @if (in_array(Auth::user()->status, ['coordinator', 'admin']))
                    <a href="{{ route('deal.change_logs.deal', ['deal' => $deal->id]) }}"
                       class="btn btn-info btn-sm">Логи</a>
                  @endif
                  <button type="button" class="edit-deal-btn"
                    data-id="{{ $deal->id }}"
                    data-project_number="{{ $deal->project_number }}"
                    data-status="{{ $deal->status }}"
                    data-price_service_option="{{ $deal->price_service }}"
                    data-rooms_count="{{ $deal->rooms_count_pricing }}"
                    data-execution_order_comment="{{ $deal->execution_order_comment }}"
                    data-package="{{ $deal->package }}"
                    data-name="{{ $deal->name }}"
                    data-client_phone="{{ $deal->client_phone }}"
                    data-client_city="{{ $deal->client_city }}"
                    data-client_email="{{ $deal->client_email }}"
                    data-client_timezone="{{ $deal->client_timezone }}"
                    data-office_partner_id="{{ $deal->office_partner_id }}"
                    data-completion_responsible="{{ $deal->completion_responsible }}"
                    data-coordinator_name="{{ $deal->coordinator->name ?? '' }}"
                    data-office_equipment="{{ $deal->office_equipment }}"
                    data-coordinator_score="{{ $deal->coordinator_score }}"
                    data-measuring_cost="{{ $deal->measuring_cost }}"
                    data-project_budget="{{ $deal->project_budget }}"
                    data-created_date="{{ $deal->created_date }}"
                    data-payment_date="{{ $deal->payment_date }}"
                    data-client_info="{{ $deal->client_info }}"
                    data-execution_comment="{{ $deal->execution_comment }}"
                    data-comment="{{ $deal->comment }}"
                    data-project_duration="{{ $deal->project_duration }}"
                    data-deal_end_date="{{ $deal->project_end_date }}"
                    data-avatar="{{ $deal->avatar_path ? asset('storage/' . $deal->avatar_path) : '' }}"
                    data-execution_order_file="{{ $deal->execution_order_file ? asset('storage/' . $deal->execution_order_file) : '' }}"
                    data-measurements_file="{{ $deal->measurements_file ? asset('storage/' . $deal->measurements_file) : '' }}"
                    data-final_floorplan="{{ $deal->final_floorplan ? asset('storage/' . $deal->final_floorplan) : '' }}"
                    data-final_collage="{{ $deal->final_collage ? asset('storage/' . $deal->final_collage) : '' }}"
                    data-final_project_file="{{ $deal->final_project_file ? asset('storage/' . $deal->final_project_file) : '' }}"
                    data-chat_screenshot="{{ $deal->chat_screenshot ? asset('storage/' . $deal->chat_screenshot) : '' }}"
                    data-archicad_file="{{ $deal->archicad_file ? asset('storage/' . $deal->archicad_file) : '' }}"
                    data-contract_attachment="{{ $deal->contract_attachment ? asset('storage/' . $deal->contract_attachment) : '' }}">
                    <img src="/storage/icon/create.svg" alt="Редактировать">
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        @php
          $activeDeals = $deals->filter(fn($deal) => in_array($deal->status, [
            'Ждем ТЗ','Планировка','Коллажи','Визуализация','Рабочка/сбор ИП',
            'Проект готов','Проект завершен','Проект на паузе','Возврат','В работе',
            'Завершенный','На потом','Регистрация','Бриф прикриплен','Поддержка','Активный'
          ]));
          $completedDeals = $deals->filter(fn($deal) => $deal->status === 'Завершенный');
        @endphp

        <h4 class="flex">
          Активные сделки
          <img class="px20" src="/storage/icon/deal_active.svg" alt="Активные сделки">
        </h4>
        <div class="faq__body__deal" id="active-deals-container">
          @if ($activeDeals->isEmpty())
            <div class="faq_block__deal faq_block-blur">
              <p>Активных сделок пока нет.</p>
            </div>
          @else
            @foreach ($activeDeals as $deal)
              <div class="faq_block__deal">
                <div class="faq_item__deal">
                  <div class="faq_question__deal flex between">
                    <div class="faq_question__deal__info">
                      @if ($deal->avatar_path)
                        <div class="deal__avatar deal__avatar__cardinator">
                          <img src="{{ asset('storage/' . $deal->avatar_path) }}" alt="Avatar">
                        </div>
                      @endif
                      <div class="deal__cardinator__info">
                        <h4>{{ $deal->name }}</h4>
                        <p>Телефон:
                          <a href="tel:{{ $deal->client_phone }}">{{ $deal->client_phone }}</a>
                        </p>
                        <p>Статус: {{ $deal->status }}</p>
                        <ul>
                          <li>
                            <a href="{{ url('/chats') }}">
                              <div class="icon">Чат</div>
                            </a>
                          </li>
                          <li>
                            <a href="{{ $deal->link ? url($deal->link) : '#' }}">
                              <div class="icon">Бриф</div>
                            </a>
                          </li>
                          @if ($deal->registration_token)
                          <li>
                              <a href="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}"
                                 class="copy-link"
                                 data-link="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}">
                                  Ссылка
                              </a>
                          </li>
                      @endif
                      
                          @if (in_array(Auth::user()->status, ['coordinator', 'admin']))
                            <li>
                              <a href="{{ route('deal.change_logs.deal', ['deal' => $deal->id]) }}"
                                 class="btn btn-info btn-sm">Логи</a>
                            </li>
                          @endif
                          <li>
                            <button type="button" class="edit-deal-btn"
                              data-id="{{ $deal->id }}"
                              data-project_number="{{ $deal->project_number }}"
                              data-status="{{ $deal->status }}"
                              data-price_service_option="{{ $deal->price_service }}"
                              data-rooms_count="{{ $deal->rooms_count_pricing }}"
                              data-execution_order_comment="{{ $deal->execution_order_comment }}"
                              data-package="{{ $deal->package }}"
                              data-name="{{ $deal->name }}"
                              data-client_phone="{{ $deal->client_phone }}"
                              data-client_city="{{ $deal->client_city }}"
                              data-client_email="{{ $deal->client_email }}"
                              data-client_timezone="{{ $deal->client_timezone }}"
                              data-office_partner_id="{{ $deal->office_partner_id }}"
                              data-completion_responsible="{{ $deal->completion_responsible }}"
                              data-coordinator_name="{{ $deal->coordinator->name ?? '' }}">
                              ИЗМЕНИТЬ
                            </button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
          <div class="pagination" id="active-deals-pagination"></div>
        </div>

        <h4 class="flex">
          Завершенные сделки
          <img class="px20" src="/storage/icon/deal_inactive.svg" alt="Завершённые сделки">
        </h4>
        <div class="faq__body__deal" id="completed-deals-container">
          @if ($completedDeals->isEmpty())
            <div class="faq_block__deal faq_block-blur">
              <p>Завершенных сделок пока нет.</p>
            </div>
          @else
            @foreach ($completedDeals as $deal)
              <div class="faq_block__deal">
                <div class="faq_item__deal">
                  <div class="faq_question__deal flex between">
                    <div class="faq_question__deal__info">
                      <h4>{{ $deal->name }}</h4>
                      <ul>
                        <li>
                          <a href="{{ url('/chats') }}">
                            <div class="icon">Чат</div>
                          </a>
                        </li>
                        <li>
                          <a href="{{ $deal->link ? url($deal->link) : '#' }}">
                            <div class="icon">Бриф</div>
                          </a>
                        </li>
                        @if (in_array(Auth::user()->status, ['coordinator', 'admin']))
                          <li>
                            <a href="{{ route('deal.change_logs.deal', ['deal' => $deal->id]) }}"
                               class="btn btn-info btn-sm">Логи</a>
                          </li>
                        @endif
                        @if ($deal->registration_token)
                        <li>
                            <a href="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}"
                               class="copy-link"
                               data-link="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}">
                                Ссылка
                            </a>
                        </li>
                    @endif
                    
                        <li>
                          <button type="button" class="edit-deal-btn"
                            data-id="{{ $deal->id }}"
                            data-project_number="{{ $deal->project_number }}"
                            data-status="{{ $deal->status }}"
                            data-price_service_option="{{ $deal->price_service }}"
                            data-rooms_count="{{ $deal->rooms_count_pricing }}"
                            data-execution_order_comment="{{ $deal->execution_order_comment }}"
                            data-package="{{ $deal->package }}"
                            data-name="{{ $deal->name }}"
                            data-client_phone="{{ $deal->client_phone }}"
                            data-client_city="{{ $deal->client_city }}"
                            data-client_email="{{ $deal->client_email }}"
                            data-client_timezone="{{ $deal->client_timezone }}"
                            data-office_partner_id="{{ $deal->office_partner_id }}"
                            data-completion_responsible="{{ $deal->completion_responsible }}"
                            data-coordinator_name="{{ $deal->coordinator->name ?? '' }}">
                            ИЗМЕНИТЬ
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
          <div class="pagination" id="completed-deals-pagination"></div>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Модальное окно редактирования сделки -->
<div class="modal modal__deal" id="editModal">
  <div class="modal-content">
    <span class="close-modal" id="closeModalBtn">&times;</span>
    <form id="editForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <!-- Скрытое поле для ID сделки -->
      <input type="hidden" name="deal_id" id="dealIdField" value="">

      @if(Auth::user()->status == 'coordinator' || Auth::user()->status == 'admin')
        <fieldset class="module">
          <legend>ЗАКАЗ</legend>
          <div class="form-group-deal">
            <label>№ проекта:
              <input type="text" name="project_number" id="projectNumberField" value="" class="maskproject">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Статус:
              <select name="status" id="statusField">
                <option value="">-- Выберите статус --</option>
                @foreach(['Ждем ТЗ','Планировка','Коллажи','Визуализация','Рабочка/сбор ИП','Проект готов','Проект завершен','Проект на паузе','Возврат','В работе','Завершенный','На потом','Регистрация','Бриф прикриплен','Поддержка','Активный'] as $statusOption)
                  <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Услуга по прайсу:
              <select name="price_service_option" id="priceServiceField">
                <option value="">-- Выберите услугу --</option>
                @foreach(['экспресс планировка','экспресс планировка с коллажами','экспресс проект с электрикой','экспресс планировка с электрикой и коллажами','экспресс проект с электрикой и визуализацией','экспресс рабочий проект','экспресс эскизный проект с рабочей документацией','экспресс 3Dвизуализация','экспресс полный дизайн-проект','360 градусов'] as $option)
                  <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Количество комнат по прайсу:
              <input type="number" name="rooms_count_pricing" id="roomsCountField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Комментарий к заказу:
              <textarea name="execution_order_comment" id="executionOrderCommentField" maxlength="1000"></textarea>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Пакет:
              <input type="text" name="package" id="packageField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>ФИО клиента:
              <input type="text" name="name" id="nameField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Телефон:
              <input type="text" name="client_phone" id="phoneField" value="" class="maskphone">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Город:
              <select name="client_city" id="cityField"></select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Email:
              <input type="email" name="client_email" id="emailField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Часовой пояс:
              <select name="client_timezone" id="client_timezone" class="form-control" required>
                <option value="">-- Выберите город --</option>
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Офис/Партнер:
              <select name="office_partner_id" id="officePartnerField">
                <option value="">-- Не выбрано --</option>
                @foreach(App\Models\User::where('status','partner')->get() as $partner)
                  <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Кто делает комплектацию:
              <input type="text" name="completion_responsible" id="completionResponsibleField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Координатор:
              <input type="text" name="coordinator_name" id="coordinatorField" value="" readonly>
            </label>
          </div>
        </fieldset>

        <fieldset class="module">
          <legend>РАБОТА НАД ПРОЕКТОМ</legend>
          <div class="form-group-deal">
            <label>Комментарии по замерам:
              <textarea name="measurement_comments" id="measurementCommentsField" maxlength="1000"></textarea>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Замеры (файл):
              <input type="file" name="measurements_file" id="measurementsFileField" accept=".pdf,.dwg,image/*">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Дата старта:
              <input type="date" name="start_date" id="startDateField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Общий срок проекта (в днях):
              <input type="number" name="project_duration" id="projectDurationField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Дата завершения:
              <input type="date" name="project_end_date" id="projectEndDateField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Архитектор:
              <select name="architect_id" id="architectField">
                <option value="">-- Не выбрано --</option>
                @foreach(App\Models\User::where('status','architect')->get() as $architect)
                  <option value="{{ $architect->id }}">{{ $architect->name }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Планировка финал (PDF):
              <input type="file" name="final_floorplan" id="finalFloorplanField" accept="application/pdf">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Дизайнер:
              <select name="designer_id" id="designerField">
                <option value="">-- Не выбрано --</option>
                @foreach(App\Models\User::where('status','designer')->get() as $designer)
                  <option value="{{ $designer->id }}">{{ $designer->name }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Коллаж финал (PDF):
              <input type="file" name="final_collage" id="finalCollageField" accept="application/pdf">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Визуализатор:
              <select name="visualizer_id" id="visualizerField">
                <option value="">-- Не выбрано --</option>
                @foreach(App\Models\User::where('status','visualizer')->get() as $visualizer)
                  <option value="{{ $visualizer->id }}">{{ $visualizer->name }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Ссылка на визуализацию:
              <input type="url" name="visualization_link" id="visualizationLinkField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Финал проекта (PDF):
              <input type="file" name="final_project_file" id="finalProjectFileField" accept="application/pdf">
            </label>
          </div>
        </fieldset>

        <fieldset class="module">
          <legend>ФИНАЛ ПРОЕКТА</legend>
          <div class="form-group-deal">
            <label>Акт выполненных работ (PDF):
              <input type="file" name="work_act" id="workActField" accept="application/pdf">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Оценка за проект (от клиента):
              <input type="number" name="client_project_rating" id="clientProjectRatingField" value="" min="0" max="10" step="0.5">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Оценка архитектора (Клиент):
              <input type="number" name="architect_rating_client" id="architectRatingClientField" value="" min="0" max="10" step="0.5">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Оценка архитектора (Партнер):
              <input type="number" name="architect_rating_partner" id="architectRatingPartnerField" value="" min="0" max="10" step="0.5">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Оценка архитектора (Координатор):
              <input type="number" name="architect_rating_coordinator" id="architectRatingCoordinatorField" value="" min="0" max="10" step="0.5">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Скрин чата с оценкой и актом (JPEG):
              <input type="file" name="chat_screenshot" id="chatScreenshotField" accept="image/jpeg,image/jpg,image/png">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Комментарий координатора:
              <textarea name="coordinator_comment" id="coordinatorCommentField" maxlength="1000"></textarea>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Исходный файл архикад (pln, dwg):
              <input type="file" name="archicad_file" id="archicadFileField" accept=".pln,.dwg">
            </label>
          </div>
        </fieldset>

        <fieldset class="module">
          <legend>О СДЕЛКЕ</legend>
          <div class="form-group-deal">
            <label>№ договора:
              <input type="text" name="contract_number" id="contractNumberField" value="" class="maskcontract">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Дата создания сделки:
              <input type="date" name="created_date" id="createdDateField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Дата оплаты:
              <input type="date" name="payment_date" id="paymentDateField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Сумма заказа:
              <input type="number" name="total_sum" id="totalSumField" value="" step="0.01">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Приложение договора:
              <input type="file" name="contract_attachment" id="contractAttachmentField" accept="application/pdf,image/jpeg,image/jpg,image/png">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Примечание:
              <textarea name="deal_note" id="dealNoteField"></textarea>
            </label>
          </div>
        </fieldset>

        <fieldset class="module">
          <legend>АВАТАР СДЕЛКИ</legend>
          <div class="form-group-deal">
            <label>Аватар сделки:
              <input type="file" name="avatar" id="avatarField" accept="image/*">
            </label>
          </div>
          <div id="avatar-preview" class="avatar-preview">
            <!-- Превью аватара -->
          </div>
        </fieldset>
      @elseif(Auth::user()->status == 'partner')
        <fieldset class="module">
          <legend>ЗАКАЗ</legend>
          <div class="form-group-deal">
            <label>№ проекта:
              <input type="text" name="project_number" id="projectNumberField" value="" class="maskproject" readonly>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Статус:
              <select name="status" id="statusField" disabled>
                <option value="">-- Выберите статус --</option>
                @foreach(['Ждем ТЗ','Планировка','Коллажи','Визуализация','Рабочка/сбор ИП','Проект готов','Проект завершен','Проект на паузе','Возврат','В работе','Завершенный','На потом','Регистрация','Бриф прикриплен','Поддержка','Активный'] as $statusOption)
                  <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Услуга по прайсу:
              <select name="price_service_option" id="priceServiceField">
                <option value="">-- Выберите услугу --</option>
                @foreach(['экспресс планировка','экспресс планировка с коллажами','экспресс проект с электрикой','экспресс планировка с электрикой и коллажами','экспресс проект с электрикой и визуализацией','экспресс рабочий проект','экспресс эскизный проект с рабочей документацией','экспресс 3Dвизуализация','экспресс полный дизайн-проект','360 градусов'] as $option)
                  <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Количество комнат по прайсу:
              <input type="number" name="rooms_count_pricing" id="roomsCountField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Комментарий к заказу:
              <textarea name="execution_order_comment" id="executionOrderCommentField" maxlength="1000"></textarea>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Пакет:
              <input type="text" name="package" id="packageField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>ФИО клиента:
              <input type="text" name="name" id="nameField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Телефон:
              <input type="text" name="client_phone" id="phoneField" value="" class="maskphone">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Город:
              <select name="client_city" id="cityField"></select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Часовой пояс:
              <select name="client_timezone" id="client_timezone" class="form-control" required>
                <option value="">-- Выберите город --</option>
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Офис/Партнер:
              <select name="office_partner_id" id="officePartnerField">
                <option value="">-- Не выбрано --</option>
                @foreach(App\Models\User::where('status','partner')->get() as $partner)
                  <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                @endforeach
              </select>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Кто делает комплектацию:
              <input type="text" name="completion_responsible" id="completionResponsibleField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Координатор:
              <input type="text" name="coordinator_name" id="coordinatorField" value="" readonly>
            </label>
          </div>
        </fieldset>

        <fieldset class="module">
          <legend>РАБОТА НАД ПРОЕКТОМ</legend>
          <div class="form-group-deal">
            <label>Комментарии по замерам:
              <textarea name="measurement_comments" id="measurementCommentsField" maxlength="1000"></textarea>
            </label>
          </div>
          <div class="form-group-deal">
            <label>Замеры (файл):
              <input type="file" name="measurements_file" id="measurementsFileField" accept=".pdf,.dwg,image/*">
            </label>
          </div>
        </fieldset>

        <fieldset class="module">
          <legend>О СДЕЛКЕ</legend>
          <div class="form-group-deal">
            <label>№ договора:
              <input type="text" name="contract_number" id="contractNumberField" value="" class="maskcontract">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Дата оплаты:
              <input type="date" name="payment_date" id="paymentDateField" value="">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Сумма заказа:
              <input type="number" name="total_sum" id="totalSumField" value="" step="0.01">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Приложение договора:
              <input type="file" name="contract_attachment" id="contractAttachmentField" accept="application/pdf,image/jpeg,image/jpg,image/png">
            </label>
          </div>
          <div class="form-group-deal">
            <label>Примечание:
              <textarea name="deal_note" id="dealNoteField"></textarea>
            </label>
          </div>
        </fieldset>

        <fieldset class="module">
          <legend>АВАТАР СДЕЛКИ</legend>
          <div class="form-group-deal">
            <label>Аватар сделки:
              <input type="file" name="avatar" id="avatarField" accept="image/*">
            </label>
          </div>
          <div id="avatar-preview" class="avatar-preview">
            <!-- Превью аватара -->
          </div>
        </fieldset>
      @endif

      <div class="form-buttons">
        <button type="button" class="toggle-edit-btn">Изменить</button>
        <button type="submit" id="saveButton" disabled>Сохранить</button>
      </div>
    </form>
  </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(function(){
  // Функция копирования ссылки
  $('.copy-link').on('click', function(e){
    e.preventDefault();
    var link = $(this).data('link') || $(this).attr('href');
    if(link) navigator.clipboard.writeText(link).then(function(){ alert('Ссылка скопирована: ' + link); });
  });

  // Инициализация DataTable
  if ($('#dealTable').length) {
    $('#dealTable').DataTable({
      language: { url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/ru.json' },
      paging: true, ordering: true, info: true, autoWidth: false, responsive: true
    });
  }

  // Универсальная функция пагинации для блочного вида
  function initPagination(container, pagination, perPage = 6) {
    var $blocks = $(container).find('.faq_block__deal');
    if($blocks.length <= perPage){ $blocks.show(); return; }
    var total = $blocks.length, pages = Math.ceil(total / perPage);
    function showPage(page) {
      $blocks.hide().slice((page - 1) * perPage, page * perPage).show();
    }
    for(var i = 1; i <= pages; i++){
      $('<button>', { text: i })
        .on('click', function(){
          $(pagination).find('button').removeClass('active');
          $(this).addClass('active');
          showPage(parseInt($(this).text()));
        }).appendTo(pagination);
    }
    $(pagination).find('button:first').addClass('active');
    showPage(1);
  }
  initPagination('#active-deals-container', '#active-deals-pagination');
  initPagination('#completed-deals-container', '#completed-deals-pagination');

  // Модальное окно и обработка формы редактирования
  var $editModal = $('#editModal'),
      $editForm = $('#editForm');
  $('.edit-deal-btn').on('click', function(){
    var data = $(this).data();
    $.each(data, function(key, value){
      $editForm.find('#' + key + 'Field').val(value);
    });
    $editForm.attr('action', "{{ url('/deal/update') }}/" + data.id)
             .find('input,select,textarea,button[type="submit"]').prop('disabled', true);
    $editModal.show().addClass('show');
  });
  $('#closeModalBtn').on('click', function(){ $editModal.removeClass('show').hide(); });
  $editModal.on('click', function(e){ if(e.target === this) $(this).removeClass('show').hide(); });
  $('.toggle-edit-btn').on('click', function(){
    var disabled = $editForm.find('#nameField').prop('disabled');
    $editForm.find('input,select,textarea,button[type="submit"]').prop('disabled', !disabled);
    $(this).text(disabled ? 'Отменить' : 'Изменить');
  });

  // Инициализация Select2 для городов
  $.getJSON('/cities.json', function(data){
    var grouped = {};
    $.each(data, function(i, item){
      grouped[item.region] = grouped[item.region] || [];
      grouped[item.region].push({ id: item.city, text: item.city });
    });
    var selectData = $.map(grouped, function(cities, region){
      return { text: region, children: cities };
    });
    $('#client_timezone, #cityField').select2({
      data: selectData,
      placeholder: "-- Выберите город --",
      allowClear: true
    });
  }).fail(function(err){ console.error("Ошибка загрузки городов", err); });

  // Простейшие маски ввода
  $("input.maskphone").on("input", function(){ this.value = this.value.replace(/\D/g, ''); });
  $("input.maskproject").on("input", function(){
    this.value = "Проект " + this.value.replace(/\D/g, '').substring(0,4);
  });
  $("input.maskcontract").on("input", function(){
    this.value = "CN-" + this.value.replace(/\D/g, '').substring(0,4);
  });
  $("#package").on("input", function(){
    this.value = this.value.replace(/\D/g, '').substring(0,1);
  });

  // Расчёт даты завершения проекта
  $("#project_duration").on("input", function(){
    var duration = parseInt(this.value.replace(/\D/g, ''));
    var start = $("#start_date").val();
    if(start && duration){
      var end = new Date(new Date(start).getTime() + duration * 86400000),
          dd = ("0" + end.getDate()).slice(-2),
          mm = ("0" + (end.getMonth() + 1)).slice(-2),
          yyyy = end.getFullYear();
      $("#project_end_date").val(yyyy + "-" + mm + "-" + dd);
    } else {
      $("#project_end_date").val('');
    }
  });
  var today = new Date().toISOString().substr(0,10);
  $("#start_date").val(today).prop("readonly", true);
});
</script>
