<form action="{{ route('commercial.saveAnswers', ['id' => $brif->id, 'page' => $page]) }}" method="POST" id="zone-form" enctype="multipart/form-data">
    @csrf
    <div class="form__title">
        @if (!empty($title_site))
            <h1>{{ $title_site }}</h1>
        @endif
        @if (!empty($description))
            <p>{{ $description }}</p>
        @endif
    </div>

    @if ($page == 2)
        <div id="zones-container">
            @foreach ($zones as $index => $zone)
                <div class="zone-item">
                    <h3>{{ $zone['name'] }}</h3>
                    <input maxlength="15" type="text" name="zones[{{ $index }}][total_area]" class="form-control"
                        placeholder="Общая площадь (м²)" value="{{ $zone['total_area'] ?? '' }}" />
                    <input maxlength="15" type="text" name="zones[{{ $index }}][projected_area]"
                        class="form-control" placeholder="Проектная площадь (м²)"
                        value="{{ $zone['projected_area'] ?? '' }}" />
                </div>
            @endforeach
        </div>

    @elseif ($page == 1)
        <div id="zones-container">
            <!-- Отображаем хотя бы одну зону -->
            @if (count($zones) > 0)
                @foreach ($zones as $index => $zone)
                    <div class="zone-item">
                        <input type="text" name="zones[{{ $index }}][name]"maxlength="250" value="{{ $zone['name'] ?? '' }}"
                            placeholder="Название зоны" class="form-control" />
                        <textarea maxlength="500" name="zones[{{ $index }}][description]" placeholder="Описание зоны"
                            class="form-control">{{ $zone['description'] ?? '' }}</textarea>
                        <span class="remove-zone"><img src="/storage/icon/сlose.svg" alt=""></span>
                    </div>
                @endforeach
            @else
                <div class="zone-item" id="add-zone">
                    <div class="blur__form__zone">
                        <p>Добавить зону</p>
                    </div>
                    <input type="text" name="zones[0][name]"maxlength="250" placeholder="Название зоны" class="form-control" />
                    <textarea maxlength="500" name="zones[0][description]" placeholder="Описание зоны" class="form-control"></textarea>
                    <span class="remove-zone"><img src="/storage/icon/сlose.svg" alt=""></span>
                </div>
                <div class="zone-item">
                    <input type="text" name="zones[0][name]" placeholder="Название зоны"maxlength="250" class="form-control" />
                    <textarea maxlength="500" name="zones[0][description]" placeholder="Описание зоны" class="form-control"></textarea>
                    <span class="remove-zone"><img src="/storage/icon/сlose.svg" alt=""></span>
                </div>
            @endif
        </div>
    @elseif ($page == 12)
        <div id="zones-container">
            @foreach ($zones as $index => $zone)
                <div class="zone-item">
                    <h3>{{ $zone['name'] }}</h3>
                    <input maxlength="500" type="text" name="budget[{{ $index }}]"
                        class="form-control budget-input" maxlength="250" placeholder="Укажите бюджет для {{ $zone['name'] }}"
                        value="{{ $zoneBudgets[$index] ?? '' }}" min="0" step="any"
                        data-zone-index="{{ $index }}" oninput="formatInput(event)" />
                </div>
            @endforeach
            <div class="faq__custom-template__prise">
                <h6>Бюджет: <span id="budget-total">0</span></h6>
                <input type="hidden" id="budget-input" name="price" value="{{ $budget }}">
            </div>
        </div>
    @elseif ($page == 13)
        <!-- Страница 14 - Загрузка документов и фотографий -->
        <div class="upload__files">
            <h6>Загрузите документы (суммарно не более 25 МБ):</h6>
            <p class="error-message" style="color: red;"></p> <!-- Место для вывода ошибок -->
            <input id="fileInput" type="file" name="documents[]" multiple
                accept=".pdf,.xlsx,.xls,.doc,.docx,.jpg,.jpeg,.png,.heic,.heif" class="form-control">
            <small>Допустимые форматы: .pdf, .xlsx, .xls, .doc, .docx, .jpg, .jpeg, .png, .heic, .heif</small>
            <small>Максимальный размер всех файлов: 25 МБ</small>
        </div>

     
    @else
        <div id="zones-container">
            @foreach ($zones as $index => $zone)
                <div class="zone-item">
                    <h3>{{ $zone['name'] }}</h3>
                    <textarea maxlength="500" name="preferences[zone_{{ $index }}][answer]" class="form-control"
                        placeholder="Введите предпочтения для {{ $zone['name'] }}">{{ $preferences['zone_' . $index]['question_' . $page] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>
    @endif

    <div class="form__button flex between">
        @if ($page > 1)
        <button type="button" class="btn btn-secondary" id="prevPageButton">На прошлый вопрос</button>

        <script>
          document.getElementById('prevPageButton').addEventListener('click', function() {
    const prevPage = {{ $page }} - 1;
    if (prevPage >= 1) {
        window.location.href = '{{ url("commercial/questions/".$brif->id) }}/' + prevPage;
    }
});

        </script>
        
        @endif
        <button type="submit" class="btn btn-primary">Далее</button>
    </div>
</form>

<script>
    document.getElementById('add-zone')?.addEventListener('click', function() {
        const container = document.getElementById('zones-container');
        const index = container.querySelectorAll('.zone-item').length;
        const zoneHtml = `
            <div class="zone-item">
                <input type="text" name="zones[${index}][name]" maxlength="250" placeholder="Название зоны" class="form-control" />
                <textarea maxlength="500" name="zones[${index}][description]" placeholder="Описание зоны" class="form-control"></textarea>
                <span class="remove-zone"><img src="/storage/icon/сlose.svg" alt=""></span>
            </div>`;
        container.insertAdjacentHTML('beforeend', zoneHtml);
    });
    document.getElementById('zones-container')?.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-zone')) {
            e.target.closest('.zone-item').remove();
        }
    });
    // Форматирование ввода в input для бюджета
    function formatInput(event) {
        let value = event.target.value;
        // Убираем все символы, кроме цифр
        value = value.replace(/[^\d]/g, ''); // Убираем все нецифровые символы
        // Если значение есть, то добавляем форматирование с разделением на тысячи
        if (value) {
            value = parseInt(value, 10).toLocaleString('ru-RU'); // Форматируем число с разделением на тысячи
        }
        // Применяем отформатированное значение в поле ввода
        event.target.value = value;
    }
    // Форматирование валюты с разделением на тысячные
    function formatCurrency(amount) {
        const formattedAmount = amount.toLocaleString('ru-RU');
        return formattedAmount + '₽'; // Добавляем символ ₽
    }
    function calculateBudget() {
        let total = 0;
        // Находим все поля ввода бюджета
        const budgetInputs = document.querySelectorAll('.zone-item input[name^="budget"]');
        budgetInputs.forEach(function(input) {
            // Получаем значение, очищаем от пробелов и символа ₽, затем приводим к числу
            const value = parseFloat(input.value.replace(/\s+/g, '').replace('₽', '')) || 0;
            total += value; // Добавляем к общей сумме
        });
        // Форматируем итоговую сумму
        const formattedTotal = formatCurrency(total);
        // Отображаем итоговую сумму в элементе
        document.getElementById('budget-total').textContent = formattedTotal;
        // Обновляем скрытое поле для отправки суммы
        const budgetInput = document.getElementById('budget-input');
        budgetInput.value = total; // Обновляем значение скрытого поля
    }
    // Добавляем обработчик события для каждого поля ввода бюджета
    document.querySelectorAll('.zone-item input[name^="budget"]').forEach(function(input) {
        input.addEventListener('input', function(event) {
            formatInput(event); // Форматируем ввод
            calculateBudget(); // Пересчитываем бюджет
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
    const areasInputs = document.querySelectorAll('input[name$="[total_area]"], input[name$="[projected_area]"]');

    areasInputs.forEach(function(input) {
        input.addEventListener('input', function(e) {
            // Только цифры
            let value = this.value.replace(/[^0-9]/g, '');  // Оставляем только цифры
            this.value = value;
        });

        input.addEventListener('blur', function() {
            // Применяем форматирование с разделением на тысячные
            let value = this.value;
            if (value) {
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');  // Форматирование числа с пробелами
            }
            // Добавляем единицу измерения "м²"
            this.value = value + ' м²';
        });

        input.addEventListener('focus', function() {
            // Убираем единицу измерения при фокусе, чтобы пользователь мог редактировать только число
            let value = this.value.replace(' м²', '');
            this.value = value;
        });
    });
});


</script>
