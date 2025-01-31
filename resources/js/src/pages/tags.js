import {createApp} from 'vue';

import Tags from '@/components/tags.vue';

import PrimeVue from 'primevue/config';

import Aura from '@primevue/themes/aura';

import ToastService from 'primevue/toastservice';

import ConfirmationService from 'primevue/confirmationservice';

const tags = createApp({});

tags.component('tags-form', Tags);
tags.use(ToastService);
tags.use(ConfirmationService);

tags.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            prefix: 'p',
            darkModeSelector: '.my-app-dark',
            cssLayer: false
        }
    }

});

tags.mount('#tags');