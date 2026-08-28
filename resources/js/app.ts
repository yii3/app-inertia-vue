import { createInertiaApp } from '@inertiajs/vue3'
import { createApp, h, type DefineComponent } from 'vue'

import './styles/app.css'

const pages = import.meta.glob<{ default: DefineComponent }>('./pages/**/*.vue')
const siteTitle = 'Yii 3 + Inertia + Vue'

createInertiaApp({
    progress: {
        color: '#e36e42',
        delay: 180,
        includeCSS: true,
        showSpinner: false,
    },
    resolve: async (name) => {
        const loadPage = pages[`./pages/${name}.vue`]

        if (loadPage === undefined) {
            throw new Error(`Unknown Inertia page: ${name}`)
        }

        return (await loadPage()).default
    },
    setup({ App, el, plugin, props }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
    title: (title) => (title === '' ? siteTitle : `${title} · ${siteTitle}`),
})
