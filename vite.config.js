// vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/chat.js', // Удалите этот входной файл
                'resources/css/style.css',
                'resources/css/font.css',
                'resources/css/element.css',
                'resources/css/animation.css',
                'resources/css/mobile.css',
                'resources/js/modal.js',
                'resources/js/success.js',
                'resources/js/login.js',
                'resources/js/mask.js',
                'public/js/jquery-3.6.0.min.js',
                'public/js/wow.js',
                'public/css/animate.css', 
            ],
            refresh: true,
        }),
    ],
});
