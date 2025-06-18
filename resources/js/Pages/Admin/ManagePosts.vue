<script setup>
import { ref, reactive, onMounted } from "vue";
import blogBg from "~images/blog-bg.jpg";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import { Link, router } from "@inertiajs/vue3";

const activePostId = ref(null);

const props = defineProps({
    blog_posts: {
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

function FilterPosts() {
    console.log(filterRequest);

    router.get(
        route('admin.posts', filterRequest), {
            preserveScroll: true,
            only: ['blog_posts'],
        })
}

const currentSearchPhrase = ref(null);

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    currentSearchPhrase.value = params.get('blog_post_name');
});

</script>

<template>
    <HeroSmall :source="blogBg" title="Zarządzaj postami"></HeroSmall>
    <section>
        <div class="container">
            <div class="col-12 d-flex flex-lg-row align-items-lg-center">
                <h2 class="mb-20px mb-lg-0">Posty</h2>
                <Link
                    :href="route('blog-create')"
                    class="ml-lg-20px btn btn-md btn-hovprim"
                    >Dodaj nowy</Link
                >
            </div>
            <form @submit.prevent="FilterPosts()" class="mb-40px">
                <div class="d-flex flex-row align-items-center">
                    <input :placeholder="currentSearchPhrase" v-model="filterRequest.blog_post_name" type="text">
                    <select v-model="filterRequest.blog_post_type">
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
            <div class="col-12">
                <div
                    class="post-list-item"
                    v-for="post in props.blog_posts.data"
                >
                    <div class="post-list-item-col">
                        <div>Obrazek</div>
                        <img
                            class="max-100"
                            :src="`/storage/${post.thumbnail_path}`"
                            alt=""
                        />
                    </div>
                    <div class="post-list-item-col">
                        <div>ID posta:</div>
                        <div>{{ post.id }}</div>
                    </div>
                    <div class="post-list-item-col">
                        <div>Nazwa</div>
                        <Link :href="`/${post.blog_post_url}`">{{
                            post.blog_post_name
                        }}</Link>
                    </div>
                    <div class="post-list-item-col">
                        <div>Kategoria posta:</div>
                        <div>{{ post.blog_post_type }}</div>
                    </div>
                    <div class="post-list-item-col">
                        <div>Data dodania:</div>
                        <div>{{ post.blog_date }}</div>
                    </div>
                    <div class="post-list-item-col">
                        <div>Autor:</div>
                        <div>{{ post.author_name }}</div>
                    </div>
                    <div class="post-list-item-col post-list-item-col-btns">
                        <button
                            class="btn btn-md btn-hovprim col-12"
                            @click="activePostId = post.id"
                        >
                            Usuń
                        </button>
                        <Link
                            class="btn btn-md btn-hovprim col-12"
                            :href="`/${post.blog_post_url}`"
                            >Podgląd</Link
                        >
                    </div>
                    <div
                        v-if="activePostId === post.id"
                        @click.self="activePostId = null"
                        class="post-list-item-popup-holder"
                    >
                        <div class="post-list-item-popup">
                            <p class="mb-30px">
                                Czy na pewno chcesz usunąć posta ?
                            </p>
                            <div
                                class="d-flex flex-row justify-content-between"
                            >
                                <Link
                                    class="btn btn-md btn-hovprim w-fit"
                                    method="delete"
                                    preserve-scroll
                                    :href="route('admin.posts.delete')"
                                    :data="{ blog_id: post.id }"
                                >
                                    Usuń
                                </Link>
                                <button
                                    class="popup__close"
                                    @click="activePostId = null"
                                >
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="event-pagination pb-100px">
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

<style lang="scss">
@use "~css/mixin.scss";
.max-100 {
    width: 100px;
    height: 100px;
    object-fit: cover;
    display: block;
}
.post-list-item {
    display: flex;
    flex-direction: column;
    padding-bottom: 20px;
    margin-bottom: 40px;
    border-bottom: 1px solid rgb(0, 0, 0, 0.1);
    position: relative;
    @include mixin.media-breakpoint-up(md) {
        flex-direction: row;
        justify-content: space-between;
    }
    @include mixin.media-breakpoint-up(lg) {
        grid-template-columns: repeat(7, auto);
        display: grid;
    }
    &-popup {
        width: 50vw;
        background-color: white;
        border: 1px solid var(--primary);
        border-radius: 18px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        position: relative;
        @include mixin.media-breakpoint-down(lg) {
            width: calc(100% - 15px);
            padding: 15px;
        }
        &-holder {
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 100vw;
        }
        .popup__close {
            background-color: transparent;
            @include mixin.media-breakpoint-down(lg) {
                top: 5px;
                right: 5px;
            }
        }
    }
}
.post-list-item-col {
    row-gap: 5px;
    display: flex;
    flex-direction: column;
    border-bottom: 1px solid rgb(0, 0, 0, 0.1);
    padding-bottom: 10px;
    padding-top: 10px;
    &:first-of-type {
        padding-bottom: 20px;
    }
    &:nth-last-of-type(3),
    &:first-of-type {
        margin-bottom: 10px;
    }
    &:last-of-type,
    &:nth-last-of-type(2) {
        border-bottom: 0;
    }
    @include mixin.media-breakpoint-up(md) {
        row-gap: 20px;
        padding: 0 10px;
        border-bottom: 0;
        &:nth-last-of-type(3),
        &:first-of-type {
            margin-bottom: 0;
        }
    }
}
</style>
