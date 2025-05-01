<script setup>
import EventsAlt from "@/Components/Sections/EventsAlt.vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";

import SingleMap from "~images/single-map.jpg";
import blogBg from "~images/single-map.jpg";

import {reactive, ref} from "vue";

const url = window.location.href;

const props = defineProps({
    event: {
        type: Array,
        required: true,
    },
    related_events: {
        type: Array,
        required: true,
    }
});

const hall = props.event.data.event_location;

function isTaken(sectionID, row, col) {
    for (const seat of props.event.data.seats) {
        if (
            seat.hall_section_id === sectionID &&
            seat.seat_row        === row       &&
            seat.seat_number     === col       &&
            (seat.status === 'sold' || seat.status === 'reserved')
        ) {
            return 'true';
        }
    }
    return false;
}

function AvailibleTickets(hRow, hCol, sID) {
    for(const section of props.event.data.standing_tickets) {
        if (section.hall_section_id === sID) {
            return section.sold;
        }
    }
    return null;
}

const standingTickets = reactive({});
function InitStandingTickets() {
    props.event.data.standing_tickets.forEach((section) => {
        if (!standingTickets[section.hall_section_id]) {
            standingTickets[section.hall_section_id] = {};
        }
        standingTickets[section.hall_section_id].hall_section_id = section.hall_section_id;
        standingTickets[section.hall_section_id].price = section.price;
        standingTickets[section.hall_section_id].amount = null;
    });
}
InitStandingTickets();

console.log(standingTickets);

const seats = reactive({});
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
InitSeats();

console.log(seats);

const seatTickets = reactive({});

function HandleSeat(sID, row, col) {
    if (seats[sID][row][col].status === 'available') {
        if (seats[sID][row][col].chosen === false) {
            seats[sID][row][col].chosen = true;
            if(!seatTickets[seats[sID][row][col].id]) {
                seatTickets[seats[sID][row][col].id] = {};
            }
            seatTickets[seats[sID][row][col].id] = seats[sID][row][col];
        } else {
            seats[sID][row][col].chosen = false;
            delete seatTickets[seats[sID][row][col].id];
        }
    }
    console.log(seatTickets);
}

const ticketRequest = reactive({
    event_id: props.event.data.id,
    seats: seatTickets,
    standing_tickets: standingTickets,
});

function SubmitTicketRequest() {

    console.log(ticketRequest);
}

</script>

<template>
    <HeroSmall :source="blogBg" :title="event.data.event_name"/>
    <section class="single">
        <div class="container container-small">
            <div class="single__content">
                <div class="single__intro">
                    <img :src="'/storage/' + event.data.image_path" alt=""/>
                </div>
                <h1 class="single__title">
                    {{ event.data.event_name }}
                </h1>
                <div class="single__details">
                    <div>
                        <h6 class="mb-13px">Event date:</h6>
                        <p>
                            {{ event.data.event_start }} -
                            {{ event.data.event_end }} <br/>
                            {{ event.data.event_date }}
                        </p>
                    </div>
                    <!--                    <div>
                        <h6 class="mb-13px">Location:</h6>
                        <a class="text-secondary" href="/">GERMANY</a>
                    </div>-->
                    <div>
                        <h6 class="mb-13px">E-mail:</h6>
                        <a
                            class="hover-primary text-underline"
                            :href="'mailto:' + event.data.contact_email"
                        >{{ event.data.contact_email }}</a
                        >
                        <a
                            class="hover-primary text-underline"
                            :href="
                                'mailto:' + event.data.contact_email_additional
                            "
                        >{{ event.data.contact_email_additional }}</a
                        >
                    </div>
                </div>
                <h4 class="mb-18px">O wydarzeniu</h4>
                <p v-html="event.data.event_description" class="mb-65px"></p>
                <h4 class="mb-18px">Więcej informacji</h4>
                <div class="mb-65px">
                    {{ event.data.event_description_additional }}
                </div>
                <h4 class="mb-18px">Miejsca</h4>
                <div>
                    <h5>{{ hall.hall_name }}</h5>
                    <div>
                        <form class="mb-40px" @submit.prevent="SubmitTicketRequest">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <div class="legend legend-stand"></div>
                                    <p>Sekcje z miejscami stojącymi</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="legend legend-seat"></div>
                                    <p>Sekcje z miejscami siedzącymi</p>
                                </div>
                            </div>
                            <div class="scene">scena</div>
                            <div
                                class="hall__row"
                                v-for="(row, hrowIndex) in hall.hall_height"
                                :key="hrowIndex"
                            >
                                <div
                                    class="hall__col"
                                    v-for="(col, hcolIndex) in hall.hall_width"
                                    :key="hcolIndex"
                                >
                                    <div
                                        class="petla"
                                        v-for="section in hall.sections.filter(
                                            (section) =>
                                                section.section_height ===
                                                    hrowIndex + 1 &&
                                                section.section_width ===
                                                    hcolIndex + 1
                                        )"
                                        :key="section.id"
                                    >
<!--
                                        Div boży 1
-->
                                        <div
                                            class="hall__section-seat"
                                            v-if="
                                                section.section_type === 'seat'
                                            "
                                        >
                                            <div class="hall__seat-cont">
                                                <div
                                                    class="hall__section-row"
                                                    v-for="(
                                                        row, rowIndex
                                                    ) in section.row"
                                                    :key="rowIndex"
                                                >
                                                    <div
                                                        class="hall__seat"
                                                        v-for="(
                                                            col, colIndex
                                                        ) in section.col"
                                                        @click="HandleSeat(section.id, rowIndex + 1, colIndex + 1)"
                                                        :key="colIndex"
                                                        :data-sID="section.id"
                                                        :data-col="colIndex + 1"
                                                        :class="{ 'taken': isTaken(section.id, rowIndex + 1, colIndex + 1), 'chosen': seats[section.id][rowIndex+1][colIndex+1].chosen }"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
<!--
                                        Div boży 2
-->
                                        <div v-else class="hall__section-stand">
                                            <div class="hall__seat-cont">
                                                <div v-html="`${AvailibleTickets(hrowIndex + 1, hcolIndex + 1, section.id)}/${section.capacity}`">
                                                </div>
                                                <input @input="console.log(standingTickets)" v-model="standingTickets[section.id].amount" class="stand-input" v-number-only type="text" placeholder="Ilość">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md">Kup bilety</button>
                        </form>
                    </div>
                </div>
                <img class="single__map" :src="SingleMap" alt=""/>
                <div class="bb-1 b-secondary"></div>
                <div
                    class="d-flex row-gap-10px column-gap-10px mt-30px mb-100px"
                >
                    <a
                        class="social-link"
                        :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent(
                            url
                        )}`"
                        target="_blank"
                    ><i class="fab fa-twitter"></i
                    ></a>

                    <a
                        class="social-link"
                        :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
                            url
                        )}`"
                        target="_blank"
                    >
                        <i class="fab fa-facebook"></i
                        ></a>

                    <a
                        class="social-link"
                        :href="`https://pinterest.com/pin/create/button/?url=${encodeURIComponent(
                            url
                        )}`"
                        target="_blank"
                    >
                        <i class="fab fa-pinterest"></i
                        ></a>
                </div>
                <h3 class="mb-30px align-self-middle">Related Events</h3>
                <EventsAlt :events="props.related_events"/>
                <!--                 <h3 class="mb-40px">Leave a Reply</h3>
                                <p class="fs-14 mb-20px">
                                    Your email address will not be published. Required fields
                                    are marked *
                                </p>
                                 <form action="" class="form">
                                    <div class="input-wrap col-12 col-lg-6">
                                        <input type="text" placeholder="Your Name*" required />
                                    </div>
                                    <div class="input-wrap col-12 col-lg-6">
                                        <input type="text" placeholder="Your Email*" required />
                                    </div>
                                    <div class="input-wrap col-12">
                                        <input type="text" placeholder="Website" />
                                    </div>
                                    <div class="input-wrap col-12">
                                        <textarea placeholder="Your Comment..."></textarea>
                                    </div>
                                    <div class="input-wrap input-wrap-check col-12">
                                        <input
                                            type="checkbox"
                                            v-model="toggle"
                                            true-value="yes"
                                            false-value="no"
                                        />
                                        <label for="checkbox"
                                            >Save my name, email, and website in this browser
                                            for the next time I comment.
                                        </label>
                                    </div>
                                    <div class="input-wrap col-12">
                                        <input type="submit" value="post comment" />
                                    </div>
                                </form>-->
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";

.stand-input {
    padding: 20px;
    border: 1px solid #E3AD84;
    border-radius: 8px;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
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
