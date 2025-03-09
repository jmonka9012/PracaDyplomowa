<script setup>
import { ref } from "vue"
defineProps({
  source: String,
  heading: String,
  desc: String,
  link: String,
  link: {
    type: Array,
    required: true,
  },
})
const selected = ref("") 
</script>

<template>
  <section class="hero" :style="{ backgroundImage: `url(${source})` }">
    <div class="container flex-column align-items-center">
      <h2 class="hero-title">{{ heading }}</h2>
      <p class="hero-desc">
        {{ desc }}
      </p>
      <form class="hero-form" action="submit">
        <div class="input-wrap hero-input-wrap">
          <i class="fa fa-search"></i>
          <input class="hero-input" type="text" placeholder="Enter name ..." />
        </div>
        <div class="input-wrap hero-select-wrap">
          <i class="fa fa-th-list"></i>
          <select class="hero-select" v-model="selected">
            <option disabled value="">Please select one</option>
            <option>Buisness</option>
            <option>Concert</option>
            <option>Music</option>
            <option>Conference</option>
            <option>Education</option>
            <option>Fashion</option>
            <option>Festival</option>
            <option>Food & drink</option>
            <option>Other</option>
            <option>Sport</option>
          </select>
        </div>
        <div class="input-wrap hero-select-wrap">
          <i class="fa fa-map-marker"></i>
          <select class="hero-select" v-model="selected">
            <option disabled value="">All time</option>
            <option>Today</option>
            <option>Tommorow</option>
            <option>This week</option>
            <option>This weekend</option>
            <option>Next week</option>
            <option>Next month</option>
          </select>
        </div>
        <button class="hero-search btn btn-or-gr">Search</button>
      </form>
      <div class="hero-events">
        <a :href="link.href">
          {{ link.text }} - <span class="text-orange">{{ link.date }}</span>
        </a>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  transition:
    background 0.3s,
    border 0.3s,
    border-radius 0.3s,
    box-shadow 0.3s;
  background-position: center center;
  background-repeat: no-repeat;
  background-size: cover;
  margin-top: -76px;
  margin-bottom: 0px;
  padding: 120px 0px 80px 0px;
  color: white;
  text-align: center;
  position: relative;
}

@media screen and (min-width: 768px) {
  .hero {
    padding: 242px 0px 210px 0px;
  }
}

.hero::after {
  background-color: rgba(0, 0, 0, 0.42);
  opacity: 0.73;
  transition:
    background 0.3s,
    border-radius 0.3s,
    opacity 0.3s;
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: block;
  z-index: 0;
  content: "";
}

.hero .container {
  z-index: 1;
  position: relative;
}

.hero-title {
  color: white;
  font-size: 35px;
  line-height: 1;
  margin-bottom: 20px;

  font-weight: 900;
}

@media screen and (min-width: 768px) {
  .hero-title {
    font-size: 66px;
  }
}

.hero-desc {
  font-size: 18px;
}

@media screen and (min-width: 768px) {
  .hero-desc {
    font-size: 20px;
  }
}

.hero-form {
  margin: 40px 0px 45px 0px;
  width: 100%;
  display: flex;
  flex-direction: column;
  row-gap: 20px;
}

@media screen and (min-width: 992px) {
  .hero-form {
    flex-direction: row;
    margin: 58px 0px 20px 0px;
  }
}

.input-wrap {
  position: relative;
}

.input-wrap .fa {
  position: absolute;
  color: var(--orange);
  position: absolute;
  left: 20px;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
  font-size: 20px;
  display: block;
}

.hero-input,
.hero-select {
  box-shadow: none;
  min-height: 60px;
  font-size: 15px;
  display: block;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  appearance: none;
  transition:
    border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out;
  width: 100%;
  padding-left: 55px;
}

.hero-input:focus,
.hero-select:focus {
  outline: none;
}

.hero-input-wrap {
  width: 100%;
}

.hero-select-wrap {
  width: 100%;
}

.hero-search {
  width: 100%;
}

@media screen and (min-width: 992px) {
  .hero-input-wrap {
    width: 30%;
  }

  .hero-select-wrap {
    width: 25%;
  }

  .hero-search {
    width: 20%;
  }
}

.hero-select option {
  padding: 6px 20px !important;
  appearance: none;
  font-family: Poppins;
  font-weight: 400;
  font-size: 16px;
  line-height: 23px;
  letter-spacing: 0px;
}

.hero-select option:hover {
  background-color: var(--orange);
  color: white;
}

.hero-events {
  text-align: center;
  background-color: rgba(255, 255, 255, 0.85);
  border-radius: 6px;
  width: fit-content;
  margin: 0 auto;
  min-height: 65px;
  display: flex;
  justify-content: center;
  align-items: center;
  color: var(--black);
  padding: 0 10px;
}

@media screen and (min-width: 992px) {
  .hero-events {
    width: 350px;
  }
}

.hero-events a {
  font-size: 18px;
}
</style>
