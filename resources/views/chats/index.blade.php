{{-- resources/views/chats/index.blade.php --}}

{{-- Подгружаем данные о пользователе (обычно это делают в основном layout) --}}
<script>
    window.Laravel = {
        user: @json([
            'id'   => auth()->id(),
            'name' => auth()->user()->name ?? 'Anon',
        ]),
    };
</script>
 
{{-- Стили или meta для CSRF-токена обычно в вашем layout --}}
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

{{-- ФУНКЦИЯ ДЛЯ ПИКЕРА ЭМОТИКОНЫ (ОДНА ДЛЯ ОБОИХ РЕЖИМОВ) --}}
<script>
    /**
     * Подключаем Emoji Picker к указанному <textarea>.
     */
    function initializeEmojiPicker(textarea) {
        const container = textarea.parentElement;

        const emojiButton = document.createElement('button');
        const emojiPicker = document.createElement('div');

        // Кнопка с эмоджи
        emojiButton.textContent = "😀";
        emojiButton.type = "button"; // чтобы не сабмитилась форма
        emojiButton.classList.add('emoji-button');

        // Сам "попап" с набором смайлов
        emojiPicker.classList.add('emoji-picker');

        // Список смайликов (можете расширять)
        const emojis = [
            "😀","😁","😂","🤣","😃","😄","😅","😆","😉","😊","😍","😘","😜","😎","😭","😡",
            "😇","😈","🙃","🤔","😥","😓","🤩","🥳","🤯","🤬","🤡","👻","💀","👽","🤖","🎃",
            "🐱","🐶","🐭","🐹","🐰","🦊","🐻","🐼","🦁","🐮","🐷","🐸","🐵","🐔","🐧","🐦",
            "🌹","🌻","🌺","🌷","🌼","🍎","🍓","🍒","🍇","🍉","🍋","🍊","🍌","🥝","🍍","🥭"
        ];

        // Генерируем HTML для списка
        let emojiHTML = '';
        emojis.forEach(emoji => {
            emojiHTML += `<span class="emoji-item">${emoji}</span>`;
        });
        emojiPicker.innerHTML = emojiHTML;

        // Обработка клика по конкретному смайлику
        emojiPicker.addEventListener('click', (e) => {
            if (e.target.classList.contains('emoji-item')) {
                const emoji = e.target.textContent;
                const cursorPos = textarea.selectionStart;
                const textBefore = textarea.value.substring(0, cursorPos);
                const textAfter = textarea.value.substring(cursorPos);

                // Вставляем смайл в текущее положение курсора
                textarea.value = textBefore + emoji + textAfter;
                // Перемещаем курсор сразу после вставленного смайла
                const newPos = cursorPos + emoji.length;
                textarea.selectionStart = newPos;
                textarea.selectionEnd = newPos;
                textarea.focus();
            }
        });

        // Добавляем элементы в DOM
        container.appendChild(emojiButton);
        container.appendChild(emojiPicker);

        // Изначально скрываем список смайлов
        emojiPicker.style.display = "none";

        // Клик по кнопке переключает видимость
        emojiButton.addEventListener('click', (event) => {
            event.stopPropagation(); // чтобы не скрывалось сразу же
            emojiPicker.style.display = (emojiPicker.style.display === "none") ? "flex" : "none";
        });

        // Клик за пределами списка смайлов скрывает его
        document.addEventListener('click', (event) => {
            if (!emojiPicker.contains(event.target) && !emojiButton.contains(event.target)) {
                emojiPicker.style.display = "none";
            }
        });
    }
</script>


{{-- =========================================
     1) РЕЖИМ: только один групповой чат
   ========================================= --}}
@if(isset($dealChat) && $dealChat)
    <div class="chat-container single-deal-chat">
        <div class="chat-box">
            <div class="chat-header">
                Групповой чат сделки: {{ $dealChat->name }}
            </div>

            <!-- Блок с сообщениями -->
            <div class="chat-messages" id="chat-messages">
                <ul></ul>
            </div>

            <!-- Поле ввода -->
            <div class="chat-input" style="position: relative;">
                <textarea id="chat-message" placeholder="Введите сообщение..." maxlength="500"></textarea>
                <button id="send-message">
                    <img src="{{ asset('/storage/icon/send.svg') }}" alt="Отправить" width="24" height="24">
                </button>
            </div>
        </div>
    </div>

    <script>
        // ----------------------------------
        // Одиночный групповой чат
        // ----------------------------------
        const currentChatId   = "{{ $dealChat->id }}";
        const currentChatType = "group";

        const chatMessagesContainer = document.getElementById('chat-messages');
        const chatMessagesList      = chatMessagesContainer.querySelector('ul');
        const chatMessageInput      = document.getElementById('chat-message');
        const sendMessageButton     = document.getElementById('send-message');

        // Инициализируем emoji picker
        initializeEmojiPicker(chatMessageInput);

        // Запоминаем уже загруженные сообщения (чтобы не дублировать)
        const loadedMessageIds = new Set();

        /** Форматирование времени */
        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString('ru-RU', {
                hour: '2-digit',
                minute: '2-digit',
            });
        }

        /** Экранирование HTML */
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, (m) => map[m]);
        }

        /** Прокрутка вниз */
        function scrollToBottom() {
            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
        }

        /** Отрисовка сообщений */
        function renderMessages(messages, currentUserId) {
            let html = '';
            (messages || []).forEach(msg => {
                if (!loadedMessageIds.has(msg.id)) {
                    const isMy = (msg.sender_id === currentUserId);
                    const liClass = isMy ? 'my-message' : 'other-message';

                    html += `
                        <li class="${liClass}" data-id="${msg.id}">
                            <div><strong>${isMy ? 'Вы' : escapeHtml(msg.sender_name || '???')}</strong></div>
                            <div>${escapeHtml(msg.message)}</div>
                            <span class="message-time">${formatTime(msg.created_at)}</span>
                        </li>
                    `;
                    loadedMessageIds.add(msg.id);
                }
            });

            if (html) {
                chatMessagesList.insertAdjacentHTML('beforeend', html);
                scrollToBottom();
            }
        }

        /** Загрузка всех сообщений */
        function loadMessages() {
            fetch(`/chats/${currentChatType}/${currentChatId}/messages`)
                .then(r => r.json())
                .then(data => {
                    if (data.messages) {
                        renderMessages(data.messages, data.current_user_id);
                        markMessagesAsRead();
                    }
                })
                .catch(e => console.error('Ошибка загрузки сообщений:', e));
        }

        /** Отправить сообщение */
        function sendMessage() {
            const text = chatMessageInput.value.trim();
            if (!text) return;

            fetch(`/chats/${currentChatType}/${currentChatId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message: text }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.message) {
                    // Добавляем своё сообщение сразу
                    renderMessages([data.message], data.message.sender_id);
                    chatMessageInput.value = '';
                }
            })
            .catch(e => console.error('Ошибка при отправке сообщения:', e));
        }

        sendMessageButton.addEventListener('click', sendMessage);

        // При нажатии Enter (без shift)
        chatMessageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        /** Пометить все непрочитанные как прочитанные */
        function markMessagesAsRead() {
            fetch(`/chats/${currentChatType}/${currentChatId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            }).catch(e => console.error('Error marking messages as read:', e));
        }

        /** Периодически подтягиваем новые (каждые 3 сек) */
        setInterval(() => {
            fetchNewMessages();
        }, 3000);

        /** Получаем новые сообщения после последнего ID */
        function fetchNewMessages() {
            const lastLi = chatMessagesList.lastElementChild;
            const lastId = lastLi ? parseInt(lastLi.getAttribute('data-id')) : 0;

            fetch(`/chats/${currentChatType}/${currentChatId}/new-messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ last_message_id: lastId }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.messages) {
                    renderMessages(data.messages, data.current_user_id);
                    markMessagesAsRead();
                }
            })
            .catch(e => console.error('Ошибка при получении новых сообщений:', e));
        }

        // Если хотите Laravel Echo (realtime), можно подключить так:
        /*
        Echo.private(`chat.${currentChatId}`)
            .listen('.message.sent', (e) => {
                if (e.message.sender_id !== window.Laravel.user.id) {
                    renderMessages([e.message], window.Laravel.user.id);
                    markMessagesAsRead();
                }
            });
        */

        // При загрузке один раз загружаем всю историю
        loadMessages();
    </script>


{{-- =========================================
     2) РЕЖИМ: список всех чатов + поиск
   ========================================= --}}
@else
    <div class="chat-container">
        <!-- Chat List -->
        <div class="user-list" style="z-index: 41;">
            <h4>Все чаты</h4>
            <input type="text" id="search-chats" placeholder="Поиск по чатам..." />
            <ul id="chat-list">
                @if(isset($chats) && count($chats))
                    @foreach ($chats as $chat)
                        <li data-chat-id="{{ $chat['id'] }}" data-chat-type="{{ $chat['type'] }}"
                            style="position: relative; display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                            <div class="user-list__avatar">
                                <img src="{{ asset($chat['avatar_url']) }}" alt="{{ $chat['name'] }}">
                            </div>
                            <div class="user-list__info" style="margin-left: 10px; width: 100%;">
                                <h5>
                                    {{ $chat['name'] }}
                                    @if ($chat['unread_count'] > 0)
                                        <span class="unread-count">{{ $chat['unread_count'] }}</span>
                                    @endif
                                </h5>
                            </div>
                        </li>
                    @endforeach
                @else
                    <p>Чатов пока нет</p>
                @endif
            </ul>
        </div>

        <!-- Chat Area -->
        <div class="chat-box">
            <div class="chat-header" id="chat-header">
                Выберите чат для общения
            </div>

            <div class="chat-messages" id="chat-messages">
                <ul></ul>
            </div>

            <div class="chat-input" style="position: relative;">
                <textarea id="chat-message" placeholder="Введите сообщение..." maxlength="500"></textarea>
                <button id="send-message">
                    <img src="{{ asset('/storage/icon/send.svg') }}" alt="Отправить" width="24" height="24">
                </button>
            </div>
        </div>
    </div>

    <!-- Notifications Container (если нужна всплывашка) -->
    <div id="notifications" class="notifications-container"></div>

    <script>
        // --------------------------
        // ПОЛНЫЙ РЕЖИМ (список чатов)
        // --------------------------

        const chatMessagesContainer = document.getElementById('chat-messages');
        const chatMessagesList      = chatMessagesContainer.querySelector('ul');
        const chatMessageInput      = document.getElementById('chat-message');
        const sendMessageButton     = document.getElementById('send-message');

        // Инициализируем emoji picker
        initializeEmojiPicker(chatMessageInput);

        const chatList             = document.getElementById('chat-list');
        const chatHeader           = document.getElementById('chat-header');
        const searchInput          = document.getElementById('search-chats');
        const notificationsContainer = document.getElementById('notifications');

        let currentChatId   = null;
        let currentChatType = null;

        // Запоминаем загруженные сообщения
        const loadedMessageIds = new Set();

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString('ru-RU', {
                hour: '2-digit',
                minute: '2-digit',
            });
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;',
            };
            return text.replace(/[&<>"']/g, (m) => map[m]);
        }

        function scrollToBottom() {
            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
        }

        function renderMessages(messages, currentUserId) {
            if (!Array.isArray(messages)) return;

            let html = '';
            messages.forEach(message => {
                if (!loadedMessageIds.has(message.id)) {
                    const isMyMessage = (message.sender_id === currentUserId);
                    let liClass = isMyMessage ? 'my-message' : 'other-message';

                    // Если нужно учитывать прочитанные:
                    let readStatus = '';
                    if (isMyMessage && message.is_read) {
                        readStatus = '<span class="read-status">✓✓</span>';
                    }

                    html += `
                        <li class="${liClass}" data-id="${message.id}">
                            <div>
                                <strong>${isMyMessage ? 'Вы' : escapeHtml(message.sender_name || 'Неизвестно')}</strong>
                            </div>
                            <div>${escapeHtml(message.message)}</div>
                            <span class="message-time">${formatTime(message.created_at)}</span>
                            ${readStatus}
                        </li>
                    `;
                    loadedMessageIds.add(message.id);
                }
            });

            if (html) {
                chatMessagesList.insertAdjacentHTML('beforeend', html);
                scrollToBottom();
            }
        }

        function loadMessages(chatId, chatType) {
            chatMessagesList.innerHTML = '';
            loadedMessageIds.clear();

            const chatItem = document.querySelector(`[data-chat-id="${chatId}"][data-chat-type="${chatType}"] h5`);
            chatHeader.textContent = chatItem ? chatItem.textContent : 'Выберите чат для общения';

            fetch(`/chats/${chatType}/${chatId}/messages`)
                .then(r => r.json())
                .then(data => {
                    if (data.messages) {
                        const currentUserId = data.current_user_id;
                        renderMessages(data.messages, currentUserId);
                        markMessagesAsRead(chatId, chatType);
                        updateUnreadCountUI(chatId, chatType, 0);
                    }
                })
                .catch(e => console.error('Error loading messages:', e));
        }

        function fetchNewMessages() {
            if (!currentChatId) return;
            const lastMessageId = getLastMessageId();

            fetch(`/chats/${currentChatType}/${currentChatId}/new-messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ last_message_id: lastMessageId }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.messages) {
                    renderMessages(data.messages, data.current_user_id);
                    markMessagesAsRead(currentChatId, currentChatType);
                    updateUnreadCountUI(currentChatId, currentChatType, 0);
                }
            })
            .catch(e => console.error('Error fetching new messages:', e));
        }

        function sendMessage() {
            if (!currentChatId || !chatMessageInput.value.trim()) return;
            const message = chatMessageInput.value.trim();

            fetch(`/chats/${currentChatType}/${currentChatId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message }),
            })
            .then(r => {
                if (!r.ok) {
                    return r.json().then(err => { throw err; });
                }
                return r.json();
            })
            .then(data => {
                if (data.message) {
                    renderMessages([data.message], data.message.sender_id);
                    chatMessageInput.value = '';
                    scrollToBottom();
                }
            })
            .catch(e => console.error('Error sending message:', e));
        }

        function markMessagesAsRead(chatId, chatType) {
            fetch(`/chats/${chatType}/${chatId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            }).catch(e => console.error('Error marking messages as read:', e));
        }

        function getLastMessageId() {
            const lastMessage = chatMessagesList.lastElementChild;
            return lastMessage ? parseInt(lastMessage.getAttribute('data-id')) : 0;
        }

        function updateUnreadCountUI(chatId, chatType, count) {
            const chatItem = document.querySelector(`[data-chat-id="${chatId}"][data-chat-type="${chatType}"]`);
            if (!chatItem) return;

            let unreadBadge = chatItem.querySelector('.unread-count');
            if (count > 0) {
                if (unreadBadge) {
                    unreadBadge.textContent = count;
                } else {
                    unreadBadge = document.createElement('span');
                    unreadBadge.className = 'unread-count';
                    unreadBadge.textContent = count;
                    chatItem.querySelector('.user-list__info').appendChild(unreadBadge);
                }
                // Поднимаем чат наверх
                chatItem.parentNode.insertBefore(chatItem, chatItem.parentNode.firstChild);
            } else {
                if (unreadBadge) {
                    unreadBadge.remove();
                }
            }
        }

        function incrementUnreadCount(chatId, chatType) {
            const chatItem = document.querySelector(`[data-chat-id="${chatId}"][data-chat-type="${chatType}"]`);
            if (!chatItem) return;

            let unreadBadge = chatItem.querySelector('.unread-count');
            if (unreadBadge) {
                unreadBadge.textContent = parseInt(unreadBadge.textContent) + 1;
            } else {
                unreadBadge = document.createElement('span');
                unreadBadge.className = 'unread-count';
                unreadBadge.textContent = '1';
                chatItem.querySelector('.user-list__info').appendChild(unreadBadge);
            }
            chatItem.parentNode.insertBefore(chatItem, chatItem.parentNode.firstChild);
        }

        function fetchUnreadCounts() {
            fetch(`/chats/unread-counts`)
                .then(r => r.json())
                .then(data => {
                    if (data.personal && data.group) {
                        // Обновляем персональные
                        for (const [senderId, count] of Object.entries(data.personal)) {
                            updateUnreadCountUI(senderId, 'personal', count);
                        }
                        // Обновляем групповые
                        for (const [gChatId, gCount] of Object.entries(data.group)) {
                            updateUnreadCountUI(gChatId, 'group', gCount);
                        }
                    }
                })
                .catch(e => console.error('Error fetching unread counts:', e));
        }

        // Периодическая проверка новых сообщений и непрочитанных
        setInterval(fetchNewMessages, 1000);
        setInterval(fetchUnreadCounts, 5000);

        // Клик по элементу списка чатов
        chatList.addEventListener('click', (event) => {
            const chatElement = event.target.closest('li');
            if (!chatElement) return;

            const chatId   = chatElement.getAttribute('data-chat-id');
            const chatType = chatElement.getAttribute('data-chat-type');

            if (currentChatId === chatId && currentChatType === chatType) return;

            currentChatId   = chatId;
            currentChatType = chatType;

            removeNotificationsForChat(chatId, chatType);
            loadMessages(chatId, chatType);
            subscribeToChat(chatId, chatType);
        });

        function subscribeToChat(chatId, chatType) {
            // Отписываемся от предыдущего (если есть)
            if (currentChatId && currentChatType) {
                if (currentChatType === 'group') {
                    window.Echo.leave(`chat.${currentChatId}`);
                } else {
                    window.Echo.leave(`user.${currentChatId}`);
                }
            }

            currentChatId   = chatId;
            currentChatType = chatType;

            if (chatType === 'group') {
                window.Echo.private(`chat.${chatId}`)
                    .listen('.message.sent', (e) => {
                        handleIncomingMessage(e.message);
                    })
                    .listen('.messages.read', (e) => {
                        updateReadStatus(e.userId);
                    });
            } else {
                window.Echo.private(`user.${chatId}`)
                    .listen('.message.sent', (e) => {
                        handleIncomingMessage(e.message);
                    });
            }
        }

        function updateReadStatus(userId) {
            document.querySelectorAll('.read-status').forEach(el => {
                if (!el.classList.contains('read')) {
                    el.textContent = '✓✓';
                    el.classList.add('read');
                }
            });
            const unreadBadge = document.querySelector(
                `[data-chat-id="${currentChatId}"][data-chat-type="${currentChatType}"] .unread-count`
            );
            if (unreadBadge) unreadBadge.remove();
        }

        function handleIncomingMessage(message) {
            const messageChatId   = message.chat_id || message.sender_id;
            const messageChatType = message.chat_id ? 'group' : 'personal';

            if (currentChatId == messageChatId && currentChatType == messageChatType) {
                renderMessages([message], window.Laravel.user.id);
                markMessagesAsRead(currentChatId, currentChatType);
            } else {
                incrementUnreadCount(messageChatId, messageChatType);
                showNotification(message);
            }
            playSoundNotification();
        }

        function showNotification(message) {
            if (!notificationsContainer) return;
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerHTML = `
                <strong>${escapeHtml(message.sender_name || 'Неизвестно')}</strong>: ${escapeHtml(message.message)}
            `;
            notificationsContainer.appendChild(notification);
            setTimeout(() => notification.remove(), 5000);
        }

        function playSoundNotification() {
            const audio = new Audio('{{ asset("sounds/notification.mp3") }}');
            audio.play().catch(e => console.error('Ошибка проигрывания звука:', e));
        }

        function removeNotificationsForChat(chatId, chatType) {
            if (notificationsContainer) {
                notificationsContainer.innerHTML = '';
            }
        }

        // Фильтр поиска
        searchInput.addEventListener('input', () => {
            const keyword = searchInput.value.toLowerCase();
            chatList.querySelectorAll('li').forEach(chat => {
                const chatName = chat.querySelector('h5').textContent.toLowerCase();
                chat.style.display = chatName.includes(keyword) ? 'flex' : 'none';
            });
        });

        // Отправка сообщения по кнопке
        sendMessageButton.addEventListener('click', sendMessage);
        // Отправка по Enter (без shift)
        chatMessageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // При желании сразу открыть первый чат
        document.addEventListener('DOMContentLoaded', () => {
            const firstChat = chatList.querySelector('li');
            if (firstChat) firstChat.click();
        });
    </script>
@endif

{{-- Минимальные стили для emoji picker (и т.д.) --}}
<style>
    
</style>
