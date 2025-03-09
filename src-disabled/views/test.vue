<script setup>
import Cards from "@/components/sections/Cards2.vue"
import CategoryCards from "@/components/sections/CategoryCards.vue"
import Hero from "@/components/sections/Hero.vue"
import EventSlider from "@/components/sections/EventSlider.vue"
import Intro from "@/components/sections/Intro.vue"
import LocationsSlider from "@/components/sections/LocationsSlider.vue"
const category = [
  {
    name: "Events",
    source: "/dist/assets/images/feature_1.png",
    count: 1,
    link: "/test",
  },
  {
    name: "Concerts",
    source: "/dist/assets/images/feature_2.png",
    count: 2,
    link: "/test",
  },
  {
    name: "Fun",
    source: "/dist/assets/images/feature_3.png",
    count: 3,
    link: "/test",
  },
  {
    name: "Events",
    source: "/dist/assets/images/feature_1.png",
    count: 1,
    link: "/test",
  },
  {
    name: "Concerts",
    source: "/dist/assets/images/feature_2.png",
    count: 0,
    link: "/test",
  },
  {
    name: "Fun",
    source: "/dist/assets/images/feature_3.png",
    count: 5,
    link: "/test",
  },
]
const linkData = {
  title: "My Link Title",
  date: "2025-02-15",
  href: "https://example.com",
}
const upcoming = [
  {
    bg: '/dist/assets/images/event-bg-1.jpg',
    source: '/test',
    heading: 'The Food Mood Reboot in the New Century',
    date: 'September 24, 2025',
    category: 'Concert',
    category_link: '/test',
    price: 10,
    location: [
      { name: 'Arvada', href: 'https://example.com/arvada' },
      { name: 'Colorado', href: 'https://example.com/colorado' }
    ]
  },
  {
    bg: '/dist/assets/images/event-bg-2.jpg',
    source: '/test',
    heading: 'Rock Festival 2025',
    date: 'October 12, 2025',
    category: 'Music',
    category_link: '/test',
    price: 20,
    location: [
      { name: 'New York', href: 'https://example.com/ny' },
      { name: 'Los Angeles', href: 'https://example.com/la' }
    ]
  },
  {
    bg: '/dist/assets/images/event-bg-3.jpg',
    source: '/test2',
    heading: 'Cum and Doom Festival',
    date: 'October 12, 2025',
    category: 'orgy',
    category_link: '/test',
    price: 20,
    location: [
      { name: 'New York', href: 'https://example.com/ny' },
      { name: 'Los Angeles', href: 'https://example.com/la' }
    ]
  }
]
const locations = [
  {
    id: 1,
    bg: '/dist/assets/images/event-bg-3.jpg',
    link: '/test',
    Ecount: 5,
    location: [
      { name: 'Washington', href: '/test' }
    ]
  },
  {
    id: 2,
    bg: '/dist/assets/images/event-bg-3.jpg',
    link: '/test',
    Ecount: 5,
    location: [
      { name: 'Juggalo island', href: '/test' }
    ]
  },
  {
    id: 1,
    bg: '/dist/assets/images/event-bg-3.jpg',
    link: '/test',
    Ecount: 5,
    location: [
      { name: 'Washington', href: '/test' }
    ]
  },
  {
    id: 1,
    bg: '/dist/assets/images/event-bg-3.jpg',
    link: '/test',
    Ecount: 5,
    location: [
      { name: 'Washington', href: '/test' }
    ]
  },
  {
    id: 1,
    bg: '/dist/assets/images/event-bg-3.jpg',
    link: '/test',
    Ecount: 5,
    location: [
      { name: 'Washington', href: '/test' }
    ]
  },
]
</script>

<template>
  <Hero heading="Connecting the world" desc="Easy to search, you just enter the keyword"
    source="/dist/assets/images/bg_home1.jpg" :link="{
      text: 'Auto racing xd',
      date: '2025-02-15',
      href: '/test'
    }" />
  <div class="section pt-30px pt-lg-90px pb-30px pb-lg-90px">
    <div class="container cat-holder">
      <CategoryCards v-for="cat in category" :key="cat.name" :heading="cat.name" :link="cat.link" :source="cat.source"
        :Ecount="cat.count" :class="'col-12 col-md-4 col-lg-2'" />
    </div>
  </div>
  <div class="section pt-80px pb-85px bg-lpurple">
    <div class="container">
      <div class="d-flex flex-column col-12 mb-30px mb-lg-45px">
        <Intro heading="Upcoming Events" subheading="You can choose to display featured" class="title2" />
      </div>
      <div class="grid-thr-tw-o column-gap-45px row-gap-45px">
        <EventSlider v-for="event in upcoming" v-bind="event" />
      </div>
    </div>
  </div>
  <div class="section pt-80px pb-80px">
    <div class="container">
      <div class="d-flex flex-column col-12 mb-30px mb-lg-45px">
        <Intro heading="How id work" subheading="You can choose to display featured" class="title" />
      </div>
      <Cards :class="'col-12 col-lg-4'" source="/dist/assets/images/feature_1.png" heading="Choose What To Do
" desc="Easily find your event via search system with multiple params." />
      <Cards :class="'col-12 col-lg-4'" source="/dist/assets/images/feature_2.png" heading="Booking event that you like"
        desc="Choose Ticket add to cart. Support payment via Woocommerce system." />
      <Cards :class="'col-12 col-lg-4'" source="/dist/assets/images/feature_3.png" heading="Get the ticket to attend"
        desc="After booking successfully, You will get ticket in email or download in your account" />
    </div>
  </div>
  <div class="section pt-80px pb-80px bg-lpurple">
    <div class="container d-flex flex-lg-row">
      <div class="d-flex flex-column col-12 mb-30px mb-lg-45px">
        <Intro heading="Most Visited Places" subheading="You can choose to display featured" class="title2" />
      </div>
      <div class="col-12 grid-fi-tw-o column-gap-30px row-gap-30px">
        <LocationsSlider v-for="locs in locations" v-bind="locs" :key="locs.id" />
      </div>

    </div>
  </div>
</template>

<style>
.test {
  color: red;
}
</style>
