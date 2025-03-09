<script setup>
import DropDown from "./DropDown.vue";

import { ref } from "vue";
const isOpen = ref(false);

const toggleMenu = () => {
	isOpen.value = !isOpen.value;
};
</script>

<template>
	<header class="section header">
		<div class="header-desk container container-big">
			<div
				class="d-flex flex-row justify-content-between align-items-center col-12"
			>
				<a href="/" class="header-logo"
					><img src="\src\assets\images\ICP-Logo.jpg" alt=""
				/></a>
				<nav class="header-nav">
					<ul>
						<li>
							<a href="/new"><span>Home</span></a>
						</li>
						<li>
							<a href="/blog"><span>Blog</span></a>
						</li>
						<li>
							<a href="/single"><span>Single</span></a>
						</li>
						<li>
							<a href="/kontakt"><span>Kontakt</span></a>
						</li>
					</ul>
				</nav>
				<div class="d-flex align-items-center">
					<div class="d-flex align-items-center mr-30px"></div>

					<a href="/login" class="hover-primary">
						<i class="fa fa-user text-primary mr-8px"></i>Login</a
					>
					<span class="divider divider-dark"></span>

					<a href="/register" class="hover-primary">
						<i class="fa fa-arrow-right text-primary mr-8px"></i> Register
					</a>
					<a href="/makeanevent" class="ml-30px btn btn-md btn-hovprim"
						>+ Create event</a
					>
				</div>
			</div>
		</div>

		<div
			class="col-12 d-flex justify-content-between align-items-center header-mobile"
		>
			<a href="/" class="header-logo"
				><img src="\src\assets\images\ICP-Logo.jpg" alt="" />
			</a>
			<a class="mobile-toggle" href="#" @click.prevent="toggleMenu">
				<i class="text-white fa fa-reorder"></i>
			</a>

			<div class="mobile-nav" :class="{ open: isOpen }">
				<div class="mobile-nav__overlay"></div>
				<div class="mobile-nav__content">
					<div class="container flex-column">
						<a class="header-logo mb-30px" href="/">
							<img src="\src\assets\images\ICP-Logo.jpg" alt="" />
						</a>
						<nav class="header-nav">
							<ul>
								<li><a href="">Zmienić tutaj overlay</a></li>
								<li>
									<a href="">Refactorować kod tak żeby były tylko dwa loga</a>
								</li>
								<li><a href="">transformujący hamburger</a></li>
								<li><a href="">text</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
</template>

<style lang="scss" scoped>
.header {
	z-index: 10;
	height: 60px;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 0 20px;
	background-color: var(--text);

	@include media-breakpoint-up(lg) {
		background-color: white;
		padding: 0 30px;
		height: 75px;
	}
	&-mobile {
		@include media-breakpoint-up(lg) {
			display: none;
		}
	}
	&-desk {
		display: none;
		@include media-breakpoint-up(lg) {
			display: flex;
		}
	}
	.container {
		padding: 0;
	}
}
.header-logo {
	width: 110px;
	height: 30px;
	@include media-breakpoint-up(lg) {
		height: 40px;
	}
	img {
		height: 100%;
	}
}
.header-nav {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	@include media-breakpoint-up(lg) {
		flex-direction: row;
		align-items: center;
	}
	ul {
		display: flex;
		flex-direction: column;
		@include media-breakpoint-up(lg) {
			flex-direction: row;
		}

		align-items: stretch;
		height: 100%;
		width: 100%;
		li {
			height: 100%;
			a {
				font-size: 14px;
				transition: all 0.4s;
				padding: 2px 0;
				color: white;
				width: 100%;
				font-family: "Krona One";
				font-weight: 400;
				@include media-breakpoint-up(lg) {
					padding: 0 13px;
					color: var(--text);
				}

				height: 100%;
				display: flex;
				align-items: center;
				&:hover {
					color: var(--primary);
				}
			}
		}
		li:not(:last-of-type) {
			margin-bottom: 15px;
			@include media-breakpoint-up(lg) {
				margin-bottom: 0;
			}
		}
	}
}

.mobile-toggle {
	padding: 20px;
	margin-right: -20px;
	display: flex;
	justify-content: center;
	align-items: center;
	.fa {
		font-size: 20px;
	}
}
.mobile-nav {
	display: flex;
	overflow-x: hidden;
	position: fixed;
	transition: transform 0.45s ease-in-out;
	z-index: 999;
	left: 0;
	right: auto;
	top: 0;
	transform: translate(-100%);
	bottom: 0;
	height: 100vh;
	background-color: var(--text);
	width: calc(100% - 48px);
	&__overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.3);
		background-color: rgba(0, 0, 0, 0.3);
		visibility: hidden;
		opacity: 0;
		transition: 0.45s ease-in-out;
		background-color: #161a1dcc;
	}
	&__content {
		width: 100%;
		display: flex;
		flex-direction: column;
		padding: 30px;
	}
	&.open {
		transform: translate(0) !important;
		.mobile-nav__overlay {
			// opacity: 1;
			// visibility: visible;
		}
	}
}
</style>
