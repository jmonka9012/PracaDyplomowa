<script setup>
import Poptext from "@/Components/Partials/Poptext.vue";
import ctaCloud from "~images/cta-cloud.png";
import ctaCalendar from "~images/cat-calendar.png";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <section class="pb-70px pb-lg-105px cta">
        <div class="container container--big">
            <div class="cta-left">
                <p class="sub-title mb-17px">Wydarzenia</p>
                <h3 class="cta-title mb-20px">
                    Zobacz na jakie wydarzenia możesz się udać w najbliższym
                    czasie!
                </h3>
                <p class="mb-35px text-gray">
                    Kliknij w poniższy link aby przejść na stronę z najbliższymi
                    eventami. Na pewno znajdziesz coś dla siebie!
                </p>
                <Link
                    :href="route('event.browser')"
                    class="btn btn-md btn-hovprim morph-outline"
                    href=""
                >
                    Zobacz więcej
                </Link>
            </div>
            <div class="cta-right">
                <Poptext class="poptext-cta" text="Najbliższe wydarzenia"/>
            </div>
        </div>
        <div class="cta-cloud">
            <img :src="ctaCloud" alt=""/>
        </div>
        <div class="cta-calendar">
            <img :src="ctaCalendar" alt=""/>
        </div>
    </section>
</template>

<style lang="scss" scoped>
@use "~css/mixin.scss";

.cta {
    column-gap: 30px;
    background-color: var(--primary);
    background-repeat: no-repeat;
    overflow: hidden;
    position: relative;
    border-top: 1px solid var(--primary);
    background-image: url("~images/cta-bg.jpg");
    background-size: 230%;
    background-position: top right;

    @include mixin.media-breakpoint-up(lg) {
        background-size: 100% auto;
        background-position: center left;
    }

    .container {
        @include mixin.media-breakpoint-up(lg) {
            padding: 0 30px;
        }
    }

    &-left {
        display: flex;
        flex-direction: column;
        padding-top: 30px;
        width: 100%;
        order: 1;
        z-index: 2;
        @include mixin.media-breakpoint-up(xl) {
            padding-top: 130px;
            width: 44%;
            order: 0;
            padding-right: 15px;
        }
    }

    &-right {
        display: flex;
        flex-direction: column;
        padding-top: 80px;
        width: 100%;
        order: 0;
        @include mixin.media-breakpoint-up(xl) {
            width: 56%;
            padding-top: 100px;
            order: 1;
            justify-content: center;
        }
    }

    &-scroller {
        background-color: var(--primary);
        width: 100%;
        padding: 18px 0;
        display: flex;
        flex-direction: row;
        border: 1px solid var(--text);
        border-left: 0;
        border-right: 0;
        white-space: nowrap;

        span {
            text-transform: uppercase;
            font-family: "Krona one";
            font-weight: 400;
            letter-spacing: 0.16px;
            line-height: 30px;
        }

        i {
            margin-right: 38px;
            margin-left: 32px;
            color: var(--text);
            display: inline-block;
            position: relative;
            vertical-align: middle;
            font-size: 16px;
            font-weight: 400;
        }
    }

    &-title {
        font-size: 26px;
        line-height: 1.24em;
        font-weight: 500;
        @include mixin.media-breakpoint-up(md) {
            font-size: 58px;
        }
    }

    &-cloud {
        position: absolute;
        transition: transform linear;
        will-change: transform;
        // display: none;
        top: 65%;
        left: 15%;
        width: 100%;
        z-index: 1;
        animation: cloudWiggle 5s infinite ease-in-out;
        @include mixin.media-breakpoint-up(lg) {
            display: block;
            top: 55%;
            left: 25%;
        }
    }

    &-calendar {
        position: absolute;
        pointer-events: none;
        transition: transform linear;
        will-change: transform;
        opacity: 1;
        visibility: visible;
        top: 15%;
        left: 80%;
        width: 100%;
        max-width: 150px;
        z-index: 0;
        animation: cloudWiggle 5s infinite ease-in-out;
        animation-delay: 1s;
        @include mixin.media-breakpoint-up(lg) {
            display: block;
            max-height: 544px;
            max-width: 390px;
        }
    }
}

@keyframes cloudWiggle {

    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(40px);
    }
}
</style>
