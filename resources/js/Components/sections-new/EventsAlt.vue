<script setup>
defineProps({
    latest: Array,
});
</script>

<template>
    <div :class="['ev-cont ev-cont-lg-three', evContClass]">
        <div
            v-for="event in latest"
            :key="event.id"
            class="event-item event-item-blog bt-1 b-secondary pt-25px"
        >
            <h6>
                <a class="hover-underline-thick" :href="event.link.href">
                    {{ event.title }}
                </a>
            </h6>
            <div class="d-flex flex-row h-fit">
                <p class="event-date">
                    {{ event.date }}
                </p>
                <span class="divider divider-dark"></span>
                <p class="event-location ff-krona">{{ event.location }}</p>
            </div>
            <div class="relative mt-auto">
                <img :src="event.src" alt="" class="event-img event-img-blog" />
                <a :href="event.link.href" class="link-stretched"></a>
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
