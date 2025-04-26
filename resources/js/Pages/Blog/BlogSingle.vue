<script setup>
import PostQuery from "../../Components/Sections/PostQuery.vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import { Link } from "@inertiajs/vue3";

import blogBg from "~images/blog-bg.jpg";

const props = defineProps({
    blog_post: {
        type: Array,
        required: true
    }
});

const post = props.blog_post.data;

console.log(props.blog_post);

</script>

<template>

    <HeroSmall :source="`/storage/${post.thumbnail_path}`" :title="post.blog_post_name"></HeroSmall>
    <section>
        <div class="container">
            <div class="col-12 d-flex flex-lg-row row-gap-30px">
                <div class="col-12 col-lg-4">
                    <div
                        class="d-flex flex-row flex-wrap-wrap justify-content-center align-items-center bg-primary pt-12px pb-12px pl-6px pr-6px column-gap-5px border-radius-12px text-white"
                    >
                        <Link>{{ post.blog_post_type }}</Link>
                    </div>
                </div>
                <div
                    class="col-12 col-lg-4 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-calendar mr-5px"></i>
                    <span>{{post.updated_at}}</span>
                </div>
                <div
                    class="col-12 col-lg-4 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-user mr-5px"></i>
                    {{ post.author.author_name}}
                </div>
            </div>

            <div
                class="col-12 d-flex flex-column align-items-center justify-content-center mt-lg-80px mt-50px"
                v-html="post.blog_post_content"
            >

            </div>
            <div class="blog-single__bottom">
                <div class="col-12 col-lg-4">
                    <div
                        class="d-flex flex-row flex-wrap-wrap justify-content-center align-items-center bg-primary pt-12px pb-12px pl-6px pr-6px column-gap-5px border-radius-12px text-white"
                    >
                        <Link>{{ post.blog_post_type }}</Link>
                    </div>
                </div>
                <div
                    class="col-12 col-lg-4 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-calendar mr-5px"></i>
                    <span>{{post.updated_at}}</span>
                </div>
                <div
                    class="col-12 col-lg-4 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-user mr-5px"></i>
                    {{ post.author.author_name}}
                </div>
                <div
                    class="col-12 col-lg-3 d-flex justify-content-center align-items-center"
                >
                    <Link :href="route('blog')" class="hover-primary"
                    ><i class="fa fa-arrow-left"></i> Widok Listy</Link
                    >
                </div>
            </div>
        </div>
        <section class="section pb-100px">
            <div class="container container-small">
                <PostQuery evContClass="ev-cont-lg-three" :latest="latest">
                </PostQuery>
            </div>
        </section>
    </section>

</template>
