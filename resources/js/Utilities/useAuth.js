import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export default function useAuth() {
    const user = computed(() => usePage().props.auth.user)
    const isLoggedIn = computed(() => !!user.value)

    return {
        user,
        isLoggedIn
    }
}
