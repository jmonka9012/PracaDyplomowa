<script>
import { Swiper, SwiperSlide } from "swiper/vue";

import "swiper/swiper-bundle.css";

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    props: {
        breakpoints: Object,
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
        :breakpoints="breakpoints"
        @swiper="onSwiper"
        @slideChange="onSlideChange"
    >
        <slot name="content"></slot>
    </swiper>
</template>
