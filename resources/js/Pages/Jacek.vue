<script setup>
import useAuth from "@/Utilities/useAuth";

import { computed } from "vue";

const { user, isLoggedIn } = useAuth();

const props = defineProps({
    halls: {
        type: Array,
        required: true,
    },
});

</script>

<template>
    <section>
        <div class="container" v-if="user">
            <h1>Twój poziom uprawnień: {{ user.permission_level }}</h1>
            <h1>Nazwa: {{ user.name }}</h1>
        </div>
        <div class="container">
            <div v-for="hall in halls" :key="hall.id">
                <h3>{{ hall.hall_name }}</h3>
                <h1>{{ hall.seat_capacity }}</h1>
                <h1>{{ hall.stand_capacity }}</h1>
                <h1>{{ hall.hall_price }}</h1>
                <h1>{{ hall.id }}</h1>
                <div v-for="section in hall.sections" :key="section.id">
                    <p>{{ section.section_name }}</p>
                    <p>{{ section.section_type }}</p>
                    <p>{{ section.col }}</p>
                    <p>{{ section.row }}</p>
                </div>
            </div>
        </div>
        <div
            class="flex-column mb-130px hall"
            v-for="hall in halls"
            :key="hall.id"
        >
            <div
                class="hall__row"
                v-for="(row, hrowIndex) in hall.hall_height"
                :key="hrowIndex"
            >
                <div
                    class="hall_col"
                    v-for="(col, hcolIndex) in hall.hall_width"
                    :key="hcolIndex"
                >
                    <div
                        class="petla"
                        v-for="section in hall.sections.filter(
                            (section) =>
                                section.section_height === hrowIndex + 1 &&
                                section.section_width === hcolIndex + 1
                        )"
                        :key="section.id"
                    >
                        <div
                            class="hall__section-seat"
                            v-if="section.section_type === 'seat'"
                        >
                            <div
                                class="hall__section-row"
                                v-for="(row, rowIndex) in section.row"
                                :key="rowIndex"
                            >
                                <div
                                    class="hall__seat"
                                    v-for="(col, colIndex) in section.col"
                                    :key="colIndex"
                                ></div>
                            </div>
                        </div>
                        <div v-else class="hall__section-stand"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style lang="scss">
.hall {
    width: 100%;
    margin-bottom: 100px;
    background-color: yellowgreen;

    &__row {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        justify-content: space-between;
        min-height: 100px;
    }

    &_col {
        width: 100%;
        background-color: yellow;
    }

    &__section-row {
        display: flex;
        flex-direction: row;
        gap: 4px;
        justify-content: space-between;
    }

    &__seat {
        width: 100%;
        height: 10px;
        min-width: 1px;
        background-color: red;

        &:hover {
            background-color: green;
            cursor: pointer;
        }
    }

    &__section-seat {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 40px;
        min-height: 100px;
    }

    &__section-stand {
        width: 100%;
        height: 200px;
        background: red;

        &:hover {
            cursor: pointer;
            background-color: green;
        }
    }
}
</style>
