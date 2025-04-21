<script setup>
import heroBg from "~images/bg_home1.jpg";

const props = defineProps({
    genres: {
        type: String,
        required: true,
    },
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
            <form class="hero-form" action="submit">
                <div class="input-wrap hero-input-wrap br-1 b-text-50">
                    <i class="fa fa-search"></i>
                    <input
                        class="hero-input"
                        type="text"
                        placeholder="Wyszukaj po nazwie"
                    />
                </div>
                <div class="input-wrap hero-select-wrap br-1 b-text-50">
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
                <div class="input-wrap hero-select-wrap">
                    <i class="fa fa-map-marker"></i>
                    <select class="hero-select">
                        <option disabled selected value="">Data</option>
                        <option>Today</option>
                        <option>Tommorow</option>
                        <option>This week</option>
                        <option>This weekend</option>
                        <option>Next week</option>
                        <option>Next month</option>
                    </select>
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
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    font-size: 20px;
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
    padding-left: 55px;
    border: 0;
    font-family: "Krona one";
    &::placeholder {
        color: var(--text);
    }
}

.hero-input:focus,
.hero-select:focus {
    outline: none;
}

.hero-input-wrap {
    width: 100%;
}

.hero-select-wrap {
    width: 100%;
    position: relative;
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
        top: calc(50% + 5px);
        transform: translateY(-50%);
        width: 0;
    }
}

.hero-search {
    width: 100%;
    background-color: var(--primary);
    border-radius: 0 4px 4px 0;
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
}

@media screen and (min-width: 992px) {
    .hero-input-wrap {
        width: 30%;
    }

    .hero-select-wrap {
        width: 25%;
    }

    .hero-search {
        width: 20%;
    }
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
