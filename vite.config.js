import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/css/app.css', 
                'resources/css/login.css', 
                
                // Javascript 
                'resources/js/app.js',
                'resources/js/login.js',
            ],
            refresh: true,
        }),
    ],
});
