<script setup>
import useAuth from "@/Composables/useAuth";
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
const errors = reactive({});


// Przechowywanie danych formularza
const requestEventForm = reactive({
    event_name: null,
    event_url: null,
    event_date: null,
    event_start: null,
    event_end: null,
    contact_email: null,
    contact_email_additional: null,
    event_description: null,
    event_description_additional: null,
    event_location: null,
});

// Plik przechowujemy osobno
const eventImage = ref(null);

// Obsługa zmiany pliku
const handleFileUpload = (event) => {
    const file = event.target.files[0]; // Pobranie pierwszego pliku
    if (file) {
        eventImage.value = file;
    }
};

// Obsługa przesyłania formularza
function submitEventRequest() {
    const formData = new FormData();

    // Dodajemy dane formularza do FormData
    Object.entries(requestEventForm).forEach(([key, value]) => {
        if (value) {
            formData.append(key, value);
        }
    });

    // Dodajemy plik, jeśli został wybrany
    if (eventImage.value) {
        formData.append("event_image", eventImage.value);
    }

    // Wysyłanie żądania POST do serwera
    router.post(route("event-create.post"), formData, {
        onError: (err) => {
            Object.assign(errors, err);
        },
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
}

const { user, isLoggedIn } = useAuth();
</script>

<template>
    <HeroSmall title="Zorganizuj wydarzenie" :source="blogBg"></HeroSmall>
    <section class="pt-50px pb-50px">
        <div class="container">
            <form class="form" enctype="multipart/form-data" @submit.prevent="submitEventRequest">
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
                        v-model="requestEventForm.event_name"
                    />
                    <div v-if="errors.event_name">{{ errors.event_name }}</div>
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
                        v-model="requestEventForm.event_url"
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
                        @change="handleFileUpload"
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
                        v-model="requestEventForm.event_date"
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
                        v-model="requestEventForm.event_start"
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
                        v-model="requestEventForm.event_end"
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
                        v-model="requestEventForm.event_location"
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
                        v-model="requestEventForm.contact_email"
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
                        v-model="requestEventForm.contact_email_additional"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-description">Opis*</label>
                    <textarea
                        id="event-description"
                        name="event-description"
                        required
                        placeholder="Opis wydarzenia"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        v-model="requestEventForm.event_description"
                    ></textarea>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-description">Więcej informacji</label>
                    <textarea
                        id="event-description-additional"
                        name="event-description-additional"
                        placeholder="Więcej informacji"
                        spellcheck="false"
                        value=""
                        aria-required="false"
                        v-model="requestEventForm.event_description_additional"
                    ></textarea>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Stwórz wydarzenie" />
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
