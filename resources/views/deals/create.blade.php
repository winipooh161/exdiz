
<h1>{{ $title_site }}</h1>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="create-deal-form" action="{{ route('deals.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


    <!-- БЛОК 1: ЗАКАЗ -->
    <fieldset class="module">
        <legend>ЗАКАЗ</legend>
        <div class="form-group-deal">
            <label for="project_number">№ проекта (пример: Проект 6303): <span class="required">*</span></label>
            <input type="text" id="project_number" name="project_number" class="form-control maskproject">
        </div>
        <div class="form-group-deal">
            <label for="status">Статус: <span class="required">*</span></label>
            <select id="status" name="status" class="form-control" required>
                <option value="">-- Выберите статус --</option>
                <option value="Ждем ТЗ">Ждем ТЗ</option>
                <option value="Планировка">Планировка</option>
                <option value="Коллажи">Коллажи</option>
                <option value="Визуализация">Визуализация</option>
                <option value="Рабочка/сбор ИП">Рабочка/сбор ИП</option>
                <option value="Проект готов">Проект готов</option>
                <option value="Проект завершен">Проект завершен</option>
                <option value="Проект на паузе">Проект на паузе</option>
                <option value="Возврат">Возврат</option>
                <option value="В работе">В работе</option>
                <option value="Завершенный">Завершенный</option>
                <option value="На потом">На потом</option>
                <option value="Регистрация">Регистрация</option>
                <option value="Бриф прикриплен">Бриф прикриплен</option>
                <option value="Поддержка">Поддержка</option>
                <option value="Активный">Активный</option>
            </select>
        </div>
        <div class="form-group-deal">
            <label for="price_service_option">Услуга по прайсу: <span class="required">*</span></label>
            <select id="price_service_option" name="price_service_option" class="form-control" required>
                <option value="">-- Выберите услугу --</option>
                <option value="экспресс планировка">Экспресс планировка</option>
                <option value="экспресс планировка с коллажами">Экспресс планировка с коллажами</option>
                <option value="экспресс проект с электрикой">Экспресс проект с электрикой</option>
                <option value="экспресс планировка с электрикой и коллажами">Экспресс планировка с электрикой и коллажами</option>
                <option value="экспресс проект с электрикой и визуализацией">Экспресс проект с электрикой и визуализацией</option>
                <option value="экспресс рабочий проект">Экспресс рабочий проект</option>
                <option value="экспресс эскизный проект с рабочей документацией">Экспресс эскизный проект с рабочей документацией</option>
                <option value="экспресс 3Dвизуализация">Экспресс 3Dвизуализация</option>
                <option value="экспресс полный дизайн-проект">Экспресс полный дизайн-проект</option>
                <option value="360 градусов">360 градусов</option>
            </select>
        </div>  
        <div class="form-group-deal">
            <label for="rooms_count_pricing">Количество комнат по прайсу:</label>
            <input type="number" id="rooms_count_pricing" name="rooms_count_pricing" class="form-control">
        </div>
        <div class="form-group-deal">
            <label for="execution_order_comment">Комментарий к заказу для отдела исполнения:</label>
            <textarea id="execution_order_comment" name="execution_order_comment" class="form-control" rows="3" maxlength="1000"></textarea>
        </div>
        <div class="form-group-deal">
            <label for="execution_order_file">Прикрепить файл (PDF, JPG, PNG):</label>
            <input type="file" id="execution_order_file" name="execution_order_file" accept=".pdf,image/*">
        </div>
        <div class="form-group-deal">
            <label for="package">Пакет (1, 2 или 3): <span class="required">*</span></label>
            <input type="text" id="package" name="package" class="form-control" required>
        </div>
        <div class="form-group-deal">
            <label for="name">ФИО клиента: <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group-deal">
            <label for="client_phone">Телефон: <span class="required">*</span></label>
            <input type="text" id="client_phone" name="client_phone" class="form-control maskphone" required
                   pattern="^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$" placeholder="Введите телефон">
        </div>
        <div class="form-group-deal">
            <label for="client_timezone">Город/часовой пояс:</label>
            <select id="client_timezone" name="client_timezone" class="form-control" required>
                 <option value="">-- Выберите город --</option>
            </select>
        </div>
        
        <div class="form-group-deal">
            <label for="office_partner_id">Офис/Партнер:</label>
            <select id="office_partner_id" name="office_partner_id" class="form-control">
                <option value="">-- Не выбрано --</option>
                @foreach($partners as $partner)
                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group-deal">
            <label for="completion_responsible">Кто делает комплектацию:</label>
            <input type="text" id="completion_responsible" name="completion_responsible" class="form-control">
        </div>
        <div class="form-group-deal">
            <label for="coordinator_id">Отв. координатор:</label>
            <select id="coordinator_id" name="coordinator_id" class="form-control">
                <option value="">-- Не выбрано (по умолчанию текущий пользователь) --</option>
                @foreach($coordinators as $coord)
                    <option value="{{ $coord->id }}">{{ $coord->name }}</option>
                @endforeach
            </select>
        </div>
    </fieldset>

    <!-- БЛОК 2: ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ -->
    <fieldset class="module">
        <legend>ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ</legend>
        <div class="form-group-deal">
            <label for="priority">Приоритет: <span class="required">*</span></label>
            <select id="priority" name="priority" class="form-control" required>
                <option value="">-- Выберите приоритет --</option>
                <option value="высокий">Высокий</option>
                <option value="средний">Средний</option>
                <option value="низкий">Низкий</option>
            </select>
        </div>
        <div class="form-group-deal">
            <label for="total_sum">Общая сумма:</label>
            <input type="number" step="0.01" id="total_sum" name="total_sum" class="form-control">
        </div>
        <div class="form-group-deal">
            <label for="measuring_cost">Стоимость замеров:</label>
            <input type="number" step="0.01" id="measuring_cost" name="measuring_cost" class="form-control">
        </div>
        <div class="form-group-deal">
            <label for="project_budget">Бюджет проекта:</label>
            <input type="number" step="0.01" id="project_budget" name="project_budget" class="form-control">
        </div>
        <div class="form-group-deal">
            <label for="client_info">Информация о клиенте:</label>
            <textarea id="client_info" name="client_info" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group-deal">
            <label for="payment_date">Дата оплаты:</label>
            <input type="date" id="payment_date" name="payment_date" class="form-control">
        </div>
        <div class="form-group-deal">
            <label for="execution_comment">Комментарий (исполнение):</label>
            <textarea id="execution_comment" name="execution_comment" class="form-control" rows="3" maxlength="1000"></textarea>
        </div>
        <div class="form-group-deal">
            <label for="comment">Общий комментарий:</label>
            <textarea id="comment" name="comment" class="form-control" rows="3" maxlength="1000"></textarea>
        </div>
        <div class="form-group-deal">
            <label for="office_equipment">Оборудование офиса:</label>
            <input type="checkbox" id="office_equipment" name="office_equipment" value="1">
        </div>
    </fieldset>

    <!-- БЛОК 3: РАБОТА НАД ПРОЕКТОМ -->
    <fieldset class="module">
        <legend>РАБОТА НАД ПРОЕКТОМ</legend>
        <div class="form-group-deal">
            <label for="measurement_comments">Комментарии по замерам:</label>
            <textarea id="measurement_comments" name="measurement_comments" class="form-control" rows="3" maxlength="1000"></textarea>
        </div>
        <div class="form-group-deal">
            <label for="measurements_file">Замеры (файл):</label>
            <input type="file" id="measurements_file" name="measurements_file" accept=".pdf,image/*,dwg">
        </div>
<!-- Поля для даты начала и даты завершения -->
<div class="form-group-deal">
    <label for="start_date">Дата начала проекта:</label>
    <input type="date" id="start_date" name="start_date" class="form-control">
  </div>
  <div class="form-group-deal">
    <label for="project_duration">Общий срок проекта (в днях):</label>
    <input type="text" id="project_duration" name="project_duration" class="form-control">
  </div>
  <div class="form-group-deal">
    <label for="project_end_date">Дата завершения проекта:</label>
    <input type="date" id="project_end_date" name="project_end_date" class="form-control">
  </div>
  
        <div class="form-group-deal">
            <label for="architect_id">Архитектор:</label>
            <select id="architect_id" name="architect_id" class="form-control">
                <option value="">-- Не выбрано --</option>
                @foreach($architects as $architect)
                    <option value="{{ $architect->id }}">{{ $architect->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group-deal">
            <label for="final_floorplan">Планировка финал (PDF):</label>
            <input type="file" id="final_floorplan" name="final_floorplan" accept="application/pdf">
        </div>
        <div class="form-group-deal">
            <label for="designer_id">Дизайнер:</label>
            <select id="designer_id" name="designer_id" class="form-control">
                <option value="">-- Не выбрано --</option>
                @foreach($designers as $designer)
                    <option value="{{ $designer->id }}">{{ $designer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group-deal">
            <label for="final_collage">Коллаж финал (PDF):</label>
            <input type="file" id="final_collage" name="final_collage" accept="application/pdf">
        </div>
        <div class="form-group-deal">
            <label for="visualizer_id">Визуализатор:</label>
            <select id="visualizer_id" name="visualizer_id" class="form-control">
                <option value="">-- Не выбрано --</option>
                @foreach($visualizers as $visualizer)
                    <option value="{{ $visualizer->id }}">{{ $visualizer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group-deal">
            <label for="visualization_link">Ссылка на визуализацию:</label>
            <input type="url" id="visualization_link" name="visualization_link" class="form-control">
        </div>
        <div class="form-group-deal">
            <label for="final_project_file">Финал проекта (PDF):</label>
            <input type="file" id="final_project_file" name="final_project_file" accept="application/pdf">
        </div>
    </fieldset>

    <!-- БЛОК 4: ФИНАЛ ПРОЕКТА -->
    <fieldset class="module">
        <legend>ФИНАЛ ПРОЕКТА</legend>
        <div class="form-group-deal">
            <label for="work_act">Акт выполненных работ (PDF):</label>
            <input type="file" id="work_act" name="work_act" accept="application/pdf">
        </div>
        <div class="form-group-deal">
            <label for="client_project_rating">Оценка за проект (от клиента):</label>
            <input type="number" id="client_project_rating" name="client_project_rating" class="form-control" min="0" max="10" step="0.5">
        </div>
        <div class="form-group-deal">
            <label>Оценка архитектора:</label>
            <input type="number" name="architect_rating_client" placeholder="Клиент" class="form-control" min="0" max="10" step="0.5">
            <input type="number" name="architect_rating_partner" placeholder="Партнер" class="form-control" min="0" max="10" step="0.5">
            <input type="number" name="architect_rating_coordinator" placeholder="Координатор" class="form-control" min="0" max="10" step="0.5">
        </div>
        <div class="form-group-deal">
            <label>Оценка дизайнера:</label>
            <input type="number" name="designer_rating_client" placeholder="Клиент" class="form-control" min="0" max="10" step="0.5">
            <input type="number" name="designer_rating_partner" placeholder="Партнер" class="form-control" min="0" max="10" step="0.5">
            <input type="number" name="designer_rating_coordinator" placeholder="Координатор" class="form-control" min="0" max="10" step="0.5">
        </div>
        <div class="form-group-deal">
            <label>Оценка визуализатора:</label>
            <input type="number" name="visualizer_rating_client" placeholder="Клиент" class="form-control" min="0" max="10" step="0.5">
            <input type="number" name="visualizer_rating_partner" placeholder="Партнер" class="form-control" min="0" max="10" step="0.5">
            <input type="number" name="visualizer_rating_coordinator" placeholder="Координатор" class="form-control" min="0" max="10" step="0.5">
        </div>
        <div class="form-group-deal">
            <label>Оценка координатора:</label>
            <input type="number" name="coordinator_rating_client" placeholder="Клиент" class="form-control" min="0" max="10" step="0.5">
            <input type="number" name="coordinator_rating_partner" placeholder="Партнер" class="form-control" min="0" max="10" step="0.5">
        </div>
        <div class="form-group-deal">
            <label for="chat_screenshot">Скрин чата с оценкой и актом (JPEG):</label>
            <input type="file" id="chat_screenshot" name="chat_screenshot" accept="image/jpeg,image/jpg,image/png">
        </div>
        <div class="form-group-deal">
            <label for="coordinator_comment">Комментарий координатора:</label>
            <textarea id="coordinator_comment" name="coordinator_comment" class="form-control" rows="3" maxlength="1000"></textarea>
        </div>
        <div class="form-group-deal">
            <label for="archicad_file">Исходный файл архикад (pln, dwg):</label>
            <input type="file" id="archicad_file" name="archicad_file" accept=".pln,.dwg">
        </div>
    </fieldset>

    <fieldset class="module">
        <legend>О СДЕЛКЕ</legend>
        <div class="form-group-deal">
            <label for="contract_number">№ договора: <span class="required">*</span></label>
            <input type="text" id="contract_number" name="contract_number" class="form-control maskcontract" required>
        </div>
        <div class="form-group-deal">
            <label for="contract_attachment">Приложение (PDF или JPEG):</label>
            <input type="file" id="contract_attachment" name="contract_attachment" accept="application/pdf,image/jpeg,image/jpg,image/png">
        </div>
        <div class="form-group-deal">
            <label for="deal_note">Примечание:</label>
            <textarea id="deal_note" name="deal_note" class="form-control" rows="3"></textarea>
        </div>
    </fieldset>

    <fieldset class="module">
        <legend>АВАТАР СДЕЛКИ</legend>
        <div class="form-group-deal">
            <label for="avatar">Загрузите фото аватара сделки (обязательно, не более 5 МБ): <span class="required">*</span></label>
            <input type="file" id="avatar" name="avatar" accept="image/*" required>
        </div>
        <div id="avatar-preview" class="avatar-preview"></div>
    </fieldset>
    
    <button type="submit" class="btn btn-primary">Создать сделку</button>
</form>
<!-- Подключение необходимых библиотек (jQuery и Select2) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Укажите корректный путь к вашему JSON-файлу
    var jsonFilePath = '/cities.json';

    // Загружаем JSON-файл
    $.getJSON(jsonFilePath, function(data) {
        // Группируем города по региону
        var groupedOptions = {};
        data.forEach(function(item) {
            var region = item.region;
            var city = item.city;
            if (!groupedOptions[region]) {
                groupedOptions[region] = [];
            }
            // Форматируем данные для Select2
            groupedOptions[region].push({
                id: city,
                text: city
            });
        });

        // Преобразуем сгруппированные данные в массив для Select2
        var select2Data = [];
        for (var region in groupedOptions) {
            select2Data.push({
                text: region,
                children: groupedOptions[region]
            });
        }

        // Инициализируем Select2 с полученными данными
        $('#client_timezone').select2({
            data: select2Data,
            placeholder: "-- Выберите город --",
            allowClear: true
        });
    })
    .fail(function(jqxhr, textStatus, error) {
        console.error("Ошибка загрузки JSON файла: " + textStatus + ", " + error);
    });
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

// Маска для поля "Пакет": разрешаем только одну цифру
$("#package").on("input", function() {
    var val = this.value.replace(/\D/g, "");
    if(val.length > 1) { val = val.substring(0, 1); }
    this.value = val;
});


</script>

<script>
    // Прикрепляем слушатель события для поля "Общий срок проекта"
    var durationField = document.getElementById("project_duration");
    if(durationField) {
        durationField.addEventListener("input", function() {
            // Разрешаем только цифры
            this.value = this.value.replace(/\D/g, "");
            // Если значение пустое – очищаем поле даты завершения
            if(this.value === "") {
                document.getElementById("project_end_date").value = "";
            } else {
                var durationDays = parseInt(this.value);
                var startDateField = document.getElementById("start_date");
                if(!isNaN(durationDays) && startDateField && startDateField.value) {
                    // Создаём дату начала из значения поля (оно должно быть в формате YYYY-MM-DD)
                    var startDate = new Date(startDateField.value);
                    // Рассчитываем дату завершения: добавляем количество дней к дате начала
                    var endDate = new Date(startDate.getTime() + durationDays * 86400000);
                    // Форматируем дату в формат YYYY-MM-DD
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
    
    // Устанавливаем сегодняшнюю дату в поле "Дата начала проекта" и делаем его readonly,
    // чтобы пользователь не мог его изменить (значение всегда в формате YYYY-MM-DD)
    var startDateField = document.getElementById("start_date");
    if(startDateField) {
        var today = new Date().toISOString().substr(0, 10);
        startDateField.value = today;
        startDateField.setAttribute("readonly", true);
    }
    </script>
    