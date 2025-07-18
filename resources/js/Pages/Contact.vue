<script setup>
import HeroSmall from "../Components/Sections/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import contactsMap from "~images/contacts_map.jpg";
import facebookIcon from "~icons/facebook-circle-black.svg";
import twitterIcon from "~icons/twitter-black.svg";
import instagramIcon from "~icons/instagram-black.svg";

import { reactive } from "vue";
import { Link, router } from "@inertiajs/vue3";
import useAuth from "@/Utilities/useAuth";
const { user, isLoggedIn } = useAuth();

import ResetObject from "@/Utilities/resetObject";

const contactForm = reactive({
    name: null,
    topic: null,
    email: null,
    message: null,
});

const errors = reactive({});

function SendTicket() {
    console.log(contactForm);
    let hadError = true;

    router.post(route("support-ticket-send"), contactForm, {
        preserveScroll: () => hadError,
        onError: (err) => {
            hadError = true;
            ResetObject(errors);
            Object.assign(errors, err);
        },
        onSuccess: () => {
            hadError = false;
        },
    });
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
                <a href="" class="sub-title sub-title-lprpl mb-17px">Kontakt</a>
                <h3 class="lh-1_4 mb-20px">Masz pytania?</h3>
                <p class="mb-16px">
                    Potrzebujesz pomocy ze swoim zamówieniem, masz problem z
                    płatnością, chcesz uzyskać fakturę lub dopytać o zwrot
                    biletu? Jesteś w dobrym miejscu. Skontaktuj się z nami, a
                    nasz zespół odpowie tak szybko, jak to możliwe.
                </p>
                <p class="mb-16px">
                    Zanim napiszesz, upewnij się, że odpowiedzi na swoje pytania
                    nie znajdziesz w sekcji
                    <Link class="fw-med hover-primary" :href="route('faq')"
                        >FAQ</Link
                    >
                    – stworzyliśmy ją specjalnie, byś mógł szybciej znaleźć
                    potrzebne informacje.
                </p>
                <div
                    class="d-flex flex-lg-row justify-content-between pb-16px mb-20px bb-1 b-secondary"
                >
                    <p class="fs-24 ff-krona">Poznań</p>
                    <p class="text-gray">ul. Koncertowa 12, 66-666 Poznań</p>
                </div>
                <div
                    class="d-flex flex-lg-row justify-content-between mb-30px mb-lg-65px"
                >
                    <div class="col-12 col-lg-6 d-flex flex-column">
                        <a
                            class="hover-primary ff-krona fs-14"
                            href="mailto:kontakt@eventmachen.pl"
                            >kontakt@eventmachen.pl</a
                        >
                        <a
                            class="hover-primary ff-krona fs-14"
                            href="tel:+48111222333"
                            >111 222 333</a
                        >
                    </div>
                    <div class="col-12 col-lg-6 d-flex justify-content-lg-end">
                        <a
                            class="morph-btn morph-btn-kont kont-icon"
                            target="_blank"
                            href=""
                        >
                            <div class="morph-btn__holder">
                                <img :src="facebookIcon" />
                            </div>
                        </a>
                        <a
                            class="morph-btn morph-btn-kont kont-icon"
                            target="_blank"
                            href=""
                        >
                            <div class="morph-btn__holder">
                                <img :src="twitterIcon" />
                            </div>
                        </a>
                        <a
                            class="morph-btn morph-btn-kont kont-icon"
                            target="_blank"
                            href=""
                        >
                            <div class="morph-btn__holder">
                                <img :src="instagramIcon" />
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 d-flex flex-column">
                    <h4 class="fs-36 mb-20px">Wyślij zapytanie</h4>
                    <form
                        v-if="!isLoggedIn"
                        class="form"
                        @submit.prevent="SendTicket"
                    >
                        <div class="input-wrap col-12 col-lg-6">
                            <input
                                v-model="contactForm.name"
                                type="text"
                                required
                                name="contact-name"
                                placeholder="Twoje imie*"
                            />
                        </div>
                        <div class="error-msg" v-if="errors.name">
                            {{ errors.name }}
                        </div>
                        <div class="input-wrap col-12 col-lg-6">
                            <input
                                v-model="contactForm.email"
                                type="text"
                                required
                                name="contact-mail"
                                placeholder="Twój email*"
                            />
                        </div>
                        <div class="error-msg" v-if="errors.email">
                            {{ errors.email }}
                        </div>
                        <div class="input-wrap col-12">
                            <input
                                v-model="contactForm.topic"
                                type="text"
                                required
                                name="contact-topic"
                                placeholder="Temat wiadomości*"
                            />
                        </div>
                        <div class="error-msg" v-if="errors.topic">
                            {{ errors.topic }}
                        </div>
                        <div class="input-wrap col-12">
                            <textarea
                                v-model="contactForm.message"
                                name="contact-message"
                                id=""
                                placeholder="Wiadomość"
                            ></textarea>
                        </div>
                        <div class="error-msg" v-if="errors.message">
                            {{ errors.message }}
                        </div>
                        <p class="mb-16px">
                            Administratorem Twoich danych osobowych jest Event
                            Machen Sp. z o.o. z siedzibą w Poznaniu przy ul.
                            Koncertowej 12. Dane przekazane w formularzu
                            kontaktowym będą przetwarzane wyłącznie w celu
                            obsługi Twojego zapytania, na podstawie
                            uzasadnionego interesu administratora (art. 6 ust. 1
                            lit. f RODO). Twoje dane nie będą udostępniane
                            podmiotom trzecim. Masz prawo dostępu do treści
                            swoich danych, ich sprostowania, usunięcia,
                            ograniczenia przetwarzania oraz wniesienia
                            sprzeciwu. Więcej informacji znajdziesz w naszej
                            Polityce prywatności.
                        </p>
                        <button class="btn-hover-border btn-hovprim btn btn-md" type="submit">Wyślij</button>
                    </form>
                    <div v-if="isLoggedIn">
                        <p class="mb-20px">
                            Jako zalogowany użytkownik masz dostęp do formularza
                            kontaktowego w panelu użytkownika w zakładce
                            "Obsługa Klienta"
                        </p>
                        <Link
                            :href="route('my-account', {tabName: 'Obsługa klienta'})"
                            class="btn btn-md btn-hovprim btn-hover-border "
                            >Panel użytkownika</Link
                        >
                    </div>
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
