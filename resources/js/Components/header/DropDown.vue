<template>
  
</template>
  <script>
  import { ref } from "vue";
export default {
  props: ["title"],
  setup(props) {
    const show = ref(false);
    return {
      show,
    };
  },
};

  </script>
