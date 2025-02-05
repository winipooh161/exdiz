// resources/js/chat.js
document.addEventListener('DOMContentLoaded', () => {
let currentChatId = null;
let currentChatType = null;

// Функция подписки на чат
function subscribeToChat(chatId, chatType) {
    currentChatId = chatId;
    currentChatType = chatType;

    if (window.Echo && window.Echo.private) {
        window.Echo.private(`${chatType === 'group' ? 'chat.' : 'user.'}${chatId}`)
            .listen('.message.sent', (e) => {
                handleIncomingMessage(e.message);
            })
            .listen('.messages.read', (e) => {
                // Обработка события прочтения сообщений
                console.log(`Сообщения в чате ${chatId} прочитаны пользователем ${e.userId}`);
            });
    } else {
        console.error('Laravel Echo не инициализирован или метод private недоступен.');
    }
}

// Функция обработки входящих сообщений
function handleIncomingMessage(message) {
    // Проверка текущего чата
    const messageChatId = message.chat_id || message.sender_id;
    const messageChatType = message.chat_id ? 'group' : 'personal';

    if (currentChatId === messageChatId && currentChatType === messageChatType) {
        renderMessages([message], window.Laravel.user.id);
        markMessagesAsRead(currentChatId, currentChatType);
    } else {
        // Увеличиваем счетчик непрочитанных сообщений
        incrementUnreadCount(messageChatId, messageChatType);
        // Отображение встроенного уведомления
        showNotification(message);
        // Используем Toastr и браузерные уведомления
        handleIncomingNotification(message, messageChatType, messageChatId);
    }
    playSoundNotification();
}

// Функции renderMessages, markMessagesAsRead, incrementUnreadCount, showNotification, playSoundNotification должны быть реализованы вами

// Пример реализации функции отображения сообщений
function renderMessages(messages, currentUserId) {
    const messagesContainer = document.getElementById('messages-container');
    messages.forEach(message => {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');
        messageElement.innerHTML = `
            <strong>${message.sender_name}</strong>: ${message.message}
            <span class="timestamp">${message.created_at}</span>
        `;
        messagesContainer.appendChild(messageElement);
    });
}

// Пример реализации функции маркировки сообщений как прочитанных
function markMessagesAsRead(chatId, chatType) {
    axios.post(`/chats/${chatType}/${chatId}/mark-as-read`)
        .then(response => {
            console.log('Сообщения успешно маркированы как прочитанные.');
        })
        .catch(error => {
            console.error('Ошибка при маркировке сообщений как прочитанных:', error);
        });
}

// Пример реализации функции инкремента непрочитанных сообщений
function incrementUnreadCount(chatId, chatType) {
    // Реализуйте логику обновления счетчиков непрочитанных сообщений на интерфейсе
}

// Пример реализации функции отображения уведомлений
function showNotification(message) {
    // Реализуйте логику отображения уведомлений на интерфейсе
}

// Пример реализации функции воспроизведения звука уведомления
function playSoundNotification() {
    const audio = new Audio('/path/to/notification-sound.mp3');
    audio.play();
}
});