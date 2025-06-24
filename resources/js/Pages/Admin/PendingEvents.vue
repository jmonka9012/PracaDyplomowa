<script setup>
import blogBg from "~images/blog-bg.jpg";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";
import DatePicker from "@/Components/Partials/DatePicker.vue";
import MultiSelect from "@/Components/Partials/MultiSelect.vue";
import {Link} from "@inertiajs/vue3";
import EventTable from "../../Components/Partials/EventTable/EventTable.vue";
import { router } from "@inertiajs/vue3";

const filterRequest = ({
    event_name: null,
    event_genres: null,
    event_date: null,
    pending_name: null,
    pending_genres: null,
    pending_date: null,
});

const props = defineProps({
    events: {
        required: true,
        type: Array,
    },
    pending_events: {
        required: true,
        type: Array,
    },
    genres: {
        required: true,
        type: Array,
    }
});

console.log(props.genres)

function submitFilterRequest() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('tabName')) {
        filterRequest.tabName = params.get('tabName');
    }

    router.get(route("admin.events"),filterRequest, {
        replace: true,
        only: ['events', 'pending_events'],
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
    <HeroSmall :source="blogBg" title="Zarządzaj wydarzeniami"></HeroSmall>
    <section class="pb-100px">
        <div class="container">
            <Tabs class="col-12">
                <Tab title="Zatwierdzone wydarzenia">
                    <h3 class="mb-30px">Zatwierdzone wydarzenia</h3>
                    <form
                        class="select-filters col-12 col-lg-8 align-items-center d-flex flex-column"
                        @submit.prevent="submitFilterRequest()">
                        <div class="input-wrap relative col-12">
                            <input
                                v-model="filterRequest.event_name"
                                class="search-input pl-10px"
                                placeholder="Szukaj po nazwie"
                                type="text"/>
                            <i class="fa fa-search search-icon"></i>
                        </div>
                        <MultiSelect
                            v-model="filterRequest.event_genres"
                            :options="props.genres"
                            placeholder="Wybierz kategorie"
                        ></MultiSelect>
                        <DatePicker
                            v-model="filterRequest.event_date"
                            format="MM/dd/yyyy"
                        ></DatePicker>
                        <input
                            id="submitFilter"
                            class="btn cursor-pointer btn-md btn-hovprim mt-30px"
                            type="submit"
                            value="Filtruj"
                        />
                    </form>
                    <EventTable v-show="Object.keys(props.events.data).length>0" :events="props.events.data" class="mb-40px col-12"></EventTable>
                    <div v-show="Object.keys(props.events.data)===0">Brak wyników</div>
                    <div class="event-pagination">
                        <ul class="ml-auto mr-auto">
                            <li v-for="page in props.events.meta.links"
                                :key="page"
                                :class="{ 'page-current': page.active }"
                                class="page">
                                <Link preserve-state :only="['events']" :href="page.url" v-html="page.label"></Link>
                            </li>
                        </ul>
                    </div>
                </Tab>
                <Tab title="Oczekujące wydarzenia">
                    <h3 class="mb-30px">Wydarzenia czekające na zatwierdzenie</h3>
                    <form
                        class="select-filters col-12 col-lg-8 align-items-center d-flex flex-column"
                        @submit.prevent="submitFilterRequest()">
                        <div class="input-wrap relative col-12">
                            <input
                                v-model="filterRequest.pending_name"
                                class="search-input pl-10px"
                                placeholder="Szukaj po nazwie"
                                type="text"/>
                            <i class="fa fa-search search-icon"></i>
                        </div>
                        <MultiSelect
                            v-model="filterRequest.pending_genres"
                            :options="props.genres"
                            placeholder="Wybierz kategorie"
                        ></MultiSelect>
                        <DatePicker
                            v-model="filterRequest.pending_date"
                            format="MM/dd/yyyy"
                        ></DatePicker>
                        <input
                            id="submitFilter"
                            class="btn cursor-pointer btn-md btn-hovprim mt-30px"
                            type="submit"
                            value="Filtruj"
                        />
                    </form>
                    <EventTable v-show="Object.keys(props.pending_events.data).length>0" :events="props.pending_events.data" :pending="true" class="mb-40px col-12"></EventTable>
                    <div v-show="Object.keys(props.pending_events.data)===0">Brak wyników</div>
                    <div class="event-pagination">
                        <ul class="ml-auto mr-auto">
                            <li v-for="page in props.pending_events.meta.links"
                                :key="page"
                                :class="{ 'page-current': page.active }"
                                class="page">
                                <Link preserve-state :only="['pending_events']" :href="page.url" v-html="page.label"></Link>
                            </li>
                        </ul>
                    </div>
                </Tab>
                <Tab title="Zakończone wydarzenia">
                    <h3>?</h3>
                </Tab>
            </Tabs>
        </div>
    </section>
</template>

<style lang="scss" scoped></style>
