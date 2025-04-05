<script setup>
import useAuth from '@/Utilities/useAuth'

const { user, isLoggedIn } = useAuth()

const props = defineProps({
    halls: {
        type: Array,
        required: true
    }
})

</script>

<template>
    <section>
        <div class="container" v-if="user">
            <h1>Twój poziom uprawnień: {{ user.permission_level }}</h1>
            <h1>Nazwa: {{ user.name }}</h1>
        </div>
        <div class="container">
            <div v-for="hall in halls" :key="hall.id">
                <h3>{{ hall.hall_name }}</h3>
                <h1>{{ hall.seat_capacity }}</h1>
                <h1>{{ hall.stand_capacity }}</h1>
                <h1>{{ hall.hall_price }}</h1>
                <div v-for="section in hall.sections" :key="section.id">
                    <p>{{section.section_name}}</p>
                    <p>{{section.section_type}}</p>
                    <p>{{section.col}}</p>
                    <p>{{section.row}}</p>
                </div>
            </div>
        </div>
    </section>
</template>
