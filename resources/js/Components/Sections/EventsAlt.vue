<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    events: Array,
});
</script>

<template>
    <div :class="['ev-cont ev-cont-lg-three']">
        <div
            v-for="event in props.events.data"
            :key="event.id"
            class="event-item event-item-blog bt-1 b-secondary pt-25px"
        >
            <h6>
                <Link
                    class="hover-underline-thick"
                    :href="`/${event.event_url}`"
                >
                    {{ event.event_name }}
                </Link>
            </h6>
            <div class="d-flex flex-column h-fit">
                <p class="event-date">
                    {{ event.event_date }}
                </p>
                <span class="divider divider-horizontal divider-dark"></span>
                <p class="event-category-link ff-krona mb-16px">
                    Kategorie:
                    <Link
                        class="event-category-link hover-primary"
                        :href="route('event.browser')"
                        :data="{ genres: genre.id }"
                        v-for="(genre, index) in event.genres"
                        >{{ genre.name
                        }}<span v-if="index < event.genres.length - 1">, </span>
                    </Link>
                </p>
            </div>
            <div class="relative d-flex mt-auto">
                <img
                    :src="`/storage/${event.image_path}`"
                    alt=""
                    class="event-img event-img-blog"
                />
                <Link
                    :href="`/${event.event_url}`"
                    class="link-stretched"
                ></Link>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.event-item-blog {
    display: flex;
    flex-direction: column;
}

.event-img-blog {
    margin-bottom: 0;
}
.event-category-link {
    font-size: 12px;
    line-height: 30px;
    color: var(--text);
}
</style>
