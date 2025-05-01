<script setup>
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";
import Hero from "@/Components/Sections/AboutUsHero.vue";
import blogBg from "~images/blog-bg.jpg";

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

    <Hero></Hero>
    <section class="section-full mb-100px">
        <div class="container container-full">
            <div class="col-12 col-lg-6 pl-10px pr-10px pl-lg-0 pr-lg-0">
                <img class="h-100 of-cover" :src="blogBg" alt="" />
            </div>
            <div
                class="col-12 col-lg-6 pt-30px pb-30px pt-lg-100px pb-lg-100px pl-10px pr-10px pl-md-30px pr-md-30px pl-lg-100px pr-lg-100px"
            >
                <h1 class="mb-15px">Lorem ispum</h1>
                <p class="mb-30px">
                    <b>Lorem ipsum dolo</b>r sit, amet consectetur adipisicing
                    elit. Dolorum, itaque. Recusandae cum quaerat explicabo.
                    Dignissimos quibusdam itaque excepturi quod corporis.
                </p>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Dolor eveniet ab eum repellat distinctio veritatis
                    voluptatum enim consectetur explicabo tempore!
                </p>
            </div>
        </div>
    </section>
    <section id="halls" class="overflow-hidden">
        <div class="container container-mid">
            <div class="col-lg-12">
                <Tabs>
                    <Tab
                        class="flex-column hall"
                        v-for="hall in halls"
                        :key="hall.id"
                        :title="hall.hall_name"
                    >
                        <div>
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <div class="legend legend-stand"></div>
                                    <p>Sekcje z miejscami stojącymi</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="legend legend-seat"></div>
                                    <p>Sekcje z miejscami siedzącymi</p>
                                </div>
                            </div>
                            <div class="scene">scena</div>
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
                                                section.section_height ===
                                                    hrowIndex + 1 &&
                                                section.section_width ===
                                                    hcolIndex + 1
                                        )"
                                        :key="section.id"
                                    >
                                        <div
                                            class="hall__section-seat"
                                            v-if="
                                                section.section_type === 'seat'
                                            "
                                        >
                                            <div class="hall__seat-cont">
                                                <div
                                                    class="hall__section-row"
                                                    v-for="(
                                                        row, rowIndex
                                                    ) in section.row"
                                                    :key="rowIndex"
                                                >
                                                    <div
                                                        class="hall__seat"
                                                        v-for="(
                                                            col, colIndex
                                                        ) in section.col"
                                                        :key="colIndex"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="hall__section-stand">
                                            <div class="hall__seat-cont"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Tab>
                </Tabs>
            </div>
        </div>
    </section>
    <section class="">
        <div class="container justify-content-center">
            <h1 class="mb-30px">Lorem Ipsum dolor sit amet</h1>
            <p class="mb-50px">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil
                officiis repudiandae totam? Sunt, ratione nam! Sed maxime et
                quos odit repellendus consectetur ex nulla! Consequuntur magni a
                possimus omnis laborum, deleniti incidunt, itaque voluptatem
                odio est quia. Asperiores, facere exercitationem. Velit hic
                placeat error quibusdam beatae consequatur doloribus enim
                nesciunt. Lorem ipsum dolor sit amet, consectetur adipisicing
                elit. Nihil officiis repudiandae totam? Sunt, ratione nam! Sed
                maxime et quos odit repellendus consectetur ex nulla!
                Consequuntur magni a possimus omnis laborum, deleniti incidunt,
                itaque voluptatem odio est quia. Asperiores, facere
                exercitationem. Velit hic placeat error quibusdam beatae
                consequatur doloribus enim nesciunt.
            </p>
        </div>
    </section>

</template>

<style lang="scss">
@use "~css/hale.scss";
</style>
