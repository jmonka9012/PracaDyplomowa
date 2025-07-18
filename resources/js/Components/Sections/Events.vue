<script setup>
import Event from "../Partials/Event.vue";

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
});

</script>
<template>
    <Event :event="event" v-for="event in props.events" :key="event.id"></Event>
</template>

