<template>
    <div>
        <h1>{{ message }}</h1>
        <p>test</p>
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
};
</script>
