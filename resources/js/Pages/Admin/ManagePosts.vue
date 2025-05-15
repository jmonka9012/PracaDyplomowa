<script setup>
import blogBg from "~images/blog-bg.jpg";

import HeroSmall from "@/Components/Sections/Hero-small.vue";

import { Link } from "@inertiajs/vue3";

const props = defineProps({
    blog_posts: {
        required: true,
    },
});

console.log(props);
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
            <div class="col-12 mt-30px mb-30px overflow-x-scroll">
                <table class="table-nowrap table-fixed">
                    <thead>
                        <tr>
                            <th class="t-details-events__input">
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select all users"
                                />
                            </th>
                            <th class="t-details-events__main-img">
                                Obrazek Główny
                            </th>
                            <th class="t-details-events__name">
                                <a href="#username-sort"
                                    >Nazwa
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th class="t-details-events__url">Url</th>
                            <th class="t-details-events__date">Data</th>
                            <th class="t-details-events__start">
                                Początek (h)
                            </th>
                            <th class="t-details-events__end">Koniec (h)</th>
                            <th class="t-details-events__loc">Lokalizacja</th>
                            <th class="t-details-events__e-main">Email gł.</th>
                            <th class="t-details-events__e-add">
                                Email dodatkowy
                            </th>
                            <th class="t-details-events__desc">Opis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="post in props.blog_posts.data"
                            class="t-details"
                        >
                            <td class="t-details__select">
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select @name event"
                                />
                            </td>
                            <td>
                                <img
                                    :src="`/storage/${post.thumbnail_path}`"
                                    class="t-details__pic mr-0"
                                />
                            </td>
                            <td>
                                <a href="#event-link">{{
                                    post.blog_post_name
                                }}</a>
                                <div class="t-details__options">
                                    <a href="#delete">Usuń</a>
                                    <Link :href="`/${post.blog_post_url}`"
                                        >Zobacz</Link
                                    >
                                </div>
                            </td>
                            <td>/Lorem-ipsum-1</td>
                            <td>1.04</td>
                            <td>16:00</td>
                            <td>24:00</td>
                            <td>Sala nr 1</td>
                            <td><a href="#email-main">Główny email</a></td>
                            <td><a href="#email-add">Dodatkowy email</a></td>
                            <td class="t-details-events__td-desc">
                                <a href="text-primary">Podgląd</a>
                            </td>
                        </tr>
                    </tbody>
                    <!--
                    <tfoot>
                        <tr>
                            <th>
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select all users"
                                />
                            </th>
                            <th>Obrazek Główny</th>

                            <th>
                                <a href="#username-sort"
                                    >Nazwa
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th>Url</th>
                            <th>Data</th>
                            <th>Początek (h)</th>
                            <th>Koniec (h)</th>
                            <th>Lokalizacja</th>
                            <th>Email gł.</th>
                            <th>Email dodatkowy</th>
                            <th>Opis</th>
                        </tr>
                    </tfoot>
-->
                </table>
            </div>
            <h1 class="mb-30px">Odebrane dane z backendu</h1>
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
                        <Link
                            class="btn btn-md col-12"
                            method="delete"
                            preserve-scroll
                            :href="route('admin.posts.delete')"
                            :data="{ blog_id: post.id }"
                            :only="['blog_posts']"
                        >
                            Usuń
                        </Link>
                        <Link
                            class="btn btn-md col-12"
                            :href="`/${post.blog_post_url}`"
                            >Podgląd</Link
                        >
                    </div>
                    <div></div>
                </div>
            </div>
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

<style scoped lang="scss">
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
    @include mixin.media-breakpoint-up(md) {
        flex-direction: row;
        justify-content: space-between;
    }
    @include mixin.media-breakpoint-up(lg) {
        grid-template-columns: repeat(7, auto);
        display: grid;
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
