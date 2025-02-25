   <!-- Передаем данные пользователя -->
    <script>
        window.Laravel = {
            user: @json([
                'id'   => auth()->id(),
                'name' => auth()->user()->name ?? 'Anon',
            ]),
        };
    </script>

    <!-- Функция инициализации эмодзи-пикера с сохранением позиции курсора -->
    <script>
        function initializeEmojiPicker(textarea) {
            // Сохраняем позицию курсора
            let caretPos = textarea.selectionStart;
            textarea.addEventListener('click', () => {
                caretPos = textarea.selectionStart;
            });
            textarea.addEventListener('keyup', () => {
                caretPos = textarea.selectionStart;
            });
            textarea.addEventListener('select', () => {
                caretPos = textarea.selectionStart;
            });
            const container = textarea.parentElement;
            const emojiButton = document.createElement('button');
            const emojiPicker = document.createElement('div');
            emojiButton.textContent = "😉";
            emojiButton.type = "button";
            emojiButton.classList.add('emoji-button');
            emojiPicker.classList.add('emoji-picker');
            const emojis = [
                "😀","😁","😂","🤣","😃","😄","😅","😆","😉","😊","😍","😘","😜","😎","😭","😡",
                "😇","😈","🙃","🤔","😥","😓","🤩","🥳","🤯","🤬","🤡","👻","💀","👽","🤖","🎃",
                "🐱","🐶","🐭","🐹","🐰","🦊","🐻","🐼","🦁","🐮","🐷","🐸","🐵","🐔","🐧","🐦",
                "🌹","🌻","🌺","🌷","🌼","🍎","🍓","🍒","🍇","🍉","🍋","🍊","🍌","🥝","🍍","🥭"
            ];
            let emojiHTML = '';
            emojis.forEach(emoji => {
                emojiHTML += `<span class="emoji-item">${emoji}</span>`;
            });
            emojiPicker.innerHTML = emojiHTML;
            emojiPicker.addEventListener('click', (e) => {
                if (e.target.classList.contains('emoji-item')) {
                    const emoji = e.target.textContent;
                    const textBefore = textarea.value.substring(0, caretPos);
                    const textAfter = textarea.value.substring(caretPos);
                    textarea.value = textBefore + emoji + textAfter;
                    caretPos = caretPos + emoji.length;
                    textarea.selectionStart = caretPos;
                    textarea.selectionEnd = caretPos;
                    textarea.focus();
                }
            });
            container.appendChild(emojiButton);
            container.appendChild(emojiPicker);
            emojiPicker.style.display = "none";
            emojiButton.addEventListener('click', (event) => {
                event.stopPropagation();
                emojiPicker.style.display = (emojiPicker.style.display === "none") ? "flex" : "none";
            });
            document.addEventListener('click', (event) => {
                if (!emojiPicker.contains(event.target) && !emojiButton.contains(event.target)) {
                    emojiPicker.style.display = "none";
                }
            });
        }
    </script>

    @if(isset($supportChat) && $supportChat)
        <!-- Чат технической поддержки -->
        <div class="chat-container support-chat">
            <div class="support-chat-block-skiter">
                <img src="{{ asset('img/support/support.png') }}" alt="Поддержка">
                <span>Время работы:</span> <br>
                <p>Пн-пт: 9:00-18:00</p>
            </div>
            <div class="chat-box">
                <div class="chat-header">
                    Техническая поддержка
                </div>
                <div class="chat-messages" id="chat-messages">
                    <ul></ul>
                </div>
                <div class="chat-input" style="position: relative;">
                    <textarea id="chat-message" placeholder="Введите сообщение..." maxlength="500"></textarea>
                    <input type="file" class="file-input" style="display: none;">
                    <button type="button" class="attach-file">
                        <img src="{{ asset('/storage/icon/Icon__file.svg') }}" alt="Прикрепить файл" width="24" height="24">
                    </button>
                    <button id="send-message">
                        <img src="{{ asset('/storage/icon/send_mesg.svg') }}" alt="Отправить" width="24" height="24">
                    </button>
                </div>
            </div>
        </div>
        <script>
            // Режим поддержки: фиксированный ID чата
            const currentChatId = "55";
            const currentChatType = "personal";
            const chatMessagesContainer = document.getElementById('chat-messages');
            const chatMessagesList = chatMessagesContainer.querySelector('ul');
            const chatMessageInput = document.getElementById('chat-message');
            const sendMessageButton = document.getElementById('send-message');
            initializeEmojiPicker(chatMessageInput);
            let loadedMessageIds = new Set();

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                return date.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });
            }
            function escapeHtml(text) {
                const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
                return text.replace(/[&<>"']/g, m => map[m]);
            }
            function scrollToBottom() {
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }
            function renderMessages(messages, currentUserId) {
                let html = '';
                (messages || []).forEach(msg => {
                    if (!loadedMessageIds.has(msg.id)) {
                        const isMy = (msg.sender_id === currentUserId);
                        const liClass = isMy ? 'my-message' : 'other-message';
                        let contentHtml = '';
                        if (msg.message && msg.message.trim() !== '') {
                            contentHtml += `<div>${escapeHtml(msg.message)}</div>`;
                        }
                        if (msg.attachments && msg.attachments.length > 0) {
                            msg.attachments.forEach(attachment => {
                                if (attachment.mime && attachment.mime.startsWith('image/')) {
                                    contentHtml += `<div><img src="${attachment.url}" alt="Image" style="max-width:100%; max-height:100%; border-radius:4px;"></div>`;
                                } else {
                                    contentHtml += `<div><a style="display:flex" href="${attachment.url}" target="_blank">${escapeHtml(attachment.original_file_name)}</a></div>`;
                                }
                            });
                        } else if (msg.file_path) {
                            const lowerPath = msg.file_path.toLowerCase();
                            if (lowerPath.endsWith('.png') || lowerPath.endsWith('.jpg') || lowerPath.endsWith('.jpeg') || lowerPath.endsWith('.gif')) {
                                contentHtml += `<div><img src="${msg.file_path}" alt="Image" style="max-width:100%; max-height:100%; border-radius:4px;"></div>`;
                            } else {
                                const docName = msg.original_file_name ? msg.original_file_name : msg.file_path.split('/').pop();
                                contentHtml += `<div><a style="display:flex" href="${msg.file_path}" target="_blank">${escapeHtml(docName)}</a></div>`;
                            }
                        }
                        if(contentHtml.trim() === ''){
                            contentHtml = `<div style="color:#888;">[Пустое сообщение]</div>`;
                        }
                        html += `
                            <li class="${liClass}" data-id="${msg.id}">
                                <div><strong>${isMy ? 'Вы' : escapeHtml(msg.sender_name || 'Неизвестно')}</strong></div>
                                ${contentHtml}
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
            function sendMessage() {
                const text = chatMessageInput.value.trim();
                const fileInput = document.querySelector('.file-input');
                const file = fileInput.files[0];
                if (!text && !file) return;
                let formData = new FormData();
                formData.append('message', text);
                if (file) {
                    formData.append('file', file);
                }
                fetch(`/chats/${currentChatType}/${currentChatId}/messages`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                .then(r => r.json())
                .then(data => {
                    if (data.message) {
                        renderMessages([data.message], data.message.sender_id);
                        chatMessageInput.value = '';
                        fileInput.value = '';
                    }
                })
                .catch(e => console.error('Ошибка при отправке сообщения:', e));
            }
            function attachFileListener() {
                const attachButton = document.querySelector('.attach-file');
                const fileInput = document.querySelector('.file-input');
                if (attachButton && fileInput) {
                    attachButton.addEventListener('click', function() {
                        fileInput.click();
                    });
                    fileInput.addEventListener('change', function() {
                        if (fileInput.files.length > 0) {
                            sendMessage();
                        }
                    });
                }
            }
            if (document.readyState !== 'loading') {
                attachFileListener();
            } else {
                document.addEventListener('DOMContentLoaded', attachFileListener);
            }
            sendMessageButton.addEventListener('click', sendMessage);
            chatMessageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            function markMessagesAsRead() {
                fetch(`/chats/${currentChatType}/${currentChatId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                }).catch(e => console.error('Ошибка при пометке сообщений как прочитанных:', e));
            }
            setInterval(() => {
                fetch(`/chats/${currentChatType}/${currentChatId}/new-messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        last_message_id: chatMessagesList.lastElementChild ? parseInt(chatMessagesList.lastElementChild.getAttribute('data-id')) : 0
                    }),
                })
                .then(r => r.json())
                .then(data => {
                    if (data.messages) {
                        renderMessages(data.messages, data.current_user_id);
                        markMessagesAsRead();
                    }
                })
                .catch(e => console.error('Ошибка при получении новых сообщений:', e));
            }, 3000);
            loadMessages();
        </script>
    @elseif(isset($dealChat) && $dealChat)
        <!-- Групповой чат сделки -->
        <div class="chat-container group-chat">
            <div class="chat-box">
                <div class="chat-header">
                    Групповой чат сделки: {{ $dealChat->name }}
                </div>
                <div class="chat-messages" id="chat-messages">
                    <ul></ul>
                </div>
                <div class="chat-input" style="position: relative;">
                    <textarea id="chat-message" placeholder="Введите сообщение..." maxlength="500"></textarea>
                    <input type="file" class="file-input" style="display: none;">
                    <button type="button" class="attach-file">
                        <img src="{{ asset('/storage/icon/Icon__file.svg') }}" alt="Прикрепить файл" width="24" height="24">
                    </button>
                    <button id="send-message">
                        <img src="{{ asset('/storage/icon/send_mesg.svg') }}" alt="Отправить" width="24" height="24">
                    </button>
                </div>
            </div>
        </div>
        <script>
            const currentChatId = "{{ $dealChat->id }}";
            const currentChatType = "group";
            const chatMessagesContainer = document.getElementById('chat-messages');
            const chatMessagesList = chatMessagesContainer.querySelector('ul');
            const chatMessageInput = document.getElementById('chat-message');
            const sendMessageButton = document.getElementById('send-message');
            initializeEmojiPicker(chatMessageInput);
            let loadedMessageIds = new Set();

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                return date.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });
            }
            function escapeHtml(text) {
                const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
                return text.replace(/[&<>"']/g, m => map[m]);
            }
            function scrollToBottom() {
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }
            function renderMessages(messages, currentUserId) {
                let html = '';
                (messages || []).forEach(msg => {
                    if (!loadedMessageIds.has(msg.id)) {
                        const isMy = (msg.sender_id === currentUserId);
                        const liClass = isMy ? 'my-message' : 'other-message';
                        let contentHtml = '';
                        if (msg.message && msg.message.trim() !== '') {
                            contentHtml += `<div>${escapeHtml(msg.message)}</div>`;
                        }
                        if (msg.attachments && msg.attachments.length > 0) {
                            msg.attachments.forEach(attachment => {
                                if (attachment.mime && attachment.mime.startsWith('image/')) {
                                    contentHtml += `<div><img src="${attachment.url}" alt="Image" style="max-width:100%; border-radius:4px;"></div>`;
                                } else {
                                    contentHtml += `<div><a style="display:flex" href="${attachment.url}" target="_blank">${escapeHtml(attachment.original_file_name)}</a></div>`;
                                }
                            });
                        } else if (msg.file_path) {
                            const lowerPath = msg.file_path.toLowerCase();
                            if (lowerPath.endsWith('.png') || lowerPath.endsWith('.jpg') || lowerPath.endsWith('.jpeg') || lowerPath.endsWith('.gif')) {
                                contentHtml += `<div><img src="${msg.file_path}" alt="Image" style="max-width:100%; border-radius:4px;"></div>`;
                            } else {
                                const docName = msg.original_file_name ? msg.original_file_name : msg.file_path.split('/').pop();
                                contentHtml += `<div><a style="display:flex" href="${msg.file_path}" target="_blank">${escapeHtml(docName)}</a></div>`;
                            }
                        }
                        if(contentHtml.trim() === ''){
                            contentHtml = `<div style="color:#888;">[Пустое сообщение]</div>`;
                        }
                        html += `
                            <li class="${liClass}" data-id="${msg.id}">
                                <div><strong>${isMy ? 'Вы' : escapeHtml(msg.sender_name || 'Неизвестно')}</strong></div>
                                ${contentHtml}
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
            function sendMessage() {
                const text = chatMessageInput.value.trim();
                const fileInput = document.querySelector('.file-input');
                const file = fileInput.files[0];
                if (!text && !file) return;
                let formData = new FormData();
                formData.append('message', text);
                if (file) {
                    formData.append('file', file);
                }
                fetch(`/chats/${currentChatType}/${currentChatId}/messages`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                .then(r => r.json())
                .then(data => {
                    if (data.message) {
                        renderMessages([data.message], data.message.sender_id);
                        chatMessageInput.value = '';
                        fileInput.value = '';
                        scrollToBottom();
                    }
                })
                .catch(e => console.error('Ошибка при отправке сообщения:', e));
            }
            function attachFileListener() {
                const attachButton = document.querySelector('.attach-file');
                const fileInput = document.querySelector('.file-input');
                if (attachButton && fileInput) {
                    attachButton.addEventListener('click', function() {
                        fileInput.click();
                    });
                    fileInput.addEventListener('change', function() {
                        if (fileInput.files.length > 0) {
                            sendMessage();
                        }
                    });
                }
            }
            if (document.readyState !== 'loading') {
                attachFileListener();
            } else {
                document.addEventListener('DOMContentLoaded', attachFileListener);
            }
            sendMessageButton.addEventListener('click', sendMessage);
            chatMessageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            function markMessagesAsRead() {
                fetch(`/chats/${currentChatType}/${currentChatId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                }).catch(e => console.error('Ошибка при пометке сообщений как прочитанных:', e));
            }
            setInterval(() => {
                fetch(`/chats/${currentChatType}/${currentChatId}/new-messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        last_message_id: chatMessagesList.lastElementChild ? parseInt(chatMessagesList.lastElementChild.getAttribute('data-id')) : 0
                    }),
                })
                .then(r => r.json())
                .then(data => {
                    if (data.messages) {
                        renderMessages(data.messages, data.current_user_id);
                        markMessagesAsRead();
                    }
                })
                .catch(e => console.error('Ошибка при получении новых сообщений:', e));
            }, 3000);
            loadMessages();
        </script>
    @else
        <!-- Режим стандартного списка чатов -->
        <div class="chat-container">
            <div class="user-list" id="chat-list-container">
                <h4>Все чаты</h4>
                <!-- Поле поиска по чатам и сообщениям -->
                
                @if(auth()->user()->status == 'coordinator' || auth()->user()->status == 'admin')
                    <a href="{{ route('chats.group.create') }}" class="create__group">Создать групповой чат</a>
                @endif
                <ul id="chat-list">
                    @if(isset($chats) && count($chats))
                        @foreach ($chats as $chat)
                            <li data-chat-id="{{ $chat['id'] }}" data-chat-type="{{ $chat['type'] }}"
                                style="position: relative; display: flex; align-items: center; margin-bottom: 10px; cursor: pointer;">
                                <div class="user-list__avatar">
                                    <img src="{{ asset($chat['avatar_url']) }}" alt="{{ $chat['name'] }}" width="40" height="40">
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
                <!-- Блок для вывода результатов поиска -->
                <div class="search-results" id="search-results" style="display: none;"></div>
            </div>
            <div class="chat-box">
                
                <div class="chat-header" >
                   <span id="chat-header">Выберите чат для общения</span>   <input type="text" id="search-chats" placeholder="Поиск по чатам и сообщениям..." />
                </div>
                <div class="chat-messages" id="chat-messages">
                    <ul></ul>
                </div>
                <div class="chat-input" style="position: relative;">
                    <textarea id="chat-message" placeholder="Введите сообщение..." maxlength="500"></textarea>
                    <input type="file" class="file-input" style="display: none;">
                    <button type="button" class="attach-file">
                        <img src="{{ asset('/storage/icon/Icon__file.svg') }}" alt="Прикрепить файл" width="24" height="24">
                    </button>
                    <button id="send-message">
                        <img src="{{ asset('/storage/icon/send_mesg.svg') }}" alt="Отправить" width="24" height="24">
                    </button>
                </div>
            </div>
        </div>
        <div id="notifications" class="notifications-container"></div>

        <!-- Подключение скриптов -->
        <script src="//js.pusher.com/7.0/pusher.min.js"></script>
        <script src="{{ asset('js/echo.js') }}"></script>
        <script>
            // Инициализация emoji-пикера (общая функция)
            function initializeEmojiPicker(textarea) {
                const container = textarea.parentElement;
                const emojiButton = document.createElement('button');
                const emojiPicker = document.createElement('div');
                emojiButton.textContent = "😉";
                emojiButton.type = "button";
                emojiButton.classList.add('emoji-button');
                emojiPicker.classList.add('emoji-picker');
                emojiPicker.style.position = 'absolute';
                emojiPicker.style.bottom = '50px';
                emojiPicker.style.left = '10px';
                const emojis = [
                    "😀","😁","😂","🤣","😃","😄","😅","😆","😉","😊","😍","😘","😜","😎","😭","😡",
                    "😇","😈","🙃","🤔","😥","😓","🤩","🥳","🤯","🤬","🤡","👻","💀","👽","🤖","🎃",
                    "🐱","🐶","🐭","🐹","🐰","🦊","🐻","🐼","🦁","🐮","🐷","🐸","🐵","🐔","🐧","🐦",
                    "🌹","🌻","🌺","🌷","🌼","🍎","🍓","🍒","🍇","🍉","🍋","🍊","🍌","🥝","🍍","🥭"
                ];
                let emojiHTML = '';
                emojis.forEach(emoji => {
                    emojiHTML += `<span class="emoji-item">${emoji}</span>`;
                });
                emojiPicker.innerHTML = emojiHTML;
                emojiPicker.addEventListener('click', (e) => {
                    if (e.target.classList.contains('emoji-item')) {
                        const emoji = e.target.textContent;
                        const cursorPos = textarea.selectionStart;
                        const textBefore = textarea.value.substring(0, cursorPos);
                        const textAfter = textarea.value.substring(cursorPos);
                        textarea.value = textBefore + emoji + textAfter;
                        const newPos = cursorPos + emoji.length;
                        textarea.selectionStart = newPos;
                        textarea.selectionEnd = newPos;
                        textarea.focus();
                    }
                });
                container.appendChild(emojiButton);
                container.appendChild(emojiPicker);
                emojiPicker.style.display = "none";
                emojiButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    emojiPicker.style.display = (emojiPicker.style.display === "none") ? "flex" : "none";
                });
                document.addEventListener('click', (event) => {
                    if (!emojiPicker.contains(event.target) && !emojiButton.contains(event.target)) {
                        emojiPicker.style.display = "none";
                    }
                });
            }

            // Общие переменные и функции
            const chatMessagesContainer = document.getElementById('chat-messages');
            const chatMessagesList = chatMessagesContainer.querySelector('ul');
            const chatMessageInput = document.getElementById('chat-message');
            const sendMessageButton = document.getElementById('send-message');
            const chatList = document.getElementById('chat-list');
            const chatHeader = document.getElementById('chat-header');
            const searchInput = document.getElementById('search-chats');
            const searchResults = document.getElementById('search-results');
            const notificationsContainer = document.getElementById('notifications');
            let currentChatId = null;
            let currentChatType = null;
            let loadedMessageIds = new Set();
            const currentUserId = window.Laravel.user.id;

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                return date.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });
            }
            function escapeHtml(text) {
                const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
                return text.replace(/[&<>"']/g, m => map[m]);
            }
            function scrollToBottom() {
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }
            function renderMessages(messages, currentUserId) {
                let html = '';
                messages.forEach(message => {
                    if (!loadedMessageIds.has(message.id)) {
                        const isMyMessage = (message.sender_id === currentUserId);
                        let liClass = isMyMessage ? 'my-message' : 'other-message';
                        let readStatus = '';
                        if (isMyMessage && message.is_read) {
                            readStatus = '<span class="read-status">✓✓</span>';
                        }
                        let contentHtml = '';
                        if (message.message && message.message.trim() !== '') {
                            contentHtml += `<div>${escapeHtml(message.message)}</div>`;
                        }
                        if (message.attachments && message.attachments.length > 0) {
                            message.attachments.forEach(attachment => {
                                if (attachment.mime && attachment.mime.startsWith('image/')) {
                                    contentHtml += `<div><img src="${attachment.url}" alt="Image" style="max-width:100%; border-radius:4px;"></div>`;
                                } else {
                                    contentHtml += `<div><a href="${attachment.url}" target="_blank">${escapeHtml(attachment.original_file_name)}</a></div>`;
                                }
                            });
                        }
                        if(contentHtml.trim() === ''){
                            contentHtml = `<div style="color:#888;">[Пустое сообщение]</div>`;
                        }
                        html += `
                            <li class="${liClass}" data-id="${message.id}">
                                <div><strong>${isMyMessage ? 'Вы' : escapeHtml(message.sender_name || 'Неизвестно')}</strong></div>
                                ${contentHtml}
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

            // Функция загрузки сообщений выбранного чата
            function loadMessages(chatId, chatType) {
                currentChatId = chatId;
                currentChatType = chatType;
                chatMessagesList.innerHTML = '';
                loadedMessageIds.clear();
                const chatItem = document.querySelector(`[data-chat-id="${chatId}"][data-chat-type="${chatType}"] h5`);
                chatHeader.textContent = chatItem ? chatItem.textContent : 'Выберите чат для общения';
                fetch(`/chats/${chatType}/${chatId}/messages`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.messages) {
                            renderMessages(data.messages, data.current_user_id);
                            markMessagesAsRead(chatId, chatType);
                        }
                    })
                    .catch(e => console.error('Ошибка загрузки сообщений:', e));
                subscribeToChat(chatId, chatType);
            }

            // Функция отправки сообщения
            function sendMessage() {
                if (!currentChatId || (!chatMessageInput.value.trim() && !document.querySelector('.file-input').files[0])) return;
                const message = chatMessageInput.value.trim();
                const fileInput = document.querySelector('.file-input');
                const file = fileInput.files[0];
                let formData = new FormData();
                formData.append('message', message);
                if (file) {
                    formData.append('file', file);
                }
                fetch(`/chats/${currentChatType}/${currentChatId}/messages`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                .then(r => {
                    if (!r.ok) return r.json().then(err => { throw err; });
                    return r.json();
                })
                .then(data => {
                    if (data.message) {
                        renderMessages([data.message], data.message.sender_id);
                        chatMessageInput.value = '';
                        fileInput.value = '';
                    }
                })
                .catch(e => console.error('Ошибка при отправке сообщения:', e));
            }

            // Функция пометки сообщений как прочитанных
            function markMessagesAsRead(chatId, chatType) {
                fetch(`/chats/${chatType}/${chatId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                }).catch(e => console.error('Ошибка при пометке сообщений как прочитанных:', e));
            }

            // Функция подписки на чат через Laravel Echo
            function subscribeToChat(chatId, chatType) {
                if(window.Echo) {
                    window.Echo.private(`chat.${chatType}.${chatId}`)
                        .listen('MessageSent', (e) => {
                            renderMessages([e.message], e.message.sender_id);
                            markMessagesAsRead(chatId, chatType);
                        });
                }
            }

            // Обработчик клика по списку чатов
            chatList.addEventListener('click', (event) => {
                const chatElement = event.target.closest('li');
                if (!chatElement) return;
                const chatId = chatElement.getAttribute('data-chat-id');
                const chatType = chatElement.getAttribute('data-chat-type');
                if (currentChatId === chatId && currentChatType === chatType) return;
                loadMessages(chatId, chatType);
            });

            searchInput.addEventListener('input', function() {
    const query = searchInput.value.trim().toLowerCase();
    if (query === '') {
        // Если поиск пустой, скрываем результаты и показываем список чатов
        searchResults.style.display = 'none';
        Array.from(chatList.children).forEach(chat => {
            chat.style.display = 'flex';
        });
    } else {
        // Фильтруем список чатов по имени
        Array.from(chatList.children).forEach(chat => {
            const chatName = chat.querySelector('h5').textContent.toLowerCase();
            chat.style.display = chatName.includes(query) ? 'flex' : 'none';
        });
        // Отправляем AJAX-запрос методом POST для поиска по сообщениям и чатам
        fetch(`/chats/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ query: query })
        })
        .then(response => response.json())
        .then(data => {
            let resultsHTML = '';
            // Результаты поиска по чатам
            if (data.chats && data.chats.length > 0) {
                resultsHTML += '<h5>Чаты</h5><ul>';
                data.chats.forEach(chat => {
                    resultsHTML += `<li data-chat-id="${chat.id}" data-chat-type="${chat.type}">${chat.name}</li>`;
                });
                resultsHTML += '</ul>';
            }
            // Результаты поиска по сообщениям
            if (data.messages && data.messages.length > 0) {
                resultsHTML += '<h5>Сообщения</h5><ul>';
                data.messages.forEach(msg => {
                    let chatId = msg.chat_id;
                    let chatType = "group";
                    // Если chat_id отсутствует, значит это личное сообщение.
                    if (!chatId) {
                        chatType = "personal";
                        // Определяем собеседника: если отправитель равен текущему пользователю, то используем receiver_id, иначе sender_id.
                        chatId = (msg.sender_id == currentUserId ? msg.receiver_id : msg.sender_id);
                    }
                    resultsHTML += `<li data-chat-id="${chatId}" data-chat-type="${chatType}" data-message-id="${msg.id}">
                        <strong>${msg.sender_name}:</strong> ${msg.message.substring(0, 50)}...
                        <br><small>${formatTime(msg.created_at)}</small>
                    </li>`;
                });
                resultsHTML += '</ul>';
            }
            searchResults.innerHTML = resultsHTML;
            searchResults.style.display = resultsHTML.trim() === '' ? 'none' : 'block';
            // Обработка клика по элементам результатов поиска
            Array.from(searchResults.querySelectorAll('li')).forEach(item => {
                item.addEventListener('click', function() {
                    const chatId = this.getAttribute('data-chat-id');
                    const chatType = this.getAttribute('data-chat-type');
                    const messageId = this.getAttribute('data-message-id');
                    loadMessages(chatId, chatType);
                    searchInput.value = '';
                    searchResults.style.display = 'none';
                    // Если кликнули по сообщению, через небольшую задержку выделяем его
                    if (messageId) {
                        setTimeout(() => {
                            highlightMessage(messageId);
                        }, 1000);
                    }
                });
            });
        })
        .catch(e => console.error('Ошибка поиска:', e));
    }
});

            function attachFileListener() {
                const attachButton = document.querySelector('.attach-file');
                const fileInput = document.querySelector('.file-input');
                if (attachButton && fileInput) {
                    attachButton.addEventListener('click', function() {
                        fileInput.click();
                    });
                    fileInput.addEventListener('change', function() {
                        if (fileInput.files.length > 0) {
                            sendMessage();
                        }
                    });
                }
            }

            if (document.readyState !== 'loading') {
                attachFileListener();
            } else {
                document.addEventListener('DOMContentLoaded', attachFileListener);
            }

            sendMessageButton.addEventListener('click', sendMessage);
            chatMessageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Инициализация emoji-пикера для текстовой области
            initializeEmojiPicker(chatMessageInput);

            // Автоматически выбираем первый чат при загрузке страницы
            document.addEventListener('DOMContentLoaded', () => {
                const firstChat = chatList.querySelector('li');
                if (firstChat) firstChat.click();
            });

            // Если Echo недоступен, можно использовать fallback-опрос (закомментировано ниже)
            // setInterval(() => {
            //     if(currentChatId) {
            //         const lastMessageId = chatMessagesList.lastElementChild ? parseInt(chatMessagesList.lastElementChild.getAttribute('data-id')) : 0;
            //         fetch(`/chats/${currentChatType}/${currentChatId}/new-messages`, {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            //             },
            //             body: JSON.stringify({ last_message_id: lastMessageId }),
            //         })
            //         .then(r => r.json())
            //         .then(data => {
            //             if (data.messages) {
            //                 renderMessages(data.messages, data.current_user_id);
            //                 markMessagesAsRead(currentChatId, currentChatType);
            //             }
            //         })
            //         .catch(e => console.error('Ошибка при получении новых сообщений:', e));
            //     }
            // }, 3000);
        </script>
        
    @endif