<script setup>
import useAuth from "@/Composables/useAuth";
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";

const { user, isLoggedIn } = useAuth();
</script>

<template>
    <HeroSmall title="Zorganizuj wydarzenie" :source="blogBg"></HeroSmall>
    <section class="pt-50px pb-50px">
        <div class="container">
            <form action="" class="form" enctype="multipart/form-data">
                <div class="input-wrap col-12">
                    <label for="event-title">Nazwa Wydarzenia*</label>
                    <input
                        type="text"
                        placeholder="Nazwa wydarzenia"
                        required
                        id="event-title"
                        autocomplete="event-title"
                        name="event-title"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-slug">Url wydarzenia</label>
                    <p class="mb-10px fs-14">
                        Jeżeli zostawisz pole puste, URL zostanie ustawiony na
                        podstawie podanego tytułu
                    </p>
                    <input
                        type="text"
                        placeholder="Url wydarzenia*"
                        id="event-slug"
                        pattern="[a-z0-9-]+"
                        name="event-slug"
                        spellcheck="false"
                        value=""
                        aria-required="false"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-image">Obrazek główny Wydarzenia*</label>
                    <input
                        type="file"
                        id="event-image"
                        name="event-image"
                        accept="image/*"
                        required
                        placeholder="Obrazek główny*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                    <p class="mt-10px fs-14">
                        Zalecane ratio 3:2, zalecana rozdzielczość 1024x1024
                    </p>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-date">Data Wydarzenia*</label>
                    <input
                        type="date"
                        id="event-date"
                        name="event-date"
                        required
                        placeholder="Data Wydarzenia*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                </div>

                <div class="input-wrap col-12 col-lg-6">
                    <label for="event-start">Początek Wydarzenia*</label>
                    <input
                        type="time"
                        id="event-start"
                        name="event-start"
                        required
                        placeholder="Rozpoczęcie wydarzenia*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12 col-lg-6">
                    <label for="event-end">Koniec Wydarzenia*</label>
                    <input
                        type="time"
                        id="event-end"
                        name="event-end"
                        required
                        placeholder="Zakończenie wydarzenia*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-location"
                        >Lokalizacja / Wybrana sala*</label
                    >
                    <input
                        type="text"
                        id="event-location"
                        name="event-location"
                        required
                        placeholder="Lokalizacja"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-email">Email kontaktowy*</label>
                    <input
                        type="email"
                        id="event-email"
                        name="event-email"
                        required
                        placeholder="Email główny"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-email-additional">Email dodatkowy</label>
                    <input
                        type="email"
                        id="event-email-additional"
                        name="event-email-additional"
                        placeholder="Email dodatkowy"
                        spellcheck="false"
                        value=""
                        aria-required="false"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-description">Opis*</label>
                    <textarea
                        id="event-description"
                        name="eevent-description"
                        required
                        placeholder="Opis wydarzenia"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    ></textarea>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-description">Więcej informacji</label>
                    <textarea
                        id="event-description-additional"
                        name="eevent-description-additional"
                        placeholder="Więcej informacji"
                        spellcheck="false"
                        value=""
                        aria-required="false"
                    ></textarea>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Stwórz wydarzenie" />
                </div>
            </form>
        </div>
    </section>
</template>
