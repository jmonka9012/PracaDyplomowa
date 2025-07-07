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


    links.forEach((link) => {
        if (window.location.pathname === link.pathname) {
            link.setAttribute('aria-current', 'page');
        }
    });
}

setTimeout(()=> {
    setCurrentPage();
}, 50);
router.on('finish', () => {
    setCurrentPage();
});


