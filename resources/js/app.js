import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp, router } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy-js";
import MainLayout from "@/Layouts/MainLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import numberOnly from "./Utilities/Directives/NumberOnly.js";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        const page = pages[`./Pages/${name}.vue`];

        const isBackendRoute = name.startsWith('Admin/');

        page.default.layout = isBackendRoute
            ? AdminLayout
            : MainLayout;

        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin).use(ZiggyVue);

        app.directive("number-only", numberOnly);

        app.mount(el);
    },
});

function setCurrentPage() {
    const links = document.querySelectorAll('a');

    const normalizePath = (path) => {
        let p = path.replace(/\/$/, '');
        return p === '' ? '/' : p;
    };

    const currentPath = normalizePath(window.location.pathname);

    links.forEach(link => {
        const url = new URL(link.getAttribute('href') || '', window.location.origin);
        const linkPath = normalizePath(url.pathname);

        if (linkPath === currentPath) {
            link.setAttribute('aria-current', 'page');
        } else {
            link.removeAttribute('aria-current');
        }
    });
}

document.addEventListener('DOMContentLoaded', setCurrentPage);


setTimeout(()=> {
    setCurrentPage();
}, 50);
router.on('finish', () => {
    setCurrentPage();
});


