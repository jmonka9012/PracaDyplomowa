<script setup>
import HeroSmall from "../../Components/Sections/Hero-small.vue";
import PostQuery from "../../Components/Sections/PostQuery.vue";
import { Link, router } from "@inertiajs/vue3";
import {ref, onMounted, reactive} from 'vue';

import blogBg from "~images/blog-bg.jpg";

const props = defineProps({
    blog_posts: {
        type: Array,
        required: true,
    },
    blogPostTypes: {
        type: Array,
        required: true
    }
});


const filterRequest = reactive({
    blog_post_name: null,
    blog_post_type: null
});

const currentCategory = ref(null);
const currentSearchPhrase = ref(null);

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    currentCategory.value = params.get('blog_post_type');
    currentSearchPhrase.value = params.get('blog_post_name');
    console.log(props);
});

function FilterBlog() {
    console.log(filterRequest);

    router.get(
        route('blog', filterRequest), {
            preserveScroll: true,
            only: ['blog_posts'],
            onError: (err) => {
            },
            onSuccess: (test) => {
                console.log(test);
            },
        })
}

</script>

<template>
    <HeroSmall :source="blogBg" title="Blog"></HeroSmall>
    <section class="section pb-80px">
        <div class="container container--small flex-column justify-content-start">
            <form @submit.prevent="FilterBlog()" class="form">
                <div class="blog-search">
                    <div class="blog-search__col">
                        <label class="w-fit ws-nowrap blog-search__label" for="search">Wyszukaj po nazwie</label>
                        <div class="d-flex flex-row align-items-center column-gap-10px flex-wrap-nowrap relative">
                            <input class="col-11" name="search" :placeholder="currentSearchPhrase" v-model="filterRequest.blog_post_name" type="text">
                            <i class="fa fa-search search-icon "></i>
                        </div>
                    </div>
                    <div class="blog-search__col">
                        <label class=" blog-search__label" for="category">Wyszukaj po kategorii</label>
                        <select class="select--lg-desk col-12" name="category" v-model="filterRequest.blog_post_type">
                            <option :value="null">
                                Jakakolwiek
                            </option>
                            <option
                                :value="category"
                                v-for="category in props.blogPostTypes"
                            >
                                {{ category }}
                            </option>
                        </select>
                    </div>
                    <div class="blog-search__col blog-search__col-btn" >
                        <button class="btn btn-md cursor-pointer btn-hovprim btn-hover-border blog-search__button" type="submit">Szukaj</button>
                    </div>
                </div>
            </form>
            <h3 v-if="currentCategory" class="mb-40px"> Posty z kategorii: {{currentCategory}}</h3>
            <PostQuery class="mb-50px" evContClass="ev-cont-lg-three" :blog_posts="props.blog_posts.data">
            </PostQuery>
            <div class="event-pagination" v-if="blog_posts.meta.links.length > 3">
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

<style scoped lang="scss">
@use "~css/mixin.scss";

.blog-search {
    display: grid;
    grid-template-columns: 1fr;
    width: 100%;
    gap: 30px;
    align-items: stretch;
    margin-bottom: 60px;

    @include mixin.media-breakpoint-up(lg) {
        grid-template-columns: .5fr .4fr .2fr;
    }

    &__col {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 10px;

        @include mixin.media-breakpoint-up(lg) {
            gap: 20px;
        }
        &-btn {

        }
    }

    &__button {
        display: block;
        margin-top: auto;

        @include mixin.media-breakpoint-up(lg) {
            margin-left: auto;
        }
    }
}

</style>
