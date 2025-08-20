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
    },
    featured_categories: {
        type: Array,
        required: true,
    }
});

console.log(props);

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
            <p class="sub-title sub-title--lprpl mb-20px">bilety na</p>
            <h3 class="title-1 mb-20px">Przyszłe wydarzenia</h3>
            <Events class="" :events="props.events" />
            <Link
                class="mt-40px btn btn--md btn--hovprim btn-hover-border"
                :href="route('event.browser')"
                >Zobacz wszystkie wydarzenia</Link>
        </div>
    </section>
    <CategoriesImg :genres="props.featured_categories" class="pt-60px pb-60px pb-lg-90px" />
    <Services />
    <section class="pt-60px pb-100px">
        <div
            class="container container--big flex-lg-row align-items-start align-items-lg-center justify-content-between"
        >
            <div class="mb-35px flex-column align-items-start-start flex-lg-row d-flex align-items-lg-end col-12 justify-content-lg-between">
                <TitleNSub
                    title="Najnowsze posty"
                    subtitle="Blog"
                />
                <Link :href="route('blog')" class="btn btn--md btn--hovprim btn-hover-border"
                >Zobacz wszystkie</Link
                >
            </div>
            <PostQuery :blog_posts="props.blog_posts"></PostQuery>
        </div>
    </section>
</template>
