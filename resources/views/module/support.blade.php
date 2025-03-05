<div class="support wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
    <h1 class="flex">Техническая поддержка</h1>
    
    <!-- Добавляем блок для отображения ошибок -->
    <div id="error-messages" class="alert alert-danger" style="display: none;"></div>
    
    <div class="support__content">
        <div class="support__tickets">
            @include('chats.index', ['supportChat' => true])
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ChatManagerInstance = new ChatManager({
                currentChatId: 55,
                currentChatType: 'personal', // Важно: используем тип personal вместо support
                autoLoad: true,
                onError: (error) => {
                    const errorBlock = document.getElementById('error-messages');
                    errorBlock.textContent = error;
                    errorBlock.style.display = 'block';
                    setTimeout(() => {
                        errorBlock.style.display = 'none';
                    }, 5000);
                }
            });

            // Добавляем обработчик для проверки статуса отправки
            document.getElementById('send-message')?.addEventListener('click', async () => {
                const messageInput = document.getElementById('chat-message');
                if (!messageInput?.value?.trim()) {
                    document.getElementById('error-messages').textContent = 'Сообщение не может быть пустым';
                    document.getElementById('error-messages').style.display = 'block';
                    return;
                }
            });
        });
    </script>

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
</div>

