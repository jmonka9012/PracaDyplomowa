<script setup>
import { RouterLink, RouterView } from "vue-router";

import MainFooter from "./Components/sections-new/MainFooter.vue";
import MainHeader from "./Components/header/MainHeader.vue";
import "@fortawesome/fontawesome-free/css/all.css";
</script>

<template>
    <MainHeader />
    <RouterView />
    <footer>
        <MainFooter />
    </footer>
</template>
