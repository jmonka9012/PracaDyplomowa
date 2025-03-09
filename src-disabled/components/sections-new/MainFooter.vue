<script setup>

</script>

<template>
    <section class="footer">
        <div class="container">
            <div
                class="col-12 col-lg-3 d-flex flex-column text-align-center text-align-lg-start align-items-center align-items-lg-start ">
                <p class="footer__heading ">
                    London
                </p>
                <a class="text-primary mb-15px" href="/">
                    london@lunfest.com
                </a>
                <a class="text-primary mb-15px" href="/">
                    +44 020 7490 8954
                </a>
                <p>
                    3 Dufferin Street. <br>London EC1Y 8NA
                </p>
            </div>
            <div class="col-12 col-lg-6 d-flex flex-column align-items-center">
                <img class="footer__logo mb-25px" src="/src/assets/images/logo-white.png" alt="">
                <p class="text-align-center mb-25px">We help organisations transform their impact by providing a
                    comprehensive new great experience </p>
                <div class="d-flex flex-row justify-content-center mb-35px"><a class="text-white hover-primary"
                        href="/">Privacy Policy</a><span class="text-white divider "></span><a
                        class="text-white hover-primary" href="/">Terms of use</a></div>
                <div class="d-flex flex-row w-fit justify-content-between">
                    <a class="morph-btn footer__icon" href=""><img
                            src="/src/assets/icons/facebook-circle-white.svg"></img></a>
                    <a class="morph-btn footer__icon" href=""><img
                            src="/src/assets/icons/twitter-circle-white.svg"></img></a>
                    <a class="morph-btn footer__icon" href=""><img
                            src="/src/assets/icons/instagram-circle-white.svg"></img></a>
                </div>

            </div>
            <div
                class="col-12 col-lg-3 d-flex flex-column text-align-center text-align-lg-end align-items-center align-items-lg-end mt-40px mt-lg-0">
                <p class="footer__heading">
                    New-York
                </p>
                <a class="text-primary mb-15px" href="">
                    newyork@lunfest.com
                </a>
                <a class="text-primary mb-15px" href="">
                    +61 0481 224 883
                </a>
                <p>
                    12 Houston Street, New-York, <br>
                    CA 9020, USA
                </p>
            </div>
        </div>
    </section>
    <section class="footer__under">
        <p>Copyright © 2024 LUNFEST by WebGeniusLab. All Rights Reserved </p>
    </section>

</template>

<style lang="scss">
.footer {
    background-color: var(--footer);
    color: #BABAC0;
    padding: 60px 0px 60px 0px;

    @include media-breakpoint-up(md) {
        padding: 80px 0px 70px 0px;
    }

    @include media-breakpoint-up(xl) {
        padding: 80px 15px 70px 15px;
    }

    &__logo {
        height: 60px;
        object-fit: cover;
        width: fit-content;
    }

    &__icon {
        padding: 25px 14px 25px 14px;
        background-color: #FFF0;
        display: flex;

        img {
            width: 31px;
            height: 30px;
            // position: absolute;
            // left: 50%;
            // top: 50%;
            // transform: translateX(-50%) translateY(-50%);
        }
    }

    &__heading {
        font-size: 24px;
        margin-bottom: 20px;
        color: white;
    }

    &__under {
        padding: 19px 0px 19px 0px;
        transition: background .3s, border .3s, border-radius .3s, box-shadow .3s, transform .4s;
        border-color: white;
        border-top: 1px solid;
        border-bottom: 1px solid;
        width: 100%;
        background-color: var(--footer);
        color: #BABAC0;
    }


}
</style>