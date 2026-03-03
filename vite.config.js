import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        host: '0.0.0.0', // Agar bisa diakses dari luar localhost
        hmr: {
            // Hapus 'https://' dari sini karena Vite akan menambahkannya secara otomatis
            host: 'semzzdev.qzz.io', 
            protocol: 'wss', // Gunakan Secure Web Sockets untuk Cloudflare
        },
    },
});
