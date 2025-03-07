<div class="support wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
    <h1 class="flex">Техническая поддержка</h1>
    
    <!-- Добавляем блок для отображения ошибок -->
    <div id="error-messages" class="alert alert-danger" style="display: none;"></div>
    
    <div class="support__content">
        <div class="support__tickets">
            @include('chats.index', ['supportChat' => true])
        </div>
    </div>

    <script type="module">

        document.addEventListener('DOMContentLoaded', () => {
            const sendMessageButton = document.getElementById('send-message');
            const chatMessageInput = document.getElementById('chat-message');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const supportUserId = 55;

            function sendMessage() {
                const message = chatMessageInput.value.trim();
                if (!message) return;

                fetch(`/support/send-message/${supportUserId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ message })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        chatMessageInput.value = '';
                        // Обновляем сообщения в чате
                        loadMessages(supportUserId, 'support');
                    } else {
                        alert(data.error || 'Ошибка отправки сообщения');
                    }
                })
                .catch(error => console.error('Ошибка при отправке сообщения:', error));
            }

            function loadMessages(chatId, chatType) {
                fetch(`/support/chat/messages`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Обновляем сообщения в чате
                        const chatMessagesContainer = document.getElementById('chat-messages');
                        const chatMessagesList = chatMessagesContainer.querySelector('ul');
                        chatMessagesList.innerHTML = '';
                        data.messages.forEach(message => {
                            const li = document.createElement('li');
                            li.textContent = message.message;
                            chatMessagesList.appendChild(li);
                        });
                    })
                    .catch(error => console.error('Ошибка загрузки сообщений:', error));
            }

            if (sendMessageButton) {
                sendMessageButton.addEventListener('click', sendMessage);
            }

            if (chatMessageInput) {
                chatMessageInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });
            }
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
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 24" width="24" height="24">
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

