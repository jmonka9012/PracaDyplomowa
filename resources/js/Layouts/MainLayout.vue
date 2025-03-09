<script setup>
import MainFooter from "../Components/sections-new/MainFooter.vue";
import MainHeader from "../Components/header/MainHeader.vue";
</script>

<template>
    <div>
        <MainHeader />
        <slot />
        <MainFooter />
    </div>
</template>
