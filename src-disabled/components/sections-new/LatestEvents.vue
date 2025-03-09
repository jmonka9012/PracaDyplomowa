<script setup>
defineProps({
	latest: Array,
	contClass: String,
	evContClass: String,
});
</script>

<template>
	<div :class="['ev-cont', evContClass]">
		<div v-for="event in latest" :key="event.id" class="event-item">
			<div class="relative">
				<img :src="event.src" alt="" class="event-img" />
				<a :href="event.link[0].href" class="stretched-link"></a>
			</div>
			<div class="d-flex flex-row flex-wrap-wrap align-items-center mb-10px">
				<p class="event-date">
					{{ event.date }}
				</p>
				<span class="divider divider-dark"></span>

				<template v-for="(cat, index) in event.category" :key="index">
					<a :href="cat.href" class="btn btn-white">
						{{ cat.title }}
					</a>
					<span
						v-if="index < event.category.length - 1"
						class="divider divider-dark"
					></span>
				</template>
			</div>
			<h3 class="event-title2">
				<a :href="event.link[0].href" class="hover-underline">
					{{ event.link[0].title }}
				</a>
			</h3>
			<a :href="event.link[0].href" class="read-more">
				Read more
				<i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</div>
</template>
