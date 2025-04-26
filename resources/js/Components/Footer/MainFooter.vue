<script setup>
import fbWhite from "~icons/facebook-circle-white.svg";
import twWhite from "~icons/twitter-circle-white.svg";
import insWhite from "~icons/instagram-circle-white.svg";
import logoW from "~icons/logoipsum-364.svg";

import Poptext from "@/Components/Sections/Poptext.vue";
import { Link } from "@inertiajs/vue3";

import pageInfo from "@/Utilities/pageInfo";
const { siteData } = pageInfo();
</script>

<template>
    <section class="footer">
        <div class="container">
            <div
                class="col-12 col-lg-3 d-flex flex-column text-align-center text-align-lg-start align-items-center align-items-lg-start"
            >
                <p class="footer__heading">Event machen</p>
                <ul>
                    <li class="justify-content-center justify-content-lg-start">
                        <Link
                            class="text-primary hover-white mb-15px"
                            :href="route('home')"
                            ><span>Strona główna</span></Link
                        >
                    </li>
                    <li class="justify-content-center justify-content-lg-start">
                        <Link
                            class="text-primary hover-white mb-15px"
                            :href="route('event.browser')"
                            ><span>Wydarzenia</span></Link
                        >
                    </li>
                    <li class="justify-content-center justify-content-lg-start">
                        <Link
                            class="text-primary hover-white mb-15px"
                            :href="route('about-us')"
                            ><span>O nas</span></Link
                        >
                    </li>
                    <li class="justify-content-center justify-content-lg-start">
                        <Link class="text-primary mb-15px" :href="route('blog')"
                            ><span>Blog</span></Link
                        >
                    </li>
                    <li class="justify-content-center justify-content-lg-start">
                        <Link
                            class="text-primary hover-white mb-15px"
                            :href="route('contact')"
                            ><span>Kontakt</span></Link
                        >
                    </li>
                    <li class="justify-content-center justify-content-lg-start">
                        <Link
                            class="text-primary hover-white mb-30px"
                            :href="route('ce')"
                            ><span>CE</span></Link
                        >
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-6 d-flex flex-column align-items-center">
                <Link :href="route('home')">
                    <Poptext
                        class="flex-column justify-content-center align-items-center poptext-white poptext-footer"
                        :text="siteData.title"
                    />
                </Link>
                <p class="text-align-center mb-25px">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    Accusantium, eveniet.
                </p>
                <div class="d-flex flex-row justify-content-center mb-35px">
                    <a class="text-white hover-primary" href="/public"
                        >Privacy Policy</a
                    ><span class="text-white divider"></span
                    ><a class="text-white hover-primary" href="/public"
                        >Terms of use</a
                    >
                </div>
                <div class="d-flex flex-row w-fit justify-content-between">
                    <a class="morph-btn footer__icon" href="">
                        <img :src="fbWhite" alt="Facebook"
                    /></a>
                    <a class="morph-btn footer__icon" href="">
                        <img :src="twWhite" alt="Twitter"
                    /></a>
                    <a class="morph-btn footer__icon" href=""
                        ><img :src="insWhite" alt="Instagram"
                    /></a>
                </div>
            </div>
            <div
                class="col-12 col-lg-3 d-flex flex-column text-align-center text-align-lg-end align-items-center align-items-lg-end mt-40px mt-lg-0"
            >
                <p class="footer__heading">New-York</p>
                <a class="text-primary hover-white mb-15px" href="">
                    newyork@loremipsum.com
                </a>
                <a class="text-primary hover-white mb-15px" href="">
                    +48 123 456 789
                </a>
                <p>
                    12 Lorem Street, New York <br />
                    TX 98 765, USA
                </p>
            </div>
        </div>
    </section>
    <section class="footer__under">
        <p>Copyright © 2024 PracaDyplomowa by My. All Rights Reserved</p>
    </section>
</template>

<style lang="scss">
@use "~css/mixin.scss";
.footer {
    background-color: var(--footer);
    color: #babac0;
    padding: 60px 0px 60px 0px;

    @include mixin.media-breakpoint-up(md) {
        padding: 80px 0px 70px 0px;
    }

    @include mixin.media-breakpoint-up(xl) {
        padding: 80px 15px 70px 15px;
    }

    &__logo {
        height: 60px;
        object-fit: cover;
        width: fit-content;
    }

    &__icon {
        padding: 25px 14px 25px 14px;
        background-color: #fff0;
        display: flex;

        img {
            width: 31px;
            height: 30px;
            // position: absolute;
            // left: 50%;
            // top: 50%;
            // transform: translateX(-50%) translateY(-50%);
        }
    }

    &__heading {
        font-size: 24px;
        margin-bottom: 20px;
        color: white;
    }

    &__under {
        padding: 19px 0px 19px 0px;
        transition: background 0.3s, border 0.3s, border-radius 0.3s,
            box-shadow 0.3s, transform 0.4s;
        border-color: white;
        border-top: 1px solid;
        border-bottom: 1px solid;
        width: 100%;
        background-color: var(--footer);
        color: #babac0;
    }
}
</style>
