<script setup>
import Popup from "@/Components/sections-new/Popup.vue";
import { ref } from "vue";
const showModal = ref(false);
import useAuth from '@/Composables/useAuth'
import { router } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3";


const Logout = () => {
    router.post(route('logout'), {});
};

const TestEmail = () => {
    router.post(route('test-email'), {});
};

const { user, isLoggedIn } = useAuth()
</script>

<template>
    <section class="ma-hero"></section>
    <section class="bg-grey">
        <div class="container flex-lg-row column-mob-reverse">
            <div class="col-12 col-lg-3 d-flex ma-lcol flex-column">
                <div class="ma-lcol-intro">
                    <p>Witaj ponownie</p>
                    <p class="fw-bold">{{user.name}}</p>
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
                            <li><a href="#">Saldo karty podarunkowej</a></li>
                        </ul>
                        <ul>
                            <li>
                                <button value="">
                                    <i class="fa fa-gear"></i>Moje ustawienia
                                </button>
                            </li>
                            <li><a href="#">Zarządzaj powiadomieniami</a></li>
                        </ul>
                        <ul>
                            <li>
                                <Link @click="Logout" class="text-primary">Wyloguj się</Link>
                                <Link @click="TestEmail" class="text-primary">Test Email</Link>
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
                <div class="tabs">
                    <nav>
                        <ul>
                            <li>
                                <a href="#"> Szczegóły profilu </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="tabs__content">
                        <h3 class="ma-ftitle">Moje informacje</h3>
                        <form class="form form-ma">
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="first-name-input">Imię</label>
                                <input
                                    type="text"
                                    id="first-name-input"
                                    autocomplete="first-name-input"
                                    name="first-name-input"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                />
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    type="submit"
                                    value="zaktualizuj szczegóły"
                                    @click.prevent="showModal = true"
                                />
                            </div>
                        </form>
                        <form class="form form-ma">
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="last-name-input">Nazwisko</label>
                                <input
                                    type="text"
                                    id="last-name-input"
                                    autocomplete="last-name-input"
                                    name="last-name-input"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
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
                        <form class="form form-ma">
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
                        <form class="form form-ma">
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="change-password">Hasło</label>
                                <input
                                    type="text"
                                    id="change-password"
                                    autocomplete="change-password"
                                    name="change-password"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Popup :show="showModal" @close="showModal = false"></Popup>
</template>

<style lang="scss">
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

    @include media-breakpoint-up(lg) {
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
    @include media-breakpoint-up(lg) {
        margin-bottom: 70px;
    }
}
.ma-lcol {
    @include media-breakpoint-up(lg) {
        margin-top: -200px;
    }
}
//tabs temporairly here
.tabs {
    nav {
        padding-bottom: 32px;
        ul {
            li {
                a {
                    display: block;
                    margin-bottom: -1px;
                    padding: 12px;
                    border-bottom: 2px solid rgb(255, 255, 255);
                    color: rgb(255, 255, 255);
                    white-space: nowrap;
                    text-decoration: none;
                }
            }
        }
    }

    &__content {
        padding: 62px 24px 32px;
        position: relative;
        box-shadow: rgba(18, 18, 18, 0.15) 0px 1px 4px 0px;
        background-color: white;
    }
}
</style>
