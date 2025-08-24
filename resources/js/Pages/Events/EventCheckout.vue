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
            <div class="d-flex flex-column justify-content-center align-items-center text-align-center col-12 mb-30px mb-lg-50px">
                <h1 class="h3 mb-20px">Zeskanuj kod QR</h1>
                <div class="order-qr" v-html="props.order[0]?.qr_data"></div>
            </div>
            <div class="flex-column order">
                <h4 class="pb-15px mb-15px bb-1 b-primary-darker ">Zamówienie <span class="text-primary-darker">{{order.order_number}}</span></h4>
                <div class="col-12 d-flex flex-column row-gap-20px mb-30px">
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
                            Całkowity koszt:
                        </p>
                        <p class="h6">{{order.total_price}} PLN</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 fw-bold text-primary-darker">
                            Adres Email kupującego:
                        </p>
                        <p class="h6">{{order.email}}</p>
                    </div>
                </div>
                <div class="flex-column">
                    <h4 class="mb-30px">Detale zamówienia</h4>
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
                        <p>{{ticket.price}} PLN</p>
                    </div>
                    <div class="order__row order__row--summary">
                        <p class="fw-bold text-primary-darker">
                            Cena całkowita
                        </p>
                        <p>{{order.total_price}} PLN</p>
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
        grid-template-columns: 150px 1fr 1fr 1fr 1fr;
        grid-row-gap: 10px;
        padding: 10px 15px;
        border-bottom: 1px solid var(--n-gray);
        border-left: 1px solid var(--n-gray);
        border-right: 1px solid var(--n-gray);

        @include mixin.media-breakpoint-up(lg) {
            padding: 10px 15px;
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
            border-radius:8px 8px 0 0;
            p {
                padding: 0;
            }
        }
        &--summary {
            border-radius:0 0 8px 8px;
            p:last-of-type {
                grid-column: 5/6;
            }
        }
    }
}
</style>
