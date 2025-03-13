<script>
import { Swiper, SwiperSlide } from "swiper/vue";

import Events from "./Events.vue";
import "swiper/swiper-bundle.css";

export default {
    components: {
        Swiper,
        SwiperSlide,
        Events,
    },
    props: {
        events: Array,
    },
    setup() {
        const onSwiper = (swiper) => {
            console.log(swiper);
        };
        const onSlideChange = () => {
            console.log("slide change");
        };

        return {
            onSwiper,
            onSlideChange,
        };
    },
};
</script>

<template>
    <swiper
        class="carousel"
        :slides-per-view="2"
        :space-between="50"
        @swiper="onSwiper"
        @slideChange="onSlideChange"
    >
        <swiper-slide v-for="event in events" :key="event.id">
            <Events v-bind="event" />
        </swiper-slide>
    </swiper>
</template>

<script></script>
