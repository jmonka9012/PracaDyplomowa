<template>
    <div class="tabs" v-bind="$attrs">
        <div class="tabs__header">
            <a class="tabs__btn"
                v-for="(tab, idx) in tabs"
                :key="idx"
                @click="setActiveTab(Number(idx))"
                :class="{ active: activeTabIndex === Number(idx) }">
                {{ tab.title }}
            </a>
        </div>
        <div class="tabs__content">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { ref, provide, onMounted } from 'vue';

const tabs = ref({});
const activeTabIndex = ref(0);
//const emit = defineEmits(["update-props"]);

const setActiveTab = (idx) => {
    const index = Number(idx);
    activeTabIndex.value = index;
    //emit("update-props", tabs.value[index]);

    params.set('tabName', tabs.value[index].title);
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, '', newUrl);
};

provide('tabsContext', {
    tabs,
    activeTabIndex,
    registerTab: (title, routeName) => {
        const idx = Object.keys(tabs.value).length;
        tabs.value[idx] = { title, routeName };
        return idx;
    },
});

let params = null;

onMounted(() => {
    params = new URLSearchParams(window.location.search);
    const initialTab = params.get('tabName');
    if (initialTab) {
        Object.keys(tabs.value).forEach((key) => {
            if (tabs.value[key].title === initialTab) {
                activeTabIndex.value = Number(key);
            }
        });
    }
});
</script>

<style lang="scss">
@use '~css/mixin.scss';

.tabs {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__header {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    &__btn {
        padding: 12px;
        white-space: nowrap;
        text-decoration: none;
        color: var(--text);
        user-select: none;
        &.active {
            border-bottom: 2px solid var(--text);
        }
    }

    &__content {
        padding: 31px 12px 16px;
        background: #fff;
        box-shadow: rgba(18, 18, 18, 0.15) 0px 1px 4px;
        position: relative;

        @include mixin.media-breakpoint-up(lg) {
            padding: 62px 24px 32px;
        }
    }

    &-white {
        .tabs__btn {
            color: #fff;
        }
    }
}
</style>
