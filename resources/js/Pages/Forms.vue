<script setup>
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Utilities/debounce";
import axios from "axios";

import { ref } from "vue";

const isVis = ref(false);

const RegShow = () => {
    if (!isVis.value) {
        isVis.value = true;
    }
};

const errors = reactive({});

const liveErrors = reactive({
    emailError: "",
    nameError: "",
});

let registerNameCorrect = false;
let registerEmailCorrect = false;

let canRegister = false;

function HandleSubmitClass() {
    canRegister = registerEmailCorrect && registerNameCorrect;
}

function HandleValidationResponse(routeName, response) {
    switch (routeName) {
        case "verification.user":
            liveErrors.nameError = response.data.message;
            registerNameCorrect = response.data.valid;
            break;
        case "verification.email":
            liveErrors.emailError = response.data.message;
            registerEmailCorrect = response.data.valid;

            break;
        default:
            console.error("Nie rozpoznano route walidacyjnego");
    }
    console.log(`${routeName} valid:`, response.data.valid);
}

const validationRequest = debounce((routeName) => {
    axios
        .post(route(routeName), registerForm)
        .then((response) => {
            HandleValidationResponse(routeName, response);
            HandleSubmitClass();
        })
        .catch((error) => {
            console.error(error);
        });
}, 1000);

function onInput(routeName) {
    validationRequest(routeName);
}

const loginForm = reactive({
    login: null,
    password: null,
    remember: false,
});

const registerForm = reactive({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    first_name: null,
    last_name: null,
});

function submitLoginRequest() {
    let hadError = false;

    router.post(route("login.post"), loginForm, {
        preserveScroll: () => hadError,
        onError: (err) => {
            hadError = true;
            Object.assign(errors, err);
        },
        onSuccess: () => {
            hadError = false;
        },
    });
}

function submitRegisterRequest() {
    let hadError = false;

    router.post(route("register.post"), registerForm, {
        preserveScroll: () => hadError,
        onError: (err) => {
            hadError = true;
            Object.assign(errors, err);
            liveErrors.emailError = null;
            liveErrors.nameError = null;
        },
    });
}
</script>

<template>
    <HeroSmall title="Forms showcase" :source="blogBg" />
    <section class="mb-60px">
        <div class="container align-items-start">
            <div class="col-12 col-lg-6 d-flex flex-column">
                <h1 class="title-1 mb-20px col-12">Logowanie</h1>
                <form class="form" @submit.prevent="submitLoginRequest">
                    <div class="input-wrap col-12">
                        <label for="username">Dane użytkownika *</label>
                        <input
                            type="text"
                            id="login"
                            autocomplete="email"
                            name="login"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="loginForm.login"
                        />
                        <div class="error-msg" v-if="errors.login">
                            {{ errors.login }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="password">Hasło *</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="password"
                            v-model="loginForm.password"
                            required=""
                            aria-required="true"
                        />
                        <div class="error-msg" v-if="errors.password">
                            {{ errors.password }}
                        </div>
                    </div>
                    <div class="input-wrap input-wrap-check col-12 mb-20px">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            aria-required="true"
                            true-value="true"
                            false-value="false"
                            v-model="loginForm.remember"
                        />
                        <label for="remember"> Zapamiętaj mnie </label>
                    </div>
                    <div class="input-wrap col-12">
                        <input type="submit" value="Zaloguj się" />
                    </div>
                </form>
                <a
                    class="h3 hover hover-primary read-more read-more-stop"
                    @click="RegShow"
                    >Nie masz konta? Zarejestruj się!</a
                >
            </div>
            <div
                id="rcol"
                class="col-12 col-lg-6 d-flex flex-column"
                :class="{ show: isVis }"
            >
                <h1 class="title-1 mb-20px">Rejestracja</h1>
                <form class="form" @submit.prevent="submitRegisterRequest">
                    <div class="input-wrap col-12">
                        <label for="register-username"
                            >Nazwa użytkownika *</label
                        >
                        <input
                            type="text"
                            id="register-username"
                            name="name"
                            autocomplete="register-username"
                            spellcheck="false"
                            value=""
                            aria-required="true"
                            v-model="registerForm.name"
                            @input="onInput('verification.user')"
                        />
                        <div class="error-msg" v-if="errors.name">
                            {{ errors.name }}
                        </div>
                        <div class="error-msg" v-if="liveErrors.nameError">
                            {{ liveErrors.nameError }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="register-email">Email *</label>
                        <input
                            type="text"
                            id="register-email"
                            name="email"
                            autocomplete="register-email"
                            spellcheck="false"
                            value=""
                            aria-required="true"
                            v-model="registerForm.email"
                            @input="onInput('verification.email')"
                        />
                        <div class="error-msg" v-if="errors.email">
                            {{ errors.email }}
                        </div>
                        <div class="error-msg" v-if="liveErrors.emailError">
                            {{ liveErrors.emailError }}
                        </div>
                        <div class="error-msg" v-if="errors.email">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="register-username">Imię *</label>
                        <input
                            type="text"
                            id="register-username"
                            name="name"
                            autocomplete="register-first_name"
                            spellcheck="false"
                            value=""
                            aria-required="true"
                            v-model="registerForm.first_name"
                        />
                        <div class="error-msg" v-if="errors.first_name">
                            {{ errors.first_name }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="register-username">Nazwisko *</label>
                        <input
                            type="text"
                            id="register-username"
                            name="name"
                            autocomplete="register-last_name"
                            spellcheck="false"
                            value=""
                            aria-required="true"
                            v-model="registerForm.last_name"
                        />
                        <div class="error-msg" v-if="errors.last_name">
                            {{ errors.last_name }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="register-password">Hasło *</label>
                        <input
                            type="password"
                            name="password"
                            id="register-password"
                            autocomplete="register"
                            required=""
                            aria-required="true"
                            v-model="registerForm.password"
                        />
                        <div class="error-msg" v-if="errors.password">
                            {{ errors.password }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="register-password-confirm"
                            >Potwierdź Hasło *</label
                        >
                        <input
                            type="password"
                            name="password_confirmation"
                            id="register-password-confirm"
                            autocomplete="register"
                            required=""
                            aria-required="true"
                            v-model="registerForm.password_confirmation"
                        />
                        <div
                            class="error-msg"
                            v-if="errors.password_confirmation"
                        >
                            {{ errors.password_confirmation }}
                        </div>
                    </div>
                    <div class="input-wrap col-12 mb-20px">
                        <p>
                            Na adres e-mail zostanie wysłany odnośnik do
                            ustawienia nowego hasła.
                        </p>
                    </div>
                    <div class="input-wrap input-wrap-check col-12 mb-20px">
                        <input
                            type="checkbox"
                            required
                            name="confirmation"
                            id="confirmation"
                            aria-required="true"
                        />
                        <label for="confirmation">
                            Twoje dane osobowe zostaną użyte do obsługi twojej
                            wizyty na naszej stronie, zarządzania dostępem do
                            twojego konta i dla innych celów o których mówi
                            nasza polityka prywatności.
                        </label>
                    </div>
                    <div class="input-wrap col-12">
                        <input
                            type="submit"
                            :disabled="!canRegister"
                            :class="{ disabled: !canRegister }"
                            value="zarejestruj się"
                        />
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
<style lang="scss">
@use "~css/mixin.scss";
#rcol {
    visibility: hidden;
    opacity: 0;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);
    &.show {
        visibility: visible;
        opacity: 1;
        max-height: 1000px;
        transition: max-height 1s ease-in-out;
        @include mixin.media-breakpoint-down(lg) {
            margin-top: 60px;
        }
    }
}
</style>
<script>
export default {
    props: {
        csrf_token: String,
    },
};
</script>
