<script setup>
const props = defineProps({
    show: Boolean,
});
</script>

<template>
    <div v-if="show" @click.self="$emit('close')" class="popup-holder">
        <div class="popup">
            <form class="form">
                <div class="input-wrap d-flex flex-column col-12">
                    <label for="my-account-confirm"
                        >Podaj Hasło, aby potwierdzić zmiane</label
                    >
                    <input
                        type="text"
                        id="my-account-confirm"
                        autocomplete="my-account-confirm"
                        name="my-account-confirm"
                        spellcheck="false"
                        value=""
                        required=""
                        aria-required="true"
                    />
                </div>
                <div class="input-wrap d-flex flex-column col-12">
                    <input type="submit" value="Zaktualizuj" />
                </div>
            </form>
            <button class="popup__close" @click="$emit('close')">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>
</template>

<style lang="scss">
.popup-holder {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.popup {
    background-color: white;
    flex-direction: column;
    padding: 20px;
    border-radius: 8px;
    position: relative;
    &__close {
        background-color: white;
        border: 0px solid transparent;
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 0;
        i {
            font-size: 26px;
        }
    }
}
</style>
