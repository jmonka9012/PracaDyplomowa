<script setup>
import { Head } from '@inertiajs/vue3';
import MainFooter from "../Components/sections-new/MainFooter.vue";
import MainHeader from "../Components/header/MainHeader.vue";

const props = defineProps({
    auth: Object,
    title: String
});
</script>

<template>
    <div>
        <Head>
            <title>{{ title || $page.props.site_data?.title }}</title>
        </Head>

        <MainHeader />
        <slot />
        <MainFooter />
    </div>
</template>
