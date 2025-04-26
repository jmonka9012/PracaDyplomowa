<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    blog_posts: Array,
    contClass: String,
    evContClass: String,
});
</script>

<template>
    <div :class="['ev-cont', props.evContClass]">
        <div v-for="post in props.blog_posts" :key="post.id" class="event-item">
            <div class="relative">
                <img :src="`/storage/${post.thumbnail_path}`" alt="" class="event-img" />
                <Link :href="`/${post.blog_post_url}`" class="link-stretched"></Link>
            </div>
            <div
                class="d-flex flex-row flex-wrap-wrap align-items-center mb-10px"
            >
                <p class="event-date ff-krona">
                    {{ post.blog_date }}
                </p>
                <span class="divider divider-dark"></span>
<!--                <template v-for="(cat, index) in event.category" :key="index">

                    <span
                        v-if="index < event.category.length - 1"
                        class="divider divider-dark"
                    ></span>
                </template>-->
                <Link :href="'/'" class="btn btn-white">
                    {{ post.blog_post_type }}
                </Link>
            </div>
            <h3 class="event-title2">
                <Link :href="`/${post.blog_post_url}`" class="hover-underline">
                    {{ post.blog_post_name }}
                </Link>
            </h3>
            <Link :href="`/${post.blog_post_url}`" class="read-more">
                Read more
                <i class="fa fa-arrow-right"></i>
            </Link>
        </div>
    </div>
</template>
