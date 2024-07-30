import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            // input: [
            //     'resources/sass/app.scss',
            //     'resources/js/app.js'
            //     // 'resources/css/loader.css'
            // ]

            input: 'resources/js/app.js',
            sass: {
                includePaths: ['node_modules'],
            },
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
