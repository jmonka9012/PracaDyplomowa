import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export default function useAuth() {
    const siteData = computed(() => usePage().props.site_data)

    return {
        siteData,
    }
}
