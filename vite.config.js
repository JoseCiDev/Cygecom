import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel(
            [
                'resources/css/app.css',
                'resources/js/app.js',

                'resources/css/login.css',
            ]
        ),
    ],
    server: {
        port: 5173,
        hmr: { host: 'localhost'},
        watch: {
            usePolling: true,
        },
        https: true
    },
});
