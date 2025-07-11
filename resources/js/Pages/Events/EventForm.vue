<script setup>
import ResetObject from "@/Utilities/resetObject";
import {router} from "@inertiajs/vue3";
import {computed} from "vue";
import {Link} from "@inertiajs/vue3";
import {reactive, ref} from "vue";
import useAuth from "@/Utilities/useAuth";
import {debounce} from "@/Utilities/debounce";
import axios from "axios";
import {onMounted} from "vue";

const {user, isLoggedIn} = useAuth();

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    user_data: {
        type: Object,
        required: false,
    },
});

console.log(props);

const showTaxField = computed(() => {
    return (paymentForm.company !== null) || props.user_data.tax_number;
})

const errors = reactive({});
const liveErrors = reactive({});

const paymentForm = reactive({
    first_name: null,
    last_name: null,
    email: null,
    phone: null,
    company: null,
    tax_number: null,
    country: null,
    city: null,
    street: null,
    house_number: null,
    zip_code: null,
    save_data: null, // checkbox
    make_account: null,// checkbox
    name: null, // nazwa konta
    password: null,
    password_confirmation: null,
});

function SubmitPaymentDetails() {
    console.log(paymentForm);

    router.post(
        route('event-ticket.buy.form.details.post', {
            order_number: props.order.order_number
        }),
        paymentForm, {
            preserveScroll: true,
            onError: (err) => {
                ResetObject(errors);
                Object.assign(errors, err);
                console.log(errors);
            },
            onSuccess: (test) => {
                console.log(test);
            },
        })
}

let canSubmit = ref(false);

function HandleValidationResponse(routeName, response) {
    liveErrors.name = response.data.message;
    canSubmit.value = response.data.valid;
    console.log(`${routeName} valid:`, response.data.valid);
}

const validationRequest = debounce((routeName) => {
    axios
        .post(route(routeName), paymentForm)
        .then((response) => {
            HandleValidationResponse(routeName, response);
        })
        .catch((error) => {
            console.error(error);
        });
}, 1000);

onMounted(() => {
    Object.keys(props.user_data).forEach((key) => {
        props.user_data[key] ? paymentForm[key] = props.user_data[key] : '';
    });
});
</script>

<template>
    <section class="pt-60px pb-60px">
        <div class="container d-flex flex-column">
            <h2 class="mb-40px">Podaj szczegóły płatności</h2>
            <div>
                <form class="form pb-100px" @submit.prevent="SubmitPaymentDetails()">
                    <div class="input-wrap col-12 col-lg-6">
                        <label for="name">Imię *</label>
                        <input
                            id="name"
                            v-model="paymentForm.first_name"
                            aria-required="true"
                            autocomplete="first_name"
                            name="name"
                            required=""
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.first_name" class="error-msg">
                            {{ errors.first_name }}
                        </div>
                    </div>
                    <div class="input-wrap col-12 col-lg-6">
                        <label for="last_name">Nazwisko *</label>
                        <input
                            id="last_name"
                            v-model="paymentForm.last_name"
                            aria-required="true"
                            autocomplete="last_name"
                            name="last_name"
                            required=""
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.last_name" class="error-msg">
                            {{ errors.last_name }}
                        </div>
                    </div>
                    <div class="input-wrap col-12 col-lg-6">
                        <label for="email">E-mail *</label>
                        <input
                            id="email"
                            v-model="paymentForm.email"
                            aria-required="true"
                            autocomplete="email"
                            name="email"
                            required=""
                            spellcheck="false"
                            type="email"
                        />
                        <div v-if="errors.email" class="error-msg">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="input-wrap col-12 col-lg-6">
                        <label for="phone">Telefon *</label>
                        <input
                            id="phone"
                            v-model="paymentForm.phone"
                            aria-required="true"
                            autocomplete="phone"
                            name="phone"
                            required=""
                            spellcheck="false"
                            type="tel"
                        />
                        <div v-if="errors.phone" class="error-msg">
                            {{ errors.phone }}
                        </div>
                    </div>
                    <div class="input-wrap col-12 ">
                        <label for="company">Firma</label>
                        <input
                            id="company"
                            v-model="paymentForm.company"
                            aria-required="false"
                            autocomplete="company"
                            name="company"
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.company" class="error-msg">
                            {{ errors.company }}
                        </div>
                    </div>
                    <div v-if="showTaxField" class="input-wrap col-12 ">
                        <label for="company">NIP</label>
                        <input
                            id="company"
                            v-model="paymentForm.tax_number"
                            aria-required="false"
                            autocomplete="company"
                            name="company"
                            spellcheck="false"
                            type="text"
                            v-number-only
                        />
                        <div v-if="errors.tax_number" class="error-msg">
                            {{ errors.tax_number }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="country">Kraj *</label>
                        <input
                            id="country"
                            v-model="paymentForm.country"
                            aria-required="true"
                            autocomplete="country"
                            name="country"
                            required=""
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.country" class="error-msg">
                            {{ errors.country }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="city">Miasto *</label>
                        <input
                            id="city"
                            v-model="paymentForm.city"
                            aria-required="true"
                            autocomplete="city"
                            name="city"
                            required=""
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.city" class="error-msg">
                            {{ errors.city }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="street">Ulica *</label>
                        <input
                            id="street"
                            v-model="paymentForm.street"
                            aria-required="true"
                            autocomplete="street"
                            name="street"
                            required=""
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.street" class="error-msg">
                            {{ errors.street }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="house_number">Numer domu/mieszkania *</label>
                        <input
                            id="house_number"
                            v-model="paymentForm.house_number"
                            aria-required="true"
                            autocomplete="house_number"
                            name="house_number"
                            required=""
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.house_number" class="error-msg">
                            {{ errors.house_number }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="zip_code">Kod pocztowy *</label>
                        <input
                            id="zip_code"
                            v-model="paymentForm.zip_code"
                            aria-required="true"
                            autocomplete="zip_code"
                            name="zip_code"
                            required=""
                            spellcheck="false"
                            type="text"
                        />
                        <div v-if="errors.zip_code" class="error-msg">
                            {{ errors.zip_code }}
                        </div>
                    </div>
                    <div v-if="user" class="input-wrap d-flex flex-row align-items-center col-12">
                        <input id="save_data" v-model="paymentForm.save_data" type="checkbox">
                        <label for="save_data">Zapisz dane do przyszłych transakcji</label>
                    </div>
                    <div v-else class="input-wrap input-wrap-check  align-items-center col-12">
                        <input id="make_account" v-model="paymentForm.make_account" type="checkbox">
                        <label for="make_account">Stwórz konto z podanymi danymi zapamiętać je na przyszłość</label>
                    </div>
                    <div v-if="paymentForm.make_account">
                        <div class="input-wrap col-12">
                            <label for="name">Nazwa konta</label>
                            <input
                                id="name"
                                v-model="paymentForm.name"
                                aria-required="true"
                                autocomplete="name"
                                name="name"
                                required=""
                                spellcheck="false"
                                type="text"
                                @input="validationRequest('verification.user')"
                            />
                            <div v-if="errors.name" class="error-msg">
                                {{ errors.name }}
                            </div>
                            <div v-if="liveErrors.name" class="error-msg">
                                {{ liveErrors.name }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-password">Hasło *</label>
                            <input
                                id="register-password"
                                v-model="paymentForm.password"
                                aria-required="true"
                                name="password"
                                required=""
                                type="password"
                            />
                            <div v-if="errors.password" class="error-msg">
                                {{ errors.password }}
                            </div>
                        </div>
                        <div class="input-wrap col-12">
                            <label for="register-password-confirm"
                            >Potwierdź Hasło *</label
                            >
                            <input
                                id="register-password-confirm"
                                v-model="paymentForm.password_confirmation"
                                aria-required="true"
                                name="password_confirmation"
                                required=""
                                type="password"
                            />
                            <div
                                v-if="errors.password_confirmation"
                                class="error-msg"
                            >
                                {{ errors.password_confirmation }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <input v-if="isLoggedIn" type="submit">
                        <input v-else :class="{ disabled: !canSubmit && paymentForm.make_account }" :disabled="!canSubmit && paymentForm.make_account" type="submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>

</style>
