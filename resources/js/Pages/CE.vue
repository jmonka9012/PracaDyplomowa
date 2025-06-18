<script setup>
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";

import hellsPit from "~images/hellspit.jpg";
import Lightbox from "../Components/Partials/Lightbox.vue";
</script>

<template>
    <section>
        <div class="container justify-content-center">
            <div class="col-lg-4">
                <Tabs>
                    <Tab title="Pierwszy Tab">
                        <div class="d-flex flex-column">
                            <h2>Lorem, ipsum dolor.</h2>
                            <p>Treść pierwszego tabu</p>
                        </div>
                    </Tab>

                    <Tab title="Drugi Tab">
                        <div class="d-flex flex-column">
                            <h2>Lorem, ipsum dolor.</h2>
                            <p>Treść drugiego tabu</p>
                        </div>
                    </Tab>

                    <Tab title="Trzeci Tab">
                        <div class="d-flex flex-column">
                            <h2>Lorem, ipsum dolor.</h2>
                            <p>Treść trzeciego tabu</p>
                        </div>
                    </Tab>
                </Tabs>
            </div>
        </div>
    </section>

    <section class="pt-100px pb-100px">
        <div
            class="container flex-column align-items-center justify-content-center"
        >
            <form action="" class="form">
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input class="check" type="checkbox" name="notif1" id="notif1" />
                    <label for="notif1">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 1
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input class="check" type="checkbox" name="notif2" id="notif2" />
                    <label for="notif2">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 2
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input class="check" type="checkbox" name="notif3" id="notif3" />
                    <label for="notif3">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 3
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input class="check" type="checkbox" name="notif4" id="notif4" />
                    <label for="notif4">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 4
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12">
                    <input type="submit" value="Zapisz zmiany" />
                </div>
            </form>
        </div>
    </section>
    <section>
        <div class="container">
            <div>
                <Lightbox :imgSrc="hellsPit" />
            </div>
        </div>
    </section>
</template>

<style lang="scss">
@use "~css/mixin.scss";
///tutaj narazie style dla blog-single

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
