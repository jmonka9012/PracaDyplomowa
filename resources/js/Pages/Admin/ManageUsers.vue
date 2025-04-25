<script setup>
import blogBg from "~images/blog-bg.jpg";

import HeroSmall from "@/Components/Sections/Hero-small.vue";
</script>

<template>
    <HeroSmall :source="blogBg" title="Zarządzaj użytkownikami"></HeroSmall>
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
</template>

<style scoped lang="scss">

</style>
