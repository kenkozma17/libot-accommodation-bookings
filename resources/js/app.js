import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/vue-tel-input.css';
import VCalendar from 'v-calendar';
import 'v-calendar/style.css';
import { createVfm } from 'vue-final-modal';
import 'vue-final-modal/style.css';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const vfm = createVfm();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueTelInput)
            .use(VCalendar, {})
            .use(pinia)
            .use(vfm)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
