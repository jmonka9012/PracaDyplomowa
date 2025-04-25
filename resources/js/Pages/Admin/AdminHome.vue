<script setup>
import {Link} from "@inertiajs/vue3";

</script>

<template>
    <section class="pt-50px pb-50px">
        <div class="container">
            <div class="admin-card__container w-100">
                <Link :href="route('admin.events')" class="w-100 admin-card">
                    <img class="mb-20px" src="" alt="<jakaś ikona>">
                    <p class="fw-bold fs-24">Zarządzaj wydarzeniami</p>
                    <p class="">Zatwierdź oczekujące wydarzenia, lub usuń już istniejące</p>
                </Link>
                <Link :href="route('blog-create')" class="w-100 admin-card">
                    <img class="mb-20px" src="" alt="<jakaś ikona>">
                    <p class="fw-bold fs-24">Dodaj wpis</p>
                    <p class="">Napisz wpis na naszego bloga</p>
                </Link>
                <Link :href="route('admin.posts')" class="w-100 admin-card">
                    <img class="mb-20px" src="" alt="<jakaś ikona>">
                    <p class="fw-bold fs-24">Zarządzaj wpisami</p>
                    <p class="">Usuń posty</p>
                </Link>
                <Link :href="route('admin.users')" class="w-100 admin-card">
                    <img class="mb-20px" src="" alt="<jakaś ikona>">
                    <p class="fw-bold fs-24">Użytkownicy</p>
                    <p class="">Zarządzaj użytkownikami: usuń, wyślij email weryfikacyjne, itd?</p>
                </Link>
                <Link :href="route('admin.customer-service')" class="w-100 admin-card">
                    <img class="mb-20px" src="" alt="<jakaś ikona>">
                    <p class="fw-bold fs-24">Obsługa klienta</p>
                    <p class="">Zobacz zgłoszenia o pomoc od naszych użytkowników</p>
                </Link>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";

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
    transition: transform .2s ease-out;

    &:hover {
        &::before {
            transform: translate(-5px, 5px);
        }

        &::after {
            transform: translate(5px, -5px);
        }
    }

    &::after, &::before {
        content: '';
        position: absolute;
        border-radius: 12px;
        transition: transform .2s ease-out;
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
}
</style>
