import {createApp} from 'vue';

import Tags from '@/components/tags.vue';

import PrimeVue from 'primevue/config';

import Aura from '@primevue/themes/aura';

const tags = createApp({});

tags.component('tags-form', Tags);
tags.use(PrimeVue, {
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

tags.mount('#tags');