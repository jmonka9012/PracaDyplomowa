<script setup>
defineProps({
    events: Array,
});
</script>
<template>
    <div class="select-filters">
        <div class="input-wrap select-wrap">
            <i class="fa fa-calendar"></i>
            <i class="fa fa-chevron-down"></i>
            <select>
                <option disabled value="">Please select one</option>
                <option>Buisness</option>
                <option>Concert</option>
                <option>Music</option>
                <option>Conference</option>
                <option>Education</option>
                <option>Fashion</option>
                <option>Festival</option>
                <option>Food & drink</option>
                <option>Other</option>
                <option>Sport</option>
            </select>
        </div>
        <div class="input-wrap select-wrap">
            <i class="fa fa-map-marker"></i>
            <select class="select">
                <option disabled value="">All time</option>
                <option>Today</option>
                <option>Tommorow</option>
                <option>This week</option>
                <option>This weekend</option>
                <option>Next week</option>
                <option>Next month</option>
            </select>
        </div>
    </div>
    <div v-for="event in events" :key="event.id" class="event">
        <div class="event-img">
            <a class="link-stretched" :href="event.mainLink[0].href"> </a>
            <img :src="event.src" alt="" />
        </div>
        <div class="d-flex flex-column col-12">
            <div
                class="d-flex flex-lg-row justify-content-between align-items-center mt-lg-8px mb-16px"
            >
                <h6 class="event-title">
                    <a :href="event.mainLink[0].href">{{
                        event.mainLink[0].title
                    }}</a>
                </h6>
                <a
                    class="event-link d-none d-lg-flex"
                    :href="event.mainLink[0].ahref"
                    ><i class="fa fa-ticket"></i>
                    Zobacz więcej
                </a>
            </div>
            <p class="event-date ff-prompt">
                <i class="fa fa-calendar mr-5px"></i>{{ event.date }}
            </p>
            <p class="event-subtitle">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed,
                eum?
            </p>
            <a class="event-link d-lg-none" :href="event.mainLink[0].ahref"
                ><i class="fa fa-ticket"></i>
                Zobacz więcej
            </a>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "~css/mixin.scss";
.event {
    display: flex;
    flex-direction: column;
    padding: 16px;
    border: 1px solid #1910280a;
    position: relative;
    background-color: #fffc;
    word-break: break-word;
    border-radius: 8px;
    width: 100%;
    margin-bottom: 16px;
    &:last-of-type {
        margin-bottom: 0;
    }

    @include mixin.media-breakpoint-up(md) {
        flex-direction: row;
        justify-content: space-between;
        align-items: start;
    }

    &-img {
        max-width: 200px;
        flex-shrink: 0;
        margin-bottom: 20px;
        position: relative;
        display: flex;
        width: 100%;
        img {
            border-radius: 8px;
        }

        @include mixin.media-breakpoint-up(md) {
            margin-right: 16px;
            margin-bottom: 0;
        }
    }

    &-title {
        font-size: 24px;
        line-height: 1.5;
        font-weight: 500;
        @include mixin.media-breakpoint-down(lg) {
            font-size: 20px;
        }
        a {
            text-decoration: underline;
            text-decoration-color: transparent;
            text-decoration-thickness: 0.08em;
            text-underline-offset: 0.05em;
            transition: all 0.45s;
        }

        @include mixin.media-breakpoint-up(lg) {
            margin-bottom: 0;
        }

        &:hover {
            a {
                text-decoration-color: var(--dark);
            }
        }
    }
    &-link {
        height: 48px;
        min-width: 48px;
        font-size: 16px;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 0 16px;
        gap: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: var(--trans-def);
        background-color: var(--primary);
        &:hover {
            background-color: #a499d5;
        }
    }
    &-date {
        display: flex;
        align-items: center;
        color: #191028a3;
        line-height: 20px;
        i {
            font-size: 12px;
        }

        @include mixin.media-breakpoint-up(md) {
            margin-bottom: 0;
        }
        @include mixin.media-breakpoint-up(lg) {
            margin-bottom: 8px;
        }
    }
    &-subtitle {
        border-top: 1px solid #19102814;
        padding-top: 8px;
        margin-top: 30px;
        margin-bottom: 16px;
        font-size: 13px;
        line-height: 1.5;
        color: #191028a3;
        width: 100%;
        @include mixin.media-breakpoint-down(lg) {
            margin-bottom: 25px;
            margin-top: 25px;
        }
    }
    &-subtitle,
    &-date {
        transition: var(--trans-def);
    }
    &:hover {
        background-color: #19102805;
        .event-date,
        .event-subtitle {
            color: #191028;
        }
    }
}
</style>
