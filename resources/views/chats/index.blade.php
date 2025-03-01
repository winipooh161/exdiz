<body>
    <!-- Передаем данные пользователя -->
    <script>
        window.Laravel = {
            user: @json([
                'id'   => auth()->id(),
                'name' => auth()->user()->name ?? 'Anon',
            ]),
        };
        // URL для картинок закрепления/открепления (измените при необходимости)
        const pinImgUrl = "{{ asset('storage/icon/pin.svg') }}";
        const unpinImgUrl = "{{ asset('storage/icon/unpin.svg') }}";
    </script>

    <!-- Функция инициализации эмодзи-пикера -->
    <script>
        function initializeEmojiPicker(textarea) {
            let caretPos = textarea.selectionStart;
            textarea.addEventListener('click', () => { caretPos = textarea.selectionStart; });
            textarea.addEventListener('keyup', () => { caretPos = textarea.selectionStart; });
            textarea.addEventListener('select', () => { caretPos = textarea.selectionStart; });
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
                    caretPos += emoji.length;
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

    <script>
        function showChatList() {
            document.querySelector('.user-list').classList.add('active');
            document.querySelector('.chat-box').classList.remove('active');
        }

        function showChatBox() {
            document.querySelector('.user-list').classList.remove('active');
            document.querySelector('.chat-box').classList.add('active');
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
                    <span class="back-button" onclick="showChatList()">← Назад</span>
                    Техническая поддержка
                    <!-- Кнопка фильтра закреплённых сообщений -->
                    <button id="toggle-pinned" class="toggle-pinned" style="margin-left:10px;">Показать только закрепленные</button>
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
            // Параметры для режима поддержки
            const currentChatId = "55";
            const currentChatType = "personal";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const chatMessagesContainer = document.getElementById('chat-messages');
            const chatMessagesList = chatMessagesContainer.querySelector('ul');
            const chatMessageInput = document.getElementById('chat-message');
            const sendMessageButton = document.getElementById('send-message');
            initializeEmojiPicker(chatMessageInput);
            let loadedMessageIds = new Set();
            let pinnedOnly = false; // Флаг режима "только закрепленные"

            // Обработчик кнопки фильтрации закрепленных сообщений
            const togglePinnedButton = document.getElementById('toggle-pinned');
            togglePinnedButton.addEventListener('click', function(){
                pinnedOnly = !pinnedOnly;
                this.textContent = pinnedOnly ? "Показать все" : "Показать только закрепленные";
                filterMessages();
            });

            function filterMessages(){
                document.querySelectorAll('#chat-messages ul li').forEach(li => {
                    li.style.display = pinnedOnly ? (li.classList.contains('pinned') ? '' : 'none') : '';
                });
            }

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                return date.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });
            }
            function escapeHtml(text) {
                const map = { '&': '&amp;', '<': '&lt;', '&gt;': '&gt;', '"': '&quot;', "'": '&#039;' };
                return text.replace(/[&<>"']/g, m => map[m]);
            }
            function scrollToBottom() {
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }
            // Рендер сообщений с добавлением класса "pinned" для закрепленных
            function renderMessages(messages, currentUserId) {
                let html = '';
                (messages || []).forEach(msg => {
                    if (!loadedMessageIds.has(msg.id)) {
                        const isMy = (msg.sender_id === currentUserId);
                        const liClass = isMy ? 'my-message' : 'other-message';
                        const pinnedClass = msg.is_pinned ? 'pinned' : '';
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
                        let actionsHtml = '';
                        if (isMy) {
                            actionsHtml = `
                                <div class="message-controls">
                                    <button class="delete-message" data-id="${msg.id}"><img src="{{ asset('storage/icon/deleteMesg.svg') }}"></button>
                                    ${msg.is_pinned 
                                        ? `<button class="unpin-message" data-id="${msg.id}"><img src="${unpinImgUrl}" alt="Открепить"></button>`
                                        : `<button class="pin-message" data-id="${msg.id}"><img src="${pinImgUrl}" alt="Закрепить"></button>`
                                    }
                                </div>
                            `;
                        }
                        html += `
                            <li class="${liClass} ${pinnedClass}" data-id="${msg.id}">
                                <div><strong>${isMy ? 'Вы' : escapeHtml(msg.sender_name || 'Неизвестно')}</strong></div>
                                ${contentHtml}
                                ${actionsHtml}
                                <span class="message-time">${formatTime(msg.created_at)}</span>
                            </li>
                        `;
                        loadedMessageIds.add(msg.id);
                    }
                });
                if (html) {
                    chatMessagesList.insertAdjacentHTML('beforeend', html);
                    scrollToBottom();
                    attachMessageActionListeners();
                    filterMessages();
                }
            }
            function attachMessageActionListeners() {
                document.querySelectorAll('.delete-message').forEach(button => {
                    button.onclick = function() {
                        const messageId = this.getAttribute('data-id');
                        if (confirm('Удалить сообщение?')) {
                            fetch(`/chats/${currentChatType}/${currentChatId}/messages/${messageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('li').remove();
                                } else {
                                    alert(data.error || 'Ошибка удаления сообщения');
                                }
                            })
                            .catch(error => console.error('Ошибка:', error));
                        }
                    };
                });
                document.querySelectorAll('.pin-message').forEach(button => {
                    button.onclick = function() {
                        const messageId = this.getAttribute('data-id');
                        fetch(`/chats/${currentChatType}/${currentChatId}/messages/${messageId}/pin`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.innerHTML = `<img src="${unpinImgUrl}" alt="Открепить">`;
                                this.classList.remove('pin-message');
                                this.classList.add('unpin-message');
                                let li = this.closest('li');
                                li.classList.add('pinned');
                                if (li && !li.querySelector('.pinned-label')) {
                                    let span = document.createElement('span');
                                    span.classList.add('pinned-label');
                                    span.textContent = ' [Закреплено]';
                                    li.querySelector('div').appendChild(span);
                                }
                                filterMessages();
                            } else {
                                alert(data.error || 'Ошибка закрепления сообщения');
                            }
                        })
                        .catch(error => console.error('Ошибка:', error));
                    };
                });
                document.querySelectorAll('.unpin-message').forEach(button => {
                    button.onclick = function() {
                        const messageId = this.getAttribute('data-id');
                        fetch(`/chats/${currentChatType}/${currentChatId}/messages/${messageId}/unpin`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.innerHTML = `<img src="${pinImgUrl}" alt="Закрепить">`;
                                this.classList.remove('unpin-message');
                                this.classList.add('pin-message');
                                let li = this.closest('li');
                                li.classList.remove('pinned');
                                let pinnedLabel = li.querySelector('.pinned-label');
                                if (pinnedLabel) { pinnedLabel.remove(); }
                                filterMessages();
                            } else {
                                alert(data.error || 'Ошибка открепления сообщения');
                            }
                        })
                        .catch(error => console.error('Ошибка:', error));
                    };
                });
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
                if (file) { formData.append('file', file); }
                fetch(`/chats/${currentChatType}/${currentChatId}/messages`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData,
                })
                .then(r => {
                    if (!r.ok) {
                        return r.text().then(text => { throw new Error(text); });
                    }
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
            function attachFileListener() {
                const attachButton = document.querySelector('.attach-file');
                const fileInput = document.querySelector('.file-input');
                if (attachButton && fileInput) {
                    attachButton.addEventListener('click', () => { fileInput.click(); });
                    fileInput.addEventListener('change', () => {
                        if (fileInput.files.length > 0) { sendMessage(); }
                    });
                }
            }
            if (document.readyState !== 'loading') { attachFileListener(); }
            else { document.addEventListener('DOMContentLoaded', attachFileListener); }
            sendMessageButton.addEventListener('click', sendMessage);
            chatMessageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
            });
            function markMessagesAsRead() {
                fetch(`/chats/${currentChatType}/${currentChatId}/mark-read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                }).catch(e => console.error('Ошибка при пометке сообщений как прочитанных:', e));
            }
            setInterval(() => {
                fetch(`/chats/${currentChatType}/${currentChatId}/new-messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        last_message_id: chatMessagesList.lastElementChild ? parseInt(chatMessagesList.lastElementChild.getAttribute('data-id')) : 0
                    }),
                })
                .then(r => {
                    if (!r.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return r.json();
                })
                .then(data => {
                    if (data.messages) {
                        renderMessages(data.messages, data.current_user_id);
                        markMessagesAsRead();
                    }
                })
                .catch(e => console.error('Ошибка при получении новых сообщений:', e));
            }, 1000); // Проверка новых сообщений каждую секунду
            loadMessages();
        </script>
    @elseif(isset($dealChat))
    <div class="chat-container">
        <div class="chat-box">
            <div class="chat-header">
                <span class="back-button" onclick="showChatList()">← Назад</span>
                {{ $dealChat->name }}
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
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessagesContainer = document.getElementById('chat-messages');
            const chatMessagesList = chatMessagesContainer.querySelector('ul');
            const chatMessageInput = document.getElementById('chat-message');
            const sendMessageButton = document.getElementById('send-message');
            const currentChatId = "{{ $dealChat->id }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
                fetch(`/chats/group/${currentChatId}/messages`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.messages) {
                            renderMessages(data.messages, data.current_user_id);
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
                if (file) { formData.append('file', file); }
                fetch(`/chats/group/${currentChatId}/messages`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData,
                })
                .then(r => {
                    if (!r.ok) {
                        return r.text().then(text => { throw new Error(text); });
                    }
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

            sendMessageButton.addEventListener('click', sendMessage);
            chatMessageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
            });

            setInterval(() => {
                fetch(`/chats/group/${currentChatId}/new-messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        last_message_id: chatMessagesList.lastElementChild ? parseInt(chatMessagesList.lastElementChild.getAttribute('data-id')) : 0
                    }),
                })
                .then(r => {
                    if (!r.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return r.json();
                })
                .then(data => {
                    if (data.messages) {
                        renderMessages(data.messages, data.current_user_id);
                        markMessagesAsRead();
                    }
                })
                .catch(e => console.error('Ошибка при получении новых сообщений:', e));
            }, 1000); // Проверка новых сообщений каждую секунду
            loadMessages();
        });
    </script>
@else
        <!-- Режим стандартного списка чатов -->
        <div class="chat-container">
            <div class="user-list" id="chat-list-container">
                <h4>Все чаты</h4>  <span class="back-button" onclick="showChatList()">← Назад</span>
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
                <div class="search-results" id="search-results" style="display: none;"></div>
            </div>
            <div class="chat-box">
                <div class="chat-header">
                   <span class="back-button" onclick="showChatList()">← Назад</span>
                   <span id="chat-header">Выберите чат для общения</span>
                   <input type="text" id="search-chats" placeholder="Поиск по чатам и сообщениям..." />
                   <!-- Кнопка фильтра для стандартного режима -->
                   <button id="toggle-pinned" class="toggle-pinned" style="margin-left:10px;">Показать только закрепленные</button>
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
        <script src="//js.pusher.com/7.0/pusher.min.js"></script>
        <script src="{{ asset('js/echo.js') }}"></script>
        <script>
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
                emojis.forEach(emoji => { emojiHTML += `<span class="emoji-item">${emoji}</span>`; });
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
            let pinnedOnly = false;
            const currentUserId = window.Laravel.user.id;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Кнопка для фильтра закрепленных сообщений
            const togglePinnedButtonStd = document.getElementById('toggle-pinned');
            togglePinnedButtonStd.addEventListener('click', function(){
                pinnedOnly = !pinnedOnly;
                this.textContent = pinnedOnly ? "Показать все" : "Показать только закрепленные";
                filterMessages();
            });
            function filterMessages(){
                document.querySelectorAll('#chat-messages ul li').forEach(li => {
                    li.style.display = pinnedOnly ? (li.classList.contains('pinned') ? '' : 'none') : '';
                });
            }
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
                        const liClass = isMyMessage ? 'my-message' : 'other-message';
                        const pinnedClass = message.is_pinned ? 'pinned' : '';
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
                        let actionsHtml = '';
                        if (isMyMessage) {
                            actionsHtml = `
                                <div class="message-controls">
                                    <button class="delete-message" data-id="${message.id}"><img src="{{ asset('storage/icon/deleteMesg.svg') }}"></button>
                                    ${message.is_pinned 
                                        ? `<button class="unpin-message" data-id="${message.id}"><img src="${unpinImgUrl}" alt="Открепить"></button>`
                                        : `<button class="pin-message" data-id="${message.id}"><img src="${pinImgUrl}" alt="Закрепить"></button>`
                                    }
                                </div>
                            `;
                        }
                        html += `
                            <li class="${liClass} ${pinnedClass}" data-id="${message.id}">
                                <div><strong>${isMyMessage ? 'Вы' : escapeHtml(message.sender_name || 'Неизвестно')}</strong></div>
                                ${contentHtml}
                                ${actionsHtml}
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
                    attachMessageActionListeners();
                    filterMessages();
                }
            }
            function attachMessageActionListeners() {
                document.querySelectorAll('.delete-message').forEach(button => {
                    button.onclick = function() {
                        const messageId = this.getAttribute('data-id');
                        if (confirm('Удалить сообщение?')) {
                            fetch(`/chats/${currentChatType}/${currentChatId}/messages/${messageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('li').remove();
                                } else {
                                    alert(data.error || 'Ошибка удаления сообщения');
                                }
                            })
                            .catch(error => console.error('Ошибка:', error));
                        }
                    };
                });
                document.querySelectorAll('.pin-message').forEach(button => {
                    button.onclick = function() {
                        const messageId = this.getAttribute('data-id');
                        fetch(`/chats/${currentChatType}/${currentChatId}/messages/${messageId}/pin`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.innerHTML = `<img src="${unpinImgUrl}" alt="Открепить">`;
                                this.classList.remove('pin-message');
                                this.classList.add('unpin-message');
                                let li = this.closest('li');
                                li.classList.add('pinned');
                                if (li && !li.querySelector('.pinned-label')) {
                                    let span = document.createElement('span');
                                    span.classList.add('pinned-label');
                                    span.textContent = ' [Закреплено]';
                                    li.querySelector('div').appendChild(span);
                                }
                                filterMessages();
                            } else {
                                alert(data.error || 'Ошибка закрепления сообщения');
                            }
                        })
                        .catch(error => console.error('Ошибка:', error));
                    };
                });
                document.querySelectorAll('.unpin-message').forEach(button => {
                    button.onclick = function() {
                        const messageId = this.getAttribute('data-id');
                        fetch(`/chats/${currentChatType}/${currentChatId}/messages/${messageId}/unpin`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.innerHTML = `<img src="${pinImgUrl}" alt="Закрепить">`;
                                this.classList.remove('unpin-message');
                                this.classList.add('pin-message');
                                let li = this.closest('li');
                                li.classList.remove('pinned');
                                let pinnedLabel = li.querySelector('.pinned-label');
                                if (pinnedLabel) { pinnedLabel.remove(); }
                                filterMessages();
                            } else { alert(data.error || 'Ошибка открепления сообщения'); }
                        })
                        .catch(error => console.error('Ошибка:', error));
                    };
                });
            }
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
            function sendMessage() {
                if (!currentChatId || (!chatMessageInput.value.trim() && !document.querySelector('.file-input').files[0])) return;
                const message = chatMessageInput.value.trim();
                const fileInput = document.querySelector('.file-input');
                const file = fileInput.files[0];
                let formData = new FormData();
                formData.append('message', message);
                if (file) { formData.append('file', file); }
                fetch(`/chats/${currentChatType}/${currentChatId}/messages`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData,
                })
                .then(r => {
                    if (!r.ok) {
                        return r.text().then(text => { throw new Error(text); });
                    }
                    return r.json();
                })
                .then(data => {
                    if (data.message) {
                        renderMessages([data.message], data.message.sender_id);
                        chatMessageInput.value = '';
                        document.querySelector('.file-input').value = '';
                    }
                })
                .catch(e => console.error('Ошибка при отправке сообщения:', e));
            }
            function markMessagesAsRead(chatId, chatType) {
                fetch(`/chats/${chatType}/${chatId}/mark-read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                }).catch(e => console.error('Ошибка при пометке сообщений как прочитанных:', e));
            }
            function subscribeToChat(chatId, chatType) {
                if(window.Echo) {
                    window.Echo.private(`chat.${chatType}.${chatId}`)
                        .listen('MessageSent', (e) => {
                            renderMessages([e.message], e.message.sender_id);
                            markMessagesAsRead(chatId, chatType);
                        });
                }
            }
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
                    searchResults.style.display = 'none';
                    Array.from(chatList.children).forEach(chat => { chat.style.display = 'flex'; });
                } else {
                    Array.from(chatList.children).forEach(chat => {
                        const chatName = chat.querySelector('h5').textContent.toLowerCase();
                        chat.style.display = chatName.includes(query) ? 'flex' : 'none';
                    });
                    fetch(`/chats/search`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ query: query })
                    })
                    .then(response => response.json())
                    .then(data => {
                        let resultsHTML = '';
                        if (data.chats && data.chats.length > 0) {
                            resultsHTML += '<h5>Чаты</h5><ul>';
                            data.chats.forEach(chat => {
                                resultsHTML += `<li data-chat-id="${chat.id}" data-chat-type="${chat.type}">${chat.name}</li>`;
                            });
                            resultsHTML += '</ul>';
                        }
                        if (data.messages && data.messages.length > 0) {
                            resultsHTML += '<h5>Сообщения</h5><ul>';
                            data.messages.forEach(msg => {
                                let chatId = msg.chat_id;
                                let chatType = "group";
                                if (!chatId) {
                                    chatType = "personal";
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
                        Array.from(searchResults.querySelectorAll('li')).forEach(item => {
                            item.addEventListener('click', function() {
                                const chatId = this.getAttribute('data-chat-id');
                                const chatType = this.getAttribute('data-chat-type');
                                const messageId = this.getAttribute('data-message-id');
                                loadMessages(chatId, chatType);
                                searchInput.value = '';
                                searchResults.style.display = 'none';
                                if (messageId) {
                                    setTimeout(() => {
                                        // Здесь можно реализовать выделение сообщения
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
                    attachButton.addEventListener('click', () => { fileInput.click(); });
                    fileInput.addEventListener('change', () => {
                        if (fileInput.files.length > 0) { sendMessage(); }
                    });
                }
            }
            if (document.readyState !== 'loading') { attachFileListener(); }
            else { document.addEventListener('DOMContentLoaded', attachFileListener); }
            sendMessageButton.addEventListener('click', sendMessage);
            chatMessageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
            });
            initializeEmojiPicker(chatMessageInput);
            document.addEventListener('DOMContentLoaded', () => {
                const firstChat = chatList.querySelector('li');
                if (firstChat) firstChat.click();
            });
            setInterval(() => {
                if (currentChatId && currentChatType) {
                    fetch(`/chats/${currentChatType}/${currentChatId}/new-messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            last_message_id: chatMessagesList.lastElementChild ? parseInt(chatMessagesList.lastElementChild.getAttribute('data-id')) : 0
                        }),
                    })
                    .then(r => {
                        if (!r.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return r.json();
                    })
                    .then(data => {
                        if (data.messages) {
                            renderMessages(data.messages, data.current_user_id);
                            markMessagesAsRead(currentChatId, currentChatType);
                        }
                    })
                    .catch(e => console.error('Ошибка при получении новых сообщений:', e));
                }
            }, 1000); // Проверка новых сообщений каждую секунду
        </script>
    @endif
</body>

