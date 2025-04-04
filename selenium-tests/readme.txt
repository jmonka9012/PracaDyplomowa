Założenia:
1.  Oczywiście, przy każdej modyfikacji package.json trzeba zrobić w terminalu "npm install" gdyż package.json zawiera
    informacje o zainstalowanych pakietach, które są zbyt ciężkie i niepotrzebne żeby je wrzucać do repozytorium. Dlatego
    pushujemy tylko informację o tym co npm ma instalować lokalnie i dlatego to jest konieczne przy każdym nowym pakiecie.
    Dla pewności możesz robić to co pulla
2.  Każdy test to oddzielny folder, zdecydowałem się to rozwiązać tak żeby była w nich możliwośc zapisywania logów o wynikach,
    tak żeby były w folderach z odpowiadającym testem.
3.  Przykładowy test jest głównie napisany przez deepseeka bo nie znam selenium na tyle dobrze żeby napisać go sam,
    ma on służyć jedynie temu żebyś mógł porównać do niego w przyszłości swoje nie działające testy (bo na pewno jakiś nie zadziała - Informatyka)
4.  Testy zakładają że masz odpalony "ddev start", oraz świeży "npm run build" (robisz builda raz na pulla), a w wypadku jak
    były zmiany w backendzie to do tego robisz "ddev php artisan cache:clear", a dodatkowo jak były zmiany w migracjach
    (bazie danych) to robisz "ddev php artisan migrate:fresh"
5.  Twój skrypt z testem musi być zapisany w selenium-tests, koniecznie w takim formacie:
    <nazwa_testu>/<nazwa_testu>.js
6.  Żeby odpalić test piszesz w terminalu:
    npm run test --file=<nazwa_testu>
