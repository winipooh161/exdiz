
    <!-- Подключение CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Подключение JS DataTables и jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <div class="brifs" id="brifs">
        <h1 class=" flex" >
            Ваши  <span class="Jikharev">сделки</span>  
          
        </h1>
        
      
        <!-- Форма поиска/фильтра -->
        <div class="filter">
            <form method="GET" action="{{ route('deal.cardinator') }}">
                <div class="search">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Поиск по имени или телефону">
                  

                    <select name="status">
                        <option value="">Все статусы</option>
                        <option value="в работе" {{ $status === 'в работе' ? 'selected' : '' }}>В работе</option>
                        <option value="Завершенный" {{ $status === 'Завершенный' ? 'selected' : '' }}>Завершенный</option>
                    </select>
                    <button type="submit">
                        <img src="/storage/icon/search.svg" alt="">
                    </button>
                </div>

                <!-- Переключение вида: таблица / блоки -->
                <div class="variate__view">
                    <button type="submit" name="view_type" value="blocks"
                            class="{{ $viewType === 'blocks' ? 'active-button' : '' }}">
                        <img src="/storage/icon/blocks.svg" alt="">
                    </button>
                    <button type="submit" name="view_type" value="table"
                            class="{{ $viewType === 'table' ? 'active-button' : '' }}">
                        <img src="/storage/icon/burger.svg" alt="">
                    </button>
                </div>
            </form>
        </div>
          <!-- Кнопка «Создать сделку» -->
          <div class="brifs__button__create flex">
            <button onclick="window.location.href='{{ route('deals.create') }}'">
                <img src="/storage/icon/add.svg" alt="">
            </button>
        </div>

    </div>

    <div class="deal" id="deal">
        <div class="deal__body">
            <div class="deal__cardinator__lists">
                @if ($viewType === 'table')
                    <!-- =====================
                         ВИД: ТАБЛИЦА
                         ===================== -->
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
                            @foreach ($deals as $deal)
                                <tr>
                                    <td>{{ $deal->name }}</td>
                                    <td>
                                        <a href="tel:{{ $deal->client_phone }}">
                                            {{ $deal->client_phone }}
                                        </a>
                                    </td>
                                    <td>{{ $deal->total_sum ?? 'Отсутствует' }}</td>
                                    <td>{{ $deal->status }}</td>
                                    <td class="link__deistv">
                                        <!-- Ссылки / действия -->
                                        <a href="{{ route('register_by_deal', ['token' => $deal->registration_token]) }}">
                                            <img src="/storage/icon/write-link.svg" alt="Ссылка">
                                        </a>
                                        <a href="{{ url('/chats') }}">
                                            <img src="/storage/icon/write-chat.svg" alt="Чат">
                                        </a>
                                        <a href="{{ $deal->link ? url($deal->link) : '#' }}">
                                            <img src="/storage/icon/write-brif.svg" alt="Бриф">
                                        </a>

                                        <!-- Кнопка «Редактировать» -->
                                        <button type="button" class="edit-deal-btn"
                                            data-id="{{ $deal->id }}"
                                            data-name="{{ $deal->name }}"
                                            data-phone="{{ $deal->client_phone }}"
                                            data-city="{{ $deal->client_city }}"
                                            data-email="{{ $deal->client_email }}"
                                            data-object_type="{{ $deal->object_type }}"
                                            data-package="{{ $deal->package }}"
                                            data-has_animals="{{ $deal->has_animals }}"
                                            data-has_plants="{{ $deal->has_plants }}"
                                            data-object_style="{{ $deal->object_style }}"
                                            data-measurements="{{ $deal->measurements }}"
                                            data-rooms_count="{{ $deal->rooms_count }}"
                                            data-deal_end_date="{{ $deal->deal_end_date }}"
                                            data-status="{{ $deal->status }}"

                                            data-completion_responsible="{{ $deal->completion_responsible }}"
                                            data-office_equipment="{{ $deal->office_equipment }}"
                                            data-stage="{{ $deal->stage }}"
                                            data-coordinator_score="{{ $deal->coordinator_score }}"
                                            data-measuring_cost="{{ $deal->measuring_cost }}"
                                            data-project_budget="{{ $deal->project_budget }}"
                                            data-created_date="{{ $deal->created_date }}"
                                            data-client_info="{{ $deal->client_info }}"
                                            data-payment_date="{{ $deal->payment_date }}"
                                            data-execution_comment="{{ $deal->execution_comment }}"
                                            data-comment="{{ $deal->comment }}"
                                        >
                                            <img src="/storage/icon/create.svg" alt="Редактировать">
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <!-- =====================
                         ВИД: БЛОКИ
                         ===================== -->
                    @php
                        $activeDeals = $deals->filter(fn($deal) => in_array($deal->status, ['в работе','registered','Brif','На потом']));
                        $completedDeals = $deals->filter(fn($deal) => $deal->status === 'Завершенный');
                    @endphp

                    <h4 class="flex">Активные сделки
                        <img class="px20" src="/storage/icon/deal_active.svg" alt="">
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
                                                    <img src="{{ asset($deal->avatar_path) }}" alt="Avatar">
                                                </div>
                                                <div class="deal__cardinator__info">
                                                    <h4>{{ $deal->name }}</h4>
                                                    <p>
                                                        Телефон:
                                                        <a href="tel:{{ $deal->client_phone }}">
                                                            {{ $deal->client_phone }}
                                                        </a>
                                                    </p>
                                                <p>Статус: {{ $deal->status }}</p>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ url('/chats') }}">
                                                                <div class="icon">
                                                                  Чат
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ $deal->link ? url($deal->link) : '#' }}">
                                                                <div class="icon">
                                                                   Бриф
                                                                </div>
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
                                                            <!-- Кнопка "Редактировать" -->
                                                            <button type="button" class="edit-deal-btn"
                                                                data-id="{{ $deal->id }}"
                                                                data-name="{{ $deal->name }}"
                                                                data-phone="{{ $deal->client_phone }}"
                                                                data-city="{{ $deal->client_city }}"
                                                                data-email="{{ $deal->client_email }}"
                                                                data-object_type="{{ $deal->object_type }}"
                                                                data-package="{{ $deal->package }}"
                                                                data-has_animals="{{ $deal->has_animals }}"
                                                                data-has_plants="{{ $deal->has_plants }}"
                                                                data-object_style="{{ $deal->object_style }}"
                                                                data-measurements="{{ $deal->measurements }}"
                                                                data-rooms_count="{{ $deal->rooms_count }}"
                                                                data-deal_end_date="{{ $deal->deal_end_date }}"
                                                                data-status="{{ $deal->status }}"

                                                                data-completion_responsible="{{ $deal->completion_responsible }}"
                                                                data-office_equipment="{{ $deal->office_equipment }}"
                                                                data-stage="{{ $deal->stage }}"
                                                                data-coordinator_score="{{ $deal->coordinator_score }}"
                                                                data-measuring_cost="{{ $deal->measuring_cost }}"
                                                                data-project_budget="{{ $deal->project_budget }}"
                                                                data-created_date="{{ $deal->created_date }}"
                                                                data-client_info="{{ $deal->client_info }}"
                                                                data-payment_date="{{ $deal->payment_date }}"
                                                                data-execution_comment="{{ $deal->execution_comment }}"
                                                                data-comment="{{ $deal->comment }}"
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

                    <h4 class="flex">Завершенные сделки
                        <img class="px20" src="/storage/icon/deal_inactive.svg" alt="">
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
                                                            <div class="icon">
                                                               ЧАТ
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ $deal->link ? url($deal->link) : '#' }}">
                                                            <div class="icon">
                                                               БРИФ
                                                            </div>
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
                                                        <!-- Кнопка "Редактировать" -->
                                                        <button type="button" class="edit-deal-btn"
                                                            data-id="{{ $deal->id }}"
                                                            data-name="{{ $deal->name }}"
                                                            data-phone="{{ $deal->client_phone }}"
                                                            data-city="{{ $deal->client_city }}"
                                                            data-email="{{ $deal->client_email }}"
                                                            data-object_type="{{ $deal->object_type }}"
                                                            data-package="{{ $deal->package }}"
                                                            data-has_animals="{{ $deal->has_animals }}"
                                                            data-has_plants="{{ $deal->has_plants }}"
                                                            data-object_style="{{ $deal->object_style }}"
                                                            data-measurements="{{ $deal->measurements }}"
                                                            data-rooms_count="{{ $deal->rooms_count }}"
                                                            data-deal_end_date="{{ $deal->deal_end_date }}"
                                                            data-status="{{ $deal->status }}"

                                                            data-completion_responsible="{{ $deal->completion_responsible }}"
                                                            data-office_equipment="{{ $deal->office_equipment }}"
                                                            data-stage="{{ $deal->stage }}"
                                                            data-coordinator_score="{{ $deal->coordinator_score }}"
                                                            data-measuring_cost="{{ $deal->measuring_cost }}"
                                                            data-project_budget="{{ $deal->project_budget }}"
                                                            data-created_date="{{ $deal->created_date }}"
                                                            data-client_info="{{ $deal->client_info }}"
                                                            data-payment_date="{{ $deal->payment_date }}"
                                                            data-execution_comment="{{ $deal->execution_comment }}"
                                                            data-comment="{{ $deal->comment }}"
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

    <!-- Модальное окно -->
    <div class="modal modal__deal" id="editModal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalBtn">&times;</span>

            <form id="editForm" class="edit-form" method="POST">
                @csrf
                @method('PUT')

                <div class="form-buttons">
                    <button type="button" class="toggle-edit-btn">Изменить</button>
                    <button type="submit" disabled>Сохранить</button>
                </div>

                <!-- Скрытое поле для ID сделки -->
                <input type="hidden" name="deal_id" id="dealIdField">

                <!-- Пример блоков с новыми полями -->
                <label>Кто делает комплектацию:
                    <input type="text" name="completion_responsible" id="completionResponsibleField" disabled>
                </label>

                <label>
                    <input type="checkbox" name="office_equipment" id="officeEquipmentField" value="1" disabled>
                    Комплектация по объекту ОФИС
                </label>

                <label>Стадия:
                    <select name="stage" id="stageField" disabled>
                        <option value="">-- Не выбрано --</option>
                        <option value="Офис">Офис</option>
                        <option value="Партнер">Партнер</option>
                        <option value="Другая">Другая</option>
                    </select>
                </label>

                <label>Оценка КООРДИНАТОР:
                    <input type="text" name="coordinator_score" id="coordinatorScoreField" disabled>
                </label>

                <label>Стоимость замеров:
                    <input type="number" step="0.01" name="measuring_cost" id="measuringCostField" disabled>
                </label>

                <label>Бюджет по проекту:
                    <input type="number" step="0.01" name="project_budget" id="projectBudgetField" disabled>
                </label>

                <label>Дата создания:
                    <input type="date" name="created_date" id="createdDateField" disabled>
                </label>

                <label>Дата оплаты:
                    <input type="date" name="payment_date" id="paymentDateField" disabled>
                </label>

                <label>Информация о клиенте и объекте:
                    <textarea name="client_info" id="clientInfoField" disabled></textarea>
                </label>

                <label>Комментарий для отдела исполнения:
                    <textarea name="execution_comment" id="executionCommentField" disabled></textarea>
                </label>

                <label>Комментарий общий:
                    <textarea name="comment" id="commentField" disabled></textarea>
                </label>

                <!-- Остальные поля (старые) -->
                <label>ФИО клиента:
                    <input type="text" name="name" id="nameField" disabled>
                </label>
                <label>Номер клиента:
                    <input type="text" name="client_phone" id="phoneField" disabled>
                </label>
                <label>Город:
                    <input type="text" name="client_city" id="cityField" disabled>
                </label>
                <label>Email:
                    <input type="email" name="client_email" id="emailField" disabled>
                </label>
                <label>Тип объекта:
                    <input type="text" name="object_type" id="objectTypeField" disabled>
                </label>
                <label>Пакет:
                    <input type="text" name="package" id="packageField" disabled>
                </label>
                <label>Есть животные:
                    <select name="has_animals" id="hasAnimalsField" disabled>
                        <option value="0">Нет</option>
                        <option value="1">Да</option>
                    </select>
                </label>
                <label>Есть растения:
                    <select name="has_plants" id="hasPlantsField" disabled>
                        <option value="0">Нет</option>
                        <option value="1">Да</option>
                    </select>
                </label>
                <label>Стиль объекта:
                    <input type="text" name="object_style" id="objectStyleField" disabled>
                </label>
                <label>Замеры:
                    <input type="text" name="measurements" id="measurementsField" disabled>
                </label>
                <label>Количество комнат:
                    <input type="number" name="rooms_count" id="roomsCountField" disabled>
                </label>
                <label>Дата окончания:
                    <input type="date" name="deal_end_date" id="dealEndDateField" disabled>
                </label>
                <label>Статус:
                    <input type="text" name="status" id="statusField" disabled>
                </label>
            </form>
        </div>
    </div>

    <!-- СКРИПТЫ: копирование, пагинация, DataTables, модалка -->
    <script>
    $(document).ready(function() {

        // 1) Копирование ссылки
        $('.copy-link').on('click', function(e) {
            e.preventDefault();
            const linkToCopy = $(this).data('link') || $(this).attr('href');
            navigator.clipboard.writeText(linkToCopy)
                .then(() => {
                    alert('Ссылка скопирована: ' + linkToCopy);
                })
                .catch(err => {
                    console.error('Ошибка при копировании ссылки: ', err);
                });
        });

        // 2) Пагинация для блочного вида
        function initBlockPagination(containerSelector, paginationSelector, itemsPerPage = 3) {
            const container = $(containerSelector);
            const blocks = container.find('.faq_block__deal');
            const paginationContainer = $(paginationSelector);

            if (blocks.length <= itemsPerPage) {
                blocks.show();
                return;
            }

            const totalItems = blocks.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);

            function showPage(pageIndex) {
                const start = (pageIndex - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                blocks.hide().slice(start, end).show();
            }

            for (let i = 1; i <= totalPages; i++) {
                const $btn = $(`<button type="button">${i}</button>`);
                $btn.on('click', function() {
                    paginationContainer.find('button').removeClass('active');
                    $(this).addClass('active');
                    showPage(i);
                });
                paginationContainer.append($btn);
            }

            // Первая страница сразу
            paginationContainer.find('button').eq(0).addClass('active');
            showPage(1);
        }

        // Вызываем пагинацию (если нужные элементы на странице)
        initBlockPagination('#active-deals-container', '#active-deals-pagination', 6);
        initBlockPagination('#completed-deals-container', '#completed-deals-pagination', 6);

        // 3) Инициализация DataTables (при виде table)
        if ($('#dealTable').length > 0) {
            $('#dealTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/ru.json"
                },
                paging: true,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true
            });
        }

        // 4) Модальное окно для редактирования сделки
        const editModal     = document.getElementById('editModal');
        const closeModalBtn = document.getElementById('closeModalBtn'); 
        const editForm      = document.getElementById('editForm');
        const toggleEditBtn = editForm.querySelector('.toggle-edit-btn');
        const saveBtn       = editForm.querySelector('button[type="submit"]');

        // Скрытое поле ID
        const dealIdField   = document.getElementById('dealIdField');

        // Хелперы, чтобы не упасть с null
        function setValueIfExist(elem, val) {
            if (elem) elem.value = val;
        }
        function setCheckedIfExist(elem, boolVal) {
            if (elem) elem.checked = boolVal;
        }

        function setFormDisabled(disabled) {
            if (!editForm) return;
            const allInputs = editForm.querySelectorAll('input, select, textarea, button[type="submit"]');
            allInputs.forEach(el => {
                if (el.type === 'submit') {
                    el.disabled = disabled;
                } else {
                    el.disabled = disabled;
                }
            });
        }

        function openModal(modal) {
            if (!modal) return;
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }
        function closeModal(modal) {
            if (!modal) return;
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Собираем кнопки «Редактировать»
        const editButtons = document.querySelectorAll('.edit-deal-btn');
        editButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Достаём data-атрибуты
                const dealId       = btn.dataset.id ?? '';
                const dealName     = btn.dataset.name ?? '';
                const dealPhone    = btn.dataset.phone ?? '';
                const dealCity     = btn.dataset.city ?? '';
                const dealEmail    = btn.dataset.email ?? '';
                const dealObjType  = btn.dataset.object_type ?? '';
                const dealPackage  = btn.dataset.package ?? '';
                const dealAnimals  = btn.dataset.has_animals ?? '0';
                const dealPlants   = btn.dataset.has_plants ?? '0';
                const dealObjStyle = btn.dataset.object_style ?? '';
                const dealMeasur   = btn.dataset.measurements ?? '';
                const dealRooms    = btn.dataset.rooms_count ?? '';
                const dealEndDate  = btn.dataset.deal_end_date ?? '';
                const dealStatus   = btn.dataset.status ?? 'в работе';

                const dealCompletionResp= btn.dataset.completion_responsible ?? '';
                const dealOfficeEquip   = (btn.dataset.office_equipment === '1');
                const dealStage         = btn.dataset.stage ?? '';
                const dealCoordScore    = btn.dataset.coordinator_score ?? '';
                const dealMeasuringCost = btn.dataset.measuring_cost ?? '';
                const dealProjectBudget = btn.dataset.project_budget ?? '';
                const dealCreatedDate   = btn.dataset.created_date ?? '';
                const dealPaymentDate   = btn.dataset.payment_date ?? '';
                const dealClientInfo    = btn.dataset.client_info ?? '';
                const dealExecComment   = btn.dataset.execution_comment ?? '';
                const dealComment       = btn.dataset.comment ?? '';

                // Заполняем
                setValueIfExist(dealIdField, dealId);
                setValueIfExist(document.getElementById('nameField'),          dealName);
                setValueIfExist(document.getElementById('phoneField'),         dealPhone);
                setValueIfExist(document.getElementById('cityField'),          dealCity);
                setValueIfExist(document.getElementById('emailField'),         dealEmail);
                setValueIfExist(document.getElementById('objectTypeField'),    dealObjType);
                setValueIfExist(document.getElementById('packageField'),       dealPackage);
                setValueIfExist(document.getElementById('hasAnimalsField'),    dealAnimals);
                setValueIfExist(document.getElementById('hasPlantsField'),     dealPlants);
                setValueIfExist(document.getElementById('objectStyleField'),   dealObjStyle);
                setValueIfExist(document.getElementById('measurementsField'),  dealMeasur);
                setValueIfExist(document.getElementById('roomsCountField'),    dealRooms);
                setValueIfExist(document.getElementById('dealEndDateField'),   dealEndDate);
                setValueIfExist(document.getElementById('statusField'),        dealStatus);

                setValueIfExist(document.getElementById('completionResponsibleField'), dealCompletionResp);
                setCheckedIfExist(document.getElementById('officeEquipmentField'), dealOfficeEquip);
                setValueIfExist(document.getElementById('stageField'),            dealStage);
                setValueIfExist(document.getElementById('coordinatorScoreField'), dealCoordScore);
                setValueIfExist(document.getElementById('measuringCostField'),    dealMeasuringCost);
                setValueIfExist(document.getElementById('projectBudgetField'),   dealProjectBudget);
                setValueIfExist(document.getElementById('createdDateField'),     dealCreatedDate);
                setValueIfExist(document.getElementById('paymentDateField'),     dealPaymentDate);
                setValueIfExist(document.getElementById('clientInfoField'),      dealClientInfo);
                setValueIfExist(document.getElementById('executionCommentField'),dealExecComment);
                setValueIfExist(document.getElementById('commentField'),         dealComment);

                // Action
                if (editForm) {
                    editForm.action = "{{ url('/deal/update') }}/" + dealId;
                }

                // Блокируем поля для чтения
                setFormDisabled(true);

                // Открываем модалку
                openModal(editModal);
            });
        });

        // Закрытие модалки
        closeModalBtn?.addEventListener('click', () => {
            closeModal(editModal);
        });
        window.addEventListener('click', (event) => {
            if (event.target === editModal) {
                closeModal(editModal);
            }
        });

        // «Изменить» / «Отменить»
        toggleEditBtn?.addEventListener('click', () => {
            const nameField = document.getElementById('nameField');
            if (!nameField) return;

            const isDisabled = nameField.disabled;
            setFormDisabled(!isDisabled);

            toggleEditBtn.textContent = isDisabled ? 'Отменить' : 'Изменить';
            saveBtn.disabled = isDisabled ? false : true;
        });
    });
    </script>



   
