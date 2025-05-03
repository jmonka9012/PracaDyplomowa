<script setup>
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Utilities/debounce";
import ResetObject from "@/Utilities/resetObject";
import axios from "axios";

const isVis = ref(false);

const params = new URLSearchParams(window.location.search);
isVis.value = params.get("reg") === "true" || false;

const RegShow = () => {
    if (!isVis.value) {
        isVis.value = true;
    }
};

const loginErrors = reactive({});
const registerErrors = reactive({});
const liveErrors = reactive({
    emailError: "",
    nameError: "",
});
const loginForm = reactive({
    login: null,
    password: null,
    remember: false,
});

const organizerDetails = reactive({
    company_name: null,
    phone_number: null,
    company_nip: null,
    bank_account: null,
    company_country: null,
    company_city: null,
    company_zip_code: null,
    company_street: null,
});

const registerForm = reactive({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    first_name: null,
    last_name: null,
    organizer_request: false,
    organizer_details: organizerDetails,
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

function submitLoginRequest() {
    let hadError = true;

    router.post(route("login.post"), loginForm, {
        preserveScroll: () => hadError,
        onError: (err) => {
            hadError = true;
            ResetObject(loginErrors);
            Object.assign(loginErrors, err);
        },
        onSuccess: () => {
            hadError = false;
        },
    });
}

function submitRegisterRequest() {
    let hadError = true;

    router.post(route("register.post"), registerForm, {
        preserveScroll: () => hadError,
        onError: (err) => {
            hadError = true;
            ResetObject(registerErrors);
            Object.assign(registerErrors, err);
            liveErrors.emailError = null;
            liveErrors.nameError = null;
        },
        onSuccess: () => {
            hadError = false;
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
                        <div class="error-msg" v-if="loginErrors.login">
                            {{ loginErrors.login }}
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
                        <div class="error-msg" v-if="loginErrors.password">
                            {{ loginErrors.password }}
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
                <button @click="console.log(registerForm)" class="btn btn-md btn-hovprim">
                    Loguj formularz rejestracyjny
                </button>
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
                        <div class="error-msg" v-if="registerErrors.name">
                            {{ registerErrors.name }}
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
                        <div class="error-msg" v-if="registerErrors.email">
                            {{ registerErrors.email }}
                        </div>
                        <div class="error-msg" v-if="liveErrors.emailError">
                            {{ liveErrors.emailError }}
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
                        <div class="error-msg" v-if="registerErrors.first_name">
                            {{ registerErrors.first_name }}
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
                        <div class="error-msg" v-if="registerErrors.last_name">
                            {{ registerErrors.last_name }}
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
                        <div class="error-msg" v-if="registerErrors.password">
                            {{ registerErrors.password }}
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
                            v-if="registerErrors.password_confirmation"
                        >
                            {{ registerErrors.password_confirmation }}
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
                    <div class="input-wrap input-wrap-check col-12 mb-20px">
                        <input
                            type="checkbox"
                            name="organizer"
                            id="organizer"
                            v-model="registerForm.organizer_request"
                            @input="console.log(registerForm)"
                        />
                        <label for="confirmation">
                            Chcę założyć konto organizatora.
                        </label>
                    </div>
                    <div
                        class="organizer-form"
                        v-if="registerForm.organizer_request"
                    >
                        <div class="input-wrap col-12">
                            <label for="register-username">Nazwa firmy*</label>
                            <input
                                type="text"
                                id="register-company-name"
                                name="company-name"
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.company_name"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.company_name
                                "
                            >
                                {{
                                    registerErrors.organizer_details
                                        .company_name
                                }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-username"
                                >Telefon kontaktowy*</label
                            >
                            <input
                                type="tel"
                                id="register-company-number"
                                name="company-number"
                                v-number-only
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.phone_number"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.phone_number
                                "
                            >
                                {{
                                    registerErrors.organizer_details
                                        .phone_number
                                }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-username">NIP*</label>
                            <input
                                type="text"
                                v-number-only
                                id="register-company-NIP"
                                name="company-NIP"
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.company_nip"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.company_nip
                                "
                            >
                                {{
                                    registerErrors.organizer_details.company_nip
                                }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-username">Kraj*</label>
                            <input
                                type="text"
                                id="register-company-country"
                                name="company-address"
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.company_country"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.company_country
                                "
                            >
                                {{
                                    registerErrors.organizer_details
                                        .company_country
                                }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-username">Miasto*</label>
                            <input
                                type="text"
                                id="register-company-country"
                                name="company-address"
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.company_city"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.company_city
                                "
                            >
                                {{
                                    registerErrors.organizer_details
                                        .company_city
                                }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-username">Kod pocztowy*</label>
                            <input
                                type="text"
                                id="register-company-country"
                                name="company-address"
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.company_zip_code"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.company_zip_code
                                "
                            >
                                {{
                                    registerErrors.organizer_details
                                        .company_zip_code
                                }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-username">Ulica*</label>
                            <input
                                type="text"
                                id="register-company-country"
                                name="company-address"
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.company_street"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.company_street
                                "
                            >
                                {{
                                    registerErrors.organizer_details
                                        .company_street
                                }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-username"
                                >Numer konta bankowego*</label
                            >
                            <input
                                type="text"
                                v-number-only
                                id="register-company-bank"
                                name="company-bank"
                                :required="registerForm.organizer_request"
                                :aria-required="registerForm.organizer_request"
                                spellcheck="false"
                                v-model="organizerDetails.bank_account"
                            />
                            <div
                                class="error-msg"
                                v-if="
                                    registerErrors.organizer_details
                                        ?.bank_account
                                "
                            >
                                {{
                                    registerErrors.organizer_details
                                        .bank_account
                                }}
                            </div>
                        </div>
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
.organizer-form {
    padding: 20px;
    background-color: var(--primary);
    border-radius: 8px;
    width: 100%;
    z-index: 5;
    margin-bottom: 30px;
    label {
        margin-bottom: 10px;
    }

    input,
    textarea {
        border-radius: 8px;
        background-color: #fff !important;
    }
}

#rcol {
    visibility: hidden;
    opacity: 0;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);
    &.show {
        visibility: visible;
        opacity: 1;
        max-height: 2000px;
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
