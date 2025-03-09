<script setup>
defineProps({
  id:Number,
  bg: String,
  link: String,
  Ecount: Number,
  location: {
      type: Array,
      required: true,
    },
});

</script>

<template>
    <div class="location" v-bind="$attrs">
        <a :href="link" class="link-stretched z-1"></a>
        <img :src="bg" alt="">
        <div class="location-content">
            <h3 class="location-name">
        <template v-for="(loc) in location" :key="loc.name">
          <a class="text-white hover-orange" :href="loc.href">{{ loc.name }}</a>
        
        </template>
            </h3>
            <p class="location-events">
                    {{ Ecount }} Events
            </p>

        </div>
    </div>
</template>

<style scoped>
.location{
    position: relative;
/* for now*/
min-height: 275px;
}
.location-content{
    position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding-left: 30px;
  padding-top: 30px;
  padding-bottom: 18px;
  background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.9));
  z-index: 2;
}
.location img{
    width: 100%;
    height: 100%;
    object-fit:cover;
    border-radius: 5px;
}
.location:hover .location-events{
  line-height: 1.2;
  visibility: visible;
  opacity: 1;
}
.location-name{
  margin: 0;
  font-size: 20px;
  color: #fff;
  line-height: 22px;
  font-weight: 600;
  transition: 0.4s;
}
.location-events{
  font-size: 15px;
  color: #fff;
  line-height: 0;
  opacity: 0;
  visibility: hidden;
  transition: 0.4s;
  margin-top: 6px;
}
</style>
