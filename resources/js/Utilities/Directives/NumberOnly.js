export default {
    beforeMount(el) {
        el._numberOnlyHandler = (e) => {
            const cleaned = e.target.value.replace(/\D+/g, "");
            if (cleaned !== e.target.value) {
                e.target.value = cleaned;
                e.target.dispatchEvent(new Event("input"));
            }
        };
        el.addEventListener("input", el._numberOnlyHandler);
    },
    unmounted(el) {
        el.removeEventListener("input", el._numberOnlyHandler);
    },
};
