<script setup>
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import {computed} from "vue";

const isOpen = ref(false);

const props = defineProps({
    event: {
        required: true,
    },
    pending: {
        required: false,
        type: Boolean,
    },
    index: {
        required: true,
    }
});

const toggle = () => {
    isOpen.value = !isOpen.value;
};
const enter = el => {
    const wr = el.querySelector('.event-details__wrapper');
    wr.style.overflow = 'hidden';
    wr.style.height = '0';
    requestAnimationFrame(() => {
        wr.style.height = `${wr.scrollHeight}px`;
    });
};

const afterEnter = el => {
    const wr = el.querySelector('.event-details__wrapper');
    wr.style.height = null;
    wr.style.overflow = null;
};

const beforeLeave = el => {
    const wr = el.querySelector('.event-details__wrapper');
    wr.style.overflow = 'hidden';
    wr.style.height = `${wr.scrollHeight}px`;
    requestAnimationFrame(() => {
        wr.style.height = '0';
    });
};

const totalSpotsSold = computed(() => {
    if (!props.event?.event_location?.sections) return 0;
    return props.event.event_location.sections.reduce((total, section) => {
        return total + (parseInt(section.spots_sold) || 0);
    }, 0);
});
</script>

<template>
    <tr :class="{odd: props.index%2 === 0}" class="t-details">
        <td>
            <img :src="`/storage/${event.image_path}`" class="t-details__pic ml-auto mr-auto"/>
        </td>
        <td>
            <a :href="`/${props.pending ? 'admin/' + event.event_url : event.event_url}`"
               target="_blank">{{ event.event_name }}</a>
            <div class="t-details__options">
                <a class="mr-6px" @click="DeleteEvent(event.id)">Usuń</a>
                <a :href="`/${props.pending ? 'admin/' + event.event_url : event.event_url}`" class="mr-6px"
                   target="_blank">Podgląd</a>
                <button class="btn-link" @click="toggle">Szczegóły</button>
            </div>
        </td>
        <td>{{ event.event_date }}</td>
        <td>{{ event.event_start }}</td>
        <td>{{ event.event_end }}</td>
        <td><a :href="route('about-us', { tabName: event.event_location.hall_name }) + '#halls'"
               target="_blank">{{ event.event_location.hall_name }}</a>
        </td>
        <td><a :href="`mailto:${event.contact_email}`">Główny email</a></td>
        <td><a :href="`mailto:${event.contact_email_additional}`">Dodatkowy email</a></td>
    </tr>
    <transition @enter="enter"
                @after-enter="afterEnter"
                @before-leave="beforeLeave">
        <tr v-if="isOpen" :aria-expanded="isOpen" class="event-details">
            <td class="col-12 p-0" colspan="10">
                <div
                    ref="detailsWrapper"
                    class="event-details__wrapper">
<!--                    <div class="event-details__container">
                        <div class="event-details__row event-details__label" :class="{ 'event-details__row&#45;&#45;pending': props.pending }">
                            <div>Sekcja</div>
                            <div>Cena za miejsce</div>
                            <div v-if="!props.pending">Sprzedano biletów</div>
                            <div v-if="!props.pending">Łączna kwota</div>
                        </div>
                        <div v-for="section in event.event_location.sections" class="event-details__row" :class="{ 'event-details__row&#45;&#45;pending': props.pending }">
                            <div>{{ section.name }}</div>
                            <div>{{ section.price }} PLN</div>
                            <div v-if="!props.pending">{{ section.spots_sold }}</div>
                            <div v-if="!props.pending">{{ section.total_sold_value }} PLN</div>
                        </div>
                        <div class="event-details__summary event-details__row" :class="{ 'event-details__row&#45;&#45;pending': props.pending }">
                            <div>Łącznie</div>
                            <div>-</div>
                            <div v-if="!props.pending">{{totalSpotsSold}}</div>
                            <div v-if="!props.pending">{{ event.total_sale_value }} PLN</div>
                        </div>
                    </div>-->
                    <div class="event-details__container">
                        <div class="event-details__row event-details__label">
                            <div>Sekcja</div>
                            <div>Cena za miejsce</div>
                            <div>Sprzedano biletów</div>
                            <div>Łączna kwota</div>
                        </div>
                        <div v-for="section in event.event_location.sections" class="event-details__row">
                            <div>{{ section.name }}</div>
                            <div>{{ section.price }} PLN</div>
                            <div>{{ section.spots_sold }}</div>
                            <div>{{ section.total_sold_value }} PLN</div>
                        </div>
                        <div class="event-details__summary event-details__row">
                            <div>Łącznie</div>
                            <div>-</div>
                            <div>{{ totalSpotsSold }}</div>
                            <div>{{ event.total_sale_value }} PLN</div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </transition>

</template>

<style lang="scss" scoped>
// Od tąd
.btn-link {
    background-color: transparent;
    color: #6f69f7;
    border: unset;
    transition: all .3s ease;
    font-family: Prompt;
    padding: 0;

    &:hover {
        color: black;
    }
}

.p-0 {
    padding: 0;
}

// Do tąd przetłumacz to na poprawnego cssa w odpowiednim miejscu xD To poniżej też możesz
.event-details {
    transition: height .2s ease-in-out;
    width: 100%;

    &__summary {
        padding-top: 5px;
        border-top: 1px solid black;
        font-weight: 600;
    }

    &__container {
        display: grid;
        gap: 12px;
        padding: 8px 10px;

        &-inner {
            display: grid;
            //grid-template-columns: repeat(2, 1fr);
        }
    }

    &__row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);

        &--pending {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    &__label {
        font-weight: 500;
        font-size: 18px;
        line-height: 1.3;
    }

    &__wrapper {
        height: fit-content;
        transition: height .2s ease-in-out;
    }
}
</style>
