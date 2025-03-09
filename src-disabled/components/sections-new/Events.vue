<script setup>
defineProps({
    id: Number,
    src: String,
    mainLink: Array, // Keep as Array if your data structure is an array
    date: String,
});
</script>

<template>
    <div class="event col-12">
        <div class="event-img">
            <a class="link-stretched" :href="mainLink[0].href">
            </a>
            <img :src="src" alt="">
        </div>

        <div class="d-flex flex-column mr-auto">
            <h6 class="event-title">
                <a :href="mainLink.href">{{ mainLink[0].title }}</a>
            </h6>
            <p class="event-date">{{ date }}</p>
        </div>

        <a class="read-more" :href="mainLink[0].href">
            {{ mainLink[0].location }}
            <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</template>

<style lang="scss" scoped>
.event {
    display: flex;
    flex-direction: column;
    padding-top: 25px;
    margin-bottom: 25px;
    position: relative;

    @include media-breakpoint-up(md) {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    &::before {
        height: 1px;
        display: block;
        width: 100%;
        top: 0;
        left: 0;
        right: 0;
        position: absolute;
        content: '';
        background-color: var(--dark);
    }

    &-img {
        max-width: 170px;
        flex-shrink: 0;
        margin-bottom: 20px;
        position: relative;
        display: flex;

        @include media-breakpoint-up(md) {
            margin-right: 30px;
            margin-bottom: 0;
        }
    }

    &-title {
        margin-bottom: 5px;
        font-size: 28px;
        line-height: 36px;
        font-weight: 500;

        a {
            text-decoration: underline;
            text-decoration-color: transparent;
            text-decoration-thickness: 0.08em;
            text-underline-offset: 0.05em;
            transition: all 0.45s;
        }


        @include media-breakpoint-up(lg) {
            margin-bottom: 0;
        }

        &:hover {
            a {
                text-decoration-color: var(--dark);
            }

        }
    }

    &-date {
        margin-bottom: 10px;

        @include media-breakpoint-up(md) {
            margin-bottom: 0;
        }
    }
}
</style>