<script setup>
import EventsAlt from "@/Components/Sections/EventsAlt.vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";

import HellSpit from "~images/hellspit.jpg";
import BangPow from "~images/bangpow.jpg";
import SingleMap from "~images/single-map.jpg";
import blogBg from "~images/single-map.jpg";

const url = window.location.href;

const props = defineProps({
    event: {
        type: Array,
        required: true,
    },
});

console.log(props);

const latest = [
    {
        id: 1,
        src: BangPow,
        title: "Lorem ipsum dolor",
        link: {
            href: "/icp",
            title: "Bang Pow Boom at Jugaloo Island",
        },

        location: "Bangpowboom",
        date: "January 22, 2025",
    },
    {
        id: 2,
        src: HellSpit,
        title: "Lorem ipsum dolor sit amet lorem ipsum",
        link: {
            href: "/icp",
            title: "Bang Pow Boom at Jugaloo Island",
        },

        location: "Bangpowboom",
        date: "January 22, 2025",
    },
    {
        id: 3,
        src: HellSpit,
        title: "Lorem ipsum dolor sit amet lorem ipsum",
        link: {
            href: "/icp",
            title: "Riddle box",
        },

        location: "Riddle box",
        date: "January 22, 2025",
    },
];
</script>

<template>
    <HeroSmall :source="blogBg" :title="event.data.event_name" />
    <section class="single">
        <div class="container container-small">
            <div class="single__content">
                <div class="single__intro">
                    <img :src="'/storage/' + event.data.image_path" alt="" />
                </div>
                <h1 class="single__title">
                    {{ event.data.event_name }}
                </h1>
                <div class="single__details">
                    <div>
                        <h6 class="mb-13px">Event date:</h6>
                        <p>
                            {{ event.data.event_start }} -
                            {{ event.data.event_end }} <br />
                            {{ event.data.event_date }}
                        </p>
                    </div>
                    <!--                    <div>
                        <h6 class="mb-13px">Location:</h6>
                        <a class="text-secondary" href="/">GERMANY</a>
                    </div>-->
                    <div>
                        <h6 class="mb-13px">E-mail:</h6>
                        <a
                            class="hover-primary text-underline"
                            :href="'mailto:' + event.data.contact_email"
                            >{{ event.data.contact_email }}</a
                        >
                        <a
                            class="hover-primary text-underline"
                            :href="
                                'mailto:' + event.data.contact_email_additional
                            "
                            >{{ event.data.contact_email_additional }}</a
                        >
                    </div>
                </div>
                <h4 class="mb-18px">O wydarzeniu</h4>
                <p v-html="event.data.event_description" class="mb-65px"></p>
                <h4 class="mb-18px">Więcej informacji</h4>
                <div class="mb-65px">
                    {{ event.data.event_description_additional }}
                </div>
                <img class="single__map" :src="SingleMap" alt="" />
                <div class="bb-1 b-secondary"></div>
                <div
                    class="d-flex row-gap-10px column-gap-10px mt-30px mb-100px"
                >
                    <a
                        class="social-link"
                        :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent(
                            url
                        )}`"
                        target="_blank"
                        ><i class="fab fa-twitter"></i
                    ></a>

                    <a
                        class="social-link"
                        :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
                            url
                        )}`"
                        target="_blank"
                    >
                        <i class="fab fa-facebook"></i
                    ></a>

                    <a
                        class="social-link"
                        :href="`https://pinterest.com/pin/create/button/?url=${encodeURIComponent(
                            url
                        )}`"
                        target="_blank"
                    >
                        <i class="fab fa-pinterest"></i
                    ></a>
                </div>
                <h3 class="mb-30px">Related Events</h3>
                <EventsAlt :latest="latest" />
                <!-- <h3 class="mb-40px">Leave a Reply</h3>
                <p class="fs-14 mb-20px">
                    Your email address will not be published. Required fields
                    are marked *
                </p> -->
                <!-- <form action="" class="form">
                    <div class="input-wrap col-12 col-lg-6">
                        <input type="text" placeholder="Your Name*" required />
                    </div>
                    <div class="input-wrap col-12 col-lg-6">
                        <input type="text" placeholder="Your Email*" required />
                    </div>
                    <div class="input-wrap col-12">
                        <input type="text" placeholder="Website" />
                    </div>
                    <div class="input-wrap col-12">
                        <textarea placeholder="Your Comment..."></textarea>
                    </div>
                    <div class="input-wrap input-wrap-check col-12">
                        <input
                            type="checkbox"
                            v-model="toggle"
                            true-value="yes"
                            false-value="no"
                        />
                        <label for="checkbox"
                            >Save my name, email, and website in this browser
                            for the next time I comment.
                        </label>
                    </div>
                    <div class="input-wrap col-12">
                        <input type="submit" value="post comment" />
                    </div>
                </form> -->
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
@use "~css/mixin.scss";
.single {
    &__content {
        width: 100%;
        padding: 0 5px;
        color: #505558;
        display: flex;
        flex-direction: column;
        margin-bottom: 55px;
        @include mixin.media-breakpoint-up(md) {
            padding: 0 30px;
            margin-bottom: 110px;
        }
    }
    &__intro {
        margin-bottom: 50px;
        display: flex;
        justify-content: center;
        img {
            max-height: 600px;
        }
    }
    &__title {
        margin-bottom: 50px;
        font-size: 28px;
        line-height: 1.25;
        word-wrap: break-word;
        overflow-wrap: break-word;
        @include mixin.media-breakpoint-up(md) {
            font-size: 42px;
        }
    }
    &__details {
        display: grid;
        grid-template-columns: 1fr;
        @include mixin.media-breakpoint-up(md) {
            grid-template-columns: repeat(3, 1fr);
            grid-column-gap: 60px;
        }
        div {
            font-size: 12px;
            line-height: 30px;
            font-family: "Krona One";
            padding: 30px 0;
            position: relative;
            display: flex;
            flex-direction: column;
            margin: 0;
            &::before {
                position: absolute;
                left: 0px;
                right: 0px;
                background-color: var(--text);
                height: 1px;
                content: "";
                top: 0;
            }
        }

        p {
        }
    }
    &__map {
        margin-bottom: 50px;
    }
    h3 {
        font-size: 24px;
        @include mixin.media-breakpoint-up(lg) {
            font-size: 36px;
        }
    }
    h4 {
        color: var(--text);
    }
}
textarea {
    height: 85px;
}
</style>
