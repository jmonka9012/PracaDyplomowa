<script setup>
import blogBg from "~images/blog-bg.jpg";
import {Link} from "@inertiajs/vue3";
import HeroSmall from "@/Components/Sections/Hero-small.vue";

const props = defineProps({
    tickets: {
        type: Array,
        required: true,
    }
});

function FilterByUser(ticket) {
    if (ticket.user_id) {
        return
    } else {
        return null;
    }
}

console.log(props.tickets)

</script>

<template>
    <HeroSmall :source="blogBg" title="Obsługa klienta"></HeroSmall>
    <section class="pb-100px">
        <div class="container flex-column">
            <h2 class="mb-40px">Zgłoszenia kontaktowe</h2>
            <div class="ticket-query mb-40px">
                <div class="ticket-query__ticket" v-for="ticket in props.tickets.data">
                    <div>{{ ticket.topic }}</div>
                    <Link
                        v-if="ticket.user_id"
                        :href="`/admin/obsluga-klienta?user_id=${ticket.user_id}`"
                        method="get"
                    >
                        {{ ticket.name }}
                    </Link>
                    <div v-else>{{ ticket.name }}</div>
                    <div>{{ ticket.created_at }}</div>
                    <div>{{ ticket.email }}</div>
                    <div
                        v-html="ticket.status === 'in_progress' ? 'W trakcie rozpatrywania' : 'Zamknięte'  "
                        :class="{ 'in-progress' : ticket.status === 'in_progress', 'closed' : ticket.status === 'closed' }"
                        class="ticket-query__status"></div>
                    <div>{{ ticket.message }}</div>
                </div>
            </div>
            <div class="event-pagination">
                <ul class="ml-auto mr-auto">
                    <li
                        :key="page"
                        class="page"
                        :class="{ 'page-current': page.active }"
                        v-for="page in props.tickets.meta.links"
                    >
                        <Link :href="page.url" v-html="page.label"></Link>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">

.ticket-query {
    &__ticket {
        display: grid;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: var(--primary);
        padding: 20px;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;

        div:nth-child(6) {
            margin-top: 20px;
            grid-column: 1/-1;
        }
    }
}

</style>
