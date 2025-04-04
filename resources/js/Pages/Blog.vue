<script setup>
import HeroSmall from "../Components/sections-new/Hero-small.vue";
import LatestEvents from "../Components/sections-new/LatestEvents.vue";
import TitleNSub from "../Components/sections-new/TitleNSub.vue";

import bangpow from "~images/bangpow.jpg";
import greatmilenko from "~images/greatmilenko.jpg";
import hellspit from "~images/hellspit.jpg";
import jeckelbros from "~images/Jeckelbros.jpg";
import blogBg from "~images/blog-bg.jpg";

const latest = [
    {
        id: 1,
        src: bangpow,
        link: [
            {
                href: "/icp",
                title: "zmień wielkość kontenera później",
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
        src: greatmilenko,
        link: [{ href: "/icp", title: "Great MILENKO GREAT MILENKO" }],
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
        src: hellspit,
        link: [{ href: "/icp", title: "Event" }],
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
        src: jeckelbros,
        link: [{ href: "/icp", title: "Jeckelbross" }],
        date: "January 22, 2025",
        category: [
            {
                href: "/bpb",
                title: "Jeckelbros",
            },
        ],
    },
];
</script>

<template>
    <HeroSmall :source="blogBg" title="Blog"></HeroSmall>
    <section class="section pb-120px">
        <div class="container container-small">
            <LatestEvents evContClass="ev-cont-lg-three" :latest="latest">
            </LatestEvents>
        </div>
    </section>
</template>
