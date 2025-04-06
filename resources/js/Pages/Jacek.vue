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
                    class="hall__col"
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
@use "~css/hale.scss";
</style>
