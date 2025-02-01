import {createApp} from 'vue';

import Tasks from '@/components/tasks.vue';

import PrimeVue from 'primevue/config';

import Aura from '@primevue/themes/aura';

import ToastService from 'primevue/toastservice';

import ConfirmationService from 'primevue/confirmationservice';

const tasks = createApp({});

tasks.component('tasks-form', Tasks);
tasks.use(ToastService);
tasks.use(ConfirmationService);

tasks.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            prefix: 'p',
            darkModeSelector: '.my-app-dark',
            cssLayer: false
        }
    }
});

tasks.mount('#tasks');