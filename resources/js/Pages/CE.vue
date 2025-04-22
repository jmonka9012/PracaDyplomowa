<script setup>
import Tab from "@/Components/Sections/Tab.vue";
import Tabs from "@/Components/Sections/Tabs.vue";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import hellsPit from "~images/hellspit.jpg";
import bangPow from "~images/bangpow.jpg";
import greatMilenko from "~images/greatmilenko.jpg";
import jeckelbros from "~images/Jeckelbros.jpg";
import Wysiwyg from "../Components/Sections/Wysiwyg.vue";
import LatestEvents from "../Components/Sections/LatestEvents.vue";
import DatePicker from "../Components/Sections/DatePicker.vue";
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

    <HeroSmall :source="blogBg" title="Wydarzenia"></HeroSmall>
    <section>
        <div class="container">
            <div class="col-12 d-flex align-items-center">
                <h1>Użytkownicy</h1>
                <a href="#" class="ml-20px btn btn-md">Dodaj nowego</a>
            </div>
            <div class="col-12 mt-30px mb-30px overflow-x-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select all users"
                                />
                            </th>
                            <th>
                                <a href="#username-sort"
                                    >Nazwa użytkownika
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th>Imię & Nazwisko</th>
                            <th>
                                <a href="#email-sort"
                                    >Email
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th>Rola</th>
                            <th>Posty?</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="t-details">
                            <td class="t-details__select">
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select &name user"
                                />
                            </td>
                            <td>
                                <img :src="hellsPit" class="t-details__pic" />
                                <a href="admin@gmail.com">Admin</a>
                                <div class="t-details__options">
                                    <a href="#edit">Edytuj</a>
                                    <a href="#delete">Usuń</a>
                                    <a href="#view">Zobacz</a>
                                    <a href="#resetPass">Resetuj Hasło</a>
                                </div>
                            </td>
                            <td>Admin Administratorski</td>
                            <td>
                                <a href="admin@gmail.com">admin@gmail.com</a>
                            </td>
                            <td>Administrator</td>
                            <td>21</td>
                            <td>05</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select all users"
                                />
                            </th>
                            <th>
                                <a href="#username-sort"
                                    >Nazwa użytkownika
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th>Imię & Nazwisko</th>
                            <th>
                                <a href="#email-sort"
                                    >Email
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th>Rola</th>
                            <th>Posty?</th>
                            <th>ID</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="col-12 d-flex align-items-center">
                <h1>Wydarzenia</h1>
                <a href="#" class="ml-20px btn btn-md">Dodaj nowe</a>
            </div>
            <div class="col-12 mt-30px mb-30px overflow-x-scroll">
                <table class="table-nowrap table-fixed">
                    <thead>
                        <tr>
                            <th class="t-details-events__input">
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select all users"
                                />
                            </th>
                            <th class="t-details-events__main-img">
                                Obrazek Główny
                            </th>
                            <th class="t-details-events__name">
                                <a href="#username-sort"
                                    >Nazwa
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th class="t-details-events__url">Url</th>
                            <th class="t-details-events__date">Data</th>
                            <th class="t-details-events__start">
                                Początek (h)
                            </th>
                            <th class="t-details-events__end">Koniec (h)</th>
                            <th class="t-details-events__loc">Lokalizacja</th>
                            <th class="t-details-events__e-main">Email gł.</th>
                            <th class="t-details-events__e-add">
                                Email dodatkowy
                            </th>
                            <th class="t-details-events__desc">Opis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="t-details">
                            <td class="t-details__select">
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select @name event"
                                />
                            </td>
                            <td>
                                <img
                                    :src="hellsPit"
                                    class="t-details__pic mr-0"
                                />
                            </td>
                            <td>
                                <a href="#event-link">Wydarzenie numer 1</a>
                                <div class="t-details__options">
                                    <a href="#edit">Edytuj</a>
                                    <a href="#delete">Usuń</a>
                                    <a href="#view">Zobacz</a>
                                </div>
                            </td>
                            <td>/Lorem-ipsum-1</td>
                            <td>1.04</td>
                            <td>16:00</td>
                            <td>24:00</td>
                            <td>Sala nr 1</td>
                            <td><a href="#email-main">Główny email</a></td>
                            <td><a href="#email-add">Dodatkowy email</a></td>
                            <td class="t-details-events__td-desc">
                                <a href="text-primary">Podgląd</a>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select all users"
                                />
                            </th>
                            <th>
                                <a href="#username-sort"
                                    >Nazwa
                                    <span class="sorters">
                                        <span class="sort sort-asc fa"></span>
                                        <span class="sort sort-desc fa"></span>
                                    </span>
                                </a>
                            </th>
                            <th>Url</th>
                            <th>Obrazek Główny</th>
                            <th>Data</th>
                            <th>Początek (h)</th>
                            <th>Koniec (h)</th>
                            <th>Lokalizacja</th>
                            <th>Email gł.</th>
                            <th>Email dodatkowy</th>
                            <th>Opis</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <!-- Koniec tables -->

    <!-- Hale -->
    <HeroSmall :source="blogBg" title="Task 3"></HeroSmall>
    <section class="mb-100px">
        <div class="container justify-content-center">
            <div class="col-lg-12">
                <Tabs>
                    <Tab title="Pierwszy Tab">
                        <div
                            class="d-flex justify-content-center align-items-center"
                        >
                            <img
                                :src="hellsPit"
                                alt=""
                                style="max-height: 600px"
                            />
                        </div>
                    </Tab>

                    <Tab title="Drugi Tab">
                        <div
                            class="d-flex justify-content-center align-items-center"
                        >
                            <img
                                :src="greatMilenko"
                                alt=""
                                style="max-height: 600px"
                            />
                        </div>
                    </Tab>

                    <Tab title="Trzeci Tab">
                        <div
                            class="d-flex justify-content-center align-items-center"
                        >
                            <img
                                :src="bangPow"
                                alt=""
                                style="max-height: 600px"
                            />
                        </div>
                    </Tab>
                </Tabs>
            </div>
        </div>
    </section>

    <!-- koniec hal -->

    <HeroSmall :source="blogBg" title="Blog formular"></HeroSmall>
    <section class="pt-50px pb-50px">
        <div class="container">
            <form class="form" enctype="multipart/form-data">
                <div class="input-wrap col-12">
                    <label for="post-title">Nazwa wpisu*</label>
                    <input
                        type="text"
                        placeholder="Nazwa wpisu"
                        required
                        id="post-title"
                        autocomplete="post-title"
                        name="post-title"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="post-image">Obrazek główny wpisu*</label>
                    <input
                        type="file"
                        id="post-image"
                        name="post-image"
                        accept="image/*"
                        required
                        placeholder="Obrazek główny*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        @change="handleFileUpload"
                    />
                    <p class="mt-10px fs-14">
                        Zalecane ratio 3:2, zalecana rozdzielczość 1024x1024
                    </p>
                </div>

                <div class="input-wrap col-12">
                    <label for="post-description">Opis wpisu*</label>
                    <textarea
                        id="post-description"
                        name="post-description"
                        required
                        placeholder="Opis wpisu"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                    ></textarea>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Stwórz wpis" />
                </div>
            </form>
        </div>
    </section>
    <section class="mb-100px">
        <div class="container">
            <Wysiwyg
                :init="{
                    toolbar_mode: 'sliding',
                    plugins: [
                        'anchor',
                        'autolink',
                        'charmap',
                        'codesample',
                        'emoticons',
                        'image',
                        'link',
                        'lists',
                        'media',
                        'searchreplace',
                        'table',
                        'visualblocks',
                        'wordcount',
                        'checklist',
                        'mediaembed',
                        'casechange',
                        'formatpainter',
                        'pageembed',
                        'a11ychecker',
                        'tinymcespellchecker',
                        'permanentpen',
                        'powerpaste',
                        'advtable',
                        'advcode',
                        'editimage',
                        'advtemplate',
                        'mentions',
                        'tinycomments',
                        'tableofcontents',
                        'footnotes',
                        'mergetags',
                        'autocorrect',
                        'typography',
                        'inlinecss',
                        'markdown',
                        'importword',
                        'exportword',
                        'exportpdf',
                    ],
                    toolbar:
                        'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | language',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [
                        { value: 'First.Name', title: 'First Name' },
                        { value: 'Email', title: 'Email' },
                    ],
                }"
            />
        </div>
    </section>

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
                <LatestEvents evContClass="ev-cont-lg-three" :latest="latest">
                </LatestEvents>
            </div>
        </section>
    </section>
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
