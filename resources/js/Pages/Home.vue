<script setup>
import UpcomingEvents from "@/Components/sections/UpcomingEvents.vue";
import Team from "@/Components/sections-new/Team.vue";
import Services from "@/Components/sections-new/Services.vue";
import CategoriesImg from "@/Components/sections-new/Categories-img.vue";
import Events from "@/Components/sections-new/Events.vue";
import LatestEvents from "@/Components/sections-new/LatestEvents.vue";
import Cta from "@/Components/sections-new/Cta.vue";
import TitleNSub from "@/Components/sections-new/TitleNSub.vue";
import Hero from "@/Components/sections-new/Hero.vue";
import Poptext from "@/Components/sections-new/Poptext.vue";

import bangPow from "~images/bangpow.jpg";
import greatMilenko from "~images/greatmilenko.jpg";
import hellsPit from "~images/hellspit.jpg";
import jeckelBros from "~images/Jeckelbros.jpg";
import teamOne from "~images/team-1.jpg";
import eventsBg from "~images/events-bg-1.jpg";
import {ref} from "vue";
import SliderGallery from "../Components/sections-new/SliderGallery.vue";

const team = [
    {
        id: 1,
        teamImg: teamOne,
        teamLink: "/chad",
        teamLinkFb: "/fb",
        teamLinkTw: "/tw",
        teamLinkIns: "/ins",
        teamName: "Chad",
        teamProps: "HNIC",
    },
    {
        id: 2,
        teamImg: teamOne,
        teamLink: "/chad",
        teamLinkFb: "/fb",
        teamLinkTw: "/tw",
        teamLinkIns: "/ins",
        teamName: "Chad",
        teamProps: "HNIC",
    },
    {
        id: 3,
        teamImg: teamOne,
        teamLink: "/chad",
        teamLinkFb: "/fb",
        teamLinkTw: "/tw",
        teamLinkIns: "/ins",
        teamName: "Chad",
        teamProps: "HNIC",
    },
    {
        id: 4,
        teamImg: teamOne,
        teamLink: "/chad",
        teamLinkFb: "/fb",
        teamLinkTw: "/tw",
        teamLinkIns: "/ins",
        teamName: "Chadk",
        teamProps: "HNIC",
    },
    {
        id: 5,
        teamImg: teamOne,
        teamLink: "/chad",
        teamLinkFb: "/fb",
        teamLinkTw: "/tw",
        teamLinkIns: "/ins",
        teamName: "Chad",
        teamProps: "HNIC",
    },
];

const latest = [
    {
        id: 1,
        src: bangPow,
        link: [
            {
                href: "/icp",
                title: "Bang Pow Boom at Jugaloo Island",
            },
        ],
        category: [
            {
                href: "/bpb",
                title: "BangPow",
            },
        ],
        date: "January 22, 2025",
    },
    {
        id: 2,
        src: greatMilenko,
        link: [{href: "/icp", title: "Great MILENKO GREAT MILENKO"}],
        date: "January 22, 2025",
        category: [
            {
                href: "/bpb",
                title: "greatmilenko",
            },
        ],
    },
    {
        id: 3,
        src: hellsPit,
        link: [{href: "/icp", title: "hellspit"}],
        date: "January 22, 2025",
        category: [
            {
                href: "/bpb",
                title: "Hellspit",
            },
        ],
    },
    {
        id: 4,
        src: jeckelBros,
        link: [{href: "/icp", title: "Jeckelbross"}],
        date: "January 22, 2025",
        category: [
            {
                href: "/bpb",
                title: "Jeckelbros",
            },
        ],
    },
];

const events = [
    {
        id: 1,
        src: eventsBg,
        mainLink: [
            {
                href: "/icp",
                title: "Bang pow boom at jugaloo island",
                location: "Jugaloo Island",
            },
        ],
        date: "22.02.2025",
    },
    {
        id: 2,
        src: eventsBg,
        mainLink: [
            {
                href: "/icp",
                title: "Proponent for sentience",
                location: "Alleagon",
            },
        ],
        date: "22.02.2025",
    },
];
const text = ref("Freedom Festival");
</script>

<template>
    <Hero>
        <template #title>
            <Poptext
                class="d-flex flex-column justify-content-center align-items-center poptext-white"
                :text="text"
            />
        </template>
    </Hero>
    <Cta/>
    <section class="pt-110px pb-100px">
        <div
            class="container container-big flex-lg-row align-items-start align-items-lg-center justify-content-between"
        >
            <TitleNSub title="Title" subtitle="subtitle" class="mb-35px"/>
            <a href="/" class="btn btn-md">View all</a>
            <LatestEvents :latest="latest"></LatestEvents>
        </div>
    </section>
    <CategoriesImg class="pt-70px pt-lg-120px pb-60px pb-lg-90px"/>
    <section class="pb-75px">
        <div class="container flex-column align-items-center">
            <p class="sub-title sub-title-lprpl mb-20px">FUTURE EVENTS</p>
            <h3 class="title-1 mb-20px">Festivals This December</h3>
            <Events v-for="event in events" v-bind="event" :key="event.id"/>
        </div>
    </section>
    <Services/>
    <Team :team="team">
        <template #subtitle>Meet Our Team</template>
        <template #title>Our Professionals</template>
    </Team>
    <section class="pt-100px pb-100px">
        <div class="container">
            <SliderGallery :events="events"/>
        </div>
    </section>
</template>
