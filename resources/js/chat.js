// chat.js
window.Echo.channel('chat')
    .listen('MessageSent', (event) => {
        console.log('Новое сообщение:', event);

        // Проигрываем звук уведомления
        let audio = new Audio('/audio/notification.mp3');
        audio.play().catch((error) => {
            console.error("Ошибка воспроизведения звука:", error);
        });

        // Здесь можно добавить обновление UI: добавить новое сообщение в чат и т.д.
    });
