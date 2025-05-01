<script setup>
import heroBg from "~images/bg_home1.jpg";
import DatePicker from "@/Components/Partials/DatePicker.vue";
import { reactive, watch, computed, ref } from "vue";

const props = defineProps({
    genres: {
        type: String,
        required: true,
    },
});

<<<<<<< Updated upstream
const searchForm = reactive({
    phrase: null,
    genres: null,
    date: null,
});

function SearchEvents() {

}
=======
>>>>>>> Stashed changes
const filterRequest = reactive({
    date: null,
});
</script>

<template>
    <section class="hero">
        <div class="hero-bg">
            <img :src="heroBg" alt="" />
        </div>
        <div class="container">
            <div
                class="d-flex flex-column align-items-center justify-content-center col-12 mb-150px"
            >
                <slot name="title">
                    <h1 class="title-1">
                        {{ title }}
                    </h1>
                </slot>
            </div>
            <form class="hero-form" @submit.prevent="SearchEvents()">
                <div class="input-wrap hero-input-wrap">
                    <i class="fa fa-search"></i>
                    <input
                        class="hero-input"
                        type="text"
                        placeholder="Wyszukaj po nazwie"
                    />
                </div>
                <div class="input-wrap hero-select-wrap">
                    <i class="fa fa-th-list"></i>
                    <select class="hero-select">
                        <option disabled selected value="">
                            Wybierz kategorię
                        </option>
                        <option
                            :key="genre.id"
                            :value="genre.id"
                            v-for="genre in genres"
                        >
                            {{ genre.genre_name }}
                        </option>
                    </select>
                </div>
                <div class="input-wrap hero-select-wrap hero-select-wrap-data">
                    <DatePicker
                        class="datepicker-hero"
                        v-model="filterRequest.date"
                        format="MM/dd/yyyy"
                    ></DatePicker>
                </div>
                <button class="hero-search">Search</button>
            </form>
        </div>
    </section>
</template>

<style lang="scss" scoped>
@use "~css/mixin.scss";
.hero {
    position: relative;
    padding-top: 240px;
    padding-bottom: 210px;

    &__text {
        width: 73%;
    }
    &__under {
        position: absolute;
        bottom: 70px;
        right: 0;
        @include mixin.media-breakpoint-up(lg) {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
    }
    &-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
    &-overlay {
        background-color: rgba(0, 0, 0, 0.42);
        opacity: 0.73;
        z-index: 0;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
}

.hero-form {
    margin: 40px 0px 45px 0px;
    width: 100%;
    display: flex;
    flex-direction: column;
    row-gap: 20px;
    z-index: 1;
    background-color: white;
    border-radius: 8px;
}

@media screen and (min-width: 992px) {
    .hero-form {
        flex-direction: row;
        margin: 58px 0px 20px 0px;
    }
}

.input-wrap {
    position: relative;
}

.input-wrap .fa {
    position: absolute;
    color: var(--primary);
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    font-size: 16px;
    display: block;
}

.hero-input,
.hero-select {
    box-shadow: none;
    min-height: 60px;
    font-size: 15px;
    display: block;
    padding: 0.375rem 0.75rem;
    font-size: 12px;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    appearance: none;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    width: 100%;
    padding-left: 40px;
    border: 0;
    font-family: "Krona one";
    &::placeholder {
        color: #495057;
    }
}

.hero-input:focus,
.hero-select:focus {
    outline: none;
}

.hero-input-wrap {
    width: 100%;
    border-right: 1px solid var(--primary-lighter);
    border-radius: 8px 0 0 8px;
    input {
        border-radius: 8px 0 0 8px;
    }
    @include mixin.media-breakpoint-down(xl) {
        border-radius: 8px 8px 0px 0px;
        input {
            border-radius: 8px 8px 0px 0px;
        }
    }
}

.hero-select-wrap {
    width: 100%;
    position: relative;
    border-right: 1px solid var(--primary-lighter);
    &:last-of-type {
        border-right: 0;
    }
    &::after {
        position: absolute;
        display: block;
        content: "";
        right: 15px;
        border-color: #888 transparent transparent transparent;
        border-style: solid;
        border-width: 5px 4px 0 4px;
        height: 0;
        margin-left: -4px;
        margin-top: -2px;
        position: absolute;
        top: calc(50%);
        transform: translateY(-50%);
        width: 0;
    }
    &-data {
        &::after {
            display: none;
        }
    }
}

.hero-search {
    width: 100%;
    background-color: var(--primary);
    border-radius: 0 8px 8px 0;
    width: 100%;
    display: inline-block;
    height: 60px;
    color: white;
    font-size: 18px;
    font-weight: 600;
    line-height: 35px;
    transition: all 0.3s ease;
    border: 1px solid var(--primary);
    &:hover {
        background-color: var(--text);
        border-color: var(--text);
    }
    @include mixin.media-breakpoint-down(xl) {
        border-radius: 0px 0px 8px 8px;
        input {
            border-radius: 0px 0px 8px 8px;
        }
    }
}

@media screen and (min-width: 992px) {
    .hero-input-wrap {
        width: 25%;
    }

    .hero-select-wrap {
        width: 25%;
    }
    .hero-select-wrap-data {
        width: 30%;
    }

    .hero-search {
        width: 20%;
    }
}
.hero-select {
    border-radius: 0;
}
.hero-select option {
    padding: 6px 20px !important;
    appearance: none;
    font-family: "Krona one";
    font-weight: 400;
    font-size: 16px;
    line-height: 23px;
    letter-spacing: 0px;
}

.hero-select option:hover {
    background-color: var(--orange);
    color: white;
}
</style>
