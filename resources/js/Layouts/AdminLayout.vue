<script setup>
import { Head } from '@inertiajs/vue3';
import MainFooter from "@/Components/sections-new/MainFooter.vue";
import AdminHeader from "@/Components/header/AdminHeader.vue";

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

        <AdminHeader />
        <slot />
        <MainFooter />
    </div>
</template>
