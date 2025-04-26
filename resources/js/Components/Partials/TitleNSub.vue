<script setup>
defineProps({
	subtitle: String,
	title: String,
});
</script>

<template>
	<div class="d-flex flex-column" v-bind="$attrs">
		<p class="sub-title sub-title-lprpl mb-17px">
			<slot name="subtitle">{{ subtitle }}</slot>
		</p>
		<h3 class="title-1 mb-17px mb-lg-0">
			<slot name="title">{{ title }}</slot>
		</h3>
	</div>
</template>
