<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const dropdownHolder = ref(null);
const dropdownContent = ref(null);

const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        dropdownHolder.value.classList.add("open");
    } else {
        dropdownHolder.value.classList.remove("open");
    }
};

const handleClickOutside = (event) => {
    if (
        isOpen.value &&
        dropdownHolder.value &&
        !dropdownHolder.value.contains(event.target)
    ) {
        isOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener("mousedown", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("mousedown", handleClickOutside);
});

const props = defineProps({
    title: {
        type: String,
    },
    subtitle: {
        type: String,
    },
    iconSource: {
        type: String,
    },
});
onMounted(() => {
    const dropDowns = document.querySelectorAll(".dropdown__item-toggle");

    dropDowns.forEach(function (dropdown) {
        dropdown.addEventListener("click", function (e) {
            const submenu = this.querySelector(".dropdown__ndlevel");
            if (!submenu) return;
            const subReturn = e.target.closest(".ndlevel-back");
            if (subReturn) {
                submenu.classList.remove("show");
                e.stopPropagation();
                e.preventDefault();
            } else if (!e.target.closest(".dropdown__ndlevel")) {
                submenu.classList.toggle("show");
                e.stopPropagation();
                e.preventDefault();
            }
        });
        const submenu = dropdown.querySelector(".dropdown__ndlevel");
        if (submenu) {
            submenu.addEventListener("click", function (e) {
                if (!e.target.closest(".ndlevel-back")) {
                    e.stopPropagation();
                }
            });
        }
    });
    document.addEventListener("click", handleClickOutside);
});
onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>
<template>
    <div
        ref="dropdownHolder"
        class="dropdown"
        v-bind="$attrs"
        :class="{ open: isOpen }"
    >
        <i class="fa fa-map-marker"></i>
        <div
            class="d-flex align-items-center col-12 h-100"
            @click="toggleDropdown"
        >
            <div class="d-flex flex-column col-11">
                <span class="select-label">{{ title }}</span>
                <span class="select-subtext"> {{ subtitle }}</span>
            </div>
            <i class="fa fa-chevron-down ml-auto"></i>
        </div>
        <div
            ref="dropdownContent"
            class="dropdown__content"
            :class="{ open: isOpen }"
        >
            <slot></slot>
        </div>
    </div>
</template>

<style lang="scss">
@use "~css/mixin.scss";

.dropdown {
    box-shadow: none;
    min-height: 60px;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 8px;
    appearance: none;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    min-width: 330px;
    padding-left: 60px;
    font-family: "Krona One";
    display: flex;
    align-items: center;
    justify-content: flex-start;
    position: relative;
    max-height: 60px;
    @include mixin.media-breakpoint-down(lg) {
        width: 100%;
    }
    &.open {
        border: 1px solid var(--primary);
        outline: 1px solid var(--primary);
        .dropdown__content {
            border: 0;
        }
    }

    &-form.open {
        outline: none;
        border: 1px solid #ced4da;
    }
    i {
        &.fa-map-marker {
            font-size: 24px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 20px;
        }
        &.fa-chevron-down {
            font-size: 16px;
            transition: all 0.25s ease;
        }
    }
    .select-label {
        transition: all 0.25s ease;
    }
    .select-subtext {
        color: var(--n-gray);
        height: 0;
        line-height: 0;
        pointer-events: none;
        font-size: 0;
        transition: all 0.25s ease;
    }
    &.open {
        .select-label {
            position: absolute;
            top: 0;
            left: 60px;
            font-size: 12px;
        }
        .select-subtext {
            height: 1em;
            line-height: 1;
            font-size: 12px;
        }
        .fa-chevron-down {
            transform: rotateZ(180deg);
        }
    }
    .dropdown__inner {
        height: 300px;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
        overflow-y: auto;
        column-gap: 10px;
        font-family: "Prompt";
        padding: 16px;
        position: relative;
        border-radius: 8px;
    }
    .dropdown__item {
        height: 2rem;
        padding-inline: 12px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        font-weight: 500;
        width: 100%;
        position: static;
        &:hover {
            background-color: #19102814;
        }
        a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            width: 100%;
            i {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                right: 12px;
            }
        }
    }
    .dropdown__ndlevel {
        position: absolute;
        top: 0;
        transition: var(--trans-def);
        left: 100%;
        visibility: hidden;
        opacity: 0;
        padding: 16px;
        background: #fff;
        border-radius: 8px;
        z-index: 1;
        height: 100%;
        &.show {
            display: flex;
            flex-direction: column;
            gap: 8px;
            left: 0;
            right: 0;
            visibility: visible;
            opacity: 1;
        }
        .divider {
            height: 1px;
            width: 100%;
            background-color: var(--n-gray);
        }
        .ndlevel-back {
            position: sticky;
            top: -16px;
            background-color: white;
            z-index: 1;
            padding-left: 45px;
            &:hover {
                background-color: #19102814;
            }
            a {
                position: relative;
            }
            i {
                right: auto;
                left: -30px;
            }
        }
    }

    .dropdown__content {
        display: none;
        flex-direction: column;
        position: absolute;
        left: 0;
        right: 0;
        border: 1px solid var(--n-gray);
        top: calc(100% + 2px);
        border-radius: 8px;
        background-color: white;
        z-index: 100;
        &.open {
            display: flex;
        }
    }
}
</style>
