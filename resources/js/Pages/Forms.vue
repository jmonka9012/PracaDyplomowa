<script setup>
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Utilities/debounce";
import axios from "axios";

const errors = reactive({});

const liveErrors = reactive({
    emailError: "",
    nameError: "",
});

let registerNameCorrect = false;
let registerEmailCorrect = false;

let canRegister = false;

function HandleSubmitClass(routeName, response) {
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
            HandleSubmitClass(routeName, response);
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
    router.post(route("login.post"), loginForm, {
        onError: (err) => {
            Object.assign(errors, err);
        },
        preserveScroll: true,
    });
}

function submitRegisterRequest() {
    router.post(route("register.post"), registerForm, {
        onError: (err) => {
            Object.assign(errors, err);
        },
        preserveScroll: true,
    });
    liveErrors.emailError = null;
    liveErrors.nameError = null;
}
</script>

<template>
    <HeroSmall title="Forms showcase" :source="blogBg" />
    <section>
        <div class="container flex-column">
            <h1 class="title-1 mb-20px">Logowanie</h1>
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
            <h1 class="title-1 mb-20px">Rejestracja</h1>
            <form class="form pb-120px" @submit.prevent="submitRegisterRequest">
                <div class="input-wrap col-12">
                    <label for="register-username">Nazwa użytkownika *</label>
                    <input
                        class="disabled"
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
                    <<<<<<< Updated upstream
                    <div class="error-msg" v-if="errors.email">
                        {{ errors.email }}
                    </div>
                    <div class="error-msg" v-if="liveErrors.emailError">
                        {{ liveErrors.emailError }}
                    </div>
                    =======
                    <div class="error-msg" v-if="errors.email">
                        {{ errors.email }}
                    </div>
                    >>>>>>> Stashed changes
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
                    <div class="error-msg" v-if="errors.password_confirmation">
                        {{ errors.password_confirmation }}
                    </div>
                </div>
                <div class="input-wrap col-12 mb-20px">
                    <p>
                        Na adres e-mail zostanie wysłany odnośnik do ustawienia
                        nowego hasła.
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
                        twojego konta i dla innych celów o których mówi nasza
                        polityka prywatności.
                    </label>
                </div>
                <div class="input-wrap col-12">
                    <input
                        type="submit"
                        :class="{ disabled: !canRegister }"
                        value="zarejestruj się"
                    />
                </div>
            </form>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        csrf_token: String,
    },
};
</script>
