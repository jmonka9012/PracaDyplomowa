<script setup>
import { Link } from "@inertiajs/vue3";
</script>
<template>
    <section class="pt-45px pb-25px bg-dark">
        <div class="container container-full">
            <Link :href="route('contact')" class="serv-item">
                <i class="fa fa-heart"></i>
                Kontakt
            </Link>
            <Link :href="route('about-us')" class="serv-item">
                <i class="fa fa-heart"></i>
                O nas
            </Link>
            <Link :href="route('terms-of-use')" class="serv-item">
                <i class="fa fa-heart"></i>
                Regulamin
            </Link>
            <Link :href="route('privacy-policy')" class="serv-item">
                <i class="fa fa-heart"></i>
                Polityka prywatności
            </Link>
            <Link :href="route('faq')" class="serv-item">
                <i class="fa fa-heart"></i>
                FAQ
            </Link>
        </div>
    </section>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";
.serv-item {
    color: white;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 15px;
    border-style: solid;
    border-width: 0 0 0 0;

    border-color: #fff;
    transition: background 0.3s, border 0.3s, border-radius 0.3s,
        box-shadow 0.3s;
    margin: 0px 0px 20px 0px;
    width: 100%;
    margin-bottom: 20px;

    @include mixin.media-breakpoint-up(md) {
        width: 50% !important;

        &:nth-of-type(1),
        &:nth-of-type(3) {
            border-width: 0 1px 0 0;
        }

        &:last-of-type {
            width: 100% !important;
        }
    }

    @include mixin.media-breakpoint-up(lg) {
        width: 25% !important;
        border-width: 0 1px 0 0;

        &:last-of-type {
            width: 25% !important;
            border-width: 0 0 0 0;
        }
    }

    i {
        font-size: 30px;
        margin-right: 20px;
        color: white;
        transition: all 0.3s;
    }

    &:hover {
        i {
            color: var(--primary);
        }
    }
}
</style>
