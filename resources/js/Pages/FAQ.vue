<script setup>
import HeroSmall from "../Components/Sections/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
</script>

<template>
  <HeroSmall :source="blogBg" title="Często zadawane pytania" />

  <section>
    <div class="container faq">
      <article>
        <h1>FAQ – Najczęściej Zadawane Pytania</h1>

        <h2>Zakup biletów</h2>

        <h3>Jak mogę zakupić bilet na wydarzenie?</h3>
        <p>
          Bilet można zakupić wyłącznie za pośrednictwem platformy EVENT MACHEN. Proces zakupu obejmuje wybór wydarzenia, zaznaczenie liczby biletów, podanie wymaganych danych osobowych oraz dokonanie płatności online. Po zakończeniu transakcji Użytkownik otrzyma elektroniczny bilet w formie pliku PDF, dostępny także w panelu użytkownika.
        </p>

        <h3>Czy mogę kupić więcej niż jeden bilet na wydarzenie?</h3>
        <p>
          Tak, Serwis umożliwia zakup wielu biletów w ramach jednej transakcji. Każdy bilet musi być przypisany do konkretnego uczestnika wydarzenia, zgodnie z wymaganiami Organizatora.
        </p>

        <h3>Czy zakup biletu wymaga rejestracji konta?</h3>
        <p>
          Nie, istnieje możliwość zakupu biletu bez konieczności zakładania konta, w tzw. trybie „gościa”. W takiej sytuacji Użytkownik podaje jedynie dane niezbędne do przypisania biletu, w tym imię, nazwisko oraz adres e-mail.
        </p>

        <h3>Czy mogę przekazać bilet innej osobie?</h3>
        <p>
          Bilet jest przypisany do konkretnego uczestnika wydarzenia. W przypadku konieczności zmiany danych właściciela biletu należy skontaktować się z administracją Serwisu poprzez formularz zgłoszeniowy dostępny na platformie EVENT MACHEN. Każda prośba o zmianę danych biletu podlega indywidualnej weryfikacji.
        </p>

        <h2>Zwrot i płatności</h2>

        <h3>Czy mogę zwrócić zakupiony bilet?</h3>
        <p>
          Tak, Użytkownik ma prawo do zwrotu biletu do momentu rozpoczęcia wydarzenia. Po tym terminie zwroty nie będą przyjmowane, niezależnie od przyczyny.
        </p>

        <h3>Jaka jest procedura zwrotu biletu?</h3>
        <p>
          Zwrot należy zgłosić za pomocą formularza kontaktowego dostępnego na stronie EVENT MACHEN. Po pozytywnej weryfikacji zgłoszenia Administrator dokona zwrotu środków w ciągu 14 dni roboczych, stosownie do wybranej metody płatności.
        </p>

        <h3>W jaki sposób mogę dokonać płatności za bilet?</h3>
        <p>
          Serwis obsługuje następujące metody płatności:
        </p>
        <ul>
          <li>Karty płatnicze (Visa, Mastercard),</li>
          <li>System BLIK,</li>
          <li>Przelewy online realizowane przez operatora płatności.</li>
        </ul>

        <h3>Czy płatność za bilet może zostać anulowana?</h3>
        <p>
          Po dokonaniu płatności i jej zaksięgowaniu anulowanie transakcji nie jest możliwe, chyba że zgłoszono zwrot biletu zgodnie z procedurą określoną w Regulaminie.
        </p>

        <h2>Rejestracja konta</h2>

        <h3>Czy muszę posiadać konto w Serwisie, aby kupić bilet?</h3>
        <p>
          Nie, zakup biletu może odbywać się bez rejestracji, jednak utworzenie konta pozwala na łatwiejsze zarządzanie transakcjami, dostęp do historii zakupów oraz uproszczoną procedurę zwrotów.
        </p>

        <h3>Jak mogę założyć konto w Serwisie?</h3>
        <p>
          Proces rejestracji obejmuje podanie podstawowych danych identyfikacyjnych, takich jak imię, nazwisko, adres e-mail oraz nazwa użytkownika. W celu zabezpieczenia konta Użytkownik ustala indywidualne hasło, które jest przechowywane w zaszyfrowanej formie.
        </p>

        <h3>Czy mogę usunąć moje konto w Serwisie?</h3>
        <p>
          Tak, Użytkownik może w dowolnym momencie złożyć wniosek o usunięcie konta za pośrednictwem formularza kontaktowego dostępnego w Serwisie. Należy pamiętać, że usunięcie konta skutkuje utratą dostępu do historii zakupów oraz przypisanych biletów.
        </p>

        <h2>Kontakt z administracją</h2>

        <h3>Jak mogę skontaktować się z administracją Serwisu?</h3>
        <p>
          Wszelkie zapytania dotyczące działania Serwisu, procesu zakupu biletów, zwrotów oraz zmiany danych w biletach należy kierować za pomocą formularza kontaktowego dostępnego na stronie EVENT MACHEN.
        </p>

        <h3>Czy mogę skontaktować się telefonicznie?</h3>
        <p>
          Tak, platforma EVENT MACHEN udostępnia kontakt telefoniczny pod numerem: +48 111 222 333.
        </p>

        <h3>Jak długo trwa oczekiwanie na odpowiedź administracji?</h3>
        <p>
          Administrator dokłada wszelkich starań, aby odpowiedzi na zgłoszenia były udzielane w możliwie najkrótszym terminie. Maksymalny czas oczekiwania na odpowiedź w sprawach dotyczących zakupów, zwrotów oraz zmian w biletach wynosi 7 dni roboczych.
        </p>

        <h3>Czy administracja może pomóc w sprawach dotyczących przebiegu wydarzenia?</h3>
        <p>
          Nie, Administrator platformy EVENT MACHEN pełni funkcję pośrednika w sprzedaży biletów, a wszelkie kwestie dotyczące organizacji i przebiegu wydarzenia pozostają w gestii jego Organizatora. W przypadku pytań związanych z miejscem wydarzenia, programem, bezpieczeństwem czy zmianami w harmonogramie Użytkownik powinien kontaktować się bezpośrednio z Organizatorem.
        </p>
      </article>
    </div>
  </section>
</template>

<style scoped lang="scss">
.faq {
  padding: 2rem 0;
  h1 {
    font-size: 2rem;
    margin-bottom: 2rem;
    text-align: center;
    color: #333;
  }
  h2 {
    margin-top: 2rem;
    font-size: 1.5rem;
    color: #444;
  }
  h3 {
    margin-top: 1.5rem;
    font-size: 1.2rem;
    color: #555;
  }
  p, ul {
    margin-top: 0.5rem;
    margin-bottom: 1.2rem;
    line-height: 1.6;
    color: #666;
  }
  ul {
    padding-left: 1.5rem;
    list-style-type: disc;
  }
}
</style>
