<script setup>
import Tab from "@/Components/sections-new/Tab.vue";
import Tabs from "@/Components/sections-new/Tabs.vue";
</script>

<template>
    <section class="pt-100px pb-100px">
        <div
            class="container flex-column align-items-center justify-content-center"
        >
            <form action="" class="form">
                <div class="input-wrap col-12 mb-20px">
                    <input type="checkbox" name="notif1" id="notif1" />
                    <label for="notif1">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 1
                    </label>
                </div>
                <div class="input-wrap col-12 mb-20px">
                    <input type="checkbox" name="notif2" id="notif2" />
                    <label for="notif2">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 2
                    </label>
                </div>
                <div class="input-wrap col-12 mb-20px">
                    <input type="checkbox" name="notif3" id="notif3" />
                    <label for="notif3">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 3
                    </label>
                </div>
                <div class="input-wrap col-12 mb-20px">
                    <input type="checkbox" name="notif4" id="notif4" />
                    <label for="notif4">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Powiadomienie 4
                    </label>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Zapisz zmiany" />
                </div>
            </form>
        </div>
    </section>
    <section class="pt-100px pb-100px">
        <div class="container flex-column align-items-center">
            <h3 class="mb-30px">Czy na pewno chcesz usunąć swoje konto ?</h3>
            <form action="" class="form">
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="register-password-confirm"
                        >Potwierdź uzywająć Hasła *</label
                    >
                    <input
                        type="password"
                        name="password_deleteacc"
                        id="register-password-confirm"
                        autocomplete="register-password-confirm"
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap col-12 mb-35px">
                    <input type="checkbox" name="notif4" id="notif4" />
                    <label for="notif4">
                        Czy na pewno pewno jesteś pewny
                    </label>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Usuń konto" />
                </div>
            </form>
        </div>
    </section>
</template>

<style lang="scss"></style>
