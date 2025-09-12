import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Import funkcji logowania wyników testu

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');

// Konfiguracja testu
const INSTANCES = 18; // Liczba równoległych instancji przeglądarki (userów)
const ACTIONS_PER_INSTANCE = 10; // Liczba akcji do wykonania przez jedną instancję (ile czynności wykona każdy user)
const ACTIONS = ['Zaloguj', 'Kontakt', 'Search', 'Scroll']; // Dostępne akcje testowe

// Statystyki testu
const stats = {
  Zaloguj: 0,
  Kontakt: 0,
  Search: 0,
  Scroll: 0,
  Powrot: 0,
  Nieudane: 0
};

// Wybór losowej akcji
function losowaAkcja() {
  return ACTIONS[Math.floor(Math.random() * ACTIONS.length)];
}

// Kliknięcie w link tekstowy (np. Zaloguj, Kontakt)
async function clickLink(driver, linkText, id) {
  try {
    const element = await driver.wait(until.elementLocated(By.linkText(linkText)), 7000);
    await element.click();
    console.log(`Instancja ${id}: Kliknięto "${linkText}"`);
    stats[linkText]++;
  } catch (err) {
    console.log(`Instancja ${id}: Nie znaleziono "${linkText}" - ${err.message}`);
    stats.Nieudane++;
  }
}

// Wykonanie akcji wyszukiwania
async function search(driver, id) {
  try {
    // Wyszukanie pola tekstowego
    const pole = await driver.wait(until.elementLocated(By.css('input.hero-input')), 7000);
    await pole.sendKeys('test');

    // Wyszukanie przycisku "Szukaj"
    const przycisk = await driver.wait(until.elementLocated(By.css('button.hero-search')), 7000);
    await przycisk.click();

    console.log(`Instancja ${id}: Wykonano wyszukiwanie`);
    stats.Search++;
  } catch (err) {
    console.log(`Instancja ${id}: Nie znaleziono pola wyszukiwania lub przycisku - ${err.message}`);
    stats.Nieudane++;
  }
}


// Scrollowanie strony w losowe miejsce
async function scroll(driver, id) {
  const y = Math.floor(Math.random() * 1000);
  await driver.executeScript(`window.scrollTo(0, ${y})`);
  console.log(`Instancja ${id}: Scroll do ${y}`);
  stats.Scroll++;
}

// Powrót na stronę główną
async function powrot(driver, id) {
  try {
    await driver.get(BASE_URL);
    await driver.sleep(1000); // Dodano opóźnienie po załadowaniu strony
    console.log(`Instancja ${id}: Powrót na stronę główną`);
    stats.Powrot++;
  } catch (err) {
    console.log(`Instancja ${id}: Nie udało się wrócić na stronę główną - ${err.message}`);
    stats.Nieudane++;
  }
}

// Uruchomienie jednej instancji testu
async function uruchomInstancje(id) {
  const options = new chrome.Options();
  options.addArguments('--disable-dev-shm-usage', '--no-sandbox', '--headless=new');

  const driver = await new Builder()
    .forBrowser('chrome')
    .setChromeOptions(options)
    .build();

  await driver.manage().window().setRect({ width: 1400, height: 1000 });
  console.log(`Instancja ${id}: Start`);

  try {
    await driver.get(BASE_URL);
    console.log(`Instancja ${id}: Załadowano stronę główną`);

    // Wykonanie określonej liczby losowych akcji
    for (let i = 0; i < ACTIONS_PER_INSTANCE; i++) {
      const akcja = losowaAkcja();

      switch (akcja) {
        case 'Zaloguj':
        case 'Kontakt':
          await clickLink(driver, akcja, id);
          break;
        case 'Search':
          await search(driver, id);
          break;
        case 'Scroll':
          await scroll(driver, id);
          break;
      }

      // Krótkie opóźnienie pomiędzy akcjami
      await new Promise(resolve => setTimeout(resolve, Math.random() * 2000));

      // Powrót na stronę główną po każdej akcji
      await powrot(driver, id);
    }
  } catch (err) {
    console.log(`Instancja ${id}: Błąd krytyczny - ${err.message}`);
    stats.Nieudane++;
  } finally {
    await driver.quit();
    console.log(`Instancja ${id}: Koniec`);
  }
}

// Główna sekcja testu — uruchomienie wielu instancji równolegle
describe('Test obciążeniowy aplikacji', function () {
  this.timeout(300000); // 5 minut na zakończenie całego testu
  const testName = 'load_test';

  it('Uruchamia wiele instancji równolegle', async function () {
    const wszystkie = [];

    for (let i = 0; i < INSTANCES; i++) {
      wszystkie.push(uruchomInstancje(i));
    }

    await Promise.all(wszystkie);

    // Podsumowanie wyników testu
    console.log('\n=== ANALIZA WYKONANYCH AKCJI ===');
    let suma = 0;
    for (const [akcja, liczba] of Object.entries(stats)) {
      console.log(`${akcja}: ${liczba}`);
      if (akcja !== 'Nieudane') suma += liczba;
    }

    console.log(`\nŁączna liczba udanych akcji: ${suma}`);
    console.log(`Liczba nieudanych akcji: ${stats.Nieudane}`);

    // Logowanie końcowego wyniku testu
    const passed = stats.Nieudane === 0;
    logTestResult(testName, passed);
  });
});
