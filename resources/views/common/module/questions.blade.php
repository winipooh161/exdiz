<form action="{{ route('common.saveAnswers', ['id' => $brif->id, 'page' => $page]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    @if (!empty($title) || !empty($subtitle))
        <div class="form__title">
            @if (!empty($title))
                <h1>{{ $title }}</h1>
            @endif
            @if (!empty($subtitle))
                <p>{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    
    {{-- Блок с вопросами в формате "checkpoint" (чекбоксы) --}}
    <div class="form__body flex between wrap pointblock">
        @foreach ($questions as $question)
            @if ($question['format'] === 'checkpoint')
                <div class="checkpoint flex wrap">
                    <div class="radio">
                        <input type="checkbox"
                               id="answer_{{ $loop->index }}"
                               class="custom-checkbox"
                               name="answers[{{ $question['key'] }}]"
                               value="{{ $question['title'] }}"
                               {{-- Проверяем, было ли уже сохранено это значение --}}
                               @if(isset($brif->{$question['key']}) && $brif->{$question['key']} === $question['title'])
                                   checked
                               @endif
                        >
                        <label for="answer_{{ $loop->index }}">{{ $question['title'] }}</label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    {{-- Блок с вопросами "default" и "faq" --}}
    <div class="form__body flex between wrap">
        @foreach ($questions as $question)
            @if ($question['format'] === 'default')
                <div class="form-group flex wrap">
                    <h2>{{ $question['title'] }}</h2>
                    @if (!empty($question['subtitle']))
                        <p>{{ $question['subtitle'] }}</p>
                    @endif
                    
                    @if ($question['type'] === 'textarea')
                        <textarea name="answers[{{ $question['key'] }}]"
                                  placeholder="{{ $question['placeholder'] }}"
                                  class="form-control"
                                  maxlength="500">{{ $brif->{$question['key']} ?? '' }}</textarea>
                    @else
                        <input type="text"
                               name="answers[{{ $question['key'] }}]"
                               class="form-control"
                               value="{{ $brif->{$question['key']} ?? '' }}"
                               placeholder="{{ $question['placeholder'] }}"
                               maxlength="500">
                    @endif
                </div>
            @endif

            {{-- Если формат faq — "аккордеон" --}}
            @if ($question['format'] === 'faq')
                <div class="faq__body">
                    <div class="faq_block flex center">
                        <div class="faq_item">
                            <div class="faq_question" onclick="toggleFaq(this)">
                                <h2>{{ $question['title'] }}</h2>
                                <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     width="24" height="24">
                                    <path d="M7 10l5 5 5-5z"></path>
                                </svg>
                            </div>
                            <div class="faq_answer">
                                @if ($question['type'] === 'textarea')
                                    <textarea name="answers[{{ $question['key'] }}]"
                                              placeholder="{{ $question['placeholder'] }}"
                                              class="form-control"
                                              maxlength="500">{{ $brif->{$question['key']} ?? '' }}</textarea>
                                @else
                                    <input type="text"
                                           name="answers[{{ $question['key'] }}]"
                                           class="form-control"
                                           value="{{ $brif->{$question['key']} ?? '' }}"
                                           placeholder="{{ $question['placeholder'] }}"
                                           maxlength="500">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Если это страница 15 — загрузка файлов --}}
        @if ($page == 15)
            <div class="upload__files">
                <h6>Загрузите документы (не более 25 МБ суммарно):</h6>
                <p class="error-message" style="color: red;"></p>
                <input id="fileInput" type="file" name="documents[]" multiple
                    accept=".pdf,.xlsx,.xls,.doc,.docx,.jpg,.jpeg,.png,.heic,.heif" class="form-control">
                <small>Допустимые форматы: .pdf, .xlsx, .xls, .doc, .docx, .jpg, .jpeg, .png, .heic, .heif</small><br>
                <small>Максимальный суммарный размер: 25 МБ</small>
            </div>
        @endif
    </div>

    {{-- Если страница 14 — считаем суммарный бюджет по textarea --}}
    @if ($page == 14)
        <div class="faq__custom-template__prise">
            <h6>Бюджет: <span id="budget-total">0</span></h6>
            <input type="hidden" id="budget-input" name="price" value="0">
        </div>

        <script>
            function calculateBudget() {
                let total = 0;
                const textareas = document.querySelectorAll('.faq__body textarea');
                textareas.forEach(function(textarea) {
                    // Удаляем все не-цифры и пробуем преобразовать в число
                    const value = parseFloat(textarea.value.replace(/\D/g, '')) || 0;
                    total += value;
                });
                document.getElementById('budget-total').textContent = formatCurrency(total);
                document.getElementById('budget-input').value = total;
            }

            function formatCurrency(amount) {
                // Форматируем в привычном для РФ виде
                return amount.toLocaleString('ru-RU') + '₽';
            }

            function formatTextareaInput(event) {
                // Удаляем все не-цифры
                let value = event.target.value.replace(/\D/g, '');
                if (value) {
                    value = parseInt(value, 10).toLocaleString('ru-RU');
                }
                event.target.value = value + '₽';
            }

            document.querySelectorAll('.faq__body textarea').forEach(function(textarea) {
                textarea.addEventListener('input', function(e) {
                    formatTextareaInput(e);
                    calculateBudget();
                });
            });

            window.addEventListener('load', calculateBudget);
        </script>
    @endif

    {{-- Кнопки "На прошлый вопрос" и "Далее" --}}
    <div class="form__button flex between">
        @if ($page > 1)
            <button type="button" class="btn btn-secondary" id="prevPageButton">На прошлый вопрос</button>
        @endif
        <button type="submit" class="btn btn-primary">Далее</button>
    </div>
</form>

{{-- Скрипт для кнопки "На прошлый вопрос" --}}
@if ($page > 1)
<script>
    document.getElementById('prevPageButton').addEventListener('click', function() {
        let prevPage = {{ $page }} - 1;
        if (prevPage >= 1) {
            window.location.href = '{{ url("common/questions") }}/{{ $brif->id }}/' + prevPage;
        }
    });
</script>
@endif

{{-- Скрипт для проверки файлов на размер и формат --}}
<script>
    document.getElementById('fileInput')?.addEventListener('change', function() {
        const allowedFormats = ['pdf', 'xlsx', 'xls', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'heic', 'heif'];
        const errorMessageElement = document.querySelector('.error-message');
        const files = this.files;
        let totalSize = 0;
        errorMessageElement.textContent = '';

        for (const file of files) {
            const fileExt = file.name.split('.').pop().toLowerCase();
            if (!allowedFormats.includes(fileExt)) {
                errorMessageElement.textContent = `Недопустимый формат файла: ${file.name}.`;
                this.value = '';
                return;
            }
            totalSize += file.size;
        }
        if (totalSize > 25 * 1024 * 1024) {
            errorMessageElement.textContent = 'Суммарный размер файлов не должен превышать 25 МБ.';
            this.value = '';
        }
    });
    function toggleFaq(questionElement) {
    const faqItem = questionElement.parentElement;       // div.faq_item
    const faqAnswer = faqItem.querySelector('.faq_answer'); 
    const inputElement = faqAnswer.querySelector('textarea, input'); 
    const isActive = faqItem.classList.contains('Активный');

    if (!isActive) {
        // --- Раскрываем FAQ ---
        faqItem.classList.add('Активный');

        // Подготовка для анимации: сначала ставим высоту 0 (если нужно)
        faqAnswer.style.height = '0px';
        // Принудительный reflow, чтобы браузер «увидел» новые стили
        faqAnswer.offsetHeight;

        // Устанавливаем высоту контента для анимации
        faqAnswer.style.height = faqAnswer.scrollHeight + 'px';

        // Фокусируемся сразу (или чуть-чуть позже) — чтобы пользователь мог писать
        if (inputElement) {
            // Небольшая задержка, чтобы блок «успел» развернуться (0 → scrollHeight)
            setTimeout(() => {
                inputElement.focus();
            }, 50);
        }

    } else {
        // --- Сворачиваем FAQ ---
        faqItem.classList.remove('Активный');

        // Плавно уходим к 0
        const currentHeight = faqAnswer.scrollHeight;
        faqAnswer.style.height = currentHeight + 'px';
        faqAnswer.offsetHeight; // reflow
        faqAnswer.style.height = '0px';
    }
}
</script>
