<script setup>
import Events from "@/Components/Sections/Events.vue";

import eventsBg from "~images/events-bg-1.jpg";

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
});
console.log(props);
</script>

<template>
    <section class="pb-75px">
        <div class="container flex-column align-items-center">
            <p class="sub-title sub-title-lprpl mb-20px">bilety na</p>
            <h3 class="title-1 mb-20px">Przyszłe wydarzenia</h3>
            <Events :events="props.events" />

            <div class="event-pagination">
                <ul>
                    <li class="direction">
                        <!-- ukryć jak jest page 1 -->
                        <a href="#forward">
                            <div class="d-flex">
                                <i class="fa fa-chevron-left"></i>
                                <i class="fa fa-chevron-left"></i>
                            </div>
                            Powróć
                        </a>
                    </li>
                    <li class="page page-current"><a href="#1">1</a></li>
                    <li class="page"><a href="#2">2</a></li>
                    <li class="direction">
                        <a href="#forward"
                            >Dalej
                            <div class="d-flex">
                                <i class="fa fa-chevron-right"></i>
                                <i class="fa fa-chevron-right"></i></div
                        ></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss"></style>
