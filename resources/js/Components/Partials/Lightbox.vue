<script setup>
import { ref } from "vue";
import VueEasyLightbox from "vue-easy-lightbox";

defineProps({
    imgSrc: {
        type: String,
        required: true,
    },
    thumbSrc: {
        type: String,
        default: "",
    },
});

const visible = ref(false);
</script>
<template>
    <div>
        <img
            :src="thumbSrc || imgSrc"
            alt="Preview"
            class="cursor-pointer w-auto h-auto max-w-[200px]"
            @click="visible = true"
        />

        <vue-easy-lightbox
            :visible="visible"
            :imgs="[imgSrc]"
            @hide="visible = false"
        />
    </div>
</template>

<style scoped lang="scss"></style>
