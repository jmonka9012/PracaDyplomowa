<script setup>
import ctaCloud from "~images/cta-cloud.png";
import spiral from "~images/spiral.png";
import IconRotate from "@/Components/icons/IconRotate.vue";

import {onMounted} from "vue";

onMounted(() => {
    const animatedStickySections = document.querySelectorAll(
        ".animated-sticky-section"
    );

    animatedStickySections.forEach((section) => {
        const stickyChild = section.querySelector(
            ".animated-sticky-section__section"
        );
        const animationTarget = section.querySelector(
            ".animated-sticky-section__target"
        );

        const colorBottom = animationTarget.dataset.from;
        //const colorBottom = '#DCDCDC';
        const colorTop = animationTarget.dataset.to;
        //const colorTop = '#0F0F0F';

        const wordsArray = [];
        const lettersArray = [];

        function GetScrollPercentage() {
            return (
                stickyChild.offsetTop /
                (section.offsetHeight - stickyChild.offsetHeight)
            );
        }

        function CreateSpans(target) {
            if (!target) return;

            const text = target.textContent.trim();
            target.textContent = "";

            text.split(" ").forEach((wordText, wordIndex) => {
                const wordSpan = document.createElement("span");
                wordSpan.classList.add("word");

                wordsArray.push(wordSpan);

                [...wordText].forEach((letter) => {
                    const letterSpan = document.createElement("span");
                    letterSpan.classList.add("letter");
                    letterSpan.textContent = letter;

                    lettersArray.push(letterSpan);

                    wordSpan.appendChild(letterSpan);
                });

                target.appendChild(wordSpan);

                if (wordIndex < text.split(" ").length - 1) {
                    target.appendChild(document.createTextNode(" "));
                }
            });
        }

        function UpdateText() {
            if (GetScrollPercentage() <= 1) {
                const sentenceIndex =
                    lettersArray.length * GetScrollPercentage();
                const letterIndex = Math.floor(sentenceIndex);
                // const letterVisibility = sentenceIndex - letterIndex;

                lettersArray.forEach((letter, index) => {
                    if (letterIndex === 0) {
                        letter.style.color = colorBottom;
                    } else if (index < letterIndex) {
                        letter.style.color = colorTop;
                    } else if (index === letterIndex) {
                        // letter.style.color = GetColor(colorBottom, colorTop, letterVisibility);
                    } else {
                        letter.style.color = colorBottom;
                    }
                });
            }
        }

        CreateSpans(animationTarget);
        window.addEventListener("scroll", UpdateText);
        UpdateText();
    });
})
</script>

<template>
    <div class="animated-sticky-section bg-primary">
        <section class="animated-sticky-section__section as-hero">
            <div class="as-iconrotate">
                <IconRotate
                    class="icon-rotate-holder-as"
                    :background="`url(${spiral})`"
                    rotateText="Nowoczesna hale koncertowo/wykładowe"
                />
            </div>

            <div class="container">
                <h1
                    data-from="red"
                    data-to="yellow"
                    class="animated-sticky-section__target as-heading"
                >
                    Poznaj nasz nowoczesny obiekt
                </h1>
            </div>
            <div class="as-cloud">
                <img :src="ctaCloud" alt="" />
            </div>
        </section>
    </div>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";

.animated-sticky-section {
    height: 200vh;
    @include mixin.media-breakpoint-up(lg) {
        height: 300vh;
    }
    position: relative;

    &__target {
        .letter {
            transition: color 0.8s;
        } // nie działa?
    }
    &__section {
        position: sticky;
        height: 100vh;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
}

.letter {
    transition: color 0.8s ease-in-out;
} // nie działa?

.as-hero {
    background-image: url("");
    background-color: var(--primary);
    background-image: url("~images/cta-bg.jpg");
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
}
.as-heading {
    line-height: 1.1;
    text-align: center;
    font-size: 58px;
    @include mixin.media-breakpoint-down(md){
        transform: translateY(50px);
    }
    @include mixin.media-breakpoint-up(md) {
        font-size: 80px;
    }
    @include mixin.media-breakpoint-up(lg) {
        font-size: 100px;
    }
}
.as-iconrotate {
    position: absolute;
    top: 100px;
    left: 50px;
    @include mixin.media-breakpoint-down(md) {
        width: 230px;
        top: 30px;
        left: -30px;
    }
}
.as-cloud {
    position: absolute;
    left: -300px;
    width: 100%;
    z-index: 1;
    min-width: 800px;
    bottom: 0;
    @include mixin.media-breakpoint-up(md) {
        left: -25%;
        min-width: 100%;
        top: 65%;
        bottom: auto;
    }
    @include mixin.media-breakpoint-up(lg) {
    }
}
</style>
