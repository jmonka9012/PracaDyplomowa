<script setup>
import Poptext from "@/Components/Partials/Poptext.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
const text = ref("404");
</script>

<template>
    <section class="pt-75px pb-75px pt-lg-120px pb-lg-120px">
        <div class="container align-items-center flex-column">
            <Poptext
                class="d-flex flex-column justify-content-center align-items-center poptext-404"
                :text="text"
            />
            <h1 class="error-title">
                Przepraszamy, nie możemy znaleźć takiej strony!
            </h1>
            <p class="mb-35px text-align-center">
                Strona której szukasz została przeniesiona, usunięta, lub nigdy
                nie istniała.
            </p>
            <!--            <form action="" class="form">
                <div class="input-wrap input-wrap-search pl-0 pr-0 col-12">
                    <input type="search" placeholder="szukaj" />
                    <i class="fa fa-search"></i>
                </div>
            </form>-->
            <Link :href="route('home')" class="btn btn--md btn--hovprim"
                >Powróć do strony</Link
            >
        </div>
    </section>
</template>

<style lang="scss">
@use "~css/mixin.scss";
.error-title {
    font-size: 28px;
    line-height: 1.3;
    margin-top: 35px;
    margin-bottom: 20px;
    text-align: center;
    @include mixin.media-breakpoint-up(lg) {
        font-size: 46px;
        margin-top: 55px;
    }
}
</style>
