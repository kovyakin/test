import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import {fileURLToPath, URL} from 'node:url';
import inheritAttrs from 'vite-plugin-vue-setup-inherit-attrs';

export default defineConfig({

    plugins: [
        vue(),
        laravel({
            input: [

                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/src/pages/tasks.js',
                'resources/js/src/pages/tags.js',
                'resources/sass/app.scss',
            ],
            refresh: true,
        }),
        inheritAttrs(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js/src', import.meta.url)),
            'vue': 'vue/dist/vue.esm-bundler.js'
        }
    }
});
