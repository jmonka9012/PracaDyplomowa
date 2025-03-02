<template>
    <div>
        <h1>{{ message }}</h1>
    </div>
</template>

<script>
export default {
    props: {
        message: String,
    },
    mounted() {
        console.log('Props:', this.$props);
    }
};z
</script>
