<script setup>
import { reactive, ref } from "vue";

import Event from "../Partials/Event.vue";

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
});

const scrollContainer = ref(null);
const scrollAmount = 50;

const scrollLeft = () => {
    if (scrollContainer.value) {
        scrollContainer.value.scrollBy(-scrollAmount, 0);
    }
};

const scrollRight = () => {
    if (scrollContainer.value) {
        scrollContainer.value.scrollBy(scrollAmount, 0);
    }
};
</script>
<template>
    <Event :event="event" v-for="event in props.events" :key="event.id"></Event>
</template>

