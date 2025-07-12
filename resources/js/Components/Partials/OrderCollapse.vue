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
    router.put(route('admin.customer-service.cancel-ticket', {id: tID}), {}, {
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
    router.put(route('admin.customer-service.cancel-order', {order: oID}), {}, {
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
        <div class="order-collapse__content">
            <div class="order-collapse__main-table">
                <div class="order-collapse__row">
                    <div class="order-collapse__label">Wydarzenie</div>
                    <a :href="`/${order.event.event_url}`" class="" target="_blank">{{ order.event.name }}</a>
                </div>
                <div class="order-collapse__row">
                    <div class="order-collapse__label">Data zamówienia</div>
                    <div>{{ order.created_at }}</div>
                </div>
                <div class="order-collapse__row">
                    <div class="order-collapse__label">E-mail</div>
                    <div>{{ order.email }}</div>
                </div>
                <div class="order-collapse__row">
                    <div class="order-collapse__label">Imie</div>
                    <div>{{ order.first_name }}</div>
                </div>
                <div class="order-collapse__row">
                    <div class="order-collapse__label">Nazwisko</div>
                    <div>{{ order.last_name }}</div>
                </div>
                <div class="order-collapse__row">
                    <div class="order-collapse__label">Nr. zamówienia</div>
                    <div>{{ order.order_number }}</div>
                </div>
                <div class="order-collapse__row">
                    <div class="order-collapse__label">Status płatnosci</div>
                    <div v-html="ReturnStatus(order.payment_status)"></div>
                </div>
                <div class="order-collapse__row">
                    <div class="order-collapse__label">Łączna cena</div>
                    <div>{{ order.total_price }}</div>
                </div>
            </div>
            <div v-if="order.payment_status !== 'cancelled'" class="order-collapse__ticket-table">
                <h5 class="fw-bold mb-20px">Wykupione miejsca</h5>
                <div :class="{'order-collapse__tickets--admin': props.admin }" class="order-collapse__tickets fw-bold">
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
            <a class="btn btn-md btn-ghost ml-auto mr-auto mt-20px" v-if="(order.payment_status !== 'cancelled') && props.admin" @click="CancelOrder(order.order_id)">Anuluj zamówienie</a>
        </div>
    </Collapse>
</template>

<style lang="scss" scoped>
.order-collapse {

    padding: 2px;
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
        padding: 20px;
    }

    &__main-table {
    }

    &__ticket-table {
        margin-top: 30px;
    }

    &__toggle {
        padding: 10px 20px;
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

    &__label {
        font-weight: 600;
    }

    &__row {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 2fr;
        padding-top: 6px;
        padding-bottom: 6px;

        &:not(:last-child) {
            border-bottom: 1px solid black;
        }
    }

    &__tickets {
        display: grid;
        grid-template-columns: 3fr 2fr 2fr 2fr;
        padding-top: 4px;
        padding-bottom: 4px;
        border-bottom: 1px solid black;

        &--admin {
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
        }
    }
}
</style>
