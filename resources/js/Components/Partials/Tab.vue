<template>
    <div class="tabs__inner" v-show="isActive">
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
    routeName: {
        type: String,
        required: false,
    }
});

const { activeTabIndex, registerTab } = inject("tabsContext");
const index = registerTab(props.title, props.routeName);

const isActive = computed(() => activeTabIndex.value === index);
</script>
