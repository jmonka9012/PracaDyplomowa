<script setup>
import Tab from "@/Components/sections-new/Tab.vue";
import Tabs from "@/Components/sections-new/Tabs.vue";

import useAuth from '@/Utilities/useAuth'

const {user, isLoggedIn} = useAuth()

const props = defineProps({
    halls: {
        type: Array,
        required: true,
    },
});

</script>

<template>

    <section>
        <div class="container container-mid">
            <div class="col-lg-12">
                <Tabs>
                    <Tab
                        class="flex-column mb-130px hall"
                        v-for="hall in halls"
                        :key="hall.id"
                        :title="hall.hall_name"
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
                    </Tab>
                </Tabs>
            </div>
        </div>
    </section>

</template>

<style lang="scss">
    @use "~css/hale.scss";
</style>
