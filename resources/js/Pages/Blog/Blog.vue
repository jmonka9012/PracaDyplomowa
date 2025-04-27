<script setup>
import HeroSmall from "../../Components/Sections/Hero-small.vue";
import PostQuery from "../../Components/Sections/PostQuery.vue";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';

import blogBg from "~images/blog-bg.jpg";

const props = defineProps({
    blog_posts: {
        type: Array,
        required: true,
    }
});

console.log(props);

const currentCategory = ref(null);

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    currentCategory.value = params.get('blog_post_type');
});

</script>

<template>
    <HeroSmall :source="blogBg" title="Blog"></HeroSmall>
    <section class="section pb-120px">
        <div class="container container-small">
            <h3 v-if="currentCategory" class="mb-40px"> Posty z kategorii: {{currentCategory}}</h3>
            <PostQuery class="mb-50px" evContClass="ev-cont-lg-three" :blog_posts="props.blog_posts.data">
            </PostQuery>
            <div class="event-pagination">
                <ul class="ml-auto mr-auto">
                    <li
                        :key="page"
                        class="page"
                        :class="{ 'page-current': page.active }"
                        v-for="page in blog_posts.meta.links"
                    >
                        <Link :href="page.url" v-html="page.label"></Link>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>
