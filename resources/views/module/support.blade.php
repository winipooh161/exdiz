
<div class="support wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
    <h1 class="flex">Техническая поддержка</h1>
    <div class="support__content">
        <div class="support__tickets">
            {{-- При обращении по адресу /support условие в chats/index.blade.php выберет режим чата с поддержкой --}}
            @include('chats.index')
        </div>
    </div>
    <h1>Часто задаваемые вопросы</h1>
    <div class="faq__body support-faq__body">
        <div class="faq_block">
            <div class="faq_item">
                <div class="faq_question" onclick="toggleFaq(this)">
                    <span>Как создать бриф для проекта?</span>
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M7 10l5 5 5-5z"></path>
                    </svg>
                </div>
                <div class="faq_answer">
                    <p>Для создания брифа перейдите в раздел "Брифы" в вашем личном кабинете. Здесь доступны два типа брифов: общий и коммерческий.</p>
                </div>
            </div>
            <div class="faq_item">
                <div class="faq_question" onclick="toggleFaq(this)">
                    <span>Что происходит после заполнения брифа?</span>
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M7 10l5 5 5-5z"></path>
                    </svg>
                </div>
                <div class="faq_answer">
                    <p>После заполнения брифа становится доступна функция сделок для начала работы над проектом, а ответственные лица ведут контроль этапов.</p>
                </div>
            </div>
            <!-- Дополнительные FAQ -->
            <div class="faq_item">
                <div class="faq_question" onclick="toggleFaq(this)">
                    <span>Как начать сделку в системе?</span>
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M7 10l5 5 5-5z"></path>
                    </svg>
                </div>
                <div class="faq_answer">
                    <p>После создания сделки в личном кабинете ответственные могут отслеживать её ход и взаимодействовать через систему.</p>
                </div>
            </div>
            <div class="faq_item">
                <div class="faq_question" onclick="toggleFaq(this)">
                    <span>Как использовать групповый чат для сделки?</span>
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M7 10l5 5 5-5z"></path>
                    </svg>
                </div>
                <div class="faq_answer">
                    <p>Открывая сделку, вам доступен групповой чат для обсуждения деталей проекта с ответственными и заинтересованными сторонами.</p>
                </div>
            </div>
            <div class="faq_item">
                <div class="faq_question" onclick="toggleFaq(this)">
                    <span>Как работают уведомления и напоминания?</span>
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M7 10l5 5 5-5z"></path>
                    </svg>
                </div>
                <div class="faq_answer">
                    <p>Уведомления информируют вас об изменениях статусов сделок, задачах и запланированных действиях, чтобы ничего не упустить.</p>
                </div>
            </div>
            <div class="faq_item">
                <div class="faq_question" onclick="toggleFaq(this)">
                    <span>Что делать, если не пришло уведомление?</span>
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M7 10l5 5 5-5z"></path>
                    </svg>
                </div>
                <div class="faq_answer">
                    <p>Проверьте настройки уведомлений в личном кабинете и папку спам в почте. Если проблема сохраняется – свяжитесь с технической поддержкой.</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleFaq(element) {
            const faqItem = element.parentElement;
            document.querySelectorAll('.faq_item').forEach(item => {
                if (item !== faqItem) item.classList.remove('active');
            });
            faqItem.classList.toggle('active');
        }
    </script>

    <div id="modal1" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="create__tiket">
                <h2>Создать новый тикет</h2>
                <form action="{{ route('support.create') }}" method="POST">
                    @csrf
                    <label for="title">
                        <p>Заголовок тикета:</p>
                        <input type="text" name="title" id="title" placeholder="Введите заголовок" required>
                    </label>
                    <label for="description">
                        <p>Описание:</p>
                        <textarea name="description" id="description" placeholder="Введите описание вашего тикета" required></textarea>
                    </label>
                    <button type="submit">Создать тикет</button>
                </form>
            </div>
        </div>
    </div>
</div>

