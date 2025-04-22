<script setup>
import Multiselect from "vue-multiselect";
import { ref } from "vue";

// import "vue-multiselect/dist/vue-multiselect.min.css";

const value = ref([]);
const options = ref([
    { name: "Vue.js", language: "JavaScript" },
    { name: "Adonis", language: "JavaScript" },
    { name: "Rails", language: "Ruby" },
    { name: "Sinatra", language: "Ruby" },
    { name: "Laravel", language: "PHP" },
    { name: "Phoenix", language: "Elixir" },
]);
</script>

<template>
    <div>
        <label class="typo__label">Simple select / dropdown</label>
        <Multiselect
            id="multiselect"
            v-model="value"
            :options="options"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
            :preserve-search="true"
            placeholder="Pick some"
            label="name"
            track-by="name"
            :preselect-first="true"
        >
            <template #selection="{ values, search, isOpen }">
                <span
                    class="multiselect__single"
                    v-if="values.length"
                    v-show="!isOpen"
                    >{{ values.length }} options selected</span
                >
            </template>
        </Multiselect>
        <div>
            <pre class="language-json"><code>{{ value }}</code></pre>
        </div>
    </div>
</template>

<style lang="scss">
.multiselect__option--selected.multiselect__option--highlight::after {

}
</style>
