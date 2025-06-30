<script setup>
import { Link, router } from "@inertiajs/vue3";
import { reactive } from "vue";

const props = defineProps({
    genres: {
        type: Array,
        required: true,
    },
    featured_categories: {
        type: Array,
    }
});
console.log(props);

const featuredCategories = reactive({
    0: {
        id: props.featured_categories[0].id ? props.featured_categories[0].id : 0,
        file: null,
    },
    1: {
        id: props.featured_categories[1].id ? props.featured_categories[1].id : 0,
        file: null,
    },
    2: {
        id: props.featured_categories[2].id ? props.featured_categories[2].id : 0,
        file: null,
    },
    3: {
        id: props.featured_categories[3].id ? props.featured_categories[3].id : 0,
        file: null,
    },
    4: {
        id: props.featured_categories[4].id ? props.featured_categories[4].id : 0,
        file: null,
    }
})

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
    console.log(featuredCategories);
    router.post(route('admin.featured.update'), featuredCategories, {
        preserveScroll: true,
        only: ["users"],
        onError: (err) => {
            console.log("Błąd:", err);
        },
        onSuccess: (page) => {
            console.log("Sukces:", page);
        },
    })
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
                    <div class="featured-categories__label">Obecna ikona {{i}}:</div>
                    <div class="featured-categories__icon-box">
                        <img   :src="`/storage/${props.featured_categories[i-1].image_path}`"
                               alt="">
                    </div>
                    <input @change="HandleIconChange($event, i-1)" type="file" accept=".svg,image/svg+xml">
                    <div v-if="featuredCategories[i-1].file">
                        <div class="featured-categories__label">Nowa ikona:</div>
                        <div
                            class="featured-categories__icon-box"
                            v-html="iconPreviews[i-1]"
                        ></div>                    </div>
                    <label class="featured-categories__label">Obecna kategoria:</label>
                    <select class="hero-select" v-model="featuredCategories[i-1].id">
                        <option disabled :value="null">
                            Wybierz kategorię
                        </option>
                        <option
                            :key="genre.id"
                            :value="genre.id"
                            v-for="genre in props.genres"
                            :selected="Number(genre.id) === Number(featuredCategories[i-1].id)">
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
