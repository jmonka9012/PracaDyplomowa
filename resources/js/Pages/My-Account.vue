<script setup>
import Popup from "@/Components/sections-new/Popup.vue";
import Tab from "@/Components/sections-new/Tab.vue";
import Tabs from "@/Components/sections-new/Tabs.vue";
import useAuth from "@/Utilities/useAuth";
import ResetObject from "@/Utilities/resetObject";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, reactive, toRaw } from "vue";

const showModal = ref(false);
const { user, isLoggedIn } = useAuth();

let currentRequest;

function handleSubmitClick(form) {
    showModal.value = true;
    currentRequest = form;
}

//$event.target.value
const handleValidationEmit = (state) => {
    if (state === true) {
        router.post(route("my-account.change"), currentRequest, {
            onError: (err) => {
                ResetObject(errors);
                Object.assign(errors, err); //errory do poprawienia
            },
            onSuccess: (page) => {
                currentRequest = null;
                showModal.value = false;
            },
        });
    }
};

const Logout = () => {
    router.post(route("logout"), {});
};

const TestEmail = () => {
    router.post(route("test-email"), {});
};

const fNameForm = reactive({
    first_name: null,
});

const lNameForm = reactive({
    last_name: null,
});

const emailForm = reactive({
    email: null,
});

const passwordForm = reactive({
    password: null,
});

const errors = reactive({});
</script>

<template>
    <section class="ma-hero"></section>
    <section class="bg-grey">
        <div class="container flex-lg-row column-mob-reverse">
            <div class="col-12 col-lg-3 d-flex ma-lcol flex-column">
                <div class="ma-lcol-intro">
                    <p>Witaj ponownie</p>
                    <p class="fw-bold">{{ user.name }}</p>
                </div>
                <div class="ma-lcol-content">
                    <nav class="ma-lcol-nav">
                        <ul>
                            <li>
                                <button>
                                    <i class="fa fa-ticket"></i>Moje bilety
                                </button>
                            </li>
                            <li><a href="#">Nadchodzące wydarzenia</a></li>
                            <li><a href="#">Poprzednie wydarzenia</a></li>
                        </ul>
                        <ul>
                            <li>
                                <button>
                                    <i class="fa fa-user"></i>Mój profil
                                </button>
                            </li>
                            <li><a href="#">Szczegóły profilu</a></li>
                            <li><a href="#">Szczególy sprzedawcy</a></li>
                        </ul>
<!--                        <ul>
                            <li>
                                <button value="">
                                    <i class="fa fa-gear"></i>Moje ustawienia
                                </button>
                            </li>
                            <li><a href="#">Zarządzaj powiadomieniami</a></li>
                        </ul>-->
                        <ul>
                            <li>
                                <Link
                                    @click="Logout"
                                    class="text-primary user-functions"
                                    >Wyloguj się</Link
                                >
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-lg-9 d-flex flex-column ma-rcol pl-lg-60px">
                <div class="bcrumb text-white mb-32px">
                    <a href="">Prev</a>
                    <span class="divider divider-star"></span>
                    <a class="bcrumb__cur" href="">Current</a>
                </div>
                <h1 class="ma-title">Mój profil</h1>

                <Tabs class="tabs-white">
                    <Tab title="Moje informacje">
                        <h3 class="ma-ftitle">Moje informacje</h3>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(fNameForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="first-name-input">Imię</label>
                                <input
                                    type="text"
                                    id="change-first-name"
                                    autocomplete="first-name-input"
                                    name="first-name-input"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    :placeholder="user.first_name"
                                    v-model="fNameForm.first_name"
                                />
                            </div>
                            <div class="error-msg" v-if="errors.first_name">
                                {{ errors.first_name }}
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    value="zaktualizuj szczegóły"
                                    type="submit"
                                    class="form-submit"
                                />
                            </div>
                        </form>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(lNameForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="last-name-input">Nazwisko</label>
                                <input
                                    type="text"
                                    id="change-last-name"
                                    autocomplete="last-name-input"
                                    name="last-name-input"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    :placeholder="user.last_name"
                                    v-model="lNameForm.last_name"
                                />
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    type="submit"
                                    value="zaktualizuj szczegóły"
                                />
                            </div>
                        </form>

                        <h3 class="ma-ftitle">Adres Email</h3>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(emailForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="change-email">Email</label>
                                <input
                                    type="text"
                                    id="change-email"
                                    autocomplete="change-email"
                                    name="change-email"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    :placeholder="user.email"
                                    v-model="emailForm.email"
                                />
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    type="submit"
                                    value="Zaktualizuj E-mail"
                                />
                            </div>
                        </form>
                        <h3 class="ma-ftitle">Zmień hasło</h3>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(passwordForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="change-password">Hasło</label>
                                <input
                                    type="password"
                                    id="change-password"
                                    autocomplete="change-password"
                                    name="change-password"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    v-model="passwordForm.password"
                                />
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    type="submit"
                                    value="Zaktualizuj Hasło"
                                />
                            </div>
                        </form>
                        <h3 class="ma-ftitle">Potwierdź Email</h3>
                        <form class="form form-ma">
                            <div class="input-wrap d-flex flex-column col-12">
                                <input type="submit" value="Potwierdź" />
                            </div>
                        </form>
                    </Tab>
                </Tabs>
            </div>
        </div>
    </section>
    <Popup
        :show="showModal"
        @close="showModal = false"
        @password-validation-success="handleValidationEmit"
    ></Popup>
</template>

<style lang="scss">
@use "~css/mixin.scss";
.ma-hero {
    background-color: var(--primary);
    min-height: 380px;
}
.ma-ftitle {
    font-size: 32px;
    line-height: 48px;
    color: var(--text);
    font-weight: 500;
    margin-bottom: 30px;
}
.ma-title {
    font-size: 32px;
    font-stretch: normal;
    line-height: 1.21;
    letter-spacing: 0.56px;
    text-align: left;
    margin-bottom: 30px;
    color: white;
}
.ma-divider {
    margin: 32px 0px 0px;
    border-width: 1px 0px 0px;
    border-style: solid none none;
    border-color: rgb(223, 228, 231);
    box-sizing: content-box;
    height: 0px;
    overflow: visible;
}
.ma-lcol-intro {
    padding: 32px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    background-color: rgba(255, 255, 255, 0.1);

    @include mixin.media-breakpoint-up(lg) {
        min-height: 200px;
    }
}
.ma-lcol-content {
    padding: 16px 0 88px;
    background-color: rgb(255, 255, 255);
    box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 10px 3px;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.ma-lcol-nav {
    color: rgb(18, 18, 18);
    ul {
        padding-bottom: 5px;
        margin-bottom: 5px;
        position: relative;
        &::after {
            width: calc(100% - 32px);
            left: 16px;
            right: 16px;
            background-color: var(--primary);
            height: 1px;
            display: block;
            position: absolute;
            content: "";
            bottom: 0;
        }
        li {
            position: relative;
            button {
                padding: 16px 64px;
                background-color: transparent;
                border: 0;
                font-size: 16px;
                font-weight: 500;
                font-family: "Prompt";
                width: 100%;
                text-align: start;
                &:hover {
                    background-color: #f6f6f6;
                    text-decoration: underline;
                }
                i {
                    position: absolute;
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    left: 24px;
                    color: rgb(100, 100, 100);
                }
            }
            a {
                padding: 12px 24px 12px 64px;
                color: rgb(18, 18, 18);
                font-size: 16px;
                line-height: 1.5;
                letter-spacing: 0.32px;
                width: 100%;
                &.user-functions {
                    padding-left: 24px;
                }
                &:hover {
                    background-color: #f6f6f6;
                    text-decoration: underline;
                }
            }
        }
        &:last-of-type {
            &::after {
                display: none;
            }
        }
    }
}
.ma-rcol {
    margin-top: -240px;
    margin-bottom: 35px;
    @include mixin.media-breakpoint-up(lg) {
        margin-bottom: 70px;
    }
}
.ma-lcol {
    @include mixin.media-breakpoint-up(lg) {
        margin-top: -200px;
    }
}
</style>
