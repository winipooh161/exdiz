
  <div class="brifs" id="brifs">
    <h1 class="flex">
      Ваши <span class="Jikharev">сделки</span>
    </h1>
    <div class="filter">
      <form method="GET" action="{{ route('deal.cardinator') }}">
        <div class="search">
          <!-- Глобальный поиск по всем полям (имя, телефон, email, № проекта, примечание, город, сумма, даты) -->
          <input type="text" name="search" value="{{ request('search') }}" 
                 placeholder="Поиск (имя, телефон, email, № проекта, примечание, город, сумма, даты)">
          
          <!-- Фильтр по статусу -->
          <select name="status">
            <option value="">Все статусы</option>
            <option value="Ждем ТЗ" {{ $status === 'Ждем ТЗ' ? 'selected' : '' }}>Ждем ТЗ</option>
            <option value="Планировка" {{ $status === 'Планировка' ? 'selected' : '' }}>Планировка</option>
            <option value="Коллажи" {{ $status === 'Коллажи' ? 'selected' : '' }}>Коллажи</option>
            <option value="Визуализация" {{ $status === 'Визуализация' ? 'selected' : '' }}>Визуализация</option>
            <option value="Рабочка/сбор ИП" {{ $status === 'Рабочка/сбор ИП' ? 'selected' : '' }}>Рабочка/сбор ИП</option>
            <option value="Проект готов" {{ $status === 'Проект готов' ? 'selected' : '' }}>Проект готов</option>
            <option value="Проект завершен" {{ $status === 'Проект завершен' ? 'selected' : '' }}>Проект завершен</option>
            <option value="Проект на паузе" {{ $status === 'Проект на паузе' ? 'selected' : '' }}>Проект на паузе</option>
            <option value="Возврат" {{ $status === 'Возврат' ? 'selected' : '' }}>Возврат</option>
            <option value="В работе" {{ $status === 'В работе' ? 'selected' : '' }}>В работе</option>
            <option value="Завершенный" {{ $status === 'Завершенный' ? 'selected' : '' }}>Завершенный</option>
            <option value="На потом" {{ $status === 'На потом' ? 'selected' : '' }}>На потом</option>
            <option value="Регистрация" {{ $status === 'Регистрация' ? 'selected' : '' }}>Регистрация</option>
            <option value="Бриф прикриплен" {{ $status === 'Бриф прикриплен' ? 'selected' : '' }}>Бриф прикриплен</option>
            <option value="Поддержка" {{ $status === 'Поддержка' ? 'selected' : '' }}>Поддержка</option>
            <option value="Активный" {{ $status === 'Активный' ? 'selected' : '' }}>Активный</option>
          </select>
          
          <button type="submit">
            <img src="/storage/icon/search.svg" alt="Поиск">
          </button>
        </div>
        
        <!-- Сохраняем блок переключения вида (variate__view) -->
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
    
    <div class="brifs__button__create flex">
      @if (Auth::user()->status == 'coordinator' || Auth::user()->status == 'admin')
        <button onclick="window.location.href='{{ route('deals.create') }}'">
          <img src="/storage/icon/add.svg" alt="Создать сделку">
        </button>
      @endif
    </div>
  </div>

  <!-- Список сделок -->
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
                  <td>
                    <a href="tel:{{ $deal->client_phone }}">{{ $deal->client_phone }}</a>
                  </td>
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
                    <!-- Кнопка редактирования сделки -->
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
                      data-contract_attachment="{{ $deal->contract_attachment ? asset('storage/' . $deal->contract_attachment) : '' }}"
                    >
                      <img src="/storage/icon/create.svg" alt="Редактировать">
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          @php
            // Для блочного вида можно отфильтровать активные и завершенные сделки
            $activeDeals = $deals->filter(fn($deal) => in_array($deal->status, [
              'Ждем ТЗ','Планировка','Коллажи','Визуализация','Рабочка/сбор ИП','Проект готов',
              'Проект завершен','Проект на паузе','Возврат','В работе','Завершенный','На потом',
              'Регистрация','Бриф прикриплен','Поддержка','Активный'
            ]));
            $completedDeals = $deals->filter(fn($deal) => $deal->status === 'Завершенный');
          @endphp

          <h4 class="flex">
            Активные сделки
            <img class="px20" src="/storage/icon/deal_active.svg" alt="Активные сделки">
          </h4>
          <div class="faq__body__deal" id="active-deals-container">
            @if ($activeDeals->isEmpty())
              <div class="faq_block__deal faq_block-blur" style="display: block;">
                <p>Активных сделок пока нет.</p>
              </div>
            @else
              @foreach ($activeDeals as $deal)
                <div class="faq_block__deal">
                  <div class="faq_item__deal">
                    <div class="faq_question__deal flex between">
                      <div class="faq_question__deal__info">
                        <div class="deal__avatar deal__avatar__cardinator">
                          <img src="{{ asset('storage/' . $deal->avatar_path) }}" alt="Avatar">
                        </div>
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
                            <li>
                              <a href="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}"
                                 class="copy-link"
                                 data-link="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}">
                                Ссылка
                              </a>
                            </li>
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
                                data-contract_attachment="{{ $deal->contract_attachment ? asset('storage/' . $deal->contract_attachment) : '' }}"
                              >
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
              <div class="faq_block__deal faq_block-blur" style="display: block;">
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
                          <li>
                            <a href="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}"
                               class="copy-link"
                               data-link="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}">
                              ССЫЛКА
                            </a>
                          </li>
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
                              data-contract_attachment="{{ $deal->contract_attachment ? asset('storage/' . $deal->contract_attachment) : '' }}"
                            >
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
      <!-- Форма редактирования; action устанавливается через JS -->
      <form id="editForm" class="edit-form" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Скрытое поле для ID сделки -->
        <input type="hidden" name="deal_id" id="dealIdField" value="">

        @if(Auth::user()->status == 'coordinator' || Auth::user()->status == 'admin')
          <!-- Полный набор полей для координатора и админа -->
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
                <!-- Для удобного выбора города используем select с Select2 -->
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

          @if(Auth::user()->status == 'coordinator' || Auth::user()->status == 'admin')
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
          @endif

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
          <!-- Модальное окно для партнёра с ограниченным набором полей -->
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
            <!-- Только поля, доступные для партнёра -->
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
  <!-- Подключение jQuery, DataTables и Select2 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script>
    // Функционал копирования ссылки
    document.querySelectorAll('.copy-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const linkToCopy = this.dataset.link || this.getAttribute('href');
        if (!linkToCopy) return;
        navigator.clipboard.writeText(linkToCopy)
          .then(() => { alert('Ссылка скопирована: ' + linkToCopy); })
          .catch(err => { console.error('Ошибка при копировании ссылки: ', err); });
      });
    });

    // Пагинация для блочного вида
    function initBlockPagination(containerSelector, paginationSelector, itemsPerPage = 6) {
      const container = document.querySelector(containerSelector);
      if (!container) return;
      const blocks = container.querySelectorAll('.faq_block__deal');
      const paginationContainer = document.querySelector(paginationSelector);
      if (!paginationContainer) return;
      if (blocks.length <= itemsPerPage) {
        blocks.forEach(el => el.style.display = 'block');
        return;
      }
      const totalItems = blocks.length;
      const totalPages = Math.ceil(totalItems / itemsPerPage);
      function showPage(pageIndex) {
        blocks.forEach(el => { el.style.display = 'none'; });
        const start = (pageIndex - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        for (let i = start; i < end && i < totalItems; i++) {
          blocks[i].style.display = 'block';
        }
      }
      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = i;
        btn.addEventListener('click', () => {
          paginationContainer.querySelectorAll('button').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          showPage(i);
        });
        paginationContainer.appendChild(btn);
      }
      paginationContainer.querySelector('button')?.classList.add('active');
      showPage(1);
    }
    initBlockPagination('#active-deals-container', '#active-deals-pagination', 6);
    initBlockPagination('#completed-deals-container', '#completed-deals-pagination', 6);

    // Инициализация DataTables для табличного вида
    if (document.getElementById('dealTable')) {
      $('#dealTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/ru.json' },
        paging: true,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true
      });
    }

    // Модальное окно редактирования сделки
    const editModal = document.getElementById('editModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const editForm = document.getElementById('editForm');
    const toggleEditBtn = editForm.querySelector('.toggle-edit-btn');
    const saveBtn = document.getElementById('saveButton');
    const dealIdField = document.getElementById('dealIdField');

    function setValueIfExist(elem, val) {
      if (elem) elem.value = val || '';
    }
    function setFormDisabled(disabled) {
      if (!editForm) return;
      const allInputs = editForm.querySelectorAll('input, select, textarea, button[type="submit"]');
      allInputs.forEach(el => { el.disabled = disabled; });
    }
    function openModal(modal) {
      if (!modal) return;
      modal.style.display = 'flex';
      setTimeout(() => { modal.classList.add('show'); }, 10);
    }
    function closeModal(modal) {
      if (!modal) return;
      modal.classList.remove('show');
      setTimeout(() => { modal.style.display = 'none'; }, 300);
    }
    function setFilePreview(previewElemId, fileUrl, labelText) {
      const previewElem = document.getElementById(previewElemId);
      if (previewElem) {
        if (fileUrl && fileUrl.trim() !== '') {
          previewElem.innerHTML = `<a href="${fileUrl}" target="_blank">${labelText}</a>`;
        } else {
          previewElem.innerHTML = 'Файл не загружен';
        }
      }
    }

    // При клике на кнопку «Редактировать» передаём data-атрибуты в поля формы
    document.querySelectorAll('.edit-deal-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const dealId = btn.dataset.id || '';
        setValueIfExist(dealIdField, dealId);
        setValueIfExist(document.getElementById('projectNumberField'), btn.dataset.project_number);
        setValueIfExist(document.getElementById('statusField'), btn.dataset.status);
        setValueIfExist(document.getElementById('priceServiceField'), btn.dataset.price_service_option);
        setValueIfExist(document.getElementById('roomsCountField'), btn.dataset.rooms_count);
        setValueIfExist(document.getElementById('executionOrderCommentField'), btn.dataset.execution_order_comment);
        setValueIfExist(document.getElementById('packageField'), btn.dataset.package);
        setValueIfExist(document.getElementById('nameField'), btn.dataset.name);
        setValueIfExist(document.getElementById('phoneField'), btn.dataset.client_phone);
        // Для поля "Город" используем select2 (если оно есть)
        var clientCity = btn.dataset.client_city || '';
        if ($('#cityField').length) {
          $('#cityField').val(clientCity).trigger('change');
        }
        setValueIfExist(document.getElementById('emailField'), btn.dataset.client_email);
        setValueIfExist(document.getElementById('clientTimezoneField'), btn.dataset.client_timezone);
        setValueIfExist(document.getElementById('officePartnerField'), btn.dataset.office_partner_id);
        setValueIfExist(document.getElementById('completionResponsibleField'), btn.dataset.completion_responsible);
        setValueIfExist(document.getElementById('coordinatorField'), btn.dataset.coordinator_name);
        setValueIfExist(document.getElementById('measurementCommentsField'), '');
        setValueIfExist(document.getElementById('measurementsFileField'), '');
        setValueIfExist(document.getElementById('contractNumberField'), '');
        setValueIfExist(document.getElementById('paymentDateField'), btn.dataset.payment_date);
        setValueIfExist(document.getElementById('totalSumField'), btn.dataset.total_sum);
        setValueIfExist(document.getElementById('dealNoteField'), '');
        setFilePreview('avatar-preview', btn.dataset.avatar, 'Просмотреть аватар');
        setFilePreview('executionOrderFilePreview', btn.dataset.execution_order_file, 'Просмотреть файл заказа');
        setFilePreview('measurementsFilePreview', btn.dataset.measurements_file, 'Просмотреть файл замеров');
        setFilePreview('finalFloorplanPreview', btn.dataset.final_floorplan, 'Просмотреть планировку');
        setFilePreview('finalCollagePreview', btn.dataset.final_collage, 'Просмотреть коллаж');
        setFilePreview('finalProjectFilePreview', btn.dataset.final_project_file, 'Просмотреть финал проекта');
        setFilePreview('chatScreenshotPreview', btn.dataset.chat_screenshot, 'Просмотреть скрин чата');
        setFilePreview('archicadFilePreview', btn.dataset.archicad_file, 'Просмотреть файл архикада');
        setFilePreview('contractAttachmentPreview', btn.dataset.contract_attachment, 'Просмотреть приложение к договору');

        // По умолчанию делаем форму недоступной для редактирования
        setFormDisabled(true);
        if (editForm) {
          editForm.action = "{{ url('/deal/update') }}/" + dealId;
        }
        openModal(editModal);
      });
    });

    closeModalBtn.addEventListener('click', () => {
      closeModal(editModal);
    });
    window.addEventListener('click', (event) => {
      if (event.target === editModal) {
        closeModal(editModal);
      }
    });
    toggleEditBtn.addEventListener('click', () => {
      const nameField = document.getElementById('nameField');
      if (!nameField) return;
      const isDisabled = nameField.disabled;
      setFormDisabled(!isDisabled);
      toggleEditBtn.textContent = isDisabled ? 'Отменить' : 'Изменить';
      saveBtn.disabled = isDisabled ? false : true;
    });

    // Скрипт для включения только тех полей, которые доступны текущему пользователю
    document.querySelector('.toggle-edit-btn').addEventListener('click', function() {
      var userRole = "{{ Auth::user()->status }}";
      if(userRole === 'coordinator' || userRole === 'admin'){
        document.getElementById('projectNumberField').disabled = false;
        document.getElementById('statusField').disabled = false;
        document.getElementById('startDateField').disabled = false;
        document.getElementById('projectDurationField').disabled = false;
        document.getElementById('projectEndDateField').disabled = false;
        document.getElementById('architectField').disabled = false;
        document.getElementById('finalFloorplanField').disabled = false;
        document.getElementById('designerField').disabled = false;
        document.getElementById('finalCollageField').disabled = false;
        document.getElementById('visualizerField').disabled = false;
        document.getElementById('visualizationLinkField').disabled = false;
        document.getElementById('finalProjectFileField').disabled = false;
      } else if(userRole === 'partner'){
        // Для партнёра разрешаем редактирование только разрешённых полей
        document.getElementById('priceServiceField').disabled = false;
        document.getElementById('roomsCountField').disabled = false;
        document.getElementById('executionOrderCommentField').disabled = false;
        document.getElementById('packageField').disabled = false;
        document.getElementById('nameField').disabled = false;
        document.getElementById('phoneField').disabled = false;
        document.getElementById('cityField').disabled = false;
        document.getElementById('clientTimezoneField').disabled = false;
        document.getElementById('officePartnerField').disabled = false;
        document.getElementById('completionResponsibleField').disabled = false;
        document.getElementById('measurementCommentsField').disabled = false;
        document.getElementById('measurementsFileField').disabled = false;
        document.getElementById('contractNumberField').disabled = false;
        document.getElementById('paymentDateField').disabled = false;
        document.getElementById('totalSumField').disabled = false;
        document.getElementById('contractAttachmentField').disabled = false;
        document.getElementById('avatarField').disabled = false;
      }
      document.getElementById('saveButton').disabled = false;
    });

    // Инициализация Select2 для загрузки городов из JSON-файла и группировки по регионам
    $(document).ready(function() {
      var jsonFilePath = '/cities.json';
      $.getJSON(jsonFilePath, function(data) {
        var groupedOptions = {};
        data.forEach(function(item) {
          var region = item.region;
          var city = item.city;
          if (!groupedOptions[region]) {
            groupedOptions[region] = [];
          }
          groupedOptions[region].push({
            id: city,
            text: city
          });
        });
        var select2Data = [];
        for (var region in groupedOptions) {
          select2Data.push({
            text: region,
            children: groupedOptions[region]
          });
        }
        // Инициализация для поля "Город/часовой пояс" в основной форме
        $('#client_timezone').select2({
          data: select2Data,
          placeholder: "-- Выберите город --",
          allowClear: true
        });
        // Инициализация для поля "Город" в модальном окне
        if ($('#cityField').length) {
          $('#cityField').select2({
            data: select2Data,
            placeholder: "-- Выберите город --",
            allowClear: true
          });
        }
      })
      .fail(function(jqxhr, textStatus, error) {
        console.error("Ошибка загрузки JSON файла: " + textStatus + ", " + error);
      });
    });

    // Маска для номера телефона
    $("input.maskphone").on("input", function() {
      var blank = "+7 (___) ___-__-__";
      var i = 0;
      var val = this.value.replace(/\D/g, "");
      this.value = blank.replace(/./g, function(char) {
          if (/[_\d]/.test(char) && i < val.length) {
              return val.charAt(i++);
          }
          return i >= val.length ? "" : char;
      });
    });

    // Маска для поля "№ проекта"
    $("input.maskproject").on("input", function() {
      var value = this.value;
      if (!value.startsWith("Проект ")) {
          value = "Проект " + value.replace(/[^0-9]/g, "");
      } else {
          var digits = value.substring(7).replace(/[^0-9]/g, "");
          digits = digits.substring(0, 4);
          value = "Проект " + digits;
      }
      this.value = value;
    });

    // Маска для поля "№ договора"
    $("input.maskcontract").on("input", function() {
      var value = this.value;
      if (!value.startsWith("CN-")) {
          value = "CN-" + value.replace(/[^0-9]/g, "");
      } else {
          var digits = value.substring(3).replace(/[^0-9]/g, "");
          digits = digits.substring(0, 4);
          value = "CN-" + digits;
      }
      this.value = value;
    });

    // Маска для поля "Пакет": разрешаем ввод только одной цифры
    $("#package").on("input", function() {
      var val = this.value.replace(/\D/g, "");
      if(val.length > 1) { val = val.substring(0, 1); }
      this.value = val;
    });

    // Скрипт для расчёта даты завершения проекта на основе срока (в днях)
    var durationField = document.getElementById("project_duration");
    if(durationField) {
      durationField.addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, "");
        if(this.value === "") {
          document.getElementById("project_end_date").value = "";
        } else {
          var durationDays = parseInt(this.value);
          var startDateField = document.getElementById("start_date");
          if(!isNaN(durationDays) && startDateField && startDateField.value) {
            var startDate = new Date(startDateField.value);
            var endDate = new Date(startDate.getTime() + durationDays * 86400000);
            var dd = endDate.getDate();
            var mm = endDate.getMonth() + 1;
            var yyyy = endDate.getFullYear();
            if(dd < 10) { dd = '0' + dd; }
            if(mm < 10) { mm = '0' + mm; }
            document.getElementById("project_end_date").value = yyyy + '-' + mm + '-' + dd;
          }
        }
      });
    }

    // Устанавливаем сегодняшнюю дату в поле "Дата начала проекта" и делаем его readonly
    var startDateField = document.getElementById("start_date");
    if(startDateField) {
      var today = new Date().toISOString().substr(0, 10);
      startDateField.value = today;
      startDateField.setAttribute("readonly", true);
    }
  </script>

