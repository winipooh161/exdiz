// vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/bootstrap.js',
                'resources/js/ChatManager.js', 
                'resources/js/emojiPicker.js',
                'resources/js/firebase.js',
                'resources/js/chat.js', 
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
        vue()
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            'firebase/app': path.resolve(__dirname, './node_modules/firebase/app'),
            'firebase/messaging': path.resolve(__dirname, './node_modules/firebase/messaging')
        }
    },
    server: {
        hmr: {
            overlay: false
        },
        cors: {
            origin: 'https://dlk',
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            allowedHeaders: ['Content-Type', 'Authorization'],
            credentials: true
        }
    }
});
