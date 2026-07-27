import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    base: '/',  // ← Assure-toi que c'est bien '/'
    server: {
        https: false,
        host: '0.0.0.0',
    },
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs'],
                },
            },
        },
    },
});