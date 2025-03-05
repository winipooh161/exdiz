class ChatManager {
    constructor(options) {
        this.currentChatId = options.currentChatId;
        this.currentChatType = options.currentChatType;
        this.autoLoad = options.autoLoad || false;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.init();
    }

    init() {
        if (this.autoLoad) {
            this.loadMessages();
        }
    }

    loadMessages() {
        fetch(`/chats/${this.currentChatType}/${this.currentChatId}/messages`)
            .then(response => response.json())
            .then(data => {
                this.renderMessages(data.messages, data.current_user_id);
                this.markMessagesAsRead();
                this.subscribeToChat();
            })
            .catch(error => console.error('Ошибка загрузки сообщений:', error));
    }

    renderMessages(messages, currentUserId) {
        const chatMessagesContainer = document.getElementById('chat-messages');
        const chatMessagesList = chatMessagesContainer.querySelector('ul');
        let html = '';
        messages.forEach(message => {
            const isMyMessage = (message.sender_id === currentUserId);
            const liClass = message.message_type === 'notification' 
                ? 'notification-message' 
                : (isMyMessage ? 'my-message' : 'other-message');
            const pinnedClass = message.is_pinned ? 'pinned' : '';
            let readStatus = '';
            if (isMyMessage && message.is_read) {
                readStatus = '<span class="read-status">✓✓</span>';
            }
            let contentHtml = '';
            if (message.message && message.message.trim() !== '') {
                if (message.message_type === 'notification') {
                    contentHtml += message.message; // Вставляем HTML для уведомлений
                } else {
                    contentHtml += `<div>${this.escapeHtml(message.message)}</div>`;
                }
            }
            if (message.attachments && message.attachments.length > 0) {
                message.attachments.forEach(attachment => {
                    if (attachment.mime && attachment.mime.startsWith('image/')) {
                        contentHtml += `<div><img src="${attachment.url}" alt="Image" style="max-width:100%; border-radius:4px;"></div>`;
                    } else {
                        contentHtml += `<div><a href="${attachment.url}" target="_blank">${this.escapeHtml(attachment.original_file_name)}</a></div>`;
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
                        <button class="delete-message" data-id="${message.id}"><img src="${window.deleteImgUrl}" alt="Удалить"></button>
                        ${message.is_pinned 
                            ? `<button class="unpin-message" data-id="${message.id}"><img src="${window.unpinImgUrl}" alt="Открепить"></button>`
                            : `<button class="pin-message" data-id="${message.id}"><img src="${window.pinImgUrl}" alt="Закрепить"></button>`
                        }
                    </div>
                `;
            }
            html += `
                <li class="${liClass} ${pinnedClass}" data-id="${message.id}">
                    <div><strong>${isMyMessage ? 'Вы' : this.escapeHtml(message.sender_name || 'Неизвестно')}</strong></div>
                    ${contentHtml}
                    ${actionsHtml}
                    <span class="message-time">${this.formatTime(message.created_at)}</span>
                    ${readStatus}
                </li>
            `;
        });
        if (html) {
            chatMessagesList.insertAdjacentHTML('beforeend', html);
            this.scrollToBottom();
            this.attachMessageActionListeners();
        }
    }

    escapeHtml(text) {
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    formatTime(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });
    }

    scrollToBottom() {
        const chatMessagesContainer = document.getElementById('chat-messages');
        chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
    }

    attachMessageActionListeners() {
        document.querySelectorAll('.delete-message').forEach(button => {
            button.onclick = () => {
                const messageId = button.getAttribute('data-id');
                if (confirm('Удалить сообщение?')) {
                    fetch(`/chats/${this.currentChatType}/${this.currentChatId}/messages/${messageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            button.closest('li').remove();
                        } else {
                            alert(data.error || 'Ошибка удаления сообщения');
                        }
                    })
                    .catch(error => console.error('Ошибка:', error));
                }
            };
        });
        document.querySelectorAll('.pin-message').forEach(button => {
            button.onclick = () => {
                const messageId = button.getAttribute('data-id');
                fetch(`/chats/${this.currentChatType}/${this.currentChatId}/messages/${messageId}/pin`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.innerHTML = `<img src="${window.unpinImgUrl}" alt="Открепить">`;
                        button.classList.remove('pin-message');
                        button.classList.add('unpin-message');
                        let li = button.closest('li');
                        li.classList.add('pinned');
                        if (li && !li.querySelector('.pinned-label')) {
                            let span = document.createElement('span');
                            span.classList.add('pinned-label');
                            span.textContent = ' [Закреплено]';
                            li.querySelector('div').appendChild(span);
                        }
                    } else {
                        alert(data.error || 'Ошибка закрепления сообщения');
                    }
                })
                .catch(error => console.error('Ошибка:', error));
            };
        });
        document.querySelectorAll('.unpin-message').forEach(button => {
            button.onclick = () => {
                const messageId = button.getAttribute('data-id');
                fetch(`/chats/${this.currentChatType}/${this.currentChatId}/messages/${messageId}/unpin`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.innerHTML = `<img src="${window.pinImgUrl}" alt="Закрепить">`;
                        button.classList.remove('unpin-message');
                        button.classList.add('pin-message');
                        let li = button.closest('li');
                        li.classList.remove('pinned');
                        let pinnedLabel = li.querySelector('.pinned-label');
                        if (pinnedLabel) { pinnedLabel.remove(); }
                    } else { alert(data.error || 'Ошибка открепления сообщения'); }
                })
                .catch(error => console.error('Ошибка:', error));
            };
        });
    }

    markMessagesAsRead() {
        fetch(`/chats/${this.currentChatType}/${this.currentChatId}/mark-read`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': this.csrfToken },
        }).catch(e => console.error('Ошибка при пометке сообщений как прочитанных:', e));
    }

    subscribeToChat() {
        if(window.Echo) {
            window.Echo.private(`chat.${this.currentChatType}.${this.currentChatId}`)
                .listen('MessageSent', (e) => {
                    this.renderMessages([e.message], e.message.sender_id);
                    this.markMessagesAsRead();
                });
        }
    }
}

export default ChatManager;
