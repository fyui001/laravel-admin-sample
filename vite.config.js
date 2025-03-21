import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    server: {
        port: 80,
        host: '0.0.0.0',
        hmr: {
            host: 'hmr.admin.localhost'
        }
    },
    plugins: [
        laravel([
            'resources/sass/app.scss',
            'resources/js/app.js',
        ]),
    ],
});
