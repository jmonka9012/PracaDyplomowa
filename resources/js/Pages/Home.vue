<script setup>
import Team from "@/Components/Sections/Team.vue";
import Services from "@/Components/Sections/Services.vue";
import CategoriesImg from "@/Components/Sections/Categories-img.vue";
import Events from "@/Components/Sections/Events.vue";
import PostQuery from "@/Components/Sections/PostQuery.vue";
import Cta from "@/Components/Sections/Cta.vue";
import TitleNSub from "@/Components/Partials/TitleNSub.vue";
import Hero from "@/Components/Sections/Hero.vue";
import Poptext from "@/Components/Partials/Poptext.vue";
import { Link } from "@inertiajs/vue3";


import bangPow from "~images/bangpow.jpg";
import greatMilenko from "~images/greatmilenko.jpg";
import hellsPit from "~images/hellspit.jpg";
import jeckelBros from "~images/Jeckelbros.jpg";
import teamOne from "~images/team-1.jpg";
import eventsBg from "~images/events-bg-1.jpg";
import { ref } from "vue";
import { SwiperSlide } from "swiper/vue";

import pageInfo from "@/Utilities/pageInfo";
const { siteData } = pageInfo();

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
    genres: {
        type: Array,
        required: true,
    },
    blog_posts: {
        type: Array,
        required: true,
    }
});

</script>

<template>
    <Hero :genres="genres">
        <template #title>
            <Poptext
                class="d-flex flex-column justify-content-center align-items-center poptext-white"
                :text="siteData.title"
            />
        </template>
    </Hero>
    <Cta />
    <section class="pt-110px pb-100px">
        <div class="container flex-column align-items-center">
            <p class="sub-title sub-title-lprpl mb-20px">bilety na</p>
            <h3 class="title-1 mb-20px">Przyszłe wydarzenia</h3>
            <Events class="" :events="props.events" />
            <Link class="mt-40px btn btn-md" :href="route('event.browser')">Zobacz wszystkie wydarzenia</Link>
        </div>
    </section>
    <CategoriesImg class="pt-60px pb-60px pb-lg-90px" />
    <Services />
    <section class="pt-60px pb-100px">
        <div
            class="container container-big flex-lg-row align-items-start align-items-lg-center justify-content-between"
        >
            <TitleNSub title="Najnowsze posty" subtitle="Blog" class="mb-35px" />
            <Link :href="route('blog')" class="btn btn-md">Zobacz wszystkie</Link>
            <PostQuery :blog_posts="props.blog_posts"></PostQuery>
        </div>
    </section>
<!--    <Team :team="team">
        <template #subtitle>Meet Our Team</template>
        <template #title>Our Professionals</template>
    </Team>-->
    <!-- <section class="pt-100px pb-100px">
        <div class="container">
            <SliderGallery
                :slides-per-view="1"
                :space-between="50"
                :breakpoints="{ 992: { slidesPerView: 2 } }"
            >
                <template #content>
                    <swiper-slide v-for="event in events" :key="event.id">
                        <Events v-bind="event" />
                    </swiper-slide>
                </template>
            </SliderGallery>
        </div>
    </section> -->
</template>
