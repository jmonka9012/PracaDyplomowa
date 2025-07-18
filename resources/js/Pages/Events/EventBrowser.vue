<script setup>
import Events from "@/Components/Sections/Events.vue";
import { Link } from "@inertiajs/vue3";
import DatePicker from "@/Components/Partials/DatePicker.vue";
import MultiSelect from "@/Components/Partials/MultiSelect.vue";
import { router } from "@inertiajs/vue3";

import {reactive, watch, computed, ref, onMounted} from "vue";

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
    genres: {
        type: Array,
        required: true,
    },
});

let genres = [];

props.genres.forEach((genre, index) => {
    genres[index] = {
        name: genre.genre_name,
        value: genre.id,
    };
});

const filterRequest = reactive({
    event_name: null,
    genres: null,
    date: null,
});

function findGenres(id) {
    return props.genres[id-1].genre_name; // -1 ponieważ index arraya jest przesunięty o 1 względem ID i możemy wydajniej dotrzeć do nazwy
}

onMounted(() => {
    console.log(props);
    const params = new URLSearchParams(window.location.search);
    const genres = [];

    if (params.get("genres")) {
        const value = params.get("genres");
        genres[0] = {};
        genres[0].value = value;
        genres[0].name = findGenres(value);
    } else {
        for (const [key, value] of params.entries()) {
            const match = key.match(/^genres\[(\d+)\]$/);
            if (match) {
                const idx = Number(match[1]);
                genres[idx] = {};
                genres[idx].value = value;
                genres[idx].name = findGenres(value);
            }
        }
    }

    filterRequest.genres = genres;
});

function submitFilterRequest() {
    console.log(filterRequest.genres)
    const filters = {};

    if (filterRequest.date) {
        if (Array.isArray(filterRequest.date)) {
            if (filterRequest.date[1]) {
                filters.date_from = filterRequest.date[0];
                filters.date_to = filterRequest.date[1];
            } else if (filterRequest.date[0]) {
                filters.date = filterRequest.date[0];
            }
        } else {
            filters.date = filterRequest.date;
        }
    }

    if (filterRequest.genres?.length) {
        filters.genres = filterRequest.genres
            .filter((genre) => genre)
            .map((genre) => genre.id || genre.value);
    }

    if (filterRequest.event_name) {
        filters.event_name = filterRequest.event_name;
    }

    router.get(route("event.browser"),filters, {
        replace: true,
        only: ['events'],
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
    <section class="pb-75px pt-75px">
        <div class="container flex-column align-items-center">
            <p class="sub-title sub-title-lprpl mb-20px">bilety na</p>
            <h3 class="title-1 mb-20px">Przyszłe wydarzenia</h3>
            <form
                @submit.prevent="submitFilterRequest"
                class="select-filters col-12 col-lg-8 align-items-center d-flex flex-column"
            >
                <div class="input-wrap relative col-12">
                    <input
                        placeholder="Szukaj po nazwie"
                        v-model="filterRequest.event_name"
                        type="text"
                        class="search-input pl-10px"
                    />
                    <i class="fa fa-search search-icon"></i>
                </div>

                <MultiSelect
                    placeholder="Wybierz kategorie"
                    v-model="filterRequest.genres"
                    :options="genres"
                ></MultiSelect>
                <DatePicker
                    format="MM/dd/yyyy"
                    v-model="filterRequest.date"
                ></DatePicker>
                <input
                    id="submitFilter"
                    class="btn cursor-pointer btn-md btn-hovprim mt-30px"
                    type="submit"
                    value="Filtruj"
                />
            </form>
            <Events :events="props.events.data" :genres="props.genres"/>
            <div class="event-pagination" v-if="events.meta.links.length > 3">
                <ul class="ml-auto mr-auto">
                    <li
                        :key="page"
                        class="page"
                        :class="{ 'page-current': page.active }"
                        v-for="page in events.meta.links"
                    >
                        <Link :href="page.url" v-html="page.label"></Link>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
#submitFilter {
    min-width: 200px;
}
</style>
