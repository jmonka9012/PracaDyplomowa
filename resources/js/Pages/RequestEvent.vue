<script setup>
import useAuth from '@/Composables/useAuth'

const { user, isLoggedIn } = useAuth()
</script>

<template>
    <section>
        <div class="container">
            <h1>Formularz dodawania eventów</h1>
        </div>
    </section>
</template>
