<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Projekt Inżynierski Event Machen

Projekt (Event Machen) napisany w technologii Laravel I Vue.js. W projekcie użyliśmy też Inertia, TinyMCE i bramki płatności Stripe.

Głównym założeniem projektu jest zarządzanie wydarzeniami, w tym m.in. tworzenie wydarzeń, kont użytkownika, sprzedaż biletów, płatności i wsparcie klienta

## Skład zespołu

Imie Nazwisko - Email - Numer Albumu - Nazwa Użytkownika na GitHubie.

Jacek Mońka - jmonka@edu.cdv.pl - 26880 - JacekMonka

Jędrzej Krzeski - jkrzeski@edu.cdv.pl - 27417 - Yen1312

Mateusz Borkowski - mborkowski2@edu.cdv.pl - 26840 - Materdeo

Piotr Galimski - pgalimski@edu.cdv.pl - 27010 - GalimPio

## Rozkład pracy

Jacek Mońka - Fullstack

Jędrzej Krzeski - Backend

Mateusz Borkowski - Frontend

Piotr Galimski - Tester

## Instalacja

1. npm install

2.npm run build

3. ddev composer install

4. ddev start

5. ddev php artisan storage:link

6. ddev php artisan migrate:fresh --seed

7. skopiowanie .env.example do pliku .env i dodanie kluczy API (wiadomość do Jędrzeja)

8. opcjonalnie zainstalowanie cron w celu automatycznego czyszcenia zamówien itd. (zależy od systemu, dla ubuntu "sudo apt-get install cron", dla arch sudo pacman -S cronie) i dodać w crontab -e "* * * * * cd [katalog z projektem] && ddev php artisan schedule:run >> /dev/null 2>&1" po czym użyć "sudo systemctl enable cron" i "sudo systemctl start cron"

## Przydatne komendy

ddev php artisan migrate:fresh --seed = generuje od podstaw baze danych z podstawowymi danymi

ddev php artisan db:seed --class=[klasa] = używa danego seedera, seeder RandomSeeders zawiera wszystkie seedery z losowymi danymi

ddev php artisan test - testy jednostkowe BE

npm run build - 'buduje' frontend

npm run watch - to samo co build, ale działa w tle kiedy widzi zmiany w kodzie FE

## Reszta

Klucze API stripe są dostępne na naszej grupie do pracy. Karty testowe można znaleźć na https://docs.stripe.com/testing 

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
