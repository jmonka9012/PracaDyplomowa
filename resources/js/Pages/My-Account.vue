<script setup>
import Popup from "@/Components/Partials/Popup.vue";
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";
import useAuth from "@/Utilities/useAuth";
import ResetObject from "@/Utilities/resetObject";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, reactive, toRaw } from "vue";
import axios from "axios";

const showModal = ref(false);
const { user, isLoggedIn } = useAuth();

const props = defineProps({
    support_tickets: {
        type: Array,
        required: true,
    },
});

console.log(props);

let currentRequest;
const Logout = () => {
    router.post(route("logout"), {});
};

const TestEmail = () => {
    router.post(route("test-email"), {});
};

const fNameForm = reactive({
    first_name: null,
});

const lNameForm = reactive({
    last_name: null,
});

const emailForm = reactive({
    email: null,
});

const passwordForm = reactive({
    password: null,
});

const contactForm = reactive({
    topic: null,
    message: null,
});

const supportTicketError = ref(null);

const organizer = reactive({});

function GetOrganizerInfo() {
    if (user.value.permission_level === 4) {
        axios
            .get(route('organizer.status'))
            .then((response) => {
                Object.assign(organizer, response.data);
            })
            .catch((error) => {
                console.error(error);
            })
        console.log(organizer);
    }
}
GetOrganizerInfo();

const errors = reactive({});
const ticketErrors = reactive({});

function handleSubmitClick(form) {
    showModal.value = true;
    currentRequest = form;
}

const handleValidationEmit = (state) => {
    if (state === true) {
        router.post(route("my-account.change"), currentRequest, {
            onError: (err) => {
                ResetObject(errors);
                Object.assign(errors, err); //errory do poprawienia
            },
            onSuccess: (page) => {
                currentRequest = null;
                showModal.value = false;
            },
        });
    }
};

function SendTicket() {

    axios
        .post(route("support-ticket-send"), contactForm)
        .then((response) => {
            ResetObject(contactForm);
            router.reload({
                preserveState: true,
                preserveScroll: true,
            })
            console.log(response);
        })
        .catch((error) => {
            supportTicketError.value = error.response.data.throttle;
            console.error(supportTicketError);
        })

}
</script>

<template>
    <section class="ma-hero"></section>
    <section class="bg-grey">
        <div class="container flex-lg-row column-mob-reverse">
            <div class="col-12 d-flex flex-column ma-rcol pl-lg-60px">
                <!--                <div class="bcrumb text-white mb-32px">
                                    <a href="">Prev</a>
                                    <span class="divider divider-star"></span>
                                    <a class="bcrumb__cur" href="">Current</a>
                                </div>-->
                <h1 class="ma-title">Mój profil</h1>
                <Tabs class="tabs-white">
                    <Tab title="Moje informacje">
                        <div
                            class="d-flex align-items-center column-gap-10px mb-32px"
                        >
                            <h3 class="ma-ftitle">Moje informacje</h3>
                            <i class="fa fa-user"></i>
                        </div>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(fNameForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="first-name-input">Imię</label>
                                <input
                                    type="text"
                                    id="change-first-name"
                                    autocomplete="first-name-input"
                                    name="first-name-input"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    :placeholder="user.first_name"
                                    v-model="fNameForm.first_name"
                                />
                            </div>
                            <div class="error-msg" v-if="errors.first_name">
                                {{ errors.first_name }}
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    value="zaktualizuj szczegóły"
                                    type="submit"
                                    class="form-submit"
                                />
                            </div>
                        </form>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(lNameForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="last-name-input">Nazwisko</label>
                                <input
                                    type="text"
                                    id="change-last-name"
                                    autocomplete="last-name-input"
                                    name="last-name-input"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    :placeholder="user.last_name"
                                    v-model="lNameForm.last_name"
                                />
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    type="submit"
                                    value="zaktualizuj szczegóły"
                                />
                            </div>
                        </form>

                        <h3 class="ma-ftitle">Adres Email</h3>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(emailForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="change-email">Email</label>
                                <input
                                    type="text"
                                    id="change-email"
                                    autocomplete="change-email"
                                    name="change-email"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    :placeholder="user.email"
                                    v-model="emailForm.email"
                                />
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    type="submit"
                                    value="Zaktualizuj E-mail"
                                />
                            </div>
                        </form>
                        <h3 class="ma-ftitle">Zmień hasło</h3>
                        <form
                            class="form form-ma"
                            @submit.prevent="handleSubmitClick(passwordForm)"
                        >
                            <div class="input-wrap d-flex flex-column col-12">
                                <label for="change-password">Hasło</label>
                                <input
                                    type="password"
                                    id="change-password"
                                    autocomplete="change-password"
                                    name="change-password"
                                    spellcheck="false"
                                    value=""
                                    required=""
                                    aria-required="true"
                                    v-model="passwordForm.password"
                                />
                            </div>
                            <div class="input-wrap col-12">
                                <input
                                    type="submit"
                                    value="Zaktualizuj Hasło"
                                />
                            </div>
                        </form>
                        <h3 class="ma-ftitle">Potwierdź Email</h3>
                        <form class="form form-ma">
                            <div class="input-wrap d-flex flex-column col-12">
                                <input type="submit" value="Potwierdź" />
                            </div>
                        </form>
                    </Tab>
                    <Tab title="Moje bilety">
                        <div
                            class="d-flex align-items-center column-gap-10px mb-32px"
                        >
                            <h3 class="ma-ftitle">Moje bilety</h3>
                            <i class="fa fa-ticket"></i>
                        </div>
                    </Tab>
                    <Tab title="Obsługa klienta">
                        <div
                            class="d-flex flex-column align-items-center column-gap-10px mb-32px"
                        >
                            <h3 class="fs-36 mb-20px">Wyślij zapytanie</h3>
                            <form
                                class="form mb-10px ml-auto mr-auto"
                                @submit.prevent="SendTicket"
                            >
                                <div class="input-wrap col-12">
                                    <input
                                        v-model="contactForm.topic"
                                        type="text"
                                        required
                                        name="contact-topic"
                                        placeholder="Temat wiadomości*"
                                    />
                                </div>
                                <div
                                    class="error-msg"
                                    v-if="ticketErrors.topic"
                                >
                                    {{ ticketErrors.topic }}
                                </div>
                                <div class="input-wrap col-12">
                                    <textarea
                                        v-model="contactForm.message"
                                        name="contact-message"
                                        id=""
                                        placeholder="Wiadomość"
                                    ></textarea>
                                </div>
                                <div
                                    class="error-msg"
                                    v-if="ticketErrors.message"
                                >
                                    {{ ticketErrors.message }}
                                </div>
                                <p class="mb-16px">
                                    Jeżeli chcesz zwrotu pieniędzy za bilet
                                    umieść wszystkie dane odnośnie transakcji
                                    takie jak ID biletu, data, wydarzenie tak
                                    aby dział księgowości mógł odnaleść
                                    płatność.
                                </p>
                                <input type="submit" value="wyślij" />
                            </form>
                            <div v-if="supportTicketError" class="error-msg mb-30px">{{supportTicketError}}</div>
                            <h3 class="mb-30px">Twoje zapytania</h3>
                            <div class="support-tickets">
                                <div
                                    class="support-tickets__ticket"
                                    v-for="ticket in props.support_tickets.data"
                                >
                                    <div
                                        class="d-flex justify-content-center align-items-center mb-10px mb-lg-0"
                                    >
                                        {{ ticket.topic }}
                                    </div>
                                    <div
                                        class="d-flex justify-content-center align-items-center mb-10px mb-lg-0"
                                    >
                                        {{ ticket.created_at }}
                                    </div>
                                    <div
                                        v-html="
                                            ticket.status === 'in_progress'
                                                ? 'W trakcie rozpatrywania'
                                                : 'Zamknięte'
                                        "
                                        :class="{
                                            'in-progress':
                                                ticket.status === 'in_progress',
                                            closed: ticket.status === 'closed',
                                        }"
                                        class="support-tickets__status"
                                    ></div>
                                    <div class="support-tickets__message">
                                        <div>
                                            {{ ticket.message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Tab>
                    <Tab v-if="user.permission_level === 4" title="Sczegóły sprzedawcy">
                        <div
                            class="d-flex align-items-center column-gap-10px mb-32px"
                        >
                            <h3 class="ma-ftitle">Szcegóły sprzedawcy</h3>
                            <i class="fa fa-user"></i>
                        </div>
                        <div>
                            <div v-if="organizer.organizer_details" >
                                <div v-if="organizer.organizer_details.company_name" class="flex-row d-flex">
                                    <div class="col-6">Nazwa firmy</div>
                                    <div class="col-6">{{organizer.organizer_details.company_name}}</div>
                                </div>
                                <div v-if="organizer.organizer_details.address" class="flex-row d-flex">
                                    <div class="col-6">Adres</div>
                                    <div class="col-6">{{organizer.organizer_details.address}}</div>
                                </div>
                                <div v-if="organizer.organizer_details.bank_account_number" class="flex-row d-flex">
                                    <div class="col-6">Numer konta bankowego</div>
                                    <div class="col-6">{{organizer.organizer_details.bank_account_number}}</div>
                                </div>
                                <div v-if="organizer.organizer_details.phone_number" class="flex-row d-flex">
                                    <div class="col-6">Numer telefonu</div>
                                    <div class="col-6">{{organizer.organizer_details.phone_number}}</div>
                                </div>
                                <div v-if="organizer.organizer_details.tax_number" class="flex-row d-flex">
                                    <div class="col-6">{{organizer.organizer_details.tax_number}}</div>
                                </div>
                            </div>
                            <div class="error-msg" v-else-if="organizer.message">{{organizer.message}}</div>
                        </div>
                    </Tab>
                </Tabs>
            </div>
        </div>
    </section>
    <Popup
        :show="showModal"
        @close="showModal = false"
        @password-validation-success="handleValidationEmit"
    ></Popup>
</template>

<style lang="scss">
@use "~css/mixin.scss";

.support-tickets {
    width: 100%;
    display: grid;

    &__ticket {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr;
        margin-bottom: 40px;
        @include mixin.media-breakpoint-up(lg) {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    &__message {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;

        @include mixin.media-breakpoint-up(lg) {
            grid-column: 1 / 4;
            margin-top: 32px;
        }
        div {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            border: 1px solid var(--primary);
            background-color: rgba(195, 185, 239, 0.0509803922);
            padding: 20px 50px;
            border-radius: 12px;
            @include mixin.media-breakpoint-up(lg) {
                width: 80%;
            }
        }
    }

    &__status {
        width: 100%;
        border-radius: 8px;
        padding: 8px 16px;
        display: flex;
        justify-content: center;

        &.in-progress {
            background-color: var(--primary);
        }

        &.closed {
            background-color: var(--yellow);
        }
    }
}

.ma-hero {
    background-color: var(--primary);
    min-height: 380px;
}

.ma-ftitle {
    font-size: 32px;
    line-height: 48px;
    color: var(--text);
    font-weight: 500;
}

.ma-title {
    font-size: 32px;
    font-stretch: normal;
    line-height: 1.21;
    letter-spacing: 0.56px;
    text-align: left;
    margin-bottom: 30px;
    color: white;
}

.ma-divider {
    margin: 32px 0px 0px;
    border-width: 1px 0px 0px;
    border-style: solid none none;
    border-color: rgb(223, 228, 231);
    box-sizing: content-box;
    height: 0px;
    overflow: visible;
}

.ma-lcol-intro {
    padding: 32px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    background-color: rgba(255, 255, 255, 0.1);

    @include mixin.media-breakpoint-up(lg) {
        min-height: 200px;
    }
}

.ma-lcol-content {
    padding: 16px 0 88px;
    background-color: rgb(255, 255, 255);
    box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 10px 3px;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.ma-lcol-nav {
    color: rgb(18, 18, 18);

    ul {
        padding-bottom: 5px;
        margin-bottom: 5px;
        position: relative;

        &::after {
            width: calc(100% - 32px);
            left: 16px;
            right: 16px;
            background-color: var(--primary);
            height: 1px;
            display: block;
            position: absolute;
            content: "";
            bottom: 0;
        }

        li {
            position: relative;

            button {
                padding: 16px 64px;
                background-color: transparent;
                border: 0;
                font-size: 16px;
                font-weight: 500;
                font-family: "Prompt";
                width: 100%;
                text-align: start;

                &:hover {
                    background-color: #f6f6f6;
                    text-decoration: underline;
                }

                i {
                    position: absolute;
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    left: 24px;
                    color: rgb(100, 100, 100);
                }
            }

            a {
                padding: 12px 24px 12px 64px;
                color: rgb(18, 18, 18);
                font-size: 16px;
                line-height: 1.5;
                letter-spacing: 0.32px;
                width: 100%;

                &.user-functions {
                    padding-left: 24px;
                }

                &:hover {
                    background-color: #f6f6f6;
                    text-decoration: underline;
                }
            }
        }

        &:last-of-type {
            &::after {
                display: none;
            }
        }
    }
}

.ma-rcol {
    margin-top: -240px;
    margin-bottom: 35px;
    @include mixin.media-breakpoint-up(lg) {
        margin-bottom: 70px;
    }

    .tabs__content {
        min-height: 1260px;
        @include mixin.media-breakpoint-up(lg) {
            min-height: 1430px;
        }
    }

    .fa {
        font-size: 30px;
    }
}

.ma-lcol {
    @include mixin.media-breakpoint-up(lg) {
        margin-top: -200px;
    }
}
</style>
