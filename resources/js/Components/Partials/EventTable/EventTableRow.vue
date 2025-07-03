<script setup>
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";

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
</script>

<template>
    <tr class="t-details" :class="{odd: props.index%2 === 0}">
        <td>
            <img :src="`/storage/${event.image_path}`" class="t-details__pic ml-auto mr-auto"/>
        </td>
        <td>
            <a target="_blank" :href="`/${props.pending ? 'admin/' + event.event_url : event.event_url}`">{{event.event_name}}</a>
            <div class="t-details__options">
                <a class="mr-6px" @click="DeleteEvent(event.id)">Usuń</a>
                <a target="_blank" class="mr-6px" :href="`/${props.pending ? 'admin/' + event.event_url : event.event_url}`">Podgląd</a>
                <button @click="toggle" class="btn-link">Szczegóły</button>
            </div>
        </td>
        <td>{{event.event_date}}</td>
        <td>{{event.event_start}}</td>
        <td>{{event.event_end}}</td>
        <td>((nazwa hali))</td>
        <td><a :href="`mailto:${event.contact_email}`">Główny email</a></td>
        <td><a :href="`mailto:${event.contact_email_additional}`">Dodatkowy email</a></td>
    </tr>
    <transition @enter="enter"
                @after-enter="afterEnter"
                @before-leave="beforeLeave">
        <tr class="event-details" v-if="isOpen" :aria-expanded="isOpen">
            <td colspan="10" class="col-12 p-0">
                <div
                    ref="detailsWrapper"
                    class="event-details__wrapper">
                    <div class="event-details__container">
                        <div class="event-details__container-inner">
                            <div class="event-details__label">
                                Tutaj będzie info o ustalonych cenach sekcji
                            </div>
                        </div>
                        <div v-if="!props.pending" class="event-details__container-inner">
                            <div class="event-details__label">
                                Tutaj będzie info o zarobionej kasie
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </transition>

</template>

<style scoped lang="scss">
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

    &__container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        padding: 8px 10px;

        &-inner {
            display: grid;
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
