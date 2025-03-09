<script setup>
import HeroSmall from "@/components/sections-new/Hero-small.vue";
</script>

<template>
	<HeroSmall title="Forms showcase" source="/src/assets/images/blog-bg.jpg" />
	<section>
		<div class="container flex-column">
			<h1 class="title-1 mb-20px">Logowanie</h1>
			<form class="form" method="post">
				<div class="input-wrap d-flex flex-column col-12">
					<label for="username">Nazwa użytkownika *</label>
					<input
						type="text"
						id="username"
						autocomplete="username"
						spellcheck="false"
						value=""
						required=""
						aria-required="true"
					/>
				</div>
				<div class="input-wrap d-flex flex-column col-12">
					<label for="usermail">Adres E-mail *</label>
					<input
						type="text"
						id="email"
						autocomplete="email"
						spellcheck="false"
						value=""
						required=""
						aria-required="true"
					/>
				</div>
				<div class="input-wrap d-flex flex-column col-12">
					<label for="password">Hasło *</label>
					<input
						type="password"
						name="password"
						id="password"
						autocomplete="password"
						required=""
						aria-required="true"
					/>
				</div>
				<div class="input-wrap col-12">
					<input type="submit" placeholder="Zaloguj się" />
				</div>
			</form>
			<h1 class="title-1 mb-20px">Rejestracja</h1>
			<form class="form" method="post">
				<div class="input-wrap d-flex flex-column col-12">
					<label for="register-username">Nazwa użytkownika *</label>
					<input
						type="text"
						id="register-username"
						autocomplete="register-username"
						spellcheck="false"
						value=""
						required=""
						aria-required="true"
					/>
				</div>
				<div class="input-wrap d-flex flex-column col-12">
					<label for="register-usermail">Adres E-mail *</label>
					<input
						type="text"
						id="register-email"
						autocomplete="registeremail"
						spellcheck="false"
						value=""
						required=""
						aria-required="true"
					/>
				</div>
				<div class="input-wrap d-flex flex-column col-12">
					<label for="register-password">Hasło *</label>
					<input
						type="password"
						name="register-password"
						id="register-password"
						autocomplete="register"
						required=""
						aria-required="true"
					/>
				</div>
				<div class="input-wrap col-12 mb-20px">
					<p>
						Na adres e-mail zostanie wysłany odnośnik do ustawienia nowego<br /><br />
						hasła. Twoje dane osobowe zostaną użyte do obsługi twojej wizyty na
						naszej stronie, zarządzania dostępem do twojego konta i dla innych
						celów o których mówi nasza polityka prywatności.
					</p>
				</div>
				<div class="input-wrap col-12">
					<input type="submit" placeholder="Zaloguj się" />
				</div>
			</form>
		</div>
	</section>
</template>
