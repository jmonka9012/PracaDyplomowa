<script setup>
import blogBg from "~images/blog-bg.jpg";
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";
import { Link } from "@inertiajs/vue3";

import HeroSmall from "@/Components/Sections/Hero-small.vue";

const props = defineProps({
    users: {
        required: true
    },
    organizer_stats: {
        required: true
    },
    user_stats: {
        required: true
    }
})

const filterRequest = reactive({
    email: null,
    role: null,
    name: null,
    company_name: null,
    account_status: null,
})

console.log(props);

function FilterUsers() {
    console.log(filterRequest);

    router.get(route('admin.users'), filterRequest, {
        preserveScroll: true,
    })
}

</script>

<template>
    <HeroSmall :source="blogBg" title="Zarządzaj użytkownikami"></HeroSmall>
    <section>
        <div class="container flex-column">
            <div class="col-12 d-flex flex-lg-row align-items-lg-center">
                <h2 class="mb-20px mb-lg-0">Użytkownicy</h2>
                <a href="#" class="ml-lg-20px btn btn-md btn-hovprim">Dodaj nowego</a>
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
            <form  @submit.prevent="FilterUsers()">
                <div>
                    <label for="userName">Nazwa:</label>
                    <input type="text" v-model="filterRequest.name">
                </div>
                <div>
                    <label for="userName">Email:</label>
                    <input type="text" v-model="filterRequest.email">
                </div>
                <div>
                    <label for="userName">Nazwa firmy:</label>
                    <input type="text" v-model="filterRequest.company_name">
                </div>
                <div>
                    <label for="userType">Typ użytkownika</label>
                    <select v-model="filterRequest.account_status" name="userType" id="">
                        <option disabled value="">Wybierz</option>
                        <option v-for="status in props.organizer_stats.original" :value="status.value">{{status.description}} ( {{status.count}} )</option>
                    </select>
                </div>
                <div>
                    <select v-model="filterRequest.role" name="userType" id="">
                        <option disabled value="">Wybierz</option>
                        <option v-for="status in props.user_stats.original" :value="status.value">{{status.description}} ( {{status.count}} )</option>
                    </select>
                </div>
                <button type="submit">Filtruj</button>
            </form>
            <div>
                <div class="user-row user-row--head">
                    <div>ID:</div>
                    <div>Nazwa:</div>
                    <div>Email:</div>
                    <div>Imie i nazwisko:</div>
                    <div>Rola:</div>
                    <div>Kupione Bilety:</div>
                    <div>Zgłoszenia o pomoc:</div>
                    <div>Akcja:</div>
                </div>
                <div class="user-row" v-for="user in props.users.data" >
                    <div class="user-row__value"> {{ user.id}} </div>
                    <div class="user-row__value"> {{ user.name}} </div>
                    <div class="user-row__value"> {{ user.email}} </div>
                    <div class="user-row__value"> {{ user.full_name}} </div>
                    <div class="user-row__value"> {{ user.role}} </div>
                    <div class="user-row__value"> {{ user.total_tickets}} </div>
                    <div class="user-row__value">  </div>
                    <div class="user-row__value">
                        <Link preserve-scroll method="delete" :data="{user_id: user.id}" :href="route('admin.users.delete')" >Usuń</Link>
                    </div>
                </div>
            </div>
            <div class="event-pagination">
                <ul class="ml-auto mr-auto">
                    <li
                        :key="page"
                        class="page"
                        :class="{ 'page-current': page.active }"
                        v-for="page in props.users.meta.links"
                    >
                        <Link :href="page.url" v-html="page.label"></Link>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.user-row {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(8, 1fr);

    &__value {

    }

    &--head {
        font-weight: 700;
    }
}
</style>
