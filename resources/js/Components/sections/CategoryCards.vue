<script setup>
defineProps({
  source: String,
  heading: String,
  link: String,
  Ecount: Number
});

</script>

<template>
<div class="cat" v-bind="$attrs" >
    <img class="cat-img" :src="source" alt="">
    <h3 class="cat-title">{{ heading }}</h3>
    <p class="cat-desc">{{ Ecount }} Events</p>
    <a class="link-stretched" :href="link"></a>
</div>
</template>

<style scoped>
.cat{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  text-align: center;
  border: 2px solid var(--gray4);
  border-radius: 5px;
  transition: 0.4s;
  padding: 40px 5px;
  position: relative;
}
.cat:hover{
    border-color:var(--orange);
}
.cat-img{
width: 50px;
height: 50px;
object-fit: contain;
margin-bottom: 17px;
}
.cat-title{
  font-size: 22px;
  line-height: 1.2;
  color: var(--black);
  font-weight: 600;
  transition: 0.4s;
}
.cat-desc{
  font-size: 16px;
  line-height: 1.2;
  margin-top: 8px;
  color: #333 !important;
}

</style>