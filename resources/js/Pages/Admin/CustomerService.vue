z<script setup>
import blogBg from "~images/blog-bg.jpg";
import {Link, router} from "@inertiajs/vue3";
import {onMounted, ref, computed} from "vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import Collapse from "../../Components/Partials/Collapse.vue";
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";
import Order from "../../Components/Partials/OrderCollapse.vue";

const activeTicketId = ref(null);
const ticket = ref(null);

const props = defineProps({
    support_tickets: { //rename?
        type: Array,
        required: true,
    },
    orders: {
        type: Array,
        required: true,
    }
});

const currentUserID = ref(null);
const currentUserName = computed(() => {
    if (!currentUserID.value) return null;

    const ticket = props.support_tickets.data.find(
        (t) => t.user_id == currentUserID.value
    );

    return ticket?.name || "Nieznany użytkownik";
});

onMounted(() => {
    console.log(props);
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
            <Tabs>
                <Tab title="Zgłoszenia kontaktowe">
                    <h2 class="mb-30px">
                        Zgłoszenia kontaktowe
                        <span v-if="currentUserID">od: {{ currentUserName }}</span>
                    </h2>
                    <Link
                        v-if="currentUserID"
                        :href="route('admin.customer-service')"
                        class="btn btn-md mb-30px"
                        preserve-scroll
                    >Wróć do wszystkich zgłoszeń
                    </Link>
                    <div class="ticket-query mb-40px">
                        <div
                            v-for="ticket in props.support_tickets.data"
                            class="ticket-query__ticket"
                        >
                            <div>{{ ticket.topic }}</div>
                            <Link
                                v-if="ticket.user_id"
                                :data="{ user_id: ticket.user_id }"
                                :href="route('admin.customer-service')"
                                :only="['support_tickets']"
                                method="get"
                                class="hover-underline"
                                preserve-scroll
                            >
                                {{ ticket.name }}
                            </Link>
                            <div v-else>{{ ticket.name }}</div>
                            <div>{{ ticket.created_at }}</div>
                            <div>{{ ticket.email }}</div>
                            <div class="relative">
                                <div
                                    :class="{
                                'in-progress': ticket.status === 'in_progress',
                                closed: ticket.status === 'closed',
                            }"
                                    class="ticket-query__status"
                                    v-html="
                                ticket.status === 'in_progress'
                                    ? 'W trakcie rozpatrywania'
                                    : 'Zamknięte'
                            "
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
                                    <button class="btn btn-md btn-ghost">
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
                                class="post-list-item-popup-holder"
                                @click.self="activeTicketId = null"
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
                                                :class="{
                                            'in-progress':
                                                ticket.status === 'in_progress',
                                            closed: ticket.status === 'closed',
                                        }"
                                                class="ticket-query__status"
                                                v-html="
                                            ticket.status === 'in_progress'
                                                ? 'W trakcie rozpatrywania'
                                                : 'Zamknięte'
                                        "
                                            ></div>
                                            <Link
                                                :data="{
                                            id: ticket.id,
                                            status: SwapStatus(ticket.status),
                                        }"
                                                :href="
                                            route(
                                                'admin.customer-service.change_status',
                                                {
                                                    id: ticket.id,
                                                }
                                            )
                                        "
                                                class="ticket-query__status-change"
                                                method="put"
                                                preserve-scroll
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
                    <div class="event-pagination" v-if="props.support_tickets.meta.links.length > 3">
                        <ul class="ml-auto mr-auto">
                            <li
                                v-for="page in props.support_tickets.meta.links"
                                :key="page"
                                :class="{ 'page-current': page.active }"
                                class="page"
                            >
                                <Link :href="page.url" v-html="page.label"></Link>
                            </li>
                        </ul>
                    </div>
                </Tab>
                <Tab title="Wyszukaj zamówienie">
                    <h2 class="mb-30px">Wyszukaj zamówienie</h2>
                    <p>W pole poniżej wpisz email lub unikalny numer szukanego biletu</p>
                    <form
                        class="mb-40px form"
                        @submit.prevent="router.get(route('admin.customer-service'), {tabName: 'Wyszukaj zamówienie',order_lookup: ticket}, { preserveScroll: true })">
                        <div class="input-wrap col-12 row-gap-20px">
                              <input v-model="ticket" type="text">  <input type="submit" value="Szukaj">
                        </div>


                    </form>
                    <div class="d-grid row-gap-10px">
                        <Order :admin="true" :order="order" v-for="order in props.orders.data" :key="order.order_id"></Order>
                    </div>
                </Tab>
            </Tabs>
        </div>
    </section>
</template>

<style lang="scss" scoped>
@use "~css/mixin.scss";

.ticket-query {
    &__ticket {
        display: grid;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: var(--primary);
        padding: 20px;
        grid-template-columns: 1fr 1fr 100px 1fr 1fr;
        align-items: center;
        grid-column-gap: 30px;
        @include mixin.media-breakpoint-down(xl) {
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
        padding: 16px 8px;
        font-size: 16px;
        line-height: 1.2;
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
