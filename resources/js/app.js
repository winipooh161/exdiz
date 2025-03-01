import './bootstrap';
import './chat'; // Импортируем наш chat.js

// Инициализация уведомлений
window.Echo.private(`chat.${window.Laravel.user.id}`)
    .listen('MessageSent', (e) => {
        window.notifyUser('Новое сообщение', e.message.message);
    });

// Импорт стилей Toastr
