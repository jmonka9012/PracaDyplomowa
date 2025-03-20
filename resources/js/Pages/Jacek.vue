<script setup>
import useAuth from '@/Composables/useAuth'

const { user, isLoggedIn } = useAuth()
</script>

<template>
    <div>
        <div v-if="user">
            <h1>Twój poziom uprawnień: {{ user.permission_level }}</h1>
            <h1>Nazwa: {{ user.name }}</h1>
        </div>
        <h1 v-else>
            Nie jesteś zalogowany
        </h1>
    </div>
</template>
