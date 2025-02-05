
<h1>{{ $title_site }}</h1>

<form action="{{ route('deals.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ФИО клиента --}}
    <label for="name">ФИО клиента:
        <input type="text" id="name" name="name" class="form-control" 
               required minlength="2" maxlength="255"
               pattern="^[\pL\s\-]+$"  {{-- Пример: только буквы/пробелы/дефисы --}}
               title="Только буквы, пробелы и дефисы.">
    </label>

    {{-- Контакт: Номер --}}
    <label for="client_phone">Контакт (Номер телефона):
        <input type="text" id="client_phone" name="client_phone" class="maskphone form-control" 
               required pattern="^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$"
               title="Формат: +7 (XXX) XXX-XX-XX">
    </label>

    {{-- Кто делает комплектацию --}}
    <label for="completion_responsible">Кто делает комплектацию:
        <input type="text" id="completion_responsible" name="completion_responsible" class="form-control"
               maxlength="255">
    </label>

    {{-- Комплектация по объекту ОФИС (чекбокс) --}}
    <label>
        <input type="checkbox" id="office_equipment" name="office_equipment" value="1">
        Комплектация по объекту ОФИС
    </label>

    {{-- Стадия (Офис / Партнер / Другая) --}}
    <label for="stage">Стадия:
        <select id="stage" name="stage" class="form-control">
            <option value="">-- Не выбрано --</option>
            <option value="Офис">Офис</option>
            <option value="Партнер">Партнер</option>
            <option value="Другая">Другая</option>
        </select>
    </label>

    {{-- Оценка КООРДИНАТОР (числовая оценка, например 0..10) --}}
    <label for="coordinator_score">Оценка координатора (0..10):
        <input type="number" id="coordinator_score" name="coordinator_score" class="form-control"
               min="0" max="10" step="0.5">
    </label>

    {{-- Город клиента --}}
    <label for="client_city">Город:
        <input type="text" id="client_city" name="client_city" class="form-control"
               maxlength="100">
    </label>

    {{-- Сумма заказа (число) --}}
    <label for="total_sum">Сумма заказа (руб.):
        <input type="number" step="0.01" id="total_sum" name="total_sum" class="form-control" min="0">
    </label>

    {{-- Стоимость замеров (число) --}}
    <label for="measuring_cost">Стоимость замеров:
        <input type="number" step="0.01" id="measuring_cost" name="measuring_cost" class="form-control" min="0">
    </label>

    {{-- Бюджет по проекту --}}
    <label for="project_budget">Бюджет по проекту:
        <input type="number" step="0.01" id="project_budget" name="project_budget" class="form-control" min="0">
    </label>

    {{-- Дата создания --}}
    <label for="created_date">Дата создания:
        <input type="date" id="created_date" name="created_date" class="form-control">
    </label>

    {{-- Дата окончания --}}
    <label for="deal_end_date">Дата окончания:
        <input type="date" id="deal_end_date" name="deal_end_date" class="form-control">
    </label>

    {{-- Информация о клиенте и объекте (textarea) --}}
    <label for="client_info">Информация о клиенте и объекте:
        <textarea id="client_info" name="client_info" class="form-control" rows="3"></textarea>
    </label>

    {{-- Дата оплаты --}}
    <label for="payment_date">Дата оплаты:
        <input type="date" id="payment_date" name="payment_date" class="form-control">
    </label>

    {{-- Выбор пакета --}}
    <label for="package">Выбор пакета:
        <input type="text" id="package" name="package" class="form-control" maxlength="255">
    </label>

    {{-- Количество комнат по прайсу (целое число) --}}
    <label for="rooms_count">Количество комнат (по прайсу):
        <input type="number" id="rooms_count" name="rooms_count" class="form-control" min="1">
    </label>

    {{-- Комментарий (отдел исполнения) --}}
    <label for="execution_comment">Комментарий (для отдела исполнения):
        <textarea id="execution_comment" name="execution_comment" class="form-control" rows="2"></textarea>
    </label>

    {{-- Общий комментарий --}}
    <label for="comment">Комментарий (общий):
        <textarea id="comment" name="comment" class="form-control" rows="2"></textarea>
    </label>

    {{-- Статус (В работе, Завершенный, На потом) --}}
    <label for="status">Статус:
        <select id="status" name="status" class="form-control" required>
            <option value="в работе">В работе</option>
            <option value="Завершенный">Завершенный</option>
            <option value="На потом">На потом</option>
        </select>
    </label>

    {{-- Ответственные (multiple) --}}
    @if ($users->isEmpty())
        <p>Нет доступных пользователей с подходящим статусом.</p>
    @else
        <label for="responsibles">Ответственные за сделку:
            <select id="responsibles" name="responsibles[]" class="form-control" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} ({{ $user->status }})
                    </option>
                @endforeach
            </select>
        </label>
    @endif

    {{-- Загрузить фото аватара (avatar) --}}
    <label for="avatar">Загрузить фото аватара сделки:
        <input type="file" name="avatar" id="avatar" accept="image/*">
    </label>

    <button type="submit" class="btn btn-primary">Создать сделку</button>
</form>

{{-- Подключение select2 (если нужно) --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#responsibles').select2({
            placeholder: 'Выберите ответственных',
            allowClear: true,
            width: '100%'
        });
    });
</script>

{{-- Маска телефона + защита от неправильного ввода --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    var inputs = document.querySelectorAll("input.maskphone");
    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        input.addEventListener("input", mask);
        input.addEventListener("focus", mask);
        input.addEventListener("blur", mask);
    }
    function mask(event) {
        // Пример +7 (XXX) XXX-XX-XX
        var blank = "+7 (___) ___-__-__";
        var i = 0;
        var val = this.value.replace(/\D/g, "");
        // Если пользователь начинает ввод не с +7 
        // - можно автоматически подменять, но для простоты оставим
        this.value = blank.replace(/./g, function (char) {
            if (/[_\d]/.test(char) && i < val.length) {
                return val.charAt(i++);
            }
            return i >= val.length ? "" : char;
        });
        if (event.type === "blur") {
            if (this.value.length < 5) this.value = "";
        } else {
            setCursorPosition(this, this.value.length);
        }
    }
    function setCursorPosition(elem, pos) {
        if (elem.setSelectionRange) {
            elem.focus();
            elem.setSelectionRange(pos, pos);
        }
    }
});
</script>

