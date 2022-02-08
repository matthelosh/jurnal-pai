require('./bootstrap');

import Vue from 'vue'
import vuetify from './plugins/vuetify'
import { createInertiaApp, Link } from '@inertiajs/inertia-vue'
Vue.component('inertia-link', Link)
createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)

        new Vue({
            vuetify,
            render: h => h(App, props),
        }).$mount(el)
    },
})
