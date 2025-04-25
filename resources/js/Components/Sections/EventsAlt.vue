<script setup>
import {Link} from "@inertiajs/vue3";


const props = defineProps({
    events: Array,
});

console.log(props.events);

</script>

<template>
    <div :class="['ev-cont ev-cont-lg-three']">
        <div
            v-for="event in props.events.data"
            :key="event.id"
            class="event-item event-item-blog bt-1 b-secondary pt-25px"
        >
            <h6>
                <Link class="hover-underline-thick" :href="event.event_url">
                    {{ event.event_name }}
                </Link>
            </h6>
            <div class="d-flex flex-row h-fit">
                <p class="event-date">
                    {{ event.event_date }}
                </p>
                <span class="divider divider-dark"></span>
                <p class="event-location ff-krona">placeholder, sala?</p>
            </div>
            <div class="relative mt-auto">
                <img :src="event.image_path" alt="" class="event-img event-img-blog" />
                <Link :href="event.event_url" class="link-stretched"></Link>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.event-item-blog {
    display: grid;
    grid-template-rows: 1fr 30px 270px;
    grid-row-gap: 30px;
}
.event-img-blog {
    margin-bottom: 0;
}
</style>
