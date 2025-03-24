<template>
    <div v-show="isActive">
        <slot />
    </div>
</template>

<script setup>
import { inject, computed } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
});

const { activeTabIndex, registerTab } = inject("tabsContext");
const index = registerTab(props.title);

const isActive = computed(() => activeTabIndex.value === index);
</script>
