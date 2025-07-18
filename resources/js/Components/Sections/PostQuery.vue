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
        <div v-for="post in props.blog_posts" :key="post.id" class="post-item">
            <div class="relative br-8px post-item__photo-container">
                <img :src="`/storage/${post.thumbnail_path}`" alt="" class="event-img post-item__photo" />
                <Link :href="`/${post.blog_post_url}`" class="link-stretched"></Link>
            </div>
            <div
                class="d-flex flex-row flex-wrap-wrap align-items-center mb-10px"
            >
                <p class="event-date ff-krona">
                    {{ post.blog_date }}
                </p>
                <span class="divider divider-dark"></span>
                <Link :href="route('blog')"
                      :data="{blog_post_type: post.blog_post_type}"
                      class="btn btn-white post-item__category-pill">
                    {{ post.blog_post_type }}
                </Link>
            </div>
            <h4 class="post-item__title">
                <Link :href="`/${post.blog_post_url}`">
                    {{ post.blog_post_name }}
                </Link>
            </h4>
            <Link :href="`/${post.blog_post_url}`" class="read-more">
                Czytaj dalej
                <i class="fa fa-arrow-right"></i>
            </Link>
        </div>
    </div>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";

.post-item {

    &:hover {
        .post-item__photo {
            transform: scale(1.05);
        }

        .post-item__title a {
            background-size: 100% 6px;
        }
    }

    &__category-pill {
        &:hover {
            color: white;
        }
    }

    &__photo {
        transition: transform .3s ease-out;
        margin-bottom: 0;
        height: 100%;
        max-height: unset;
        &-container {
            overflow: hidden;
            height: fit-content;
            display: flex;
            margin-bottom: 20px;
        }
    }

    &__title {
        margin-bottom: 20px;
        line-height: 36px;
        min-height: 77px;

        a {
            font-size: 26px;
            gap: 0;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline;
            transition: all 0.5s ease-out;
            background: linear-gradient(
                    to bottom,
                    var(--primary) 0%,
                    var(--primary) 98%
            );
            background-size: 0 16px;
            background-repeat: no-repeat;
            background-position: left 100%;

            &:hover {
                background-size: 100% 6px;
            }
        }
    }
}

</style>
