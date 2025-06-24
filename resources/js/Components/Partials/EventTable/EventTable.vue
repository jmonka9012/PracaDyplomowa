<script setup>
import EventTableRow from "./EventTableRow.vue";
import EventTableHead from "./EventTableHead.vue";

const props = defineProps({
    events: {
        required: true,
        type: Array,
    },
    pending: {
        required: false,
        type: Boolean,
    }
});
</script>

<template>
    <table class="table-nowrap table-fixed">
        <thead><EventTableHead></EventTableHead></thead>
        <tbody>
        <EventTableRow :pending="props.pending" v-for="(event, index) in events" :key="event" :index="index" :event="event"></EventTableRow>
        </tbody>
        <tfoot><EventTableHead></EventTableHead></tfoot>
    </table>
</template>

<style scoped lang="scss">

</style>
