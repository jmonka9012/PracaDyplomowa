<?php

use Illuminate\Support\Facades\Route;

//strony statyczne
require __DIR__ .'/static.php';

// Strona bloga
require __DIR__.'/blog.php';

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

//errory
require __DIR__.'/404.php';

//weryfikacja live
require __DIR__.'/liveverification.php';

//panel admina
require __DIR__.'/admin.php';

//generowanie stron eventów
require __DIR__.'/events.php';