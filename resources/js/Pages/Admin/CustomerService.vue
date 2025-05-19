<script setup>
import blogBg from "~images/blog-bg.jpg";
import { Link } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import Collapse from "../../Components/Partials/Collapse.vue";

const activeTicketId = ref(null);

const props = defineProps({
    tickets: {
        type: Array,
        required: true,
    },
});

const currentUserID = ref(null);
const currentUserName = computed(() => {
    if (!currentUserID.value) return null;

    const ticket = props.tickets.data.find(
        (t) => t.user_id == currentUserID.value
    );

    return ticket?.name || "Nieznany użytkownik";
});

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    currentUserID.value = params.get("user_id");
});

const SwapStatus = (status) => {
    return status === "closed" ? "in_progress" : "closed";
};
</script>

<template>
    <HeroSmall :source="blogBg" title="Obsługa klienta"></HeroSmall>
    <section class="pb-100px col-12">
        <div class="container flex-column">
            <h2 class="mb-30px">
                Zgłoszenia kontaktowe
                <span v-if="currentUserID">od: {{ currentUserName }}</span>
            </h2>
            <Link
                v-if="currentUserID"
                preserve-scroll
                class="btn btn-md mb-30px"
                :href="route('admin.customer-service')"
                >Wróć do wszystkich zgłoszeń
            </Link>
            <div class="ticket-query mb-40px">
                <div
                    class="ticket-query__ticket"
                    v-for="ticket in props.tickets.data"
                >
                    <div>{{ ticket.topic }}</div>
                    <Link
                        v-if="ticket.user_id"
                        :href="route('admin.customer-service')"
                        :data="{ user_id: ticket.user_id }"
                        method="get"
                    >
                        {{ ticket.name }}
                    </Link>
                    <div v-else>{{ ticket.name }}</div>
                    <div>{{ ticket.created_at }}</div>
                    <div>{{ ticket.email }}</div>
                    <div class="relative">
                        <div
                            v-html="
                                ticket.status === 'in_progress'
                                    ? 'W trakcie rozpatrywania'
                                    : 'Zamknięte'
                            "
                            :class="{
                                'in-progress': ticket.status === 'in_progress',
                                closed: ticket.status === 'closed',
                            }"
                            class="ticket-query__status"
                        ></div>
                        <button
                            class="ticket-query__status-change"
                            @click="activeTicketId = ticket.id"
                        >
                            Zmienić status?
                        </button>
                    </div>
                    <Collapse class="w-100">
                        <template #trigger="{ isOpen }">
                            <button class="btn btn-md">
                                {{
                                    isOpen
                                        ? "Zwiń wiadomość"
                                        : "Rozwiń wiadomość"
                                }}
                            </button>
                        </template>
                        <div class="content pt-20px">
                            <p>{{ ticket.message }}</p>
                        </div>
                    </Collapse>
                    <!-- popup -->
                    <div
                        v-if="activeTicketId === ticket.id"
                        @click.self="activeTicketId = null"
                        class="post-list-item-popup-holder"
                    >
                        <div class="post-list-item-popup">
                            <button
                                class="popup__close"
                                @click="activeTicketId = null"
                            >
                                <i class="fa fa-close"></i>
                            </button>
                            <p class="mb-30px text-align-center col-12">
                                Potwierdź zmianę statusu.
                            </p>

                            <div class="d-flex flex-row justify-content-center">
                                <div class="relative">
                                    <div
                                        v-html="
                                            ticket.status === 'in_progress'
                                                ? 'W trakcie rozpatrywania'
                                                : 'Zamknięte'
                                        "
                                        :class="{
                                            'in-progress':
                                                ticket.status === 'in_progress',
                                            closed: ticket.status === 'closed',
                                        }"
                                        class="ticket-query__status"
                                    ></div>
                                    <Link
                                        method="put"
                                        :href="
                                            route(
                                                'admin.customer-service.change_status',
                                                {
                                                    id: ticket.id,
                                                }
                                            )
                                        "
                                        class="ticket-query__status-change"
                                        preserve-scroll
                                        :data="{
                                            id: ticket.id,
                                            status: SwapStatus(ticket.status),
                                        }"
                                    >
                                        Potwierdzam
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- popup end -->
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
@use "~css/mixin.scss";
.ticket-query {
    &__ticket {
        display: grid;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: var(--primary);
        padding: 20px;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        align-items: center;
        @include mixin.media-breakpoint-down(lg) {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            row-gap: 10px;
        }

        div:nth-child(6) {
            margin-top: 20px;
            grid-column: 1/-1;
        }
    }

    &__status {
        padding: 8px 16px;
        border-radius: 8px;
        position: relative;

        &-change {
            position: absolute;
            padding: 8px 16px;
            border-radius: 8px;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background-color: white;
            text-align: center;
            opacity: 0;
            transition: opacity 0.4s ease-out;

            &:hover {
                opacity: 1;
            }
        }

        &.in-progress {
            background-color: var(--yellow);
        }

        &.closed {
            background-color: #73f0ad;
        }
    }
}
</style>
