<script setup>
import HeroSmall from "../../Components/Sections/Hero-small.vue";
import PostQuery from "../../Components/Sections/PostQuery.vue";
import blogBg from "~images/blog-bg.jpg";

const props = defineProps({
    blog_posts: {
        type: Array,
        required: true,
    }
});

</script>

<template>
    <HeroSmall :source="blogBg" title="Blog"></HeroSmall>
    <section class="section pb-120px">
        <div class="container container-small">
            <PostQuery evContClass="ev-cont-lg-three" :blog_posts="props.blog_posts">
            </PostQuery>
        </div>
    </section>
</template>
