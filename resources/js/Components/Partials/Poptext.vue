<script setup>
import { computed } from "vue";

const props = defineProps({
    text: {
        type: String,
        required: true,
    },
});

const splitText = computed(() => props.text.split(" "));

const wordTotal = computed(() => splitText.value.length);

const charTotal = computed(() => props.text.length);
</script>

<template>
    <h3
        class="poptext"
        :style="`--pop-word-total: ${wordTotal}; --pop-char-total: ${charTotal};`"
        v-bind="$attrs"
    >
        <span
            v-for="(word, wordIndex) in splitText"
            :key="wordIndex"
            class="word"
            :data-word="word"
            :style="`--pop-word-index: ${wordIndex};`"
        >
            <span
                v-for="(char, charIndex) in word.split('')"
                :key="charIndex"
                class="char"
                :data-char="char"
                :style="{
                    '--pop-char-index': charIndex,
                    '--pop-char-total': charTotal,
                }"
            >
                {{ char }}
            </span>
        </span>
    </h3>
</template>

<style lang="scss">
@use "~css/mixin.scss";
.poptext {
    font-family: "Krona one";
    font-size: 8vw;
    line-height: 1.05em;
    text-transform: uppercase;
    --pop-word-center: calc((var(--pop-word-total) - 1) / 2);
    --pop-char-center: calc((var(--pop-char-total) - 1) / 2);
    --pop-line-center: calc((var(--pop-line-total) - 1) / 2);
    --pop-color-bg-text: #fff;
    z-index: 1;
    font-weight: 500;
    --pop-animation-speed: 200ms;
    --pop-animation-delay: 100ms;

    .word {
        --word-percent: calc(var(--pop-word-index) / var(--pop-word-total));
        display: inline-block;
        white-space: nowrap;
        font: inherit;
        line-height: inherit;
        line-height: inherit;
        letter-spacing: inherit;
        --pop-text-color: var(--primary);
    }

    .char {
        --char-percent: calc(var(--pop-char-index) / var(--pop-char-total));
        --pop-char-offset: calc(var(--pop-char-index) - var(--pop-char-center));
        --pop-distance: calc(
            (var(--pop-char-offset) * var(--pop-char-offset)) / var(--pop-char-center)
        );
        --pop-distance-sine: calc(var(--pop-char-offset) / var(--pop-char-center));
        --pop-distance-percent: calc((var(--pop-distance) / var(--pop-char-center)));
        display: inline-block;
        position: relative;
        animation-timing-function: cubic-bezier(0.5, 0, 0.5, 1), linear;
        animation-iteration-count: infinite;
        animation-duration: calc(var(--pop-animation-speed) * (var(--pop-char-total)));
        animation-delay: calc(var(--pop-animation-delay) * var(--pop-char-index));
        animation-name: color-rotation;
        color: var(--primary);

        &::before,
        &::after {
            content: attr(data-char);
            position: absolute;
            top: 0;
            left: 0;
            transition: inherit;
            -webkit-user-select: none;
            user-select: none;
            color: inherit;
            visibility: visible;
            z-index: 1;
            animation: inherit;
            animation-name: inherit;
        }

        &::before {
            --pop-text-color: var(--yellow);
            animation-name: character-out-2, color-rotation;
        }

        &::after {
            animation-name: character-out;
            color: var(--text);
            z-index: 2;
            transition: color 0.4s;
        }
    }
    &--cta {
        z-index: 3;
        font-size: 5vw;
        display: flex;
        column-gap: 20px;
        @include mixin.media-breakpoint-up(lg) {
            display: block;
        }
        @include mixin.media-breakpoint-up(xl) {
            padding-left: 65px;
        }
    }
    &--long {
        font-size: 5vw;
        display: flex;
        column-gap: 20px;
        @include mixin.media-breakpoint-up(lg) {
            display: block;
        }
    }
    &--white {
        .word {
            --pop-text-color: var(--yellow);
        }
        .char {
            &::before {
                --pop-text-color: var(--primary);
            }
            &::after {
                color: #f4f4f4;
            }
        }
    }
    &--404 {
        font-size: 100px;
        --pop-animation-speed: 700ms;
        @include mixin.media-breakpoint-up(sm) {
            font-size: 120px;
        }
        @include mixin.media-breakpoint-up(md) {
            font-size: 150px;
        }
        @include mixin.media-breakpoint-up(lg) {
            font-size: 250px;
        }
    }

    &--logo {
        font-size: 25px;

        --pop-animation-speed: 700ms;
    }

    &--footer {
        font-size: 55px;
        display: flex;
    }
}
</style>
