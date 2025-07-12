<script setup>
import Collapse from "./Collapse.vue";
import {router} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    admin: {
        type: Boolean,
        required: false,
    },
    order: {
        type: Object,
        required: true
    }
})

const isOpen = ref(false);

function ReturnStatus(status) {
    if (status === 'paid') {
        return 'Opłacone';
    } else if (status === 'cancelled') {
        return 'Anulowane'
    } else {
        return "Oczekujące"
    }
}

function CancelTicket(tID) {
    router.put(route('admin.customer-service.cancel-ticket', {id: tID}), {id: tID}, {
        preserveScroll: true,
        only: ['orders'],
        onSuccess: (page) => {
            console.log(page);
        },
        onError: (err) => {
            console.log(err);
        }
    })
}

function CancelOrder(oID) {
    console.log(oID);
    router.put(route('admin.customer-service.cancel-ticket', {order: oID}), {order_id: oID}, {
        preserveScroll: true,
        only: ['orders'],
        onSuccess: (page) => {
            console.log(page);
        },
        onError: (err) => {
            console.log(err);
        }
    })
}

const handleToggle = (state) => {
    isOpen.value = state;
}

</script>

<template>
    <Collapse :class="{open: isOpen}" @toggle="handleToggle" class="w-100 order-collapse">
        <template #trigger="{ isOpen }">
            <div :class="{paid: order.payment_status === 'paid', cancelled: order.payment_status === 'cancelled', pending: order.payment_status === 'pending', open: isOpen}" class="col-12 order-collapse__toggle">
                <span class="d-none">{{isOpen ? "Zwiń wiadomość" : "Rozwiń wiadomość"}}</span>
                <div v-if="props.admin">
                    <div class="order-collapse__toggle-label">Nabywca</div>
                    <div>{{order.email}}</div>
                </div>
                <div v-else>
                    <div class="order-collapse__toggle-label">Wydarzenie</div>
                    <div>{{order.event.name}}</div>
                </div>
                <div>
                    <div class="order-collapse__toggle-label">Numer zamówienia</div>
                    <div>{{order.order_number}}</div>
                </div>
                <div>
                    <div class="order-collapse__toggle-label">Status</div>
                    <div>{{ReturnStatus(order.payment_status)}}</div>
                </div>
            </div>
        </template>
        <div class="order-collapse__content mb-20px">
            <div class="order-collapse__row">
                <div>Wydarzenie</div>
                <a :href="`/${order.event.event_url}`" class="" target="_blank">{{ order.event.name }}</a>
            </div>
            <div class="order-collapse__row">
                <div>created at</div>
                <div>{{ order.created_at }}</div>
            </div>
            <div class="order-collapse__row">
                <div>e-mail</div>
                <div>{{ order.email }}</div>
            </div>
            <div class="order-collapse__row">
                <div>Imie</div>
                <div>{{ order.first_name }}</div>
            </div>
            <div class="order-collapse__row">
                <div>Nazwisko</div>
                <div>{{ order.last_name }}</div>
            </div>
            <div class="order-collapse__row">
                <div>Nr. zamówienia</div>
                <div>{{ order.order_number }}</div>
            </div>
            <div class="order-collapse__row">
                <div>Status płatnosci</div>
                <div v-html="ReturnStatus(order.payment_status)"></div>
            </div>
            <div class="order-collapse__row">
                <div>Łączna cena</div>
                <div>{{ order.total_price }}</div>
            </div>
            <div v-if="order.payment_status !== 'cancelled'" class="mb-10px">
                <div>Wykupione miejsca</div>
                <div :class="{'order-collapse__tickets--admin': props.admin }" class="order-collapse__tickets">
                    <div>Sekcja</div>
                    <div>Rząd</div>
                    <div>Miejsce</div>
                    <div>Cena</div>
                    <div v-if="props.admin">Akcja</div>
                </div>
                <div :class="{'order-collapse__tickets--admin': props.admin }" v-for="ticket in order.tickets" :key="ticket.id" class="order-collapse__tickets">
                    <div
                        v-html="ticket.is_seat === 1 ? ('Siedząca ' + ticket.seat_data.section.name) : ('Stojąca ' + ticket.standing_ticket_data.section.name)"></div>
                    <div v-html="ticket.is_seat === 1 ? ticket.seat_data.row : '-'"></div>
                    <div v-html="ticket.is_seat === 1 ? ticket.seat_data.number : '-'"></div>
                    <div v-html="ticket.is_seat === 1 ? ticket.seat_data.price : ticket.standing_ticket_data.price"></div>
                    <div v-if="props.admin"><a @click="CancelTicket(ticket.ticket_id)">Anuluj miejsce</a></div>
                </div>
            </div>
            <a v-if="(order.payment_status !== 'cancelled') && props.admin" @click="CancelOrder(order.order_id)">Anuluj zamówienie</a>
        </div>
    </Collapse>
</template>

<style lang="scss" scoped>
.order-collapse {

    padding: 02px;
    background-color: #fff;
    border: 2px solid transparent;
    transition: border-color .2s ease-out;
    border-radius: 8px;

    &.open {
        border-color: black;
    }

    &__content {
        width: 100%;
        display: grid;
    }

    &__toggle {
        padding: 20px;
        border-radius: 8px;
        grid-template-columns: 1fr 1fr 1fr;
        display: grid;
        background-color: yellow;
        transition: background-color .2s ease-out;
        user-select: none;
        cursor: pointer;

        &.paid {
            background-color: #73f0ad;
        }

        &.cancelled {
            background-color: lightcoral;
        }

        &.pending {
            background-color: var(--yellow);
        }

        &.open {

        }

        &-label {
            font-weight: 600;
        }
    }

    &__row {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    &__tickets {
        display: grid;
        grid-template-columns: repeat(4, 1fr);

        &--admin {
            grid-template-columns: repeat(5, 1fr);
        }
    }
}
</style>
