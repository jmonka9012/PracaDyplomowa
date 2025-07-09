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
    <table class="table--event table-nowrap">
        <thead><EventTableHead :pending="props.pending"></EventTableHead></thead>
        <tbody>
        <EventTableRow :pending="props.pending" v-for="(event, index) in events" :key="event" :index="index" :event="event"></EventTableRow>
        </tbody>
        <tfoot><EventTableHead :pending="props.pending"></EventTableHead></tfoot>
    </table>
</template>

<style scoped lang="scss">

</style>
