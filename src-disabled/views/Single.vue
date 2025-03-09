<script setup>
import EventsAlt from "@/components/sections-new/EventsAlt.vue";
import HeroSmall from "@/components/sections-new/Hero-small.vue";

const latest = [
	{
		id: 1,
		src: "/src/assets/images/bangpow.jpg",
		title: "Lorem ipsum dolor",
		link: {
			href: "/icp",
			title: "Bang Pow Boom at Jugaloo Island",
		},

		location: "Bangpowboom",
		date: "January 22, 2025",
	},
	{
		id: 2,
		src: "/src/assets/images/hellspit.jpg",
		title: "Lorem ipsum dolor sit amet lorem ipsum",
		link: {
			href: "/icp",
			title: "Bang Pow Boom at Jugaloo Island",
		},

		location: "Bangpowboom",
		date: "January 22, 2025",
	},
	{
		id: 3,
		src: "/src/assets/images/hellspit.jpg",
		title: "Lorem ipsum dolor sit amet lorem ipsum",
		link: {
			href: "/icp",
			title: "Riddle box",
		},

		location: "Riddle box",
		date: "January 22, 2025",
	},
];

</script>

<template>
	<HeroSmall source="/src/assets/images/blog-bg.jpg" title="Single" />
	<section class="single">
		<div class="container container-small">
			<div class="single__content">
				<div class="single__intro">
					<img src="/src/assets/images/hellspit.jpg" alt="" />
				</div>
				<h1 class="single__title">
					Festival of Japanese Culture in Berlin 2022
				</h1>
				<div class="single__details">
					<div>
						<h6 class="mb-13px">Event date:</h6>
						<p>
							Start at 12:00 AM <br />
							December 27, 2022 - <br />
							December 29, 2022
						</p>
					</div>
					<div>
						<h6 class="mb-13px">Location:</h6>
						<a class="text-secondary" href="/">GERMANY</a>
					</div>
					<div>
						<h6 class="mb-13px">E-mail:</h6>
						<a class="hover-none" href="">city@vox.com.ua</a>
						<a class="hover-none" href="">thegov@gmail.com</a>
					</div>
				</div>
				<h4 class="mb-18px">About Festival</h4>
				<ul class="list-stars list-stars-prpl mb-35px">
					<li>
						Ultricies mauris pharetra et ultrices neque ornare nascetur aenean.
					</li>
					<li>
						Pharetra magna ac placerat vestibulum lectus mauris ultrices eros.
					</li>
					<li>
						Eget sit amet tellus cras tincidunt adipiscing enim eu turpis.
					</li>
					<li>Ornare arcu dui vivamus arcu consectetur felis bibendum.</li>
				</ul>
				<p class="mb-65px">
					Blandit cursus risus at ultrices sed tempus imperdiet nulla malesuada.
					Faucibus in ornare quam viverra orci sagittis eu magnis volutpat odio.
				</p>
				<h4 class="mb-18px">More Information</h4>
				<p class="mb-65px">
					Mattis rhoncus urna neque viverra. Leo vitae turpis massa elementum
					tempus. Enim nulla aliquet porttitor lacus a accumsan tortor posuere.
					Euismod elementum nisi quis eleifend adipiscing vitae proin. Sagittis
					aliquam malesuada bibendum arcu vitae elementum curabitur vitae.
				</p>
				<img
					class="single__map"
					src="/src/assets/images/single-map.jpg"
					alt=""
				/>
				<div class="bb-1 b-secondary"></div>
				<div class="d-flex flex-lg-row column-gap-10px mt-30px mb-100px">
					<a class="social-link" href=""><i class="fab fa-twitter"></i></a>

					<a class="social-link" href=""> <i class="fab fa-facebook"></i></a>

					<a class="social-link" href=""> <i class="fab fa-pinterest"></i></a>

					<a class="social-link" href=""><i class="fab fa-instagram"></i></a>
				</div>
				<h3 class="mb-30px">Related Events</h3>
				<EventsAlt :latest="latest" />
				<h3 class="mb-40px">Leave a Reply</h3>
				<p class="fs-14 mb-20px">
					Your email address will not be published. Required fields are marked *
				</p>
				<form action="" class="form">
					<div class="input-wrap col-12 col-lg-6">
						<input type="text" placeholder="Your Name*" required />
					</div>
					<div class="input-wrap col-12 col-lg-6">
						<input type="text" placeholder="Your Email*" required />
					</div>
					<div class="input-wrap col-12">
						<input type="text" placeholder="Website" />
					</div>
					<div class="input-wrap col-12">
						<textarea placeholder="Your Comment..."></textarea>
					</div>
					<div class="d-flex flex-column pl-15px pr-15px">
						<div class="form-checkwrap">
							<input
								type="checkbox"
								v-model="toggle"
								true-value="yes"
								false-value="no"
							/>
							<label for="checkbox"
								>Save my name, email, and website in this browser for the next
								time I comment.
							</label>
						</div>

						<input type="submit" placeholder="Post comment" />
					</div>
				</form>
			</div>
		</div>
	</section>
</template>

<style scoped lang="scss">
.single {
	&__content {
		width: 100%;
		padding: 0 5px;
		color: #505558;
		display: flex;
		flex-direction: column;
		@include media-breakpoint-up(md) {
			padding: 0 30px;
		}
	}
	&__intro {
		margin-bottom: 50px;
	}
	&__title {
		margin-bottom: 50px;
		font-size: 28px;
		line-height: 1.25;
		word-wrap: break-word;
		overflow-wrap: break-word;
		@include media-breakpoint-up(md) {
			font-size: 42px;
		}
	}
	&__details {
		display: grid;
		grid-template-columns: 1fr;
		@include media-breakpoint-up(md) {
			grid-template-columns: repeat(3, 1fr);
			grid-column-gap: 60px;
		}
		div {
			font-size: 12px;
			line-height: 30px;
			font-family: "Krona One";
			padding: 30px 0;
			position: relative;
			display: flex;
			flex-direction: column;
			margin: 0;
			&::before {
				position: absolute;
				left: 0px;
				right: 0px;
				background-color: var(--text);
				height: 1px;
				content: "";
				top: 0;
			}
		}

		p {
		}
	}
	&__map {
		margin-bottom: 50px;
	}
	h3 {
		font-size: 24px;
		@include media-breakpoint-up(lg) {
			font-size: 36px;
		}
	}
	h4 {
		color: var(--text);
	}
}
textarea {
	height: 85px;
}
</style>
