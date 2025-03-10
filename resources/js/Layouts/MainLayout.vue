<script setup>
import MainFooter from "../Components/sections-new/MainFooter.vue";
import MainHeader from "../Components/header/MainHeader.vue";

const props = defineProps({
    auth: Object,
});

console.log(props.auth.user);

</script>

<template>
    <div>
        <MainHeader />
        <slot />
        <MainFooter />
    </div>
</template>
