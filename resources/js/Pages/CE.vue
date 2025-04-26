<script setup>
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import hellsPit from "~images/hellspit.jpg";
import bangPow from "~images/bangpow.jpg";
import greatMilenko from "~images/greatmilenko.jpg";
import jeckelbros from "~images/Jeckelbros.jpg";
import PostQuery from "../Components/Sections/PostQuery.vue";
import DatePicker from "../Components/Partials/DatePicker.vue";
import MultiSelect from "@/Components/Partials/MultiSelect.vue";
const latest = [
    {
        id: 1,
        src: bangPow,
        link: [
            {
                href: "/icp",
                title: "zmień wielkość kontenera później",
            },
        ],
        category: [
            {
                href: "/bpb",
                title: "bangpow",
            },
        ],
        date: "January 22, 2025",
    },
    {
        id: 2,
        src: greatMilenko,
        link: [{ href: "/icp", title: "Great MILENKO GREAT MILENKO" }],
        date: "January 22, 2025",
        category: [
            {
                href: "/bpb",
                title: "greatMilenko",
            },
        ],
    },
    {
        id: 3,
        src: hellsPit,
        link: [{ href: "/icp", title: "Event" }],
        date: "January 22, 2025",
        category: [
            {
                href: "/bpb",
                title: "hellsPit",
            },
        ],
    },
    {
        id: 4,
        src: jeckelbros,
        link: [{ href: "/icp", title: "Jeckelbross" }],
        date: "January 22, 2025",
        category: [
            {
                href: "/bpb",
                title: "Jeckelbros",
            },
        ],
    },
];
</script>

<template>
    <section>
        <div class="container justify-content-center">
            <div class="col-lg-4">
                <Tabs>
                    <Tab title="Pierwszy Tab">
                        <div class="d-flex flex-column">
                            <h2>Lorem, ipsum dolor.</h2>
                            <p>Treść pierwszego tabu</p>
                        </div>
                    </Tab>

                    <Tab title="Drugi Tab">
                        <div class="d-flex flex-column">
                            <h2>Lorem, ipsum dolor.</h2>
                            <p>Treść drugiego tabu</p>
                        </div>
                    </Tab>

                    <Tab title="Trzeci Tab">
                        <div class="d-flex flex-column">
                            <h2>Lorem, ipsum dolor.</h2>
                            <p>Treść trzeciego tabu</p>
                        </div>
                    </Tab>
                </Tabs>
            </div>
        </div>
    </section>

    <section class="pt-100px pb-100px">
        <div
            class="container flex-column align-items-center justify-content-center"
        >
            <form action="" class="form">
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input type="checkbox" name="notif1" id="notif1" />
                    <label for="notif1">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 1
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input type="checkbox" name="notif2" id="notif2" />
                    <label for="notif2">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 2
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input type="checkbox" name="notif3" id="notif3" />
                    <label for="notif3">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 3
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12 mb-20px">
                    <input type="checkbox" name="notif4" id="notif4" />
                    <label for="notif4">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 4
                    </label>
                </div>
                <div class="input-wrap input-wrap-check col-12">
                    <input type="submit" value="Zapisz zmiany" />
                </div>
            </form>
        </div>
    </section>
    <section class="pt-100px pb-100px">
        <div class="container flex-column align-items-center">
            <h3 class="mb-30px">Czy na pewno chcesz usunąć swoje konto ?</h3>
            <form action="" class="form">
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="register-password-confirm"
                        >Potwierdź uzywająć Hasła *</label
                    >
                    <input
                        type="password"
                        name="password_deleteacc"
                        id="register-password-confirm"
                        autocomplete="register-password-confirm"
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap input-wrap-check col-12 mb-35px">
                    <input type="checkbox" name="notif4" id="notif4" />
                    <label for="notif4">
                        Czy na pewno pewno jesteś pewny
                    </label>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Usuń konto" />
                </div>
            </form>
        </div>
    </section>



    <section>
        <
    </section>

    <!-- Koniec tables -->

    <!-- Hale -->

    <!-- koniec hal -->


    <!-- O nas  -->
    <HeroSmall :source="blogBg" title="O nas"></HeroSmall>
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
    <section class="mb-100px">
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
            <img class="mh-600 mb-30px" :src="hellsPit" alt="" />
            <h3 class="mb-30px">Lorem Ipsum dolor sit amet</h3>
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
            <h3 class="mb-50px">Gdzie jesteśmy ? (tu mapa)</h3>
            <img :src="blogBg" class="on-map" alt="" />
        </div>
    </section>
    <section>
        <div class="container"><DatePicker></DatePicker></div>
    </section>
</template>

<style lang="scss">
@use "~css/mixin.scss";
///tutaj narazie style dla blog-single

.blog-image {
    max-height: 450px;
    max-width: 450px;
    width: 100%;
    @include mixin.media-breakpoint-up(lg) {
        max-height: 600px;
        max-width: 600px;
    }
    &-square {
        max-width: 450px;
        @include mixin.media-breakpoint-up(lg) {
            max-width: 600px;
        }
    }
}
.blog-single__bottom {
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding-top: 40px;
    padding-bottom: 40px;
    border-top: 1px solid #dddedf;
    display: flex;
    flex-direction: column;
    row-gap: 30px;
    @include mixin.media-breakpoint-up(lg) {
        flex-direction: row;
        padding-bottom: 100px;
    }
}
//tutaj narazie o nas

.on-map {
    max-height: 600px;
    width: 100%;
    object-fit: cover;
    aspect-ratio: 16 / 9;
}
</style>
