<script setup>
import Multiselect from "vue-multiselect";
import { ref } from "vue";

import "vue-multiselect/dist/vue-multiselect.min.css";

const value = ref([]);

const addTag = (newTag) => {
    const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
    };
    options.value.push(tag);
    value.value.push(tag);
};

const translations = ref({
    selectLabel: "Naciśnij Enter, aby wybrać",
    deselectLabel: "Naciśnij Enter, aby usunąć",
    selectedLabel: "Wybrano",
});
</script>

<template>
    <Multiselect
        id="tagging"
        v-model="value"
        label="name"
        track-by="name"
        :multiple="true"
        :taggable="true"
        @tag="addTag"
        :close-on-select="false"
        selectLabel="Naciśnij Enter, aby wybrać"
        deselectLabel="Naciśnij Enter, aby usunąć"
        selectedLabel="Wybrano"
    />
</template>

<style lang="scss">
.multiselect__option--selected.multiselect__option--highlight::after {
}
.multiselect__tags {
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
    font-family: "Krona One";
    display: flex;
    align-items: center;
    justify-content: flex-start;
    position: relative;
    max-height: 60px;
    box-shadow: none;
    min-height: 60px;
}
.multiselect__select {
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    justify-content: center;
    align-items: center;
    &::before {
        --fa: "";
        content: var(--fa);
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        margin-top: 0;
        border-width: 0;
        color: var(--text);
        transition: var(--trans-def);
    }
}
.multiselect--active .multiselect__select {
    transform: translateY(-50%) rotateZ(0deg);
    &::before {
        transform: rotateZ(180deg);
    }
}
.multiselect--active {
    .multiselect__input {
        font-size: 0;
    }
}
.multiselect__placeholder {
    margin-bottom: 0;
    color: var(--text);
}
.multiselect__input {
    margin: 0;
    padding: 0;
}
.multiselect__input::placeholder {
    color: var(--text);
}
.multiselect__tags-wrap {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    column-gap: 10px;
}
.multiselect__tag {
    background: var(--primary);
}
.multiselect__tag-icon::after {
    color: white;
}
.multiselect__tag-icon:focus::after,
.multiselect__tag-icon:hover::after {
    color: var(--text);
}
.multiselect__option {
    padding: 6px 35px;
    display: flex;
    align-items: center;
}
.multiselect__option--highlight {
    background: var(--primary);
    &::after {
        background: var(--primary);
    }
}
.multiselect__option--selected {
    font-weight: 500;
}
.multiselect__option--selected.multiselect__option--highlight {
}
.multiselect__option--selected.multiselect__option--highlight::after {
}
</style>
