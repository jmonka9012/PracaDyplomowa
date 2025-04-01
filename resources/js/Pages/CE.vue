<script setup>
import Tab from "@/Components/sections-new/Tab.vue";
import Tabs from "@/Components/sections-new/Tabs.vue";
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import hellsPit from "~images/hellspit.jpg";
import bangPow from "~images/bangpow.jpg";
import greatMilenko from "~images/greatmilenko.jpg";
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
                            <th class="t-details-events__mr-info">
                                Więcej informacji
                            </th>
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
                                Lorem ipsum dolor sit, amet consectetur
                                adipisicing elit. Expedita suscipit nisi cum
                                reiciendis exercitationem. Placeat magnam
                                explicabo consequatur quam possimus dolore iste
                                harum eum perferendis repellendus, dolorem
                                cupiditate error beatae?
                            </td>
                            <td class="t-details-events__td-desc">
                                Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Sed culpa vero dicta facere
                                quaerat nam ullam fuga harum exercitationem
                                illum?
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
                            <th>Więcej informacji</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <!-- Koniec tables -->

    <!-- Hale -->
    <HeroSmall :source="blogBg" title="Task 3"></HeroSmall>
    <section>
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
</template>

<style lang="scss"></style>
