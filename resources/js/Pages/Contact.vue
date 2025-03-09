<script setup>
import HeroSmall from "../Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import contactsMap from "~images/contacts_map.jpg";
import facebookIcon from "~icons/facebook-circle-black.svg";
import twitterIcon from "~icons/twitter-black.svg";
import instagramIcon from "~icons/instagram-black.svg";
</script>

<template>
    <HeroSmall title="Kontakt" :source="blogBg" />

    <section class="mt-75px mt-lg-120px mb-75px mb-lg-120px">
        <div class="container container-small flexc-reverse-mob flex-lg-row">
            <div class="col-12 col-lg-6 mt-50px mt-lg-0 contact-map">
                <img src="/public/images/contacts_map.jpg" alt="" />
            </div>
            <div class="col-12 col-lg-6 d-flex flex-column">
                <a href="" class="sub-title sub-title-lprpl mb-17px"
                    >Contact us</a
                >
                <h3 class="lh-1_4 mb-20px">In Touch with You</h3>
                <p class="mb-16px">
                    Faucibus interdum posuere habitant morbi tristique senectus
                    netus et malesuada. Euismod nisi porta lorem mollis aliquam
                    ut porttitor.
                </p>
                <div
                    class="d-flex flex-lg-row justify-content-between pb-16px mb-20px bb-1 b-secondary"
                >
                    <p class="fs-24 ff-krona">London</p>
                    <p class="text-gray">3 Dufferin Street. London EC1Y 8NA</p>
                </div>
                <div
                    class="d-flex flex-lg-row justify-content-between mb-30px mb-lg-65px"
                >
                    <div class="col-12 col-lg-6 d-flex flex-column">
                        <a class="hover-primary ff-krona fs-14" href=""
                            >mborkowski2@edu.cdv.pl</a
                        >
                        <a class="hover-primary ff-krona fs-14" href=""
                            >mój numer xd</a
                        >
                    </div>
                    <div class="col-12 col-lg-6 d-flex justify-content-lg-end">
                        <a class="morph-btn morph-btn-kont kont-icon" href="">
                            <div class="morph-btn__holder">
                                <img :src="facebookIcon" />
                            </div>
                        </a>
                        <a class="morph-btn morph-btn-kont kont-icon" href="">
                            <div class="morph-btn__holder">
                                <img :src="twitterIcon" />
                            </div>
                        </a>
                        <a class="morph-btn morph-btn-kont kont-icon" href="">
                            <div class="morph-btn__holder">
                                <img :src="instagramIcon" />
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 d-flex flex-column">
                    <h4 class="fs-36 mb-20px">Drop us a line</h4>
                    <form class="form" action="">
                        <div class="input-wrap col-12 col-lg-6">
                            <input type="text" placeholder="Full Name*" />
                        </div>
                        <div class="input-wrap col-12 col-lg-6">
                            <input type="text" placeholder="Your Email*" />
                        </div>
                        <div class="input-wrap col-12">
                            <input type="text" placeholder="Website" />
                        </div>
                        <div class="input-wrap col-12">
                            <textarea
                                name=""
                                id=""
                                placeholder="Your message"
                            ></textarea>
                        </div>
                        <input type="submit" />
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.morph-btn-kont {
    padding: 25px 13px 25px 13px;
}
.contact-map {
    img {
        @media screen and (min-width: 992px) and (max-width: 1200px) {
            width: 80%;
        }
    }
}
</style>
