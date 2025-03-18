<script setup>
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
</script>

<template>
    <HeroSmall title="Forms showcase" :source="blogBg" />
    <section>
        <div class="container flex-column">
            <h1 class="title-1 mb-20px">Logowanie</h1>
            <form class="form" method="post" action="/login">
                <input type="hidden" name="_token" :value="csrf_token" />
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="username">Dane użytkownika *</label>
                    <input
                        type="text"
                        id="login"
                        autocomplete="email"
                        name="login"
                        spellcheck="false"
                        value=""
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="password">Hasło *</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        autocomplete="password"
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" placeholder="Zaloguj się" />
                </div>
            </form>
            <h1 class="title-1 mb-20px">Rejestracja</h1>
            <form class="form pb-120px" method="post" action="/register">
                <input type="hidden" name="_token" :value="csrf_token" />
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="register-username">Nazwa użytkownika *</label>
                    <input
                        type="text"
                        id="register-username"
                        name="name"
                        autocomplete="register-username"
                        spellcheck="false"
                        value=""
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="register-email">Email *</label>
                    <input
                        type="text"
                        id="register-email"
                        name="email"
                        autocomplete="register-email"
                        spellcheck="false"
                        value=""
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="register-password">Hasło *</label>
                    <input
                        type="password"
                        name="password"
                        id="register-password"
                        autocomplete="register"
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap d-flex flex-column col-12">
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
                    />
                </div>
                <div class="input-wrap col-12 mb-20px">
                    <p>
                        Na adres e-mail zostanie wysłany odnośnik do ustawienia
                        nowego hasła.
                    </p>
                </div>
                <div class="input-wrap col-12 mb-20px">
                    <input
                        type="checkbox"
                        required
                        name="confirmation"
                        id="confirmation"
                        aria-required="true"
                    />
                    <label for="checkbox">
                        Twoje dane osobowe zostaną użyte do obsługi twojej
                        wizyty na naszej stronie, zarządzania dostępem do
                        twojego konta i dla innych celów o których mówi nasza
                        polityka prywatności.
                    </label>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" placeholder="Zarejestruj się" />
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
