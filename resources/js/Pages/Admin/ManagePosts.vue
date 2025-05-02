<script setup>
import blogBg from "~images/blog-bg.jpg";

import HeroSmall from "@/Components/Sections/Hero-small.vue";

import {Link} from "@inertiajs/vue3";
</script>

<template>
    <HeroSmall :source="blogBg" title="Zarządzaj postami"></HeroSmall>
    <section>
        <div class="container">
            <div class="col-12 d-flex flex-lg-row align-items-lg-center">
                <h2 class="mb-20px mb-lg-0">Posty</h2>
                <Link :href="route('blog-create')" class="ml-lg-20px btn btn-md btn-hovprim">Dodaj nowy</Link>
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
                            <th>Obrazek Główny</th>

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
</template>

<style scoped lang="scss"></style>
