<script setup>
import Events from "@/Components/Sections/Events.vue";
import { Link } from "@inertiajs/vue3";

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

function isCurrentPage(pageId) {
    console.log(pageId);
    return window.location.href.endsWith(pageId);
}

console.log(props);
console.log(route('event.browser'));
</script>

<template>
    <section class="pb-75px pt-75px">
        <div class="container flex-column align-items-center">
            <p class="sub-title sub-title-lprpl mb-20px">bilety na</p>
            <h3 class="title-1 mb-20px">Przyszłe wydarzenia</h3>
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
