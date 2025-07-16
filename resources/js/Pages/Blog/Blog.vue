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
    <section class="section pb-120px">
        <div class="container container-small flex-column align-items-start justify-content-start">
            <form @submit.prevent="FilterBlog()" class="mb-40px form">
                <div class="col-12 d-flex flex-lg-row align-items-lg-center column-gap-20px row-gap-10px row-gap-lg-20px mb-30px">    
                    <div class="col-6 col-xl-8 d-flex flex-lg-row relative">  
                         <label class="w-fit ws-nowrap" for="search">Wyszukaj po nazwie</label>
                        <i class="fa fa-search search-icon"></i>
                        <input name="search" :placeholder="currentSearchPhrase" v-model="filterRequest.blog_post_name" type="text">
                    </div>
                    <label class="ml-lg-auto" for="category">Wyszukaj po kategorii</label>
                    <select class="select--lg-desk" name="category" v-model="filterRequest.blog_post_type">
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
                 <input class="btn btn-md cursor-pointer btn-hovprim" type="submit">
            </form>
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
