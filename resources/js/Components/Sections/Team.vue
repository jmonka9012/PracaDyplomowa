<script setup>
import IconRotate from "@/Components/icons/IconRotate.vue";

defineProps({
    team: {
        type: Array,
        required: true,
    },
});

import fbWhite from "~icons/facebook-circle-white.svg";
import twWhite from "~icons/twitter-circle-white.svg";
import insWhite from "~icons/instagram-circle-white.svg";
import spiral from "~images/spiral.png";
</script>

<template>
    <section class="team">
        <div class="container d-flex flex-column">
            <div class="team__iconrotate">
                <IconRotate
                    :background="`url(${spiral})`"
                    rotateText="- Custom Rotating Text - Custom Rotating Text 2 "
                />
            </div>

            <p class="sub-title mb-15px">
                <slot name="subtitle">Default Subtitle</slot>
            </p>

            <h3 class="title-1 text-black mb-35px mb-lg-50px">
                <slot name="title">Default Title</slot>
            </h3>

            <div class="col-12 flex-row team__members">
                <div
                    v-for="member in team"
                    :key="member.id"
                    class="d-flex flex-column"
                >
                    <div class="team__item">
                        <a :href="member.teamLink" class="link-stretched"></a>
                        <img
                            class="team__img"
                            :src="member.teamImg"
                            :alt="`${member.teamName} photo`"
                        />
                        <div class="team__content">
                            <a
                                class="morph-btn btn--white team__icon"
                                :href="member.teamLinkFb"
                            >
                                <img :src="fbWhite" alt="Facebook" />
                            </a>
                            <a
                                class="morph-btn btn--white team__icon"
                                :href="member.teamLinkTw"
                            >
                                <img :src="twWhite" alt="Twitter" />
                            </a>
                            <a
                                class="morph-btn btn--white team__icon"
                                :href="member.teamLinkIns"
                            >
                                <img :src="insWhite" alt="Instagram" />
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-column pt-20px pb-10px">
                        <h2 class="team__name">
                            <a class="hover-underline" :href="member.teamLink">
                                {{ member.teamName }}
                            </a>
                        </h2>
                        <p class="team__position mt-10px">
                            {{ member.teamProps }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";
.team {
    background-image: url("~images/bg-team.jpg");
    background-position: center center;
    background-size: cover;
    padding: 80px 0;
    position: relative;

    @include mixin.media-breakpoint-up(lg) {
        padding: 121px 20px;
    }

    .container {
        max-width: 1800px;
    }

    &__iconrotate {
        display: none;
        @include mixin.media-breakpoint-up(lg) {
            display: block;
            position: absolute;
            right: 60px;
            top: 120px;
        }
    }

    &__members {
        display: grid;
        grid-template-columns: 1fr;
        justify-content: center;
        row-gap: 50px;
        grid-column-gap: 30px;

        @include mixin.media-breakpoint-up(md) {
            grid-template-columns: repeat(2, auto);
        }

        @include mixin.media-breakpoint-up(xl) {
            grid-template-columns: repeat(5, auto);
        }
    }

    &__item {
        position: relative;
        display: flex;
        max-height: 400px;
        height: 100%;
        @include mixin.media-breakpoint-up(lg) {
            max-height: 600px;
        }
        @include mixin.media-breakpoint-up(xl) {
            max-height: 375px;
        }

        &::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            transition: 0.3s;
        }

        &::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            transition: 0.3s;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
        }

        &:hover {
            &::after {
                opacity: 1;
            }

            .team__icon {
                opacity: 1;
                transform: translateY(0);
                transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out;

                &:nth-child(1) {
                    transition-delay: 0s;
                }

                &:nth-child(2) {
                    transition-delay: 0.1s;
                }

                &:nth-child(3) {
                    transition-delay: 0.2s;
                }
            }
        }

    }

    &__icon {
        width: 50px;
        height: 50px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        transition: transform 0.2s ease-in, opacity 0.2s ease-in;
        transform: translateY(20px);
        opacity: 0;

        img {
            width: 28px;
            height: 28px;
        }
    }

    &__img {
        width: 100%;
        object-fit: cover;
    }

    &__link {
    }

    &__content {
        position: absolute;
        z-index: 1;
        display: flex;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: 0.3s;
    }

    &__name {
        font-size: 24px;
        line-height: 1.3;
        font-weight: 500;
    }

    &__position {
        font-size: 12px;
        font-weight: 400;
        line-height: 1;
        text-transform: uppercase;
        position: relative;
        font-family: var(--additonal);

        &::before {
            font-size: 10px;
            display: inline-block;
            top: 50%;
            transform: translateY(-50%);
            margin-right: 6px;
            transition: 0.4s;
            content: "*";
            --fa: "\2a";
            position: relative;
            font-family: "Font Awesome 6 Free";
        }
    }
}
</style>
