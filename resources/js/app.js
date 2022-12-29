import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import MainLayout from "./Layouts/MainLayout.vue"

createInertiaApp({
    resolve: name => {
        // récupération de la page
        let page = require(`./Pages/${name}`).default
        // si pas de layout alors la page mainlayout est la page par default (page parent et layout persistant)
        // if (page.layout == null) {
        //     page.layout = MainLayout
        // }
        // en 1 ligne :
        page.layout ??= MainLayout
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
