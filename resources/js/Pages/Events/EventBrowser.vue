<script setup>
import Events from "@/Components/sections-new/Events.vue";

import eventsBg from "~images/events-bg-1.jpg";

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
});
console.log(props);
</script>

<template>

    <section class="pb-75px">
        <div class="container flex-column align-items-center">
            <p class="sub-title sub-title-lprpl mb-20px">bilety na</p>
            <h3 class="title-1 mb-20px">Przyszłe wydarzenia</h3>
            <Events :events="props.events.data" />
        </div>
    </section>
</template>

<style scoped lang="scss">

</style>
