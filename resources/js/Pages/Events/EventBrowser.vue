<script setup>
import Events from "@/Components/Sections/Events.vue";
import { Link } from "@inertiajs/vue3";
import DatePicker from "@/Components/Sections/DatePicker.vue";
import MultiSelect from "@/Components/Partials/MultiSelect.vue";

import { reactive, watch, computed, ref } from "vue";

import eventsBg from "~images/events-bg-1.jpg";

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
    genres: {
        type: Array,
        required: true,
    }
});

let genres = [];

props.genres.forEach((genre, index) => {
    genres[index] = {
        name:  genre.genre_name,
        value: genre.id,
    };
});

const filterRequest = reactive({
    phrase: null,
    date: null,
    genres: null,
});

function submitFilterRequest() {
    let hadError = ref(false);

    console.log(filterRequest);
}

function isCurrentPage(pageId) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    return urlParams.get('page') === (pageId);
}

console.log(props);
console.log(route('event.browser'));
</script>

<template>
    <section class="pb-75px pt-75px">
        <div class="container flex-column align-items-center">
            <p class="sub-title sub-title-lprpl mb-20px">bilety na</p>
            <h3 class="title-1 mb-20px">Przyszłe wydarzenia</h3>
            <form @submit.prevent="submitFilterRequest()" class="select-filters">
                <input placeholder="Szukaj po nazwie" v-model="filterRequest.phrase" type="text">
                <MultiSelect v-model="filterRequest.genres" :options="genres" ></MultiSelect>
                <DatePicker v-model="filterRequest.date"></DatePicker>
                <input type="submit" value="Filtruj"/>
            </form>
            <Events :events="props.events.data" :genres="props.genres" />

            <div class="event-pagination">
                <ul class="ml-auto mr-auto">
<!--                    <li class="direction">
                        &lt;!&ndash; ukryć jak jest page 1 &ndash;&gt;
                        <a href="#forward">
                            <div class="d-flex">
                                <i class="fa fa-chevron-left"></i>
                                <i class="fa fa-chevron-left"></i>
                            </div>
                            Powróć
                        </a>
                    </li>-->
                    <li :key="page" class="page" :class="{'page-current': isCurrentPage(page.label)}" v-for="page in events.meta.links">
                        <Link :href="page.url" v-html="page.label"></Link>
                    </li>
<!--                    <li class="direction">
                        <a href="#forward"
                            >Dalej
                            <div class="d-flex">
                                <i class="fa fa-chevron-right"></i>
                                <i class="fa fa-chevron-right"></i></div
                        ></a>
                    </li>-->
                </ul>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss"></style>
