<script setup>
import Tab from "@/Components/Partials/Tab.vue";
import Tabs from "@/Components/Partials/Tabs.vue";
import Hero from "@/Components/Sections/AboutUsHero.vue";
import blogBg from "~images/blog-bg.jpg";

import useAuth from "@/Utilities/useAuth";

const { user, isLoggedIn } = useAuth();

const props = defineProps({
  halls: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <Hero></Hero>

  <section class="section-full mb-100px">
    <div class="container container--full">
      <div class="col-12 col-lg-6 pl-10px pr-10px pl-lg-0 pr-lg-0">
        <img class="h-100 of-cover" :src="blogBg" alt="" />
      </div>
      <div
        class="col-12 col-lg-6 pt-30px pb-30px pt-lg-100px pb-lg-100px pl-10px pr-10px pl-md-30px pr-md-30px pl-lg-100px pr-lg-100px"
      >
        <h1 class="mb-15px">O nas</h1>
        <p class="mb-30px">
          <strong>EVENT MACHEN</strong> to nowoczesna, w pełni cyfrowa platforma do zakupu biletów na wydarzenia rozrywkowe, kulturalne, społeczne i medialne, która została stworzona z myślą o nowej generacji uczestników eventów. Naszym sercem jest innowacyjna hala koncertowo-wydarzeniowa, zaprojektowana z uwzględnieniem potrzeb organizatorów i oczekiwań widzów.
        </p>
        <p>
          Działamy lokalnie, myśląc globalnie – łącząc wygodę sprzedaży internetowej z bezpieczeństwem transakcji i jakością obsługi, jakiej oczekuje współczesna publiczność.
        </p>
      </div>
    </div>
  </section>

  <section id="halls" class="overflow-hidden">
    <div class="container container--mid">
      <div class="col-12">
        <Tabs>
          <Tab
            class="flex-column hall"
            v-for="hall in halls"
            :key="hall.id"
            :title="hall.hall_name"
          >
            <div>
              <div class="d-flex flex-column">
                <div class="d-flex align-items-center">
                  <div class="legend legend--stand"></div>
                  <p>Sekcje z miejscami stojącymi</p>
                </div>
                <div class="d-flex align-items-center">
                  <div class="legend legend--seat"></div>
                  <p>Sekcje z miejscami siedzącymi</p>
                </div>
              </div>
              <div class="scene">scena</div>
              <div
                class="hall__row"
                v-for="(row, hrowIndex) in hall.hall_height"
                :key="hrowIndex"
              >
                <div
                  class="hall__col"
                  v-for="(col, hcolIndex) in hall.hall_width"
                  :key="hcolIndex"
                >
                  <div
                    class="petla"
                    v-for="section in hall.sections.filter(
                      (section) =>
                        section.section_height === hrowIndex + 1 &&
                        section.section_width === hcolIndex + 1
                    )"
                    :key="section.id"
                  >
                    <div
                      class="hall__section-seat"
                      v-if="section.section_type === 'seat'"
                    >
                      <div class="hall__seat-cont">
                        <div
                          class="hall__section-row"
                          v-for="(row, rowIndex) in section.row"
                          :key="rowIndex"
                        >
                          <div
                            class="hall__seat"
                            v-for="(col, colIndex) in section.col"
                            :key="colIndex"
                          ></div>
                        </div>
                      </div>
                    </div>
                    <div v-else class="hall__section-stand">
                      <div class="hall__seat-cont"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </Tab>
        </Tabs>
      </div>
    </div>
  </section>

  <section class="">
    <div class="container justify-content-center">
      <h2 class="mb-30px">Nowoczesna hala wydarzeniowa</h2>
      <p class="mb-50px">
        Arena EVENT MACHEN to wirtualny, ale w pełni funkcjonalny obiekt dostosowany do organizacji różnorodnych wydarzeń: koncertów, stand-upów, kabaretów, premier filmowych, wydarzeń politycznych, pokazów specjalnych i wielu innych. Obiekt oferuje zarówno miejsca siedzące, jak i stojące, z przejrzystym systemem podziału stref i dynamicznym planem sali, który umożliwia szybki wybór najlepszych miejsc.
      </p>
      <p class="mb-50px">
        Każdy organizator wydarzenia przechodzi proces weryfikacji – gwarantujemy, że oferowane wydarzenia spełniają nasze standardy jakości i bezpieczeństwa.
      </p>

      <h2 class="mb-30px">Platforma biletowa</h2>
      <p class="mb-50px">
        Jesteśmy niezależnym operatorem biletowym – nie organizujemy wydarzeń, ale zapewniamy najlepsze możliwe narzędzia do ich promocji i sprzedaży. Nasz system został zaprojektowany od podstaw z myślą o prostocie, szybkości działania i pełnej automatyzacji.
      </p>
      <p class="mb-50px">
        Kupując bilet przez EVENT MACHEN, otrzymujesz go błyskawicznie w formie pliku PDF z unikalnym kodem QR, wysyłanym bezpośrednio na podany adres e-mail. Nie drukujesz? Nie szkodzi – nasz system wejść obsługuje elektroniczne skanowanie z telefonu.
      </p>

      <h2 class="mb-30px">Twoje konto, Twoje wydarzenia</h2>
      <p class="mb-50px">
        Rejestrując się w serwisie, zyskujesz dostęp do własnego panelu użytkownika, w którym znajdziesz historię zakupionych biletów, statusy wydarzeń, aktualizacje i powiadomienia od organizatorów. Nasz system umożliwia także przypomnienia o nadchodzących eventach oraz szybki zakup kolejnych biletów na podstawie Twoich preferencji.
      </p>

      <h2 class="mb-30px">Bezpieczeństwo i niezawodność</h2>
      <p class="mb-50px">
        Wszystkie transakcje realizowane są przez bezpieczną bramkę płatniczą, zgodną z najnowszymi standardami szyfrowania. Nie przechowujemy wrażliwych danych – stawiamy na ochronę prywatności i pełną transparentność.
      </p>
      <p class="mb-50px">
        Dzięki technologii opartej na sprawdzonych rozwiązaniach webowych, nasza aplikacja działa szybko, stabilnie i jest dostępna z każdego urządzenia.
      </p>

      <h2 class="mb-30px">Współpraca i rozwój</h2>
      <p class="mb-50px">
        EVENT MACHEN to nie tylko narzędzie – to projekt, który żyje i rozwija się razem ze swoimi użytkownikami. Jesteśmy otwarci na współpracę z organizatorami, sponsorami, mediami i innymi partnerami branżowymi. Jeśli chcesz wspólnie tworzyć przyszłość wydarzeń – skontaktuj się z nami.
      </p>

      <h2 class="mb-30px">Myśl globalnie, działaj lokalnie</h2>
      <p class="mb-50px">
        Choć nasz projekt powstał lokalnie – z pasji, ambicji i kreatywności młodego zespołu inżynierów – już teraz gotowi jesteśmy działać na szerszą skalę. Naszą misją jest stworzenie miejsca, które łączy ludzi poprzez emocje, sztukę, debatę, humor i wyjątkowe chwile – niezależnie od tego, gdzie się znajdują.
      </p>

      <p class="mb-50px font-semibold">
        EVENT MACHEN – wszystko zaczyna się od biletu.<br />
        Dołącz do nas i przekonaj się, jak proste może być uczestnictwo w wydarzeniach.
      </p>
    </div>
  </section>
</template>

<style lang="scss">
@use "~css/hale.scss";
</style>
