<script setup>
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";

import hellsPit from "~images/hellspit.jpg";
import Lightbox from "../Components/Partials/Lightbox.vue";
</script>

<template>
    <section>
        <div class="container">
            <div class="flex-column order">
                <h3 class="mb-30px">
                    Dane tutaj ew do usunięcia
                </h3>
                <div class="col-12 order__data">
                           <div class="flex-column">
                        <p class="fw-bold text-primary">Nazwa wydarzenia:</p>
                        <p>Lorem ipsum</p>
                    </div>
                    <div class="flex-column">
                        <p class="fw-bold text-primary">Numer zamówienia:</p>
                        <p>123</p>
                    </div>
                    <div class="flex-column">
                        <p class="fw-bold text-primary">Koszt:</p>
                        <p>48zł</p>
                    </div>
                    <div class="flex-column">
                        <p class="fw-bold text-primary">Adres Email:</p>
                        <p>example@example.com</p>
                    </div>
                </div>
                <div class="flex-column">
                    <h5>Detale zamówienia</h5>
                    <div class="order__row order__row--head">
                        <p class="fw-bold">Typ biletu</p>
                        <p class="fw-bold">sekcja</p>
                        <p class="fw-bold">rząd</p>
                        <p class="fw-bold">cena</p>
                    </div>
                    <div class="order__row">
                        <p>Bilet siedzący</p>
                        <p>36zł</p>
                    </div>
                    <div class="order__row">
                        <p>Bilet stojący</p>
                        <p>12zł</p>
                    </div>
                    <div class="order__row">
                        <p class="fw-bold">Cena całkowita</p>
                        <p>48zł</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style lang="scss">
@use "~css/mixin.scss";
///tutaj narazie style dla blog-single

.order {
    width: 100%;
    &__data {
        display: grid;
        grid-template-columns: 1fr;
        grid-row-gap: 20px;
        grid-column-gap: 20px;

        @include mixin.media-breakpoint-up(md) {
            grid-template-columns: repeat(2, 1fr);
        }

        @include mixin.media-breakpoint-up(lg) {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    &__row {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 20px 30px;
        border-bottom: 1px solid var(--n-gray);
        border-left: 1px solid var(--n-gray);
        border-right: 1px solid var(--n-gray);

        &--head{
            color: var(--primary);
        }

        &:first-of-type {
            border-top: 1px solid var(--n-gray);
        }
    }
}

.blog-image {
    max-height: 450px;
    max-width: 450px;
    width: 100%;
    @include mixin.media-breakpoint-up(lg) {
        max-height: 600px;
        max-width: 600px;
    }
    &-square {
        max-width: 450px;
        @include mixin.media-breakpoint-up(lg) {
            max-width: 600px;
        }
    }
}
.blog-single__bottom {
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding-top: 40px;
    padding-bottom: 40px;
    border-top: 1px solid #dddedf;
    display: flex;
    flex-direction: column;
    row-gap: 30px;
    @include mixin.media-breakpoint-up(lg) {
        flex-direction: row;
        padding-bottom: 100px;
    }
}
//tutaj narazie o nas

.on-map {
    max-height: 600px;
    width: 100%;
    object-fit: cover;
    aspect-ratio: 16 / 9;
}
</style>
