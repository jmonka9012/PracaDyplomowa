<script setup>
import ResetObject from "@/Utilities/resetObject";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { reactive } from "vue";
import useAuth from "@/Utilities/useAuth";

const { user, isLoggedIn } = useAuth();


const props = defineProps({
  order: Object
});


const errors = reactive({});

const paymentForm = reactive({
    first_name: null,
    last_name: null,
    email: null,
    phone: null,
    country: null,
    city: null,
    street: null,
    house_number: null,
    zip_code: null,
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
        },
        onSuccess: (test) => {
            console.log(test);
        },
    })
}
</script>

<template>
    <section>
        <div class="container d-flex flex-column">
            <h2 class="mb-40px">Podaj szczegóły płatności</h2>
            <div>
                <form @submit.prevent="SubmitPaymentDetails()">
                    <div class="input-wrap col-12">
                        <label for="name">Imię *</label>
                        <input
                            type="text"
                            id="name"
                            autocomplete="first_name"
                            name="name"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.first_name"
                        />
                        <div class="error-msg" v-if="errors.first_name">
                            {{ errors.first_name }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="last_name">Nazwisko *</label>
                        <input
                            type="text"
                            id="last_name"
                            autocomplete="last_name"
                            name="last_name"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.last_name"
                        />
                        <div class="error-msg" v-if="errors.last_name">
                            {{ errors.last_name }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="email">E-mail *</label>
                        <input
                            type="email"
                            id="email"
                            autocomplete="email"
                            name="email"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.email"
                        />
                        <div class="error-msg" v-if="errors.email">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="phone">Telefon *</label>
                        <input
                            type="tel"
                            id="phone"
                            autocomplete="phone"
                            name="phone"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.phone"
                        />
                        <div class="error-msg" v-if="errors.phone">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="country">Kraj *</label>
                        <input
                            type="text"
                            id="country"
                            autocomplete="country"
                            name="country"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.country"
                        />
                        <div class="error-msg" v-if="errors.country">
                            {{ errors.country }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="city">Miasto *</label>
                        <input
                            type="text"
                            id="city"
                            autocomplete="city"
                            name="city"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.city"
                        />
                        <div class="error-msg" v-if="errors.city">
                            {{ errors.city }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="street">Ulica *</label>
                        <input
                            type="text"
                            id="street"
                            autocomplete="street"
                            name="street"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.street"
                        />
                        <div class="error-msg" v-if="errors.street">
                            {{ errors.street }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="house_number">Numer domu/mieszkania *</label>
                        <input
                            type="text"
                            id="house_number"
                            autocomplete="house_number"
                            name="house_number"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.house_number"
                        />
                        <div class="error-msg" v-if="errors.house_number">
                            {{ errors.house_number }}
                        </div>
                    </div>
                    <div class="input-wrap col-12">
                        <label for="zip_code">Kod pocztowy *</label>
                        <input
                            type="text"
                            id="zip_code"
                            autocomplete="zip_code"
                            name="zip_code"
                            spellcheck="false"
                            required=""
                            aria-required="true"
                            v-model="paymentForm.zip_code"
                        />
                        <div class="error-msg" v-if="errors.zip_code">
                            {{ errors.zip_code }}
                        </div>
                    </div>
                    <input type="submit">
                </form>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">

</style>
