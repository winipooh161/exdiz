
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
            <form method="GET" action="<?php echo e(route('deal.cardinator')); ?>">
                <div class="search">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Поиск по имени или телефону">
                  

                    <select name="status">
                        <option value="">Все статусы</option>
                        <option value="в работе" <?php echo e($status === 'в работе' ? 'selected' : ''); ?>>В работе</option>
                        <option value="Завершенный" <?php echo e($status === 'Завершенный' ? 'selected' : ''); ?>>Завершенный</option>
                    </select>
                    <button type="submit">
                        <img src="/storage/icon/search.svg" alt="">
                    </button>
                </div>

                <!-- Переключение вида: таблица / блоки -->
                <div class="variate__view">
                    <button type="submit" name="view_type" value="blocks"
                            class="<?php echo e($viewType === 'blocks' ? 'active-button' : ''); ?>">
                        <img src="/storage/icon/blocks.svg" alt="">
                    </button>
                    <button type="submit" name="view_type" value="table"
                            class="<?php echo e($viewType === 'table' ? 'active-button' : ''); ?>">
                        <img src="/storage/icon/burger.svg" alt="">
                    </button>
                </div>
            </form>
        </div>
          <!-- Кнопка «Создать сделку» -->
          <div class="brifs__button__create flex">
            <button onclick="window.location.href='<?php echo e(route('deals.create')); ?>'">
                <img src="/storage/icon/add.svg" alt="">
            </button>
        </div>

    </div>

    <div class="deal" id="deal">
        <div class="deal__body">
            <div class="deal__cardinator__lists">
                <?php if($viewType === 'table'): ?>
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
                            <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($deal->name); ?></td>
                                    <td>
                                        <a href="tel:<?php echo e($deal->client_phone); ?>">
                                            <?php echo e($deal->client_phone); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($deal->total_sum ?? 'Отсутствует'); ?></td>
                                    <td><?php echo e($deal->status); ?></td>
                                    <td class="link__deistv">
                                        <!-- Ссылки / действия -->
                                        <a href="<?php echo e(route('register_by_deal', ['token' => $deal->registration_token])); ?>">
                                            <img src="/storage/icon/write-link.svg" alt="Ссылка">
                                        </a>
                                        <a href="<?php echo e(url('/chats')); ?>">
                                            <img src="/storage/icon/write-chat.svg" alt="Чат">
                                        </a>
                                        <a href="<?php echo e($deal->link ? url($deal->link) : '#'); ?>">
                                            <img src="/storage/icon/write-brif.svg" alt="Бриф">
                                        </a>

                                        <!-- Кнопка «Редактировать» -->
                                        <button type="button"
                                        class="edit-deal-btn"
                                        data-id="<?php echo e($deal->id); ?>"
                                        data-name="<?php echo e($deal->name); ?>"
                                        data-phone="<?php echo e($deal->client_phone); ?>"
                                        data-city="<?php echo e($deal->client_city); ?>"
                                        data-email="<?php echo e($deal->client_email); ?>"
                                        data-completion_responsible="<?php echo e($deal->completion_responsible); ?>"
                                        data-office_equipment="<?php echo e($deal->office_equipment); ?>"
                                        data-stage="<?php echo e($deal->stage); ?>"
                                        data-coordinator_score="<?php echo e($deal->coordinator_score); ?>"
                                        data-measuring_cost="<?php echo e($deal->measuring_cost); ?>"
                                        data-project_budget="<?php echo e($deal->project_budget); ?>"
                                        data-created_date="<?php echo e($deal->created_date); ?>"
                                        data-payment_date="<?php echo e($deal->payment_date); ?>"
                                        data-client_info="<?php echo e($deal->client_info); ?>"
                                        data-execution_comment="<?php echo e($deal->execution_comment); ?>"
                                        data-comment="<?php echo e($deal->comment); ?>"
                                        data-status="<?php echo e($deal->status); ?>"
                                        data-rooms_count="<?php echo e($deal->rooms_count); ?>"
                                        data-deal_end_date="<?php echo e($deal->deal_end_date); ?>"
                                >
                                <img src="/storage/icon/create.svg" alt="Редактировать">
                                            
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <!-- =====================
                         ВИД: БЛОКИ
                         ===================== -->
                    <?php
                        $activeDeals = $deals->filter(fn($deal) => in_array($deal->status, ['в работе','registered','Brif','На потом']));
                        $completedDeals = $deals->filter(fn($deal) => $deal->status === 'Завершенный');
                    ?>

                    <h4 class="flex">Активные сделки
                        <img class="px20" src="/storage/icon/deal_active.svg" alt="">
                    </h4>
                    <div class="faq__body__deal" id="active-deals-container">
                        <?php if($activeDeals->isEmpty()): ?>
                            <div class="faq_block__deal faq_block-blur" style="display: block;">
                                <p>Активных сделок пока нет.</p>
                            </div>
                        <?php else: ?>
                            <?php $__currentLoopData = $activeDeals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="faq_block__deal">
                                    <div class="faq_item__deal">
                                        <div class="faq_question__deal flex between">
                                            <div class="faq_question__deal__info">
                                                <div class="deal__avatar deal__avatar__cardinator">
                                                    <img src="<?php echo e(asset($deal->avatar_path)); ?>" alt="Avatar">
                                                </div>
                                                <div class="deal__cardinator__info">
                                                    <h4><?php echo e($deal->name); ?></h4>
                                                    <p>
                                                        Телефон:
                                                        <a href="tel:<?php echo e($deal->client_phone); ?>">
                                                            <?php echo e($deal->client_phone); ?>

                                                        </a>
                                                    </p>
                                                <p>Статус: <?php echo e($deal->status); ?></p>
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo e(url('/chats')); ?>">
                                                                <div class="icon">
                                                                  Чат
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e($deal->link ? url($deal->link) : '#'); ?>">
                                                                <div class="icon">
                                                                   Бриф
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e(route('register_by_deal', ['token' => $deal->registration_token])); ?>"
                                                               class="copy-link"
                                                               data-link="<?php echo e(route('register_by_deal', ['token' => $deal->registration_token])); ?>">
                                                                Ссылка
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <!-- Кнопка "Редактировать" -->
                                                            <button type="button" class="edit-deal-btn"
                                                                data-id="<?php echo e($deal->id); ?>"
                                                                data-name="<?php echo e($deal->name); ?>"
                                                                data-phone="<?php echo e($deal->client_phone); ?>"
                                                                data-city="<?php echo e($deal->client_city); ?>"
                                                                data-email="<?php echo e($deal->client_email); ?>"
                                                                data-object_type="<?php echo e($deal->object_type); ?>"
                                                                data-package="<?php echo e($deal->package); ?>"
                                                                data-has_animals="<?php echo e($deal->has_animals); ?>"
                                                                data-has_plants="<?php echo e($deal->has_plants); ?>"
                                                                data-object_style="<?php echo e($deal->object_style); ?>"
                                                                data-measurements="<?php echo e($deal->measurements); ?>"
                                                                data-rooms_count="<?php echo e($deal->rooms_count); ?>"
                                                                data-deal_end_date="<?php echo e($deal->deal_end_date); ?>"
                                                                data-status="<?php echo e($deal->status); ?>"

                                                                data-completion_responsible="<?php echo e($deal->completion_responsible); ?>"
                                                                data-office_equipment="<?php echo e($deal->office_equipment); ?>"
                                                                data-stage="<?php echo e($deal->stage); ?>"
                                                                data-coordinator_score="<?php echo e($deal->coordinator_score); ?>"
                                                                data-measuring_cost="<?php echo e($deal->measuring_cost); ?>"
                                                                data-project_budget="<?php echo e($deal->project_budget); ?>"
                                                                data-created_date="<?php echo e($deal->created_date); ?>"
                                                                data-client_info="<?php echo e($deal->client_info); ?>"
                                                                data-payment_date="<?php echo e($deal->payment_date); ?>"
                                                                data-execution_comment="<?php echo e($deal->execution_comment); ?>"
                                                                data-comment="<?php echo e($deal->comment); ?>"
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <div class="pagination" id="active-deals-pagination"></div>
                    </div>

                    <h4 class="flex">Завершенные сделки
                        <img class="px20" src="/storage/icon/deal_inactive.svg" alt="">
                    </h4>
                    <div class="faq__body__deal" id="completed-deals-container">
                        <?php if($completedDeals->isEmpty()): ?>
                            <div class="faq_block__deal faq_block-blur" style="display: block;">
                                <p>Завершенных сделок пока нет.</p>
                            </div>
                        <?php else: ?>
                            <?php $__currentLoopData = $completedDeals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="faq_block__deal">
                                    <div class="faq_item__deal">
                                        <div class="faq_question__deal flex between">
                                            <div class="faq_question__deal__info">
                                                <h4><?php echo e($deal->name); ?></h4>
                                                
                                                <ul>
                                                    <li>
                                                        <a href="<?php echo e(url('/chats')); ?>">
                                                            <div class="icon">
                                                               ЧАТ
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e($deal->link ? url($deal->link) : '#'); ?>">
                                                            <div class="icon">
                                                               БРИФ
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(route('register_by_deal', ['token' => $deal->registration_token])); ?>"
                                                           class="copy-link"
                                                           data-link="<?php echo e(route('register_by_deal', ['token' => $deal->registration_token])); ?>">
                                                           ССЫЛКА
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <!-- Кнопка "Редактировать" -->
                                                        <button type="button" class="edit-deal-btn"
                                                            data-id="<?php echo e($deal->id); ?>"
                                                            data-name="<?php echo e($deal->name); ?>"
                                                            data-phone="<?php echo e($deal->client_phone); ?>"
                                                            data-city="<?php echo e($deal->client_city); ?>"
                                                            data-email="<?php echo e($deal->client_email); ?>"
                                                            data-object_type="<?php echo e($deal->object_type); ?>"
                                                            data-package="<?php echo e($deal->package); ?>"
                                                            data-has_animals="<?php echo e($deal->has_animals); ?>"
                                                            data-has_plants="<?php echo e($deal->has_plants); ?>"
                                                            data-object_style="<?php echo e($deal->object_style); ?>"
                                                            data-measurements="<?php echo e($deal->measurements); ?>"
                                                            data-rooms_count="<?php echo e($deal->rooms_count); ?>"
                                                            data-deal_end_date="<?php echo e($deal->deal_end_date); ?>"
                                                            data-status="<?php echo e($deal->status); ?>"

                                                            data-completion_responsible="<?php echo e($deal->completion_responsible); ?>"
                                                            data-office_equipment="<?php echo e($deal->office_equipment); ?>"
                                                            data-stage="<?php echo e($deal->stage); ?>"
                                                            data-coordinator_score="<?php echo e($deal->coordinator_score); ?>"
                                                            data-measuring_cost="<?php echo e($deal->measuring_cost); ?>"
                                                            data-project_budget="<?php echo e($deal->project_budget); ?>"
                                                            data-created_date="<?php echo e($deal->created_date); ?>"
                                                            data-client_info="<?php echo e($deal->client_info); ?>"
                                                            data-payment_date="<?php echo e($deal->payment_date); ?>"
                                                            data-execution_comment="<?php echo e($deal->execution_comment); ?>"
                                                            data-comment="<?php echo e($deal->comment); ?>"
                                                        >
                                                           ИЗМЕНИТЬ
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <div class="pagination" id="completed-deals-pagination"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal modal__deal" id="editModal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalBtn">&times;</span>
    
            <form id="editForm" class="edit-form" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
    
                <!-- Скрытое поле для ID сделки -->
                <input type="hidden" name="deal_id" id="dealIdField">
    
                <div class="form-buttons" style="margin-bottom: 1rem;">
                    <!-- Кнопка «Изменить/Отменить» будет переключать disabled / enabled -->
                    <button type="button" class="toggle-edit-btn">Изменить</button>
                    <!-- Кнопка «Сохранить» делаем disabled, пока пользователь не нажмёт «Изменить» -->
                    <button type="submit" disabled>Сохранить</button>
                </div>
    
               
                    <label>ФИО клиента:
                        <input type="text" name="name" id="nameField" disabled>
                    </label>
    
                    <label>Номер телефона:
                        <input type="text" name="client_phone" id="phoneField" disabled>
                    </label>
    
                    <label>Город:
                        <input type="text" name="client_city" id="cityField" disabled>
                    </label>
    
                    <label>Email:
                        <input type="email" name="client_email" id="emailField" disabled>
                    </label>
    
                    <!-- Пример новых полей (комплектация, офис и т.п.) -->
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
    
                    <label>Оценка координатора:
                        <input type="number" name="coordinator_score" step="0.1" id="coordinatorScoreField" disabled>
                    </label>
    
                    <label>Стоимость замеров:
                        <input type="number" name="measuring_cost" step="0.01" id="measuringCostField" disabled>
                    </label>
    
                    <label>Бюджет по проекту:
                        <input type="number" name="project_budget" step="0.01" id="projectBudgetField" disabled>
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
    
                    <!-- Пример дополнительных полей -->
                    <label>Количество комнат:
                        <input type="number" name="rooms_count" id="roomsCountField" disabled>
                    </label>
    
                    <label>Дата окончания сделки:
                        <input type="date" name="deal_end_date" id="dealEndDateField" disabled>
                    </label>
    
                    <label>Статус:
                        <select name="status" id="statusField" disabled>
                            <option value="в работе">в работе</option>
                            <option value="Завершенный">Завершенный</option>
                            <option value="На потом">На потом</option>
                        </select>
                    </label>
           
            </form>
        </div>
    </div>

    <!-- СКРИПТЫ: копирование, пагинация, DataTables, модалка -->
     <!-- Подключаем jQuery (нужно для DataTables и некоторых скриптов) -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Подключаем DataTables CSS / JS -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
     <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
 
     <script>
     // Ждём, когда DOM полностью загрузится
     document.addEventListener('DOMContentLoaded', function() {
 
         // ========== 1) Копирование ссылки ==========
         document.querySelectorAll('.copy-link').forEach(link => {
             link.addEventListener('click', function(e) {
                 e.preventDefault();
                 const linkToCopy = this.dataset.link || this.getAttribute('href');
                 if (!linkToCopy) return;
                 navigator.clipboard.writeText(linkToCopy)
                     .then(() => {
                         alert('Ссылка скопирована: ' + linkToCopy);
                     })
                     .catch(err => {
                         console.error('Ошибка при копировании ссылки: ', err);
                     });
             });
         });
 
         // ========== 2) Пагинация для блочного вида ==========
         // Пишем функцию, которая разбивает блоки .faq_block__deal постранично
         function initBlockPagination(containerSelector, paginationSelector, itemsPerPage = 3) {
             const container = document.querySelector(containerSelector);
             if (!container) return;
 
             const blocks = container.querySelectorAll('.faq_block__deal');
             const paginationContainer = document.querySelector(paginationSelector);
             if (!paginationContainer) return;
 
             // Если блоков мало — просто показываем все
             if (blocks.length <= itemsPerPage) {
                 blocks.forEach(el => el.style.display = 'block');
                 return;
             }
 
             const totalItems = blocks.length;
             const totalPages = Math.ceil(totalItems / itemsPerPage);
 
             function showPage(pageIndex) {
                 // Скрываем все
                 blocks.forEach(el => { el.style.display = 'none'; });
                 // Показываем нужные
                 const start = (pageIndex - 1) * itemsPerPage;
                 const end = start + itemsPerPage;
                 for (let i = start; i < end && i < totalItems; i++) {
                     blocks[i].style.display = 'block';
                 }
             }
 
             // Создаём кнопки
             for (let i = 1; i <= totalPages; i++) {
                 const btn = document.createElement('button');
                 btn.type = 'button';
                 btn.textContent = i;
                 btn.addEventListener('click', () => {
                     // Сброс класса у всех
                     paginationContainer.querySelectorAll('button').forEach(b => b.classList.remove('active'));
                     // Подсветить текущую
                     btn.classList.add('active');
                     // Показать страницу
                     showPage(i);
                 });
                 paginationContainer.appendChild(btn);
             }
 
             // Начальная страница
             paginationContainer.querySelector('button')?.classList.add('active');
             showPage(1);
         }
 
         // Инициализируем пагинацию для «Активных» и «Завершённых»
         initBlockPagination('#active-deals-container', '#active-deals-pagination', 6);
         initBlockPagination('#completed-deals-container', '#completed-deals-pagination', 6);
 
         // ========== 3) DataTables (для табличного вида) ==========
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
 
         // ========== 4) Модальное окно для редактирования ==========
         const editModal     = document.getElementById('editModal');
         const closeModalBtn = document.getElementById('closeModalBtn');
         const editForm      = document.getElementById('editForm');
         const toggleEditBtn = editForm?.querySelector('.toggle-edit-btn');
         const saveBtn       = editForm?.querySelector('button[type="submit"]');
         const dealIdField   = document.getElementById('dealIdField');
 
         // Хелперы
         function setValueIfExist(elem, val) {
             if (elem) elem.value = val ?? '';
         }
         function setCheckedIfExist(elem, boolVal) {
             if (elem) elem.checked = Boolean(boolVal);
         }
         // Включение/отключение полей
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
         // Анимация показа
         function openModal(modal) {
             if (!modal) return;
             modal.style.display = 'flex';
             setTimeout(() => {
                 modal.classList.add('show');
             }, 10);
         }
         // Анимация скрытия
         function closeModal(modal) {
             if (!modal) return;
             modal.classList.remove('show');
             setTimeout(() => {
                 modal.style.display = 'none';
             }, 300);
         }
 
         // Все кнопки «Редактировать»
         document.querySelectorAll('.edit-deal-btn').forEach(btn => {
             btn.addEventListener('click', () => {
                 const dealId = btn.dataset.id || '';
                 // Основные поля
                 setValueIfExist(dealIdField, dealId);
                 setValueIfExist(document.getElementById('nameField'), btn.dataset.name);
                 setValueIfExist(document.getElementById('phoneField'), btn.dataset.phone);
                 setValueIfExist(document.getElementById('cityField'), btn.dataset.city);
                 setValueIfExist(document.getElementById('emailField'), btn.dataset.email);
 
                 // Новые/доп. поля
                 setValueIfExist(document.getElementById('completionResponsibleField'), btn.dataset.completion_responsible);
                 setCheckedIfExist(document.getElementById('officeEquipmentField'), btn.dataset.office_equipment === '1');
                 setValueIfExist(document.getElementById('stageField'), btn.dataset.stage);
                 setValueIfExist(document.getElementById('coordinatorScoreField'), btn.dataset.coordinator_score);
                 setValueIfExist(document.getElementById('measuringCostField'), btn.dataset.measuring_cost);
                 setValueIfExist(document.getElementById('projectBudgetField'), btn.dataset.project_budget);
                 setValueIfExist(document.getElementById('createdDateField'), btn.dataset.created_date);
                 setValueIfExist(document.getElementById('dealEndDateField'), btn.dataset.deal_end_date);
                 setValueIfExist(document.getElementById('clientInfoField'), btn.dataset.client_info);
                 setValueIfExist(document.getElementById('paymentDateField'), btn.dataset.payment_date);
                 setValueIfExist(document.getElementById('executionCommentField'), btn.dataset.execution_comment);
                 setValueIfExist(document.getElementById('commentField'), btn.dataset.comment);
                 setValueIfExist(document.getElementById('roomsCountField'), btn.dataset.rooms_count);
 
                 // Статус (select)
                 const statusField = document.getElementById('statusField');
                 if (statusField) statusField.value = btn.dataset.status || 'в работе';
 
                 // Action формы (PUT /deal/update/{id})
                 if (editForm) {
                     editForm.action = "<?php echo e(url('/deal/update')); ?>/" + dealId;
                 }
 
                 // Отключаем поля (режим «только чтение»)
                 setFormDisabled(true);
 
                 // Открываем модалку
                 openModal(editModal);
             });
         });
 
         // Закрыть модалку по крестику
         closeModalBtn?.addEventListener('click', () => {
             closeModal(editModal);
         });
         // Закрыть по клику вне контента
         window.addEventListener('click', (event) => {
             if (event.target === editModal) {
                 closeModal(editModal);
             }
         });
 
         // Кнопка «Изменить / Отменить»
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


   
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\deals\cardinators.blade.php ENDPATH**/ ?>