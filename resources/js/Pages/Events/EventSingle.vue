<script setup>
import EventsAlt from "@/Components/Sections/EventsAlt.vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";

import SingleMap from "~images/single-map.jpg";
import blogBg from "~images/blog-bg.jpg";

import ResetObject from "@/Utilities/resetObject";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { reactive, ref, computed, watch } from "vue";

const url = window.location.href;

const props = defineProps({
    event: {
        type: Array,
        required: true,
    },
    related_events: {
        type: Array,
        required: true,
    },
});
console.log(props);

//console.log(props);
const hall = props.event.data.event_location;
const seats = reactive({});
const standingTickets = reactive({});
const seatTickets = reactive({});
const standingSectionPrices = reactive({});
const errors = reactive({});
const summary = reactive({
    seats: null,
    seats_price: null,
    standing: null,
    standing_price: null,
});
const ticketRequest = reactive({
    event_id: props.event.data.id,
    seats: seatTickets,
    standing_tickets: standingTickets,
});

function InitStandingTickets() {
    props.event.data.standing_tickets.forEach((section) => {
        if (!standingTickets[section.hall_section_id]) {
            standingTickets[section.hall_section_id] = {};
        }
        standingTickets[section.hall_section_id].hall_section_id =
            section.hall_section_id;
        standingTickets[section.hall_section_id].price = section.price;
        standingTickets[section.hall_section_id].amount = null;
        standingTickets[section.hall_section_id].id = section.id;
        standingTickets[section.hall_section_id].sold = section.sold;
        standingTickets[section.hall_section_id].reserved = section.reserved;
        standingTickets[section.hall_section_id].capacity = section.capacity;
    });
}

function InitSeats() {
    props.event.data.seats.forEach((seat) => {
        if (!seats[seat.hall_section_id]) {
            seats[seat.hall_section_id] = {};
        }
        if (!seats[seat.hall_section_id][seat.seat_row]) {
            seats[seat.hall_section_id][seat.seat_row] = {};
        }
        if (!seats[seat.hall_section_id][seat.seat_row][seat.seat_number]) {
            seats[seat.hall_section_id][seat.seat_row][seat.seat_number] = {};
        }
        seats[seat.hall_section_id][seat.seat_row][seat.seat_number] = {
            hall_section_id: seat.hall_section_id,
            price: seat.price,
            seat_row: seat.seat_row,
            seat_number: seat.seat_number,
            id: seat.id,
            status: seat.status,
            chosen: false,
        };
    });
}

function InitSectionPrices() {
    Object.keys(props.event.data.standing_tickets).forEach((key) => {
        if (
            !standingSectionPrices[
                props.event.data.standing_tickets[key].hall_section_id
            ]
        ) {
            standingSectionPrices[
                props.event.data.standing_tickets[key].hall_section_id
            ] = {};
        }
        standingSectionPrices[
            props.event.data.standing_tickets[key].hall_section_id
        ].price = props.event.data.standing_tickets[key].price;
    });
    //console.log(standingSectionPrices);
}

InitStandingTickets();
InitSeats();
InitSectionPrices();

watch(seatTickets, (newState) => {
    let price = 0;
    Object.keys(newState).forEach((key) => {
        const seatPrice = Number(newState[key]?.price);
        price += seatPrice;
    });
    summary.seats = Object.keys(seatTickets).length;
    summary.seats_price = price;
    // console.log(summary);
});

watch(standingTickets, (newState) => {
    let sum = 0;
    let price = 0;

    Object.keys(newState).forEach((key) => {
        const amount = Number(newState[key]?.amount) || 0;
        const itemPrice = Number(newState[key]?.price) || 0;

        sum += amount;
        price += amount * itemPrice;
    });

    summary.standing_price = price;
    summary.standing = sum;

    //console.log(summary);
});

function isTaken(sectionID, row, col) {
    for (const seat of props.event.data.seats) {
        if (
            seat.hall_section_id === sectionID &&
            seat.seat_row === row &&
            seat.seat_number === col &&
            (seat.status === "sold" || seat.status === "reserved")
        ) {
            return true;
        }
    }
    return false;
}

function AvailibleTickets(hRow, hCol, sID) {
    for (const section of props.event.data.standing_tickets) {
        if (section.hall_section_id === sID) {
            return Number(section.sold) + Number(section.reserved);
        }
    }
    return null;
}

function HandleSeat(sID, row, col) {
    if (seats[sID][row][col].status === "available") {
        if (seats[sID][row][col].chosen === false) {
            seats[sID][row][col].chosen = true;
            if (!seatTickets[seats[sID][row][col].id]) {
                seatTickets[seats[sID][row][col].id] = {};
            }
            seatTickets[seats[sID][row][col].id] = seats[sID][row][col];
        } else {
            seats[sID][row][col].chosen = false;
            delete seatTickets[seats[sID][row][col].id];
        }
    }
}

function SubmitTicketRequest() {
    console.log(ticketRequest);

    router.post(route("event-ticket.buy.form.post"), ticketRequest, {
        onError: (err) => {
            ResetObject(errors);
            Object.assign(errors, err);
        },
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
    console.log(errors);
    //console.log(ticketRequest);
}
</script>

<template>
    <HeroSmall :source="blogBg" :title="event.data.event_name" />
    <section class="single">
        <div class="container container--small">
            <div class="single__content">
                <div class="single__intro">
                    <img :src="'/storage/' + event.data.image_path" alt="" />
                </div>
                <h1 class="single__title">
                    {{ event.data.event_name }}
                </h1>
                <div class="single__details">
                    <div>
                        <h6 class="mb-13px">Event date:</h6>
                        <p>
                            {{ event.data.event_start }} -
                            {{ event.data.event_end }} <br />
                            {{ event.data.event_date }}
                        </p>
                    </div>
                    <div>
                        <h6 class="mb-13px">E-mail:</h6>
                        <a
                            :href="'mailto:' + event.data.contact_email"
                            class="hover-primary text-underline"
                            >{{ event.data.contact_email }}</a
                        >
                        <a
                            :href="
                                'mailto:' + event.data.contact_email_additional
                            "
                            class="hover-primary text-underline"
                            >{{ event.data.contact_email_additional }}</a
                        >
                    </div>
                    <div>
                        <h6 class="mb-13px">Kategorie</h6>
                        <p class="event-categories ff-krona">
                            <Link
                                v-for="(genre, index) in event.data.genres"
                                :data="{ genres: genre.id }"
                                :href="route('event.browser')"
                                class="hover-primary"
                                >{{ genre.name
                                }}<span
                                    v-if="index < event.data.genres.length - 1"
                                    >,
                                </span>
                            </Link>
                        </p>
                    </div>
                </div>
                <h4 class="mb-18px">O wydarzeniu</h4>
                <p class="mb-65px" v-html="event.data.event_description"></p>
                <h4 class="mb-18px">Więcej informacji</h4>
                <div class="mb-65px">
                    {{ event.data.event_description_additional }}
                </div>
                <h4 class="mb-18px">Miejsca</h4>
                <div>
                    <h5>{{ hall.hall_name }}</h5>
                    <div>
                        <form
                            class="mb-40px"
                            @submit.prevent="SubmitTicketRequest"
                        >
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <div class="legend legend--stand"></div>
                                    <p>Sekcje z miejscami stojącymi</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="legend legend--seat"></div>
                                    <p>Sekcje z miejscami siedzącymi</p>
                                </div>
                            </div>
                            <div class="scene">scena</div>
                            <div
                                v-for="(row, hrowIndex) in hall.hall_height"
                                :key="hrowIndex"
                                class="hall__row"
                            >
                                <div
                                    v-for="(col, hcolIndex) in hall.hall_width"
                                    :key="hcolIndex"
                                    class="hall__col"
                                >
                                    <div
                                        v-for="section in hall.sections.filter(
                                            (section) =>
                                                section.section_height ===
                                                    hrowIndex + 1 &&
                                                section.section_width ===
                                                    hcolIndex + 1
                                        )"
                                        :key="section.id"
                                        class="petla"
                                    >
                                        <!--
                                        Div boży 1 xd xd
-->
                                        <div
                                            v-if="
                                                section.section_type === 'seat'
                                            "
                                            class="hall__section-seat"
                                        >
                                            <div class="hall__seat-cont">
                                                <div
                                                    v-for="(
                                                        row, rowIndex
                                                    ) in section.row"
                                                    :key="rowIndex"
                                                    class="hall__section-row"
                                                >
                                                    <div
                                                        v-for="(
                                                            col, colIndex
                                                        ) in section.col"
                                                        :key="colIndex"
                                                        :class="{
                                                            taken: isTaken(
                                                                section.id,
                                                                rowIndex + 1,
                                                                colIndex + 1
                                                            ),
                                                            chosen: seats[
                                                                section.id
                                                            ][rowIndex + 1][
                                                                colIndex + 1
                                                            ].chosen,
                                                        }"
                                                        :data-col="colIndex + 1"
                                                        :data-sID="section.id"
                                                        class="hall__seat"
                                                        @click="
                                                            HandleSeat(
                                                                section.id,
                                                                rowIndex + 1,
                                                                colIndex + 1
                                                            )
                                                        "
                                                    >
                                                        <div
                                                            class="hall__seat-tooltip"
                                                        >
                                                            <div
                                                                class="d-flex column-gap-4px"
                                                            >
                                                                <div>Rząd:</div>
                                                                <div
                                                                    class="fw-med text-primary text-black"
                                                                >
                                                                    {{
                                                                        rowIndex +
                                                                        1
                                                                    }}
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex column-gap-4px"
                                                            >
                                                                <div>
                                                                    Kolumna:
                                                                </div>
                                                                <div
                                                                    class="fw-med text-primary text-black"
                                                                >
                                                                    {{
                                                                        colIndex +
                                                                        1
                                                                    }}
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex column-gap-4px"
                                                            >
                                                                <div>Cena:</div>
                                                                <div
                                                                    class="fw-med text-primary text-black"
                                                                >
                                                                    {{
                                                                        seats[
                                                                            section
                                                                                .id
                                                                        ][
                                                                            rowIndex +
                                                                                1
                                                                        ][
                                                                            colIndex +
                                                                                1
                                                                        ].price
                                                                    }}
                                                                    PLN
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                v-if="
                                                    errors?.seats?.[section.id]
                                                "
                                                class="error-msg"
                                            >
                                                <div
                                                    v-html="
                                                        errors?.seats?.[
                                                            section.id
                                                        ]
                                                    "
                                                ></div>
                                            </div>
                                        </div>
                                        <!--
                                        Div boży 2 xd xdd 12.05
-->
                                        <div v-else class="hall__section-stand">
                                            <div
                                                class="hall__seat-cont hall__seat-cont--info"
                                            >
                                                <p
                                                    v-html="
                                                        `${AvailibleTickets(
                                                            hrowIndex + 1,
                                                            hcolIndex + 1,
                                                            section.id
                                                        )}/${
                                                            section.capacity
                                                        } miejsc zajętych.`
                                                    "
                                                ></p>
                                                <p>
                                                    {{
                                                        standingSectionPrices[
                                                            section.id
                                                        ].price
                                                    }}
                                                    PLN
                                                </p>
                                                <input
                                                    v-model.trim="
                                                        standingTickets[
                                                            section.id
                                                        ].amount
                                                    "
                                                    v-number-only
                                                    class="stand-input"
                                                    placeholder="Ilość"
                                                    type="text"
                                                    @blur="
                                                        standingTickets[
                                                            section.id
                                                        ].amount =
                                                            standingTickets[
                                                                section.id
                                                            ].amount || null
                                                    "
                                                />
                                            </div>
                                            <div
                                                v-if="
                                                    errors?.standing_tickets?.[
                                                        section.id
                                                    ]
                                                "
                                                class="error-msg"
                                            >
                                                <div
                                                    v-html="
                                                        errors
                                                            ?.standing_tickets?.[
                                                            section.id
                                                        ]
                                                    "
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                v-if="errors?.no_ticket"
                                class="error-msg mb-20px"
                            >
                                <div v-html="errors?.no_ticket"></div>
                            </div>
                            <div
                                v-if="summary"
                                class="d-flex flex-column mb-40px"
                            >
                                <div
                                    v-if="summary.seats && summary.seats_price"
                                    class="d-flex flex-lg-row"
                                >
                                    <div class="mr-lg-40px">
                                        Ilość wybranych miejsc siedzących:
                                        {{ summary.seats }}
                                    </div>
                                    <div class="mr-lg-40px">
                                        Cena wybranych miejsc siedzących:
                                        {{ summary.seats_price.toFixed(2) }} PLN
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        summary.standing &&
                                        summary.standing_price
                                    "
                                    class="d-flex flex-lg-row"
                                >
                                    <div class="mr-lg-40px">
                                        Ilość wybranych miejsc stojących:
                                        {{ summary.standing }}
                                    </div>
                                    <div class="mr-lg-40px">
                                        Cena wybranych miejsc stojących:
                                        {{ summary.standing_price.toFixed(2) }} PLN
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        summary.standing &&
                                        summary.standing_price &&
                                        summary.seats &&
                                        summary.seats_price
                                    "
                                    class="d-flex flex-lg-row"
                                >
                                    <div class="mr-lg-40px">
                                        Łączna ilość wybranych miejsc:
                                        {{ summary.standing + summary.seats }}
                                    </div>
                                    <div class="mr-lg-40px">
                                        Łączna cena wybranych miejsc:
                                        {{
                                            (
                                                summary.standing_price +
                                                summary.seats_price
                                            ).toFixed(2)
                                        }} PLN
                                    </div>
                                </div>
                            </div>
                            <button
                                class="btn btn--md btn--hovprim mb-30px btn-hover-border "
                                type="submit">
                                Kup bilety
                            </button>
                        </form>
                    </div>
                </div>
                <img :src="SingleMap" alt="" class="single__map" />
                <div class="bb-1 b-secondary"></div>
                <div
                    class="d-flex row-gap-10px column-gap-10px mt-30px mb-100px"
                >
                    <a
                        :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent(
                            url
                        )}`"
                        class="social-link"
                        target="_blank"
                        ><i class="fab fa-twitter"></i
                    ></a>
                    <a
                        :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
                            url
                        )}`"
                        class="social-link"
                        target="_blank"
                        ><i class="fab fa-facebook"></i
                    ></a>
                    <a
                        :href="`https://pinterest.com/pin/create/button/?url=${encodeURIComponent(
                            url
                        )}`"
                        class="social-link"
                        target="_blank"
                        ><i class="fab fa-pinterest"></i
                    ></a>
                </div>
                <h3 class="mb-30px align-self-middle">Related Events</h3>
                <EventsAlt :events="props.related_events" />
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
@use "~css/mixin.scss";

.stand-input {
    padding: 20px;
    border: 1px solid #e3ad84;
    border-radius: 8px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 25%;
}

.hall {
    &__seat {
        &.taken {
            pointer-events: none;
        }

        &.chosen {
            background-color: var(--yellow);
        }
    }
}

.single {
    &__content {
        width: 100%;
        padding: 0 5px;
        color: #505558;
        display: flex;
        flex-direction: column;
        margin-bottom: 55px;
        @include mixin.media-breakpoint-up(md) {
            padding: 0 30px;
            margin-bottom: 110px;
        }
    }

    &__intro {
        margin-bottom: 50px;
        display: flex;
        justify-content: center;

        img {
            max-height: 600px;
        }
    }

    &__title {
        margin-bottom: 50px;
        font-size: 28px;
        line-height: 1.25;
        word-wrap: break-word;
        overflow-wrap: break-word;
        @include mixin.media-breakpoint-up(md) {
            font-size: 42px;
        }
    }

    &__details {
        display: grid;
        grid-template-columns: 1fr;
        @include mixin.media-breakpoint-up(md) {
            grid-template-columns: repeat(3, 1fr);
            grid-column-gap: 60px;
        }

        div {
            font-size: 12px;
            line-height: 30px;
            font-family: "Krona One";
            padding: 30px 0;
            position: relative;
            display: flex;
            flex-direction: column;
            margin: 0;

            &::before {
                position: absolute;
                left: 0px;
                right: 0px;
                background-color: var(--text);
                height: 1px;
                content: "";
                top: 0;
            }
        }

        p {
        }
    }

    &__map {
        margin-bottom: 50px;
    }

    h3 {
        font-size: 24px;
        @include mixin.media-breakpoint-up(lg) {
            font-size: 36px;
        }
    }

    h4 {
        color: var(--text);
    }
}

textarea {
    height: 85px;
}
</style>
