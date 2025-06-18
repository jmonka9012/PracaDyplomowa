<script setup>
import { Link } from "@inertiajs/vue3";
import { reactive } from "vue";

const props = defineProps({
    genres: {
        type: Array,
        required: true,
    },
    featured_genres: {
        type: Array,
    }
});

const featuredCategories = reactive({
    1: {
        id: null,
        file: null,
    },
    2: {
        id: null,
        file: null,
    },
    3: {
        id: null,
        file: null,
    },
    4: {
        id: null,
        file: null,
    },
    5: {
        id: null,
        file: null,
    },
});

const iconPreviews = reactive({})

function HandleIconChange(event, index) {
    const file = event.target.files?.[0]
    if (!file) return
    featuredCategories[index].file = file

    const reader = new FileReader()
    reader.onload = () => {
        iconPreviews[index] = reader.result
    }
    reader.readAsText(file)
}


function SetFeaturedCategories() {
    console.log("nic sie nigdy nie dzieje");
    console.log(featuredCategories);
}
</script>

<template>
    <section class="pt-50px pb-50px">
        <div class="container">
            <div class="admin-card__container w-100 mb-80px">
                <Link :href="route('admin.events')" class="w-100 admin-card">
                    <i class="mb-20px fa fa-calendar"></i>
                    <p class="fw-bold fs-24">Zarządzaj wydarzeniami</p>
                    <p class="">
                        Zatwierdź oczekujące wydarzenia, lub usuń już istniejące
                    </p>
                </Link>
                <Link :href="route('blog-create')" class="w-100 admin-card">
                    <i class="mb-20px fa fa-plus"></i>
                    <p class="fw-bold fs-24">Dodaj wpis</p>
                    <p class="">Napisz wpis na naszego bloga</p>
                </Link>
                <Link :href="route('admin.posts')" class="w-100 admin-card">
                    <i class="mb-20px fa fa-pencil-square"></i>
                    <p class="fw-bold fs-24">Zarządzaj wpisami</p>
                    <p class="">Usuń posty</p>
                </Link>
                <Link :href="route('admin.users')" class="w-100 admin-card">
                    <i class="mb-20px fa fa-address-card"></i>
                    <p class="fw-bold fs-24">Użytkownicy</p>
                    <p class="">
                        Zarządzaj użytkownikami: usuń, wyślij email
                        weryfikacyjne, itd?
                    </p>
                </Link>
                <Link
                    :href="route('admin.customer-service')"
                    class="w-100 admin-card"
                >
                    <i class="mb-20px fa fa-user"></i>
                    <p class="fw-bold fs-24">Obsługa klienta</p>
                    <p class="">
                        Zobacz zgłoszenia o pomoc od naszych użytkowników
                    </p>
                </Link>
            </div>
            <h3 class="mb-30px w-100">Promowane kategorie (strona główna)</h3>
            <div class="featured-categories">
                <div v-for="i in 5" :key="i" class="featured-categories__cat-box">
                    <div class="featured-categories__label">Obecna ikona:</div>
                    <div class="featured-categories__icon-box">
                        <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.1056 7.82366C21.0368 7.613 20.8562 7.46253 20.6369 7.42814L14.1021 6.4995L11.1614 0.588067C11.0626 0.390303 10.8605 0.265625 10.6412 0.265625C10.422 0.265625 10.2199 0.390303 10.121 0.592366L7.21905 6.521L0.68423 7.49262C0.464969 7.52702 0.284402 7.67749 0.215614 7.88815C0.146827 8.09881 0.207016 8.33097 0.366087 8.48145L5.10813 13.0773L4.01183 19.5863C3.97314 19.8056 4.06342 20.0249 4.24399 20.1538C4.34287 20.2269 4.46325 20.2656 4.58363 20.2656C4.67821 20.2656 4.76849 20.2441 4.85448 20.1968L10.6885 17.1057L16.5398 20.1624C16.6258 20.2054 16.716 20.2269 16.8063 20.2269C17.1245 20.2269 17.3867 19.9647 17.3867 19.6465C17.3867 19.5992 17.3824 19.5563 17.3695 19.5133L16.2388 13.0429L20.9508 8.42126C21.1185 8.26648 21.1743 8.03433 21.1056 7.82366ZM15.2156 12.4281C15.078 12.5614 15.0178 12.7549 15.0522 12.944L16.0368 18.5889L10.9551 15.9363C10.7874 15.846 10.5853 15.8503 10.4134 15.9363L5.34889 18.619L6.29902 12.9655C6.32911 12.7764 6.26892 12.5872 6.13135 12.4539L2.02129 8.46425L7.69197 7.6216C7.88113 7.59151 8.0445 7.47543 8.12619 7.30346L10.6455 2.15728L13.1993 7.29056C13.2853 7.46253 13.4486 7.57861 13.6378 7.6087L19.3128 8.41696L15.2156 12.4281Z"/>
                        </svg>
                    </div>
                    <input @change="HandleIconChange($event, i)" type="file" accept=".svg,image/svg+xml">
                    <div v-if="featuredCategories[i].file">
                        <div class="featured-categories__label">Nowa ikona:</div>
                        <div
                            class="featured-categories__icon-box"
                            v-html="iconPreviews[i]"
                        ></div>                    </div>
                    <label class="featured-categories__label">Obecna kategoria:</label>
                    <select class="hero-select" v-model="featuredCategories[i].id">
                        <option disabled :value="null">
                            Wybierz kategorię
                        </option>
                        <option
                            :key="genre.id"
                            :value="genre.id"
                            v-for="genre in props.genres"
                        >
                            {{ genre.genre_name }}
                        </option>
                    </select>
                </div>
            </div>
            <button @click="SetFeaturedCategories()" class="ml-auto mr-auto btn btn-md btn-hovprim">Ustaw kategorie</button>
        </div>
    </section>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";

.featured-categories {
    display: grid;
    gap: 25px;
    margin-bottom: 40px;
    max-width: 100%;
    align-items: start;

    @include mixin.media-breakpoint-up(md) {
        grid-template-columns: repeat(3, minmax(0, 1fr));

        @include mixin.media-breakpoint-up(xl) {
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }
    }

    &__cat-box {
        min-width: 0;
        box-sizing: border-box;

        border-radius: 8px;
        border: 1px solid var(--primary);
        padding: 16px;
        display: flex;
        flex-direction: column;
    }

    &__icon-box {
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
        border-radius: 8px;
        border: 1px solid var(--primary);
        padding: 25px;

        svg {
            width: 100% !important;
            height: auto;
            fill: black;
        }
    }

    /* reszta styli… */
}


.d-block {
    display: block;
}

.w-100 {
    width: 100%;
}

.admin-card {
    &__container {
        display: grid;
        gap: 30px;

        @include mixin.media-breakpoint-up(lg) {
            grid-template-columns: 1fr 1fr;
        }
    }

    color: white;
    padding: 20px;
    position: relative;
    display: block;
    transition: transform 0.2s ease-out;

    &:hover {
        &::before {
            transform: translate(-5px, 5px);
        }

        &::after {
            transform: translate(5px, -5px);
        }
    }

    &::after,
    &::before {
        content: "";
        position: absolute;
        border-radius: 12px;
        transition: transform 0.2s ease-out;
        width: 100%;
        height: 100%;
        inset: 0;
    }

    &::after {
        background-color: var(--primary);
        z-index: -1;
    }

    &::before {
        z-index: -2;
        background-color: var(--primary-darker);
    }
    i {
        font-size: 24px;
    }
}
</style>
