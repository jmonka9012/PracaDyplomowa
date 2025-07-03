<script setup>
import catImage from "~images/cat-img-bg-1.jpg";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    genres: {
        type: Array,
        required: true,
    }
});
console.log(props.genres);
</script>

<template>
    <section v-bind="$attrs">
        <div class="container cat-cont">
            <div v-for="genre in props.genres" class="cat-item">
                <Link :href="route('event.browser', {genres: genre.genre_id})" class="link-stretched z-1"></Link>
                <img class="cat-img" :src="`/storage/${genre.image_path}`" alt="" />
                <h3 class="cat-name">{{genre.genre_name}}</h3>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
@use "~css/mixin.scss";
.cat-cont {
    display: grid;
    grid-template-columns: 1fr;
    column-gap: 30px;
    justify-content: center;
    align-items: center;
    row-gap: 30px;

    @include mixin.media-breakpoint-up(md) {
        grid-template-columns: repeat(5, 1fr);
    }
}

.cat-img {
    width: 150px;
    clip-path: polygon(
        clamp(0px, 0px, 100%) clamp(0px, -30px, 100%),
        clamp(0px, 100% - 0px * -1, 100%) clamp(0px, -30px * -1, 100%),
        clamp(0px, 100% - 0px, 100%) clamp(0px, 100% - -30px, 100%),
        clamp(0px, 0px * -1, 100%) clamp(0px, 100% - -30px * -1, 100%)
    );
    transition: 0.3s;
    position: relative;
}

.cat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
}

.cat-item:hover .cat-img {
    clip-path: polygon(
        clamp(0px, 0px, 100%) clamp(0px, 30px, 100%),
        clamp(0px, 100% - 0px * -1, 100%) clamp(0px, 30px * -1, 100%),
        clamp(0px, 100% - 0px, 100%) clamp(0px, 100% - 30px, 100%),
        clamp(0px, 0px * -1, 100%) clamp(0px, 100% - 30px * -1, 100%)
    );
}

.cat-name {
    font-size: 22px;
    margin: 15px 0px 0px 0px;
    position: relative;
    z-index: 1;
    line-height: 1.5;
    word-break: break-word;
    transition: 0.4s;
    font-weight: 500;
    text-align: center;
}
</style>
