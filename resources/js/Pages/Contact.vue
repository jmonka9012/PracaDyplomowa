<script setup>
import HeroSmall from "../Components/Sections/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import contactsMap from "~images/contacts_map.jpg";
import facebookIcon from "~icons/facebook-circle-black.svg";
import twitterIcon from "~icons/twitter-black.svg";
import instagramIcon from "~icons/instagram-black.svg";

import {reactive} from "vue";

const contactForm = reactive({
    name: null,
    topic: null,
    email: null,
    message: null,
});

function SendContactEmail() {
    console.log(contactForm);
}
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
                    >Kontakt</a
                >
                <h3 class="lh-1_4 mb-20px">Masz pytania?</h3>
                <p class="mb-16px">
                    Masz pytania? Regulamin jest niejasny? Chcesz dopytać o to w jaki sposób organizujemy wydarzenia? Napisz do nas!
                </p>
                <div
                    class="d-flex flex-lg-row justify-content-between pb-16px mb-20px bb-1 b-secondary"
                >
                    <p class="fs-24 ff-krona">Poznań</p>
                    <p class="text-gray">ul. adres.pl 66-666</p>
                </div>
                <div
                    class="d-flex flex-lg-row justify-content-between mb-30px mb-lg-65px"
                >
                    <div class="col-12 col-lg-6 d-flex flex-column">
                        <a class="hover-primary ff-krona fs-14" href="mailto:kontakt@eventmachen.pl"
                            >kontakt@eventmachen.pl</a
                        >
                        <a class="hover-primary ff-krona fs-14" href="tel:+48111222333"
                            >111 222 333</a
                        >
                    </div>
                    <div class="col-12 col-lg-6 d-flex justify-content-lg-end">
                        <a class="morph-btn morph-btn-kont kont-icon" target="_blank" href="">
                            <div class="morph-btn__holder">
                                <img :src="facebookIcon" />
                            </div>
                        </a>
                        <a class="morph-btn morph-btn-kont kont-icon" target="_blank" href="">
                            <div class="morph-btn__holder">
                                <img :src="twitterIcon" />
                            </div>
                        </a>
                        <a class="morph-btn morph-btn-kont kont-icon" target="_blank" href="">
                            <div class="morph-btn__holder">
                                <img :src="instagramIcon" />
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 d-flex flex-column">
                    <h4 class="fs-36 mb-20px">Wyślij e-mail</h4>
                    <form class="form" @submit.prevent="SendContactEmail">
                        <div class="input-wrap col-12 col-lg-6">
                            <input v-model="contactForm.name" type="text" required name="contact-name" placeholder="Twoje imie*" />
                        </div>
                        <div class="input-wrap col-12 col-lg-6">
                            <input v-model="contactForm.email" type="text" required name="contact-mail" placeholder="Twój email*" />
                        </div>
                        <div class="input-wrap col-12">
                            <input v-model="contactForm.topic" type="text" required name="contact-topic" placeholder="Temat wiadomości*" />
                        </div>
                        <div class="input-wrap col-12">
                            <textarea
                                v-model="contactForm.message"
                                name="contact-message"
                                id=""
                                placeholder="Wiadomość"
                            ></textarea>
                        </div>
                        <input type="submit" value="wyślij" />
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
