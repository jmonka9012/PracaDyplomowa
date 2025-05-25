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
        required: true,
    },
    organizer_stats: {
        required: true,
    },
    user_stats: {
        required: true,
    },
});

const filterRequest = reactive({
    email: null,
    role: null,
    name: null,
    company_name: null,
    account_status: null,
});

console.log(props);

function FilterUsers() {
    console.log(filterRequest);

    router.get(route("admin.users"), filterRequest, {
        preserveScroll: true,
    });
}

function DeleteUser(id) {
    router.delete(route("admin.users.delete"), {
        data: { user_id: id },
        preserveScroll: true,
        only: ["users"],
    });
}

function TranslateStatus(status) {
    if (status === "verified") {
        return "Zweryfikowany";
    } else if (status === "denied") {
        return "Odrzucony";
    } else if (status === "pending") {
        return "Oczekujący na zatwierdzenie";
    }
}

function SetOrganizerStatus(value, userID) {
    console.log(value);
    router.put(
        route("admin.users.organizers.change_status", {
            id: userID,
        }),
        {
            account_status: value,
        },
        {
            preserveScroll: true,
            only: ["users"],
            onError: (err) => {
                console.log("Błąd:", err);
            },
            onSuccess: (page) => {
                console.log("Sukces:", page);
            },
        }
    );
    /*    router.reload({
        preserveState: true,
        preserveScroll: true,
        only: ['users'],
    })*/
}
</script>

<template>
    <HeroSmall :source="blogBg" title="Zarządzaj użytkownikami"></HeroSmall>
    <section>
        <div class="container flex-column">
            <div class="col-12 d-flex flex-lg-row align-items-lg-center">
                <h2 class="mb-20px mb-lg-0">Użytkownicy</h2>
                <a href="#" class="ml-lg-20px btn btn-md btn-hovprim"
                    >Dodaj nowego</a
                >
            </div>
            <!-- <div class="col-12 mt-30px mb-30px overflow-x-scroll">
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
            </div> -->
            <form class="form" @submit.prevent="FilterUsers()">
                <div class="input-wrap col-12">
                    <label for="userName">Nazwa:</label>
                    <input type="text" v-model="filterRequest.name" />
                </div>
                <div class="input-wrap col-12">
                    <label for="userName">Email:</label>
                    <input type="text" v-model="filterRequest.email" />
                </div>
                <div class="input-wrap col-12">
                    <label for="userName">Nazwa firmy:</label>
                    <input type="text" v-model="filterRequest.company_name" />
                </div>
                <div class="input-wrap col-12">
                    <label class="mb-10px" for="userType"
                        >Typ użytkownika</label
                    >
                    <select
                        v-model="filterRequest.account_status"
                        name="userType"
                        id=""
                    >
                        <option disabled value="">Wybierz</option>
                        <option
                            v-for="status in props.organizer_stats.original"
                            :value="status.value"
                        >
                            {{ status.description }} ( {{ status.count }} )
                        </option>
                    </select>
                </div>
                <div class="input-wrap col-12">
                    <select v-model="filterRequest.role" name="userType" id="">
                        <option disabled value="">Wybierz</option>
                        <option
                            v-for="status in props.user_stats.original"
                            :value="status.value"
                        >
                            {{ status.description }} ( {{ status.count }} )
                        </option>
                    </select>
                </div>
                <div class="input-wrap col-12">
                    <button class="btn btn-md w-fit" type="submit">
                        Filtruj
                    </button>
                </div>
            </form>
            <div class="d-flex flex-column">
                <div
                    class="d-flex flex-row bb-1 b-text pt-10px pl-lg-10px pr-lg-10px pb-20px flex-wrap-wrap"
                    v-for="user in props.users.data"
                >
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
                    <div class="user-row">
                        <div class="user-row__value">{{ user.id }}</div>
                        <div class="user-row__value">{{ user.name }}</div>
                        <div class="user-row__value">{{ user.email }}</div>
                        <div class="user-row__value">{{ user.full_name }}</div>
                        <div class="user-row__value">{{ user.role }}</div>
                        <div class="user-row__value">
                            {{ user.total_tickets }}
                        </div>
                        <div class="user-row__value">
                            <Link
                                v-if="user.support_tickets !== 0"
                                :href="route('admin.customer-service')"
                                :data="{ user_id: user.id }"
                                method="get"
                            >
                                {{ user.support_tickets }}
                            </Link>
                            <div v-else>{{ user.support_tickets }}</div>
                        </div>
                        <div class="user-row__value">
                            <Link
                                class="btn btn-md"
                                preserve-scroll
                                method="delete"
                                :only="['users']"
                                @click="DeleteUser(user.id)"
                                >Usuń</Link
                            >
                        </div>
                    </div>
                    <div
                        v-if="user.organizer"
                        class="user-row__value user-row__value--span"
                    >
                        <Collapse class="col-12">
                            <template #trigger="{ isOpen }">
                                <button class="btn btn-md">
                                    {{
                                        isOpen
                                            ? "Ukryj"
                                            : "Pokaż szczegóły organizatora"
                                    }}
                                </button>
                            </template>
                            <div class="content d-flex flex-row pt-20px">
                                <div
                                    class="user-row user-row--head user-row--head_collapsed col-2"
                                >
                                    <div>ID:</div>
                                    <div>Nazwa firmy:</div>
                                    <div>Adres:</div>
                                    <div>NIP:</div>
                                    <div>Bank:</div>
                                    <div>E-mail:</div>
                                    <div>Nr. telefonu:</div>
                                    <div>Status:</div>
                                </div>
                                <div class="user-row user-row_collapsed col-10">
                                    <div class="user-row__value">
                                        {{ user.organizer.id }}
                                    </div>
                                    <div class="user-row__value">
                                        {{ user.organizer.company_name }}
                                    </div>
                                    <div class="user-row__value">
                                        {{ user.organizer.address }}
                                    </div>
                                    <div class="user-row__value">
                                        {{ user.organizer.tax_number }}
                                    </div>
                                    <div class="user-row__value">
                                        {{ user.organizer.bank_account_number }}
                                    </div>
                                    <div class="user-row__value">
                                        {{ user.organizer.email }}
                                    </div>
                                    <div class="user-row__value">
                                        {{ user.organizer.phone_number }}
                                    </div>
                                    <div
                                        class="user-row__value user-row__button relative"
                                    >
                                        <div
                                            v-html="
                                                TranslateStatus(
                                                    user.organizer
                                                        .account_status
                                                )
                                            "
                                        ></div>
                                        <select
                                            @change="
                                                SetOrganizerStatus(
                                                    $event.target.value,
                                                    user.organizer.id
                                                )
                                            "
                                            class="user-row__change-status"
                                            name="changeStatus"
                                            id="changeStatus"
                                        >
                                            <option
                                                :selected="
                                                    user.organizer
                                                        .account_status ===
                                                    'verified'
                                                "
                                                :disabled="
                                                    user.organizer
                                                        .account_status ===
                                                    'verified'
                                                "
                                                value="verified"
                                            >
                                                Zweryfikowany
                                            </option>
                                            <option
                                                :selected="
                                                    user.organizer
                                                        .account_status ===
                                                    'denied'
                                                "
                                                :disabled="
                                                    user.organizer
                                                        .account_status ===
                                                    'denied'
                                                "
                                                value="denied"
                                            >
                                                Odrzucony
                                            </option>
                                            <option
                                                :selected="
                                                    user.organizer
                                                        .account_status ===
                                                    'pending'
                                                "
                                                :disabled="
                                                    user.organizer
                                                        .account_status ===
                                                    'pending'
                                                "
                                                value="pending"
                                            >
                                                Oczekujący
                                            </option>
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
@use "~css/mixin.scss";
.user-row {
    width: 50%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    row-gap: 5px;
    @include mixin.media-breakpoint-down(xl) {
        width: 75%;
    }

    &__value {
        display: flex;
        justify-content: center;
        align-items: center;
        @include mixin.media-breakpoint-down(xl) {
            font-size: 14px;
        }
        &--span {
            padding: 0;
            width: 100%;
            margin-top: 10px;
            .user-row {
                border-bottom: 0;
                border-left: 0;
                border-right: 0;
            }
        }
    }
    &__button {
        min-height: 60px;
    }
    &_collapsed {
        display: flex;
        flex-direction: column;
        .user-row__value {
            justify-content: flex-start;
        }
    }

    &__change-status {
        position: absolute;
        transition: all 0.2s ease-in-out;
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
        border-right: 0;
        width: 50%;
        @include mixin.media-breakpoint-down(xl) {
            width: 25%;
            padding-right: 10px;
        }
        > div {
            display: flex;
            justify-content: center;
            text-align: left;
            @include mixin.media-breakpoint-down(xl) {
                font-size: 14px;
            }
        }
        &_collapsed {
            flex-direction: column;
            display: flex;
            .user-row__value {
                white-space: nowrap;
            }
            > div {
                justify-content: flex-start;
                text-align: left;
                white-space: nowrap;
            }
        }
    }
}
#changeStatus {
    @include mixin.media-breakpoint-down(xl) {
        min-width: 150px;
        font-size: 14px;
    }
}
</style>
