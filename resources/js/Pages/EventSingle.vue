<script setup>
import { onMounted } from 'vue';

const props = defineProps({
    event: Object
});

onMounted(() => {
    console.log('Props received:', props);
    console.log('Event data:', props.event);
});
</script>

<template>
    <div>
        <h1>Event Data Debug</h1>

        <div v-if="event">
            <h2>Raw Props:</h2>
            <pre>{{ $props }}</pre>

            <h2>Event Data:</h2>
            <pre>{{ event }}</pre>

            <h2>Individual Fields:</h2>
            <ul>
                <li><strong>ID:</strong> {{ event.data.id }}</li>
                <li><strong>Name:</strong> {{ event.data.event_name }}</li>
                <li><strong>Date:</strong> {{ event.data.event_date }}</li>
                <li><strong>Description:</strong> {{ event.data.event_description }}</li>
                <!-- Add other fields as needed -->
            </ul>
        </div>

        <div v-else>
            Loading event data...
        </div>
    </div>
</template>

<style scoped>
pre {
    background: #f4f4f4;
    padding: 1rem;
    border-radius: 4px;
    max-width: 100%;
    overflow-x: auto;
}
ul {
    list-style: none;
    padding: 0;
}
li {
    margin-bottom: 0.5rem;
}
</style>
