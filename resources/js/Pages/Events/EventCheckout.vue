<script setup>

const props = defineProps({
    order: {
        type: Object,
        required: true,
    }
})

const order = props.order[0];

console.log(props);

</script>

<template>
    <section class="pt-75px pb-75px">
        <div class="container">
            <div class="flex-column order">
                <h3 class="mb-30px">Zamówienie {{order.order_number}}</h3>
                <div class="col-12 row-gap-30px mb-30px">
                    <div class="flex-column">
                        <p class="h5 text-lg fw-bold text-primary-darker">
                            Nazwa wydarzenia:
                        </p>
                        <p class="h6">{{order.event.event_name}}</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 text-lg fw-bold text-primary-darker">
                            Data wydarzenia:
                        </p>
                        <p class="h6">{{order.event.event_date}}</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 text-lg fw-bold text-primary-darker">
                            Godzina wydarzenia:
                        </p>
                        <p class="h6">{{order.event.event_start}}</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 fw-bold text-primary-darker">
                            całkowity koszt:
                        </p>
                        <p class="h6">{{order.total_price}} zł</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 fw-bold text-primary-darker">
                            Adres Email kupującego:
                        </p>
                        <p class="h6">{{order.email}}</p>
                    </div>
                </div>
                <div class="flex-column">
                    <h3 class="mb-30px">Detale zamówienia</h3>
                    <div class="order__row order__row--head">
                        <p class="fw-bold">Typ biletu</p>
                        <p class="fw-bold">Sekcja</p>
                        <p class="fw-bold">Rząd</p>
                        <p class="fw-bold">Miejsce</p>
                        <p class="fw-bold">Cena</p>
                    </div>
                    <div v-for="ticket in order.tickets" class="order__row">
                        <p>{{ticket.is_seat === 1 ? "Bilet siedzący" : "Bilet stojący"}}</p>
                        <p v-html="ticket.is_seat === 1 ? ticket.seat.section.section_name : ticket.standing_ticket.section.section_name"></p>
                        <p v-html="ticket.is_seat === 1 ? ticket.seat.seat_row : '-'"></p>
                        <p v-html="ticket.is_seat === 1 ? ticket.seat.seat_number : '-'"></p>
                        <p>{{ticket.price}}</p>
                    </div>
                    <div class="order__row order__row--summary">
                        <p class="fw-bold text-primary-darker">
                            Cena całkowita
                        </p>
                        <p>36zł</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";

.order {
    width: 100%;
    &__row {
        display: grid;
        grid-template-columns: 100px 1fr 1fr 1fr 1fr;
        grid-row-gap: 10px;
        padding: 20px 10px;
        border-bottom: 1px solid var(--n-gray);
        border-left: 1px solid var(--n-gray);
        border-right: 1px solid var(--n-gray);

        @include mixin.media-breakpoint-up(lg) {
            padding: 20px 30px;
        }

        &:first-of-type {
            border-top: 1px solid var(--n-gray);
        }

        p {
            text-align: center;
            font-size: 12px;

            @include mixin.media-breakpoint-up(lg) {
                font-size: 16px;
            }
        }

        &--head {
            color: var(--primary-darker);
            p {
                padding: 0;
            }
        }
        &--summary {
            p:last-of-type {
                grid-column: 5/6;
            }
        }
    }
}
</style>
