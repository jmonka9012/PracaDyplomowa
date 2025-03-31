<?php

use Illuminate\Support\Facades\Route;

// Strona domowa
require __DIR__.'/home.php';

// Strona bloga
require __DIR__.'/blog.php';

// Strona kontaktu
require __DIR__.'/contact.php';

//strona rejestracji i logowania
require __DIR__.'/auth.php';

//strone testowa matiego
require __DIR__ . '/CE.php';

//strona moje konto
require __DIR__.'/myaccount.php';

//strona 404
require __DIR__.'/error404.php';

//testowy email
require __DIR__.'/email.php';

//formularz dodawania eventu
require __DIR__.'/createevent.php';

//errory
require __DIR__.'/404.php';

//weryfikacja live
require __DIR__.'/liveverification.php';