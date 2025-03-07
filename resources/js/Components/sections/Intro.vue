<script setup>
defineProps({
heading:String,
subheading:String,
});
</script>
<template>
    <h3 class="text-black" v-bind="$attrs">{{heading}}</h3>
    <p class="sub-title orange-underline">{{subheading}}</p>
</template>
<style scoped>
</style>