require('./bootstrap');

import Vue from 'vue'
import vuetify from './plugins/vuetify'
import { createInertiaApp, Link } from '@inertiajs/inertia-vue'
import { InertiaProgress}  from '@inertiajs/progress'
import VueQuillEditor from 'vue-quill-editor'
import ImageResize from 'quill-image-resize-module'
Quill.register('modules/imageResize', ImageResize)

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import moment from 'moment'
import { VSubheader } from 'vuetify/lib';

Vue.use(VueQuillEditor)
Vue.use(moment)

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
