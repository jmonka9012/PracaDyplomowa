<script setup>
import hellspit from "~images/hellspit.jpg";
import bangpow from "~images/bangpow.jpg";
import jeckelbros from "~images/Jeckelbros.jpg";
import icpLogo from "~images/ICP-Logo.jpg";
</script>

<template>
    <section class="hero">
        <div class="container container-big">
            <div class="d-flex flex-column col-12 col-lg-6">
                <p class="sub-title sub-title-lprpl mb-40px">Modern art</p>
                <slot name="title">
                    <h1 class="title-1">
                        {{ title }}
                    </h1>
                </slot>
                <p class="mb-40px hero__text">
                    Nibh nisl condimentum venenatis a condimentum vitae sapien
                    dignissim sodales. Consequat ac felis ridiculus mus mauris
                    vitae ultricies leo integer malesuada.
                </p>
                <a href="" class="btn btn-md">Styl jest</a>
            </div>
            <div class="hero__images col-12 col-lg-6">
                <div class="hero__images__item">
                    <img :src="hellspit" alt="" />
                </div>
                <div class="hero__images__item">
                    <img :src="bangpow" alt="" />
                </div>
                <div class="hero__images__item">
                    <img :src="jeckelbros" alt="" />
                </div>
            </div>
        </div>

        <img class="hero__under" :src="icpLogo" alt="" />
    </section>
</template>

<style lang="scss" scoped>
.hero {
    position: relative;
    padding-bottom: 70px;
    &__images {
        position: relative;
        &__item {
            position: absolute;
            transition: all 800ms;
            img {
                width: 210px;
                height: 270px;
            }

            &:nth-of-type(1) {
                transition-delay: 600ms;
                left: 100px;
            }

            &:nth-of-type(2) {
                transition-delay: 1200ms;
                left: 100px;
            }

            &:nth-of-type(3) {
                transition-delay: 1800ms;
                left: 260px;
            }

            &:nth-of-type(4) {
                transition-delay: 2400ms;
                left: 260px;
            }

            &:nth-of-type(5) {
                transition-delay: 3000ms;
                left: 270px;
            }
        }
    }
    &__text {
        width: 73%;
    }
    &__under {
        position: absolute;
        bottom: 70px;
        right: 0;
        @include media-breakpoint-up(lg) {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
    }
}
</style>
