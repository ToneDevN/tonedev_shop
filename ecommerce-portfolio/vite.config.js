import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // สำคัญ: เพื่อให้เข้าถึงจากนอก Container ได้
        port: 5173,
        hmr: {
            host: 'localhost', // พอร์ตที่ Browser จะวิ่งไปหา Hot Reload
        },
        watch: {
            usePolling: true, // สำหรับ Windows/WSL เพื่อให้แก้ไขไฟล์แล้วเปลี่ยนทันที
        },
    },
});
