import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [{
                paths: ['resources/views/**', 'config/**', 'app/Http/Controllers/**'],
                config: {delay: 300}
            }]
        }),

    ],
    server: {
        cors: true,
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
            port: 5173,
        },
    }
});
