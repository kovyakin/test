import {createApp} from 'vue';

import Tasks from '@/components/tasks.vue';

import PrimeVue from 'primevue/config';

import Aura from '@primevue/themes/aura';

const tasks = createApp({});

tasks.component('tasks-form', Tasks);
tasks.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            prefix: 'p',
            darkModeSelector: '.my-app-dark',
            cssLayer: {
                name: 'primevue',
                order: 'tailwind-base, primevue, tailwind-utilities'
            }
        }
    }
});

tasks.mount('#tasks');