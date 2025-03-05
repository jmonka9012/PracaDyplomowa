<script setup>
//import { route } from '../../../vendor/tightenco/ziggy';
import { Link } from '@inertiajs/vue3';

// Pobieranie props w <script setup>
defineProps({
    message: String
});


</script>

<template>
    <div>
        <h1>{{ message }}</h1>
        <Link :href="route('register')">Rejestracja</Link>
    </div>
</template>
