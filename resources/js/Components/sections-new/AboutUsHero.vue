<script setup>
document.addEventListener('DOMContentLoaded', () => {
    const animatedStickySections = document.querySelectorAll('.animated-sticky-section');

    animatedStickySections.forEach((section) => {
        const stickyChild = section.querySelector('.animated-sticky-section__section');
        const animationTarget = section.querySelector('.animated-sticky-section__target');

        const colorBottom = animationTarget.dataset.from;
        //const colorBottom = '#DCDCDC';
        const colorTop = animationTarget.dataset.to;
        //const colorTop = '#0F0F0F';

        const wordsArray = [];
        const lettersArray = [];

        function GetScrollPercentage() {
            return (stickyChild.offsetTop) / (section.offsetHeight - stickyChild.offsetHeight);
        }

        function CreateSpans(target) {
            if (!target) return;

            const text = target.textContent.trim();
            target.textContent = '';

            text.split(' ').forEach((wordText, wordIndex) => {
                const wordSpan = document.createElement('span');
                wordSpan.classList.add('word');

                wordsArray.push(wordSpan);

                [...wordText].forEach((letter) => {
                    const letterSpan = document.createElement('span');
                    letterSpan.classList.add('letter');
                    letterSpan.textContent = letter;

                    lettersArray.push(letterSpan);

                    wordSpan.appendChild(letterSpan);
                });

                target.appendChild(wordSpan);

                if (wordIndex < text.split(' ').length - 1) {
                    target.appendChild(document.createTextNode(' '));
                }
            });
        }

        function UpdateText() {
            if (GetScrollPercentage() <= 1) {
                const sentenceIndex = lettersArray.length * GetScrollPercentage();
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
        window.addEventListener('scroll', UpdateText);
        UpdateText();
    });
});

</script>

<template>

    <div class="animated-sticky-section">
        <section class="animated-sticky-section__section as-hero">
            <div class="container ">
                <h1 data-from="red" data-to="yellow" class="animated-sticky-section__target">Poznaj nasz nowoczesny obiekt</h1>
            </div>
        </section>
    </div>

</template>

<style scoped lang="scss">
.animated-sticky-section {
    height: 300vh;
    position: relative;
    &__target {
        .letter {
            transition: color 0.8s;
        }// nie działa?
    }
    &__section {
        position: sticky;
        height: 100vh;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

.letter {
    transition: color 0.8s ease-in-out;
}// nie działa?

.as-hero {
    background-color: var(--primary);
}
</style>
