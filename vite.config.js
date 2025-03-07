import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [/*'resources/css/app-old.scss', css trzeba naprawic, na razie nie dziala*/'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ]/*,
    server: {
        hmr: {
            host: 'localhost',
        }
    }*/
});


