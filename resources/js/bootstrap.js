/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Удаление Pusher и Echo
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// Добавить поддержку уведомлений
if ('Notification' in window && Notification.permission !== 'granted') {
    Notification.requestPermission();
}

window.notifyUser = function (title, body) {
    if (Notification.permission === 'granted') {
        new Notification(title, { body });
    }
};

// Удаляем инициализацию Firebase
// import { initializeApp } from "firebase/app";
// import { getMessaging, onMessage } from "firebase/messaging";

// const firebaseConfig = {
//     apiKey: "AIzaSyB6N1n8dW95YGMMuTsZMRnJY1En7lK2s2M",
//     authDomain: "dlk-diz.firebaseapp.com",
//     projectId: "dlk-diz",
//     storageBucket: "dlk-diz.firebasestorage.app",
//     messagingSenderId: "209164982906",
//     appId: "1:209164982906:web:0836fbb02e7effd80679c3"
// };

// const app = initializeApp(firebaseConfig);
// const messaging = getMessaging(app);

// onMessage(messaging, (payload) => {
//     console.log('Message received. ', payload);
//     new Notification(payload.notification.title, {
//         body: payload.notification.body,
//         icon: payload.notification.icon
//     });
// });


import 'bootstrap/dist/js/bootstrap.bundle.min.js';

document.addEventListener('DOMContentLoaded', function() {
    // Инициализация компонентов Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
