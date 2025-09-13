<script setup>
import { Link } from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    event: {
        type: Object,
        required: true
    }
})

const isHoveringButton = ref(false);

</script>

<template>
    <div class="event">
        <div class="event__img">
            <Link class="link-stretched" :href="`/${event.event_url}`"> </Link>
            <img :src="`/storage/${event.image_path}`" alt="" />
        </div>
        <div class="d-flex flex-column col-12">
            <div
                class="d-flex flex-lg-row justify-content-between align-items-start mt-lg-8px mb-16px"
            >
                <h6 :class="{'btn-hover-border--instant': isHoveringButton}" class="event__title">
                    <Link :href="`/${event.event_url}`">{{
                            event.event_name
                        }}</Link>
                </h6>
                <div class="d-flex flex-column row-gap-10px">
                    <Link
                        @mouseenter="isHoveringButton = true"
                        @mouseleave="isHoveringButton = false"
                        class="event__link d-none d-lg-flex"
                        :href="`/${event.event_url}`"
                    ><i class="fa fa-ticket"></i>
                        Zobacz więcej
                    </Link>
                    <div class="event__desktop-price">Ceny od {{ event.lowest_price }} PLN</div>
                </div>
            </div>
            <p class="event__date ff-prompt">
                <i class="fa fa-calendar mr-5px"></i>{{ event.event_date }}
            </p>
            <p class="event__subtitle">
                <span class="event__subtitle-label">Kategorie:</span>
                <Link
                    class="event__category-link"
                    :href="route('event.browser')"
                    :data="{ genres: genre.id }"
                    v-for="(genre, index) in event.genres"
                >{{ genre.name }}
                    <span v-if="index < event.genres.length - 1">, </span>
                </Link>
            </p>
            <div class="d-flex flex-column row-gap-10px">
                <Link class="event__link d-lg-none"
                      @mouseenter="isHoveringButton = true"
                      @mouseleave="isHoveringButton = false"
                      :href="`/${event.event_url}`"
                ><i class="fa fa-ticket"></i>
                    Zobacz więcej
                </Link>
                <div class="d-lg-none">Ceny od {{ event.lowest_price }} PLN</div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";
@use "~css/base.scss";

$border-color: rgba(#191028, .2);
.event {
    display: flex;
    flex-direction: column;
    padding: 16px;
    position: relative;
    background-color: #fffc;
    border: 1px solid $border-color;
    word-break: break-word;
    border-radius: 8px;
    width: 100%;
    margin-bottom: 25px;
    transition: background-color .2s ease-out;
    &:last-of-type {
        margin-bottom: 0;
    }

    &__subtitle-label {
        color: #191028;
        margin-right: 5px;
    }

    &:hover {
        background-color: #19102805;
        border-color: rgba(#191028, .3);
        .event__date,
        .event__subtitle {
            color: #191028;
        }
    }

    @include mixin.media-breakpoint-up(md) {
        flex-direction: row;
        justify-content: space-between;
        align-items: start;
    }

    &__desktop-price {
        display: none;
        @include mixin.media-breakpoint-up(lg) {
            display: block;
        }
    }

    &__category-link {
        transition: color 0.2s ease-out;
        display: inline-flex;
        margin-right: 5px;

        &:hover {
            color: var(--primary);

            span {
                color: rgba(25, 16, 40, 0.64);
            }
        }
    }

    &__img {
        max-width: 80%;
        margin-left: auto;
        margin-right: auto;
        flex-shrink: 0;
        margin-bottom: 20px;
        position: relative;
        display: flex;
        width: 100%;
        img {
            border-radius: 8px;
        }

        @include mixin.media-breakpoint-up(sm) {
            max-width: 60%;
            @include mixin.media-breakpoint-up(md) {
                margin-right: 16px;
                margin-bottom: 0;
                max-width: 200px;
            }
        }
    }

    &__title {
        font-size: 24px;
        line-height: 1.5;
        font-weight: 500;
        @extend .hover-custom-underline;
        @include mixin.media-breakpoint-down(md) {
            font-size: 20px;
        }

        @include mixin.media-breakpoint-up(lg) {
            margin-bottom: 0;
        }

        &:hover {
            @extend .hover-custom-underline;
        }
    }
    &__link {
        height: 48px;
        min-width: 48px;
        font-size: 16px;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 0 16px;
        gap: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: var(--trans-def);
        background-color: var(--primary);
        &:hover {
            background-color: #a499d5;
        }
    }
    &__date {
        display: flex;
        align-items: center;
        color: #191028a3;
        line-height: 20px;
        i {
            font-size: 12px;
        }

        @include mixin.media-breakpoint-up(md) {
            margin-bottom: 0;
        }
        @include mixin.media-breakpoint-up(lg) {
            margin-bottom: 8px;
        }
    }
    &__subtitle {
        border-top: 1px solid $border-color;
        padding-top: 8px;
        margin-top: 30px;
        margin-bottom: 16px;
        font-size: 13px;
        line-height: 1.5;
        color: #191028a3;
        width: 100%;
        @include mixin.media-breakpoint-down(lg) {
            margin-bottom: 15px;
            margin-top: 15px;
        }
    }
    &__subtitle,
    &__date {
        transition: var(--trans-def);
    }
}

.btn-hover-border--instant {
    background-size: 100% 6px !important;
}
</style>
