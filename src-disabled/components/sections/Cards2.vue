<script setup>
defineProps({
  source: String,
  heading: String,
  desc: String,
});

</script>

<template>
    <div class="card" v-bind="$attrs">
      <div class="card-bg">
        <img class="card-img" :src="source" alt="">
      </div>
        
        <h3 class="title">{{ heading }}</h3>
        <p class="sub-title">{{ desc }}</p>
    </div>
</template>

<style scoped>
.card{
  display: flex;
  flex-direction: column;
  text-align: center;
  justify-content: center;
  align-items: center;
}
@media screen and (max-width:991px){
  .card{
      margin-bottom:50px;
  }
}
.card-bg{
  width: 168px;
  height: 168px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 100%;
  background-color: var(--lightgrey);
  margin-bottom: 25px;
  transition: all 0.4s;
}
.card-bg:hover{
  transform: scale(1.1, 1.1);
}
.card-img{
  width: 70px;
  height: 70px;
}

</style>