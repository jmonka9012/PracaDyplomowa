<template>
    <section v-bind="$attrs">
        <div class="container cat-cont">
            <div class="cat-item">
                <a href="/" class="link-stretched z-1"></a>
                <img class="cat-img" src="/src/assets/images/cat-img-bg-1.jpg" alt="">
                <h3 class="cat-name">Dupa</h3>
            </div>
            <div class="cat-item">
                <a href="/" class="link-stretched z-1"></a>
                <img class="cat-img" src="/src/assets/images/cat-img-bg-1.jpg" alt="">
                <h3 class="cat-name">Dupa</h3>
            </div>
            <div class="cat-item">
                <a href="/" class="link-stretched z-1"></a>
                <img class="cat-img" src="/src/assets/images/cat-img-bg-1.jpg" alt="">
                <h3 class="cat-name">Dupa</h3>
            </div>
            <div class="cat-item">
                <a href="/" class="link-stretched z-1"></a>
                <img class="cat-img" src="/src/assets/images/cat-img-bg-1.jpg" alt="">
                <h3 class="cat-name">Dupa</h3>
            </div>
            <div class="cat-item">
                <a href="/" class="link-stretched z-1"></a>
                <img class="cat-img" src="/src/assets/images/cat-img-bg-1.jpg" alt="">
                <h3 class="cat-name">Dupa</h3>
            </div>

        </div>
    </section>

</template>

<style lang="scss" scoped>
.cat-cont {
    display: grid;
    grid-template-columns: 1fr;
    column-gap: 30px;
    justify-content: center;
    align-items: center;
    row-gap: 30px;

    @include media-breakpoint-up(md) {
        grid-template-columns: repeat(5, 1fr);
    }
}

.cat-img {
    width: 150px;
    clip-path: polygon(clamp(0px, 0px, 100%) clamp(0px, -30px, 100%),
            clamp(0px, 100% - 0px * -1, 100%) clamp(0px, -30px * -1, 100%),
            clamp(0px, 100% - 0px, 100%) clamp(0px, 100% - -30px, 100%),
            clamp(0px, 0px * -1, 100%) clamp(0px, 100% - -30px * -1, 100%));
    transition: 0.3s;
    position: relative;
}

.cat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
}

.cat-item:hover .cat-img {
    clip-path: polygon(clamp(0px, 0px, 100%) clamp(0px, 30px, 100%),
            clamp(0px, 100% - 0px * -1, 100%) clamp(0px, 30px * -1, 100%),
            clamp(0px, 100% - 0px, 100%) clamp(0px, 100% - 30px, 100%),
            clamp(0px, 0px * -1, 100%) clamp(0px, 100% - 30px * -1, 100%));
}

.cat-name {
    font-size: 22px;
    margin: 15px 0px 0px 0px;
    position: relative;
    z-index: 1;
    line-height: 1.5;
    word-break: break-word;
    transition: 0.4s;
    font-weight: 500;
    text-align: center;
}
</style>