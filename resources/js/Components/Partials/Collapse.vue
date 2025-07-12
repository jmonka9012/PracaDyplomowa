<script setup>
import { ref } from 'vue';

const isOpen = ref(false);
const emit = defineEmits(['toggle']);

const toggle = () => {
    isOpen.value = !isOpen.value;
    emit('toggle', isOpen.value)
};

const enter = (element) => {
    element.style.height = '0';
    requestAnimationFrame(() => {
        element.style.height = `${element.scrollHeight}px`;
    });
};

const afterEnter = (element) => {
    element.style.height = null;
};

const beforeLeave = (element) => {
    element.style.height = `${element.scrollHeight}px`;
    requestAnimationFrame(() => {
        element.style.height = '0';
    });
};
</script>

<template>
    <div>
        <div @click="toggle">
            <slot name="trigger" :is-open="isOpen" />
        </div>
        <transition
            @enter="enter"
            @after-enter="afterEnter"
            @before-leave="beforeLeave">
            <div
                v-show="isOpen"
                class="collapsible-content"
                :aria-expanded="isOpen">
                <slot />
            </div>
        </transition>
    </div>
</template>

<style scoped lang="scss">
.collapsible-content {
    overflow: hidden;
    transition: height 0.3s ease-out;
}
</style>
