<script setup>
  defineProps({
    bg: String,
    source: String,
    heading: String,
    date: String,
    category: String,
    category_link: String,
    price: Number,
    location: {
      type: Array,
      required: true,
    },
  })
</script>

<template>
  <div class="d-flex flex-column" v-bind:class="$attrs">
    <div class="relative d-flex">
      <a class="link-stretched z-1" :href="source"></a>
      <img class="event-img" :src="bg" alt="" />
      <a class="event-cat" :href="category_link">{{ category }}</a>
    </div>
    <div class="event-content">
      <h2 class="mb-25px">{{ heading }}</h2>
      <div class="d-flex flex-row align-items-center mb-5px">
        <i class="fa fa-clock mr-5px"></i>
        <p>{{ date }}</p>
      </div>
      <div class="d-flex flex-row align-items-center">
        <i class="fa fa-map-marker mr-5px"></i>
        <template v-for="(loc, index) in location" :key="loc.name">
          <a class="text-gray2 hover-orange" :href="loc.href">{{ loc.name }}</a>
          <span v-if="index < location.length - 1">, </span>
        </template>
      </div>
      <div class="d-flex flex-row">
        <a :href="source"></a>
      </div>
      <div class="d-flex flex-row justify-content-between mt-25px">
        <button class="buy" :href="source">Get ticket</button>
        <p class="text-orange event-price">${{ price }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .event-img {
    position: relative;
    border-radius: 5px 5px 0 0;
    width: 100%;
  }
  .event-cat {
    display: inline-block;
    font-size: 14px;
    line-height: 20px;
    color: white;
    padding: 3px 12px 2px 12px;
    transition: 0.4s;
    border-radius: 3px;
    background-color: #dfc881;
    position: absolute;
    bottom: 20px;
    left: 25px;
    z-index: 1;
  }
  .event-cat:hover {
    background-color: var(--orange);
  }

  .event-content {
    padding: 22px 30px 30px 30px;
    border: 1px solid #eae9f3;
    border-top: none;
    border-radius: 0 0 5px 5px;
    background: white;
  }
  .event-content .fa{
    color: #888;
  }
  .event-cat:hover {
    background-color: #e86c60 !important;
  }
  .buy {
    display: inline-block;
    background-color: white;
    font-size: 15px;
    line-height: 26px;
    font-weight: 600;
    border: 2px solid #cccccc;
    padding: 3px 18px 2px 17px;
    border-radius: 3px;
    transition: 0.4s;
  }
  .buy:hover {
    background-color: var(--orange);
    border-color: var(--orange);
    color: #fff;
  }
  .event-price {
    font-size: 20px;
    line-height: 26px;
    font-weight: 600;
  }
</style>
