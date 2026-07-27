import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            publicDirectory: 'public',
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                entryFileNames: `assets/app.js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/app.css`
            }
        }
    }
});