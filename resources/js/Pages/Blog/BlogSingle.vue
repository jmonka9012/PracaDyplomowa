<script setup>
import PostQuery from "../../Components/Sections/PostQuery.vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";

import blogBg from "~images/blog-bg.jpg";

</script>

<template>

    <HeroSmall :source="blogBg" title="Tytuł wpisu"></HeroSmall>
    <section>
        <div class="container">
            <div class="col-12 d-flex flex-lg-row row-gap-30px">
                <div class="col-12 col-lg-4">
                    <div
                        class="d-flex flex-row flex-wrap-wrap justify-content-center align-items-center bg-primary pt-12px pb-12px pl-6px pr-6px column-gap-5px border-radius-12px text-white"
                    >
                        <!-- Tutaj potrzebny będzie loop żeby tworzyć kategorie -->
                        <a class="hover-text" href="/kategoria/Bez-kategorii"
                        >Bez kategorii,
                        </a>
                        <a class="hover-text" href="/kategoria/Bez-kategorii"
                        >Lorem Ipsum,
                        </a>
                        <a class="hover-text" href="/kategoria/Bez-kategorii"
                        >Lorem Ipsum Dolor</a
                        >
                    </div>
                </div>
                <div
                    class="col-12 col-lg-4 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-calendar mr-5px"></i>
                    <span>2025-01-01</span>
                </div>
                <div
                    class="col-12 col-lg-4 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-user mr-5px"></i>
                    The Ringmaster
                </div>
            </div>

            <div
                class="col-12 d-flex flex-column align-items-center justify-content-center mt-lg-80px mt-50px"
            >
                <h1 class="mb-30px">Lorem ipsum</h1>
                <p class="mb-30px">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Sequi cumque incidunt earum architecto dolor sit accusamus,
                    magnam optio eius repellat labore molestias recusandae vitae
                    delectus itaque. Facilis, et quis labore sint eligendi fuga
                    unde quam quaerat dolorem voluptatum, alias rerum itaque.
                    Nihil accusantium placeat consectetur numquam pariatur?
                    Maxime, laborum doloribus? Lorem ipsum dolor sit, amet
                    consectetur adipisicing elit. Sequi cumque incidunt earum
                    architecto dolor sit accusamus, magnam optio eius repellat
                    labore molestias recusandae vitae delectus itaque. Facilis,
                    et quis labore sint eligendi fuga unde quam quaerat dolorem
                    voluptatum, alias rerum itaque. Nihil accusantium placeat
                    consectetur numquam pariatur? Maxime, laborum doloribus?
                </p>
                <h3 class="mb-30px">Lorem Ipsum</h3>
                <img
                    class="blog-image blog-image-square mb-30px mb-lg-50px"
                    :src="greatMilenko"
                    alt=""
                />
                <p class="mb-30px">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Sequi cumque incidunt earum architecto dolor sit accusamus,
                    magnam optio eius repellat labore molestias recusandae vitae
                    delectus itaque. Facilis, et quis labore sint eligendi fuga
                    unde quam quaerat dolorem voluptatum, alias rerum itaque.
                    Nihil accusantium placeat consectetur numquam pariatur?
                    Maxime, laborum doloribus? Lorem ipsum dolor sit, amet
                    consectetur adipisicing elit. Sequi cumque incidunt earum
                    architecto dolor sit accusamus, magnam optio eius repellat
                    labore molestias recusandae vitae delectus itaque. Facilis,
                    et quis labore sint eligendi fuga unde quam quaerat dolorem
                    voluptatum, alias rerum itaque. Nihil accusantium placeat
                    consectetur numquam pariatur? Maxime, laborum doloribus?
                </p>
            </div>
            <div class="blog-single__bottom">
                <div class="col-12 col-lg-3">
                    <div
                        class="d-flex flex-row flex-wrap-wrap justify-content-center align-items-center bg-primary pt-12px pb-12px pl-6px pr-6px column-gap-5px border-radius-12px text-white"
                    >
                        <a class="hover-text" href="/kategoria/Bez-kategorii"
                        >Bez kategorii,
                        </a>
                        <a class="hover-text" href="/kategoria/Bez-kategorii"
                        >Lorem Ipsum,
                        </a>
                        <a class="hover-text" href="/kategoria/Bez-kategorii"
                        >Lorem Ipsum Dolor</a
                        >
                    </div>
                </div>
                <div
                    class="col-12 col-lg-3 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-calendar mr-5px"></i>
                    <span>2025-01-01</span>
                </div>
                <div
                    class="col-12 col-lg-3 d-flex justify-content-center align-items-center"
                >
                    <i class="fa fa-user mr-5px"></i>
                    The Ringmaster
                </div>
                <div
                    class="col-12 col-lg-3 d-flex justify-content-center align-items-center"
                >
                    <a href="#" class="hover-primary"
                    ><i class="fa fa-arrow-left"></i> Widok Listy</a
                    >
                </div>
            </div>
        </div>
        <section class="section pb-100px">
            <div class="container container-small">
                <PostQuery evContClass="ev-cont-lg-three" :latest="latest">
                </PostQuery>
            </div>
        </section>
    </section>

</template>
