<template>
    <div class="tabs" v-bind="$attrs">
        <div class="tabs__header">
            <a
                class="tabs__btn"
                v-for="(tab, index) in tabs"
                :key="index"
                @click="setActiveTab(index)"
                :class="{ active: activeTabIndex === index }"
            >
                {{ tab.title }}
            </a>
        </div>
        <div class="tabs__content">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { ref, provide } from "vue";

const tabs = ref([]);
const activeTabIndex = ref(0);

const setActiveTab = (index) => {
    activeTabIndex.value = index;
};

provide("tabsContext", {
    tabs,
    activeTabIndex,
    registerTab: (title) => {
        const index = tabs.value.length;
        tabs.value.push({ title });
        return index;
    },
});
</script>

<style lang="scss">
.tabs {
    display: flex;
    flex-direction: column;
    &__header {
        display: flex;
        flex-direction: row;
        gap: 20px;
        overflow-x: scroll;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    &__btn {
        display: block;
        padding: 12px;
        color: var(--text);
        white-space: nowrap;
        text-decoration: none;

        &.active {
            border-bottom: 2px solid var(--text);
        }
    }
    &__content {
        padding: 31px 12px 16px;
        @include media-breakpoint-up(lg) {
            padding: 62px 24px 32px;
        }
        position: relative;
        box-shadow: rgba(18, 18, 18, 0.15) 0px 1px 4px 0px;
        background-color: white;
    }
    &-white {
        .tabs__btn {
            color: white;
        }
    }
}
</style>
