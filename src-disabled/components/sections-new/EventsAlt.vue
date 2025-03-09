<script setup>
defineProps({
	latest: Array,
});
</script>

<template>
	<div :class="['ev-cont ev-cont-lg-three', evContClass]">
		<div v-for="event in latest" :key="event.id" class="event-item">
			<div
				class="d-flex flex-row flex-wrap-wrap align-items-center pt-25px mb-30px bt-1 b-secondary"
			>
				<h6 class="mb-30px">
					<a class="hover-underline-thick" :href="event.link.href">
						{{ event.title }}
					</a>
				</h6>
				<p class="event-date">
					{{ event.date }}
				</p>
				<span class="divider divider-dark"></span>
				<p class="event-location ff-krona">{{ event.location }}</p>
			</div>
			<div class="relative">
				<img :src="event.src" alt="" class="event-img" />
				<a :href="event.link.href" class="link-stretched"></a>
			</div>
		</div>
	</div>
</template>
