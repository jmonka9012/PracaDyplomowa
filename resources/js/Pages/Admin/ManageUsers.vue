<script setup>
import blogBg from "~images/blog-bg.jpg";
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";
import { Link } from "@inertiajs/vue3";
import useAuth from "@/Utilities/useAuth";
import HeroSmall from "@/Components/Sections/Hero-small.vue";
import Collapse from "../../Components/Partials/Collapse.vue";


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

function DeleteUser(id) {
    router.delete(route('admin.users.delete'), {
        data: { user_id: id },
        preserveScroll: true,
        only: ['users']
    })
}

function TranslateStatus(status) {
    if (status === 'verified') {
        return "Zweryfikowany"
    } else if (status === 'denied') {
        return "Odrzucony"
    } else if (status === 'pending') {
        return 'Oczekujący na zatwierdzenie'
    }
}

function SetOrganizerStatus(value, userID) {
    router.put(route('admin.users.organizers.change_status', {
        id: userID // Tutaj przekazujemy ID do parametru URL
    }), {
        status: value // Tylko status w ciele żądania
    }, {
        onError: (err) => {
            console.log('Błąd:', err);
        },
        onSuccess: (page) => {
            console.log('Sukces:', page);
        },
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
                        <Link preserve-scroll method="delete" :only="['users']" @click="DeleteUser(user.id)" >Usuń</Link>
                    </div>
                    <div v-if="user.organizer" class="user-row__value user-row__value--span" >
                        <Collapse class="w-100">
                        <template #trigger="{ isOpen }">
                            <button class="btn btn-md">
                                {{
                                    isOpen
                                        ? "Ukryj"
                                        : "Pokaż szczegóły organizatora"
                                }}
                            </button>
                        </template>
                        <div class="content pt-20px">
                            <div class="user-row user-row--head">
                                <div>ID:</div>
                                <div>Nazwa firmy:</div>
                                <div>Adres:</div>
                                <div>NIP:</div>
                                <div>Bank:</div>
                                <div>E-mail:</div>
                                <div>Nr. telefonu:</div>
                                <div>Status:</div>
                            </div>
                            <div class="user-row">
                                <div class="user-row__value">{{user.organizer.id}}</div>
                                <div class="user-row__value">{{user.organizer.company_name}}</div>
                                <div class="user-row__value">{{user.organizer.address}}</div>
                                <div class="user-row__value">{{user.organizer.tax_number}}</div>
                                <div class="user-row__value">{{user.organizer.bank_account_number}}</div>
                                <div class="user-row__value">{{user.organizer.email}}</div>
                                <div class="user-row__value">{{user.organizer.phone_number}}</div>
                                <div  class="user-row__value relative">
                                    <div v-html="TranslateStatus(user.organizer.account_status)"></div>
                                    <select @change="SetOrganizerStatus($event.target.value, user.organizer.id)" class="user-row__change-status" name="changeStatus" id="changeStatus">
                                        <option :selected="user.organizer.account_status === 'verified'" :disabled="user.organizer.account_status === 'verified'" value="verified">Zweryfikowany</option>
                                        <option :selected="user.organizer.account_status === 'denied'" :disabled="user.organizer.account_status === 'denied'" value="verified">Odrzucony</option>
                                        <option :selected="user.organizer.account_status === 'pending'" :disabled="user.organizer.account_status === 'pending'" value="verified">Oczekujący</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </Collapse>
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
    border: 1px solid black;

    &__value {

        &--span {
            grid-column: 1/-1;
        }
    }

    &__change-status {
        position: absolute;
        transition: all .2s ease-in-out;
        top: 0;
        left: 0;
        z-index: 5;

        &:hover {
            opacity: 1;
            visibility: visible;
        }
    }

    &--head {
        font-weight: 700;
    }
}
</style>
