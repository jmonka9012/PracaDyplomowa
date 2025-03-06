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
    <h3 class="poptext" :style="`--word-total: ${wordTotal}; --char-total: ${charTotal};`">
        <span v-for="(word, wordIndex) in splitText" :key="wordIndex" class="word" :data-word="word"
            :style="`--word-index: ${wordIndex};`">
            <span v-for="(char, charIndex) in word.split('')" :key="charIndex" class="char" :data-char="char" :style="{
                '--char-index': charIndex,
                '--char-total': charTotal, 
            }">
                {{ char }}
            </span>
        </span>
    </h3>
</template>


<style lang="scss">
.poptext {
    font-family: 'Krona one';
    font-size: 8vw;
    line-height: 1.05em;
    text-transform: uppercase;
    --word-center: calc((var(--word-total) - 1) / 2);
    --char-center: calc((var(--char-total) - 1) / 2);
    --line-center: calc((var(--line-total) - 1) / 2);
    --color-bg-text: #fff;
    z-index: 0;
    font-weight: 500;
    --animation-speed: 200ms;
    --animation-delay: 100ms;

    .word {
        --word-percent: calc(var(--word-index) / var(--word-total));
        display: inline-block;
        white-space: nowrap;
        font: inherit;
        line-height: inherit;
        line-height: inherit;
        letter-spacing: inherit;
        --color-text: var(--primary)
    }

    .char {
        --char-percent: calc(var(--char-index) / var(--char-total));
        --char-offset: calc(var(--char-index) - var(--char-center));
        --distance: calc((var(--char-offset) * var(--char-offset)) / var(--char-center));
        --distance-sine: calc(var(--char-offset) / var(--char-center));
        --distance-percent: calc((var(--distance) / var(--char-center)));
        display: inline-block;
        position: relative;
        animation-timing-function: cubic-bezier(0.5, 0, 0.5, 1), linear;
        animation-iteration-count: infinite;
        animation-duration: calc(var(--animation-speed) * (var(--char-total)));
        animation-delay: calc(var(--animation-delay) * var(--char-index));
        animation-name: color-cycle;
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
            --color-text: var(--yellow);
            animation-name: pop-char-out2, color-cycle;
        }

        &::after {
            animation-name: pop-char-out;
            color: var(--text);
            z-index: 2;
            transition: color 0.4s;
        }
    }

}
</style>