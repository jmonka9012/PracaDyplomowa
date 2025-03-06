<script setup>
import HeroSmall from "@/components/sections-new/Hero-small.vue";
import LatestEvents from "@/components/sections-new/LatestEvents.vue";
import TitleNSub from "@/components/sections-new/TitleNSub.vue";

const latest = [
	{
		id: 1,
		src: "/src/assets/images/bangpow.jpg",
		link: [
			{
				href: "/icp",
				title: "zmień wielkość kontenera później",
			},
		],
		category: [
			{
				href: "/bpb",
				title: "BangPow",
			},
		],
		date: "January 22, 2025",
	},
	{
		id: 2,
		src: "/src/assets/images/greatmilenko.jpg",
		link: [{ href: "/icp", title: "Great MILENKO GREAT MILENKO" }],
		date: "January 22, 2025",
		category: [
			{
				href: "/bpb",
				title: "greatmilenko",
			},
		],
	},
	{
		id: 3,
		src: "/src/assets/images/hellspit.jpg",
		link: [{ href: "/icp", title: "GIVE ME HEAD BIIITCH" }],
		date: "January 22, 2025",
		category: [
			{
				href: "/bpb",
				title: "Hellspit",
			},
		],
	},
	{
		id: 4,
		src: "/src/assets/images/Jeckelbros.jpg",
		link: [{ href: "/icp", title: "Jeckelbross" }],
		date: "January 22, 2025",
		category: [
			{
				href: "/bpb",
				title: "Jeckelbros",
			},
		],
	},
];
</script>

<template>
	<HeroSmall source="/src/assets/images/blog-bg.jpg" title="Blog"></HeroSmall>
	<div class="section pb-120px">
		<div class="container container-small">
			<LatestEvents evContClass="ev-cont-lg-three" :latest="latest">
			</LatestEvents>
		</div>
	</div>
</template>
