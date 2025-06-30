<script setup>
import blogBg from "~images/blog-bg.jpg";
import {router} from "@inertiajs/vue3";
import {reactive} from "vue";
import {Link} from "@inertiajs/vue3";
import { computed } from 'vue';
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

const filteredRoles = computed(() => {
    return (props.user_stats.original || [])
        .filter(role => role
            && role.value
            && !['admin', 'organizer'].includes(role.value)
        );
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
        data: {user_id: id},
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

function SetUserProperty(value, userID, property) {
    let routeName = null;
    if (property === 'organizer_status') {
        routeName = "admin.users.organizers.change_status";
    } else if (property === 'role') {
        routeName = "admin.users.change_role";
    }

    router.put(
        route(routeName, {
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
}

</script>

<template>
    <HeroSmall :source="blogBg" title="Zarządzaj użytkownikami"></HeroSmall>
    <section>
        <div class="container flex-column">
            <div class="col-12 d-flex flex-lg-row align-items-lg-center">
                <h2 class="mb-20px mb-lg-0">Użytkownicy</h2>
                <a class="ml-lg-20px btn btn-md btn-hovprim" href="#"
                >Dodaj nowego</a
                >
            </div>
            <form class="form" @submit.prevent="FilterUsers()">
                <div class="input-wrap col-12">
                    <label for="userName">Nazwa:</label>
                    <input v-model="filterRequest.name" type="text"/>
                </div>
                <div class="input-wrap col-12">
                    <label for="userName">Email:</label>
                    <input v-model="filterRequest.email" type="text"/>
                </div>
                <div class="input-wrap col-12">
                    <label for="userName">Nazwa firmy:</label>
                    <input v-model="filterRequest.company_name" type="text"/>
                </div>
                <div class="input-wrap col-12">
                    <label class="mb-10px" for="userRole">Rola</label>
                    <select id="userRole" v-model="filterRequest.role" name="userRole">
                        <option disabled value="">Wybierz</option>
                        <option
                            v-for="status in props.user_stats.original"
                            :value="status.value">
                            {{ status.description }} ( {{ status.count }} )
                        </option>
                    </select>
                </div>
                <div class="input-wrap col-12">
                    <label class="mb-10px" for="organizerStatus">Status organizatora:</label>
                    <select
                        id="organizerStatus"
                        v-model="filterRequest.account_status"
                        name="organizerStatus">
                        <option disabled value="">Wybierz</option>
                        <option
                            v-for="status in props.organizer_stats.original"
                            :value="status.value">
                            {{ status.description }} ( {{ status.count }} )
                        </option>
                    </select>
                </div>
                <div class="input-wrap col-12">
                    <button class="btn btn-md btn-hovprim w-fit" type="submit">
                        Filtruj
                    </button>
                </div>
            </form>
            <div class="d-flex flex-column mb-50px">
                <div v-for="user in props.users.data"
                    class="d-flex flex-row bb-1 b-text pt-10px pl-lg-10px pr-lg-10px pb-20px flex-wrap-wrap">
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
                        <div v-if="user.role === 'admin' || user.role === 'organizer'" v-html="props.user_stats.original.find(role => role.value === user.role)?.description" class="user-row__value"></div>
                        <div v-else>
                            <select
                                id="changeStatus"
                                class=""
                                name="changeStatus"
                                @change="SetUserProperty($event.target.value,user.id,'role')">
                                <option :selected="role.value === user.role" v-for="role in filteredRoles" :value="role.value">{{role.description}}</option>                            </select>
                        </div>
                        <div class="user-row__value">
                            {{ user.total_tickets }}
                        </div>
                        <div class="user-row__value">
                            <Link
                                v-if="user.support_tickets !== 0"
                                :data="{ user_id: user.id }"
                                :href="route('admin.customer-service')"
                                method="get"
                            >
                                {{ user.support_tickets }}
                            </Link>
                            <div v-else>{{ user.support_tickets }}</div>
                        </div>
                        <div class="user-row__value">
                            <Link
                                :only="['users']"
                                class="btn btn-md btn-hovprim"
                                method="delete"
                                preserve-scroll
                                @click="DeleteUser(user.id)"
                            >Usuń
                            </Link
                            >
                        </div>
                    </div>
                    <div
                        v-if="user.organizer"
                        class="user-row__value user-row__value--span"
                    >
                        <Collapse class="col-12">
                            <template #trigger="{ isOpen }">
                                <button class="btn btn-md btn-hovprim">
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
                                            id="changeStatus"
                                            class="user-row__change-status"
                                            name="changeStatus"
                                            @change="
                                                SetUserProperty(
                                                    $event.target.value,
                                                    user.organizer.id,
                                                    'organizer_status'
                                                )
                                            "
                                        >
                                            <option
                                                :disabled="
                                                    user.organizer
                                                        .account_status ===
                                                    'verified'
                                                "
                                                :selected="
                                                    user.organizer
                                                        .account_status ===
                                                    'verified'
                                                "
                                                value="verified"
                                            >
                                                Zweryfikowany
                                            </option>
                                            <option
                                                :disabled="
                                                    user.organizer
                                                        .account_status ===
                                                    'denied'
                                                "
                                                :selected="
                                                    user.organizer
                                                        .account_status ===
                                                    'denied'
                                                "
                                                value="denied">
                                                Odrzucony
                                            </option>
                                            <option
                                                :disabled="
                                                    user.organizer
                                                        .account_status ===
                                                    'pending'
                                                "
                                                :selected="
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
            <div class="event-pagination pb-75px">
                <ul class="ml-auto mr-auto">
                    <li
                        v-for="page in props.users.meta.links"
                        :key="page"
                        :class="{ 'page-current': page.active }"
                        class="page"
                    >
                        <Link :href="page.url" v-html="page.label"></Link>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
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
