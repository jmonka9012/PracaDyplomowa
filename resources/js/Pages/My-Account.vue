<script setup></script>

<template>
    <section class="ma-hero"></section>
    <section>
        <div class="container">
            <div class="col-12 col-lg-3 d-flex flex-column">
                <div class="ma-lcol-intro">
                    <p>Witaj ponownie</p>
                    <p class="fw-bold">[[User]]</p>
                </div>
                <div class="ma-lcol-content">
                    <nav class="ma-lcol-nav">
                        <ul>
                            <li>
                                <button>Moje bilety</button>
                            </li>
                            <li><a href="#">Nadchodzące wydarzenia</a></li>
                            <li><a href="#">Poprzednie wydarzenia</a></li>
                        </ul>
                        <ul>
                            <li>
                                <button>Mój profil</button>
                            </li>
                            <li><a href="#">Szczegóły profilu</a></li>
                            <li><a href="#">Szczególy sprzedawcy</a></li>
                            <li><a href="#">Saldo karty podarunkowej</a></li>
                        </ul>
                        <ul>
                            <li>
                                <button>Moje ustawienia</button>
                            </li>
                            <li><a href="#">Zarządzaj powiadomieniami</a></li>
                        </ul>
                        <ul>
                            <li>
                                <a href="#" class="text-primary">Wyloguj się</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-lg-9 d-flex flex-column pl-60px">
                <div class="bcrumb bcrumb-ma text-white">
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
                                    placeholder="Zarejestruj się"
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
                                    placeholder="Zarejestruj się"
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
                                    placeholder="Zarejestruj się"
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
                                    placeholder="Zarejestruj się"
                                />
                            </div>
                        </form>
                        <h3 class="ma-ftitle">Potwierdź Email</h3>
                        <form class="form form-ma">
                            <div class="input-wrap d-flex flex-column col-12">
                                <input
                                    type="submit"
                                    placeholder="Zarejestruj się"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style lang="scss">
.ma-hero {
    background-color: var(--primary);
    min-height: 380px;
    margin-bottom: -200px;
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
    background-color: rgba(255, 255, 255, 0.1);
    height: 200px;
}
.ma-lcol-content {
    padding: 16px 0 88px;
    background-color: rgb(255, 255, 255);
    box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 10px 3px;
    display: flex;
    flex-direction: column;
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
            button {
                padding: 16px 64px;
                background-color: transparent;
                border: 0;
                font-size: 16px;
                font-weight: 500;
                font-family: "Prompt";
                width: 100%;
                text-align: start;
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
//tabs temporairly here
.tabs {
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
    &__content {
        padding: 62px 24px 32px;
        position: relative;
        box-shadow: rgba(18, 18, 18, 0.15) 0px 1px 4px 0px;
        background-color: white;
    }
}
</style>
