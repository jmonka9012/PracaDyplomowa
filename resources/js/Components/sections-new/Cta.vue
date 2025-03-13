<script setup>
import { ref } from "vue";
import Poptext from "@/Components/sections-new/Poptext.vue";
import ctaCloud from "~images/cta-cloud.png";
import ctaCalendar from "~images/cat-calendar.png";

const text = ref("Future Events");
</script>

<template>
    <div class="cta-scroller">
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>

        <div class="d-flex flex-row align-items-center">
            <span>Future Events</span>
            <i class="fa fa-arrow-down"></i>
        </div>
    </div>
    <section class="pb-70px pb-lg-105px cta">
        <div class="container container-big">
            <div class="cta-left">
                <p class="sub-title mb-17px">Lorem ipsum</p>
                <h3 class="cta-title mb-20px">
                    The Essential Guide to Upcoming Festivals
                </h3>
                <p class="mb-35px text-gray">
                    Facilisi etiam dignissim diam quis sociis natoque penatibus.
                    Aliquam ut porttitor leo a diam sollicitudin velit sed
                    ullamcorper morbi porta non pulvinar neque.
                </p>
                <a class="btn btn-md morph-outline" href=""> Learn more </a>
            </div>
            <div class="cta-right">
                <Poptext class="poptext-cta" :text="text" />
            </div>
        </div>
        <div class="cta-cloud">
            <img :src="ctaCloud" alt="" />
        </div>
        <div class="cta-calendar">
            <img :src="ctaCalendar" alt="" />
        </div>
    </section>
</template>

<style lang="scss" scoped>
.cta {
    column-gap: 30px;
    background-color: var(--primary);
    background-image: url("/public/images/cta-bg.jpg");
    background-position: center right;
    background-repeat: no-repeat;
    overflow: hidden;
    position: relative;
    .container {
        @include media-breakpoint-up(lg) {
            padding: 0 35px;
        }
    }

    &-left {
        display: flex;
        flex-direction: column;
        padding-top: 30px;
        width: 100%;
        order: 1;
        z-index: 2;

        @include media-breakpoint-up(xl) {
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

        @include media-breakpoint-up(xl) {
            width: 56%;
            padding-top: 100px;
            order: 1;
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

        @include media-breakpoint-up(md) {
            font-size: 58px;
        }
    }

    &-cloud {
        position: absolute;
        transform: translateY(-32px);
        transition: transform linear;
        will-change: transform;
        z-index: 0;
        display: none;
        top: 55%;
        left: 25%;
        width: 100%;
        z-index: 1;
        @include media-breakpoint-up(lg) {
            display: block;
        }
    }

    &-calendar {
        position: absolute;
        z-index: 0;
        width: 100%;
        pointer-events: none;
        transform: translateX(-20px);
        transition: transform linear;
        will-change: transform;
        opacity: 1;
        visibility: visible;
        display: none;
        top: 15%;
        left: 80%;
        max-height: 544px;
        max-width: 390px;
        @include media-breakpoint-up(lg) {
            display: block;
        }

        z-index: 0;
    }
}
</style>
