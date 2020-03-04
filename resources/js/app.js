window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.moment = require('moment');

import Vue from 'vue'
import PortalVue from 'portal-vue'
import {InertiaApp} from '@inertiajs/inertia-vue'
import InputVal from "./Shared/InputVal";

Vue.config.productionTip = false;
Vue.use(InertiaApp);
Vue.use(PortalVue);
Vue.component(InputVal);


Vue.directive('click-away', {
    bind: function (el, binding, vNode) {
        // Provided expression must evaluate to a function.
        if (typeof binding.value !== 'function') {
            const compName = vNode.context.name
            let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
            if (compName) {
                warn += `Found in component '${compName}'`
            }

            console.warn(warn)
        }
        // Define Handler and cache it on the element
        const bubble = binding.modifiers.bubble
        const handler = (e) => {
            if (bubble || (!el.contains(e.target) && el !== e.target)) {
                binding.value(e)
            }
        }
        el.__vueClickOutside__ = handler

        // add Event Listeners
        document.addEventListener('click', handler)
    },

    unbind: function (el, binding) {
        // Remove Event Listeners
        document.removeEventListener('click', el.__vueClickOutside__)
        el.__vueClickOutside__ = null

    }
});

Vue.mixin({
    methods: {
        route: window.route,
        snackbar: (obj) => {
            if (typeof obj === "string") {
                obj = {text: obj};
            }

            obj = Object.assign({
                pos: 'bottom-right',
                showAction: false
            }, obj);

            Snackbar.show(obj)
        }
    }
});


let app = document.getElementById('app');

new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(app);
