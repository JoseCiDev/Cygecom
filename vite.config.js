import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel(
            [
                'resources/css/app.css',
                'resources/js/app.js',

                'resources/css/login.css',

                'public/js/plugins/validation/jquery.validate.min.js', // v1.13.1
                'public/js/plugins/validation/additional-methods.min.js' // v1.13.1,
            ]
        ),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: { host: 'localhost'},
        watch: {
            usePolling: true,
        },
        https: false
    },
});
