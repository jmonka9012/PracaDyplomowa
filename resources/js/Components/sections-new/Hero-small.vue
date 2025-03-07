<script setup>
defineProps({
	source: String,
	title: String,
});
</script>

<template>
	<section class="hero-small mb-60px">
		<div class="container align-items-center flex-column">
			<img class="hero-small__bg" :src="source" alt="" />
			<h1 class="hero-small__title">
				{{ title }}
			</h1>
			<div class="bcrumb text-white">
				<a href="">Prev</a>
				<span class="divider divider-star"></span>
				<a class="bcrumb__cur" href="">Current</a>
			</div>
		</div>
	</section>
</template>

<style lang="scss" scoped>
.hero-small {
	background-color: #3a3a3a;
	min-height: 400px;
	padding-top: 56px;
	padding-bottom: 60px;
	justify-content: center;
	align-items: center;
	position: relative;
	overflow: hidden;
	&__title {
		color: white;
		font-size: 32px;
		line-height: 42px;

		z-index: 1;
	}
	&__bg {
		object-fit: cover;
		object-position: center bottom;
		position: absolute;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 0;
	}
}
</style>
