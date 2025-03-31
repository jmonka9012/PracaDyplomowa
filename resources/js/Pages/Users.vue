<script>
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import hellsPit from "~images/hellspit.jpg";
</script>

<template>
    <HeroSmall :source="blogBg" title="Users"></HeroSmall>

    <section>
        <div class="container">
            <div class="col-12 d-flex align-items-center">
                <h1>Użytkownicy</h1>
                <a href="#" class="ml-20px btn btn-md">Dodaj nowego</a>
            </div>
            <div class="col-12 mt-30px mb-30px overflow-x-scroll">
                <table class="table-fixed">
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
                        <tr class="user">
                            <td class="user__select">
                                <input
                                    class="check"
                                    type="checkbox"
                                    name="Select &name user"
                                />
                            </td>
                            <td class="user__nick">
                                <img :src="hellsPit" class="user__pic" />
                                <a href="admin@gmail.com">Admin</a>
                                <div class="user__options">
                                    <a href="#edit">Edytuj</a>
                                    <a href="#delete">Usuń</a>
                                    <a href="#view">Zobacz</a>
                                    <a href="#resetPass">Resetuj Hasło</a>
                                </div>
                            </td>
                            <td class="user__name">Admin Administratorski</td>
                            <td class="user__mail">
                                <a href="admin@gmail.com">admin@gmail.com</a>
                            </td>
                            <td class="user__role">Administrator</td>
                            <td class="user__posts">21</td>
                            <td class="user__id">05</td>
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
