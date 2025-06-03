import '../css/app.css';
import './bootstrap';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Swal from 'sweetalert2';
import { createApp, h } from 'vue';

import { library } from '@fortawesome/fontawesome-svg-core'
import { faFacebook, faInstagram, faWhatsapp } from '@fortawesome/free-brands-svg-icons'
import { faAngleDown, faChevronDown, faUser } from '@fortawesome/free-solid-svg-icons'
import { faClock, faEnvelope, faLocationDot, faPhone } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { createInertiaApp } from '@inertiajs/vue3';

import { ZiggyVue } from '../../vendor/tightenco/ziggy';

window.Swal = Swal;


library.add(faUser, faChevronDown, faAngleDown,faPhone, faEnvelope, faClock, faFacebook, faInstagram, faWhatsapp, faLocationDot);


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
