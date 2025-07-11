<script setup>
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";

import Lightbox from "../../Components/Partials/Lightbox.vue";
</script>

<template>
    <section class="pt-75px pb-75px">
        <div class="container">
            <div class="flex-column order">
                <h3 class="mb-30px">Zamówienie NR 123</h3>
                <div class="col-12 row-gap-30px mb-30px">
                    <div class="flex-column">
                        <p class="h5 text-lg fw-bold text-primary-darker">
                            Nazwa wydarzenia:
                        </p>
                        <p class="h6">Lorem ipsum</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 text-lg fw-bold text-primary-darker">
                            Data wydarzenia:
                        </p>
                        <p class="h6">22.02.2222</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 text-lg fw-bold text-primary-darker">
                            Godzina wydarzenia:
                        </p>
                        <p class="h6">14:20</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 fw-bold text-primary-darker">
                            Numer zamówienia:
                        </p>
                        <p class="h6">123</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 fw-bold text-primary-darker">
                            całkowity koszt:
                        </p>
                        <p class="h6">36zł</p>
                    </div>
                    <div class="flex-column">
                        <p class="h5 fw-bold text-primary-darker">
                            Adres Email kupującego:
                        </p>
                        <p class="h6">example@example.com</p>
                    </div>
                </div>
                <div class="flex-column">
                    <h3 class="mb-30px">Detale zamówienia</h3>
                    <div class="order__row order__row--head">
                        <p class="fw-bold">Typ biletu</p>
                        <p class="fw-bold">Sekcja</p>
                        <p class="fw-bold">Rząd</p>
                        <p class="fw-bold">Miejsce</p>
                        <p class="fw-bold">Cena</p>
                    </div>
                    <div class="order__row">
                        <p>Bilet siedzący</p>
                        <p>1</p>
                        <p>3</p>
                        <p>5</p>
                        <p>12zł</p>
                    </div>
                    <div class="order__row">
                        <p>Bilet siedzący</p>
                        <p>1</p>
                        <p>3</p>
                        <p>6</p>
                        <p>12zł</p>
                    </div>
                    <div class="order__row">
                        <p>Bilet siedzący</p>
                        <p>1</p>
                        <p>3</p>
                        <p>7</p>
                        <p>12zł</p>
                    </div>
                    <div class="order__row order__row--summary">
                        <p class="fw-bold text-primary-darker">
                            Cena całkowita
                        </p>
                        <p>36zł</p>
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
    &__row {
        display: grid;
        grid-template-columns: 100px 1fr 1fr 1fr 1fr;
        grid-row-gap: 10px;
        padding: 20px 10px;
        border-bottom: 1px solid var(--n-gray);
        border-left: 1px solid var(--n-gray);
        border-right: 1px solid var(--n-gray);

        @include mixin.media-breakpoint-up(lg) {
            padding: 20px 30px;
        }

        &:first-of-type {
            border-top: 1px solid var(--n-gray);
        }

        p {
            text-align: center;
            font-size: 12px;

            @include mixin.media-breakpoint-up(lg) {
                font-size: 16px;
            }
        }

        &--head {
            color: var(--primary-darker);
            p {
                padding: 0;
            }
        }
        &--summary {
            p:last-of-type {
                grid-column: 5/6;
            }
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
