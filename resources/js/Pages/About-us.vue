<script setup>
import useAuth from '@/Utilities/useAuth'

import {computed} from "vue";

const {user, isLoggedIn} = useAuth()

const props = defineProps({
    halls: {
        type: Array,
        required: true
    }
})


</script>

<template>

    <section>
        <div class="container container-mid">Test</div>
    </section>

</template>

<style>

.hall {
    width: 100%;
    margin-bottom: 100px;
    background-color: yellowgreen;
}

.hall__row {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    justify-content: space-between;
    min-height: 100px;

}

.hall_col {
    width: 100%;
    background-color: yellow;

}

.hall__section-row {
    display: flex;
    flex-direction: row;
    gap: 4px;
    justify-content: space-between;
}

.hall__seat {
    width: 100%;
    height: 10px;
    min-width: 1px;
    background-color: red;
}

.hall__seat:hover {
    background-color: green;
    cursor: pointer;
}

.hall__section-seat {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 40px;
    min-height: 100px;
}

.hall__section-stand {
    width: 100%;
    height: 200px;
    background: red;
}

.hall__section-stand:hover {
    cursor: pointer;
    background-color: green;
}

</style>
