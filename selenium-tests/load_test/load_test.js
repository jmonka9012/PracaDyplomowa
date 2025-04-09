import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usuwa cudzysłowy z wartości, jeśli są

// Liczba instancji równoległych (userów)
const INSTANCES = 18;

// Liczba akcji wykonywanych przez jedną instancję (ilość czynności jaką wykona pojedynczy user)
const ACTIONS_PER_INSTANCE = 10;

// Dostępne typy akcji do losowania
const ACTIONS = ['Login', 'Kontakt', 'Search', 'Scroll'];

// Statystyki wykonanych akcji
const stats = {
  Login: 0,
  Kontakt: 0,
  Search: 0,
  Scroll: 0,
  Powrot: 0,
  Nieudane: 0
};

// Losowanie jednej akcji z dostępnych
function losowaAkcja() {
  return ACTIONS[Math.floor(Math.random() * ACTIONS.length)];
}

// Kliknięcie w link tekstowy (np. Login, Kontakt)
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
    const pole = await driver.wait(until.elementLocated(By.css('input[type="search"], input[type="text"]')), 7000);
    await pole.sendKeys('test');
    const przycisk = await driver.wait(until.elementLocated(By.css('button[type="submit"], input[type="submit"]')), 7000);
    await przycisk.click();
    console.log(`Instancja ${id}: Wykonano wyszukiwanie`);
    stats.Search++;
  } catch (err) {
    console.log(`Instancja ${id}: Nie znaleziono pola wyszukiwania lub przycisku - ${err.message}`);
    stats.Nieudane++;
  }
}

// Scrollowanie do losowej wysokości
async function scroll(driver, id) {
  const y = Math.floor(Math.random() * 1000);
  await driver.executeScript(`window.scrollTo(0, ${y})`);
  console.log(`Instancja ${id}: Scroll do ${y}`);
  stats.Scroll++;
}

// Powrót do strony głównej
async function powrot(driver, id) {
  try {
    await driver.get(BASE_URL);
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
  options.addArguments(
    '--disable-dev-shm-usage',
    '--no-sandbox',
    '--headless=new'
  );

  const driver = await new Builder()
    .forBrowser('chrome')
    .setChromeOptions(options)
    .build();

  // Ustawienie okna przeglądarki
  await driver.manage().window().setRect({ width: 1400, height: 1000 });

  console.log(`Instancja ${id}: Start`);

  try {
    await driver.get(BASE_URL);
    console.log(`Instancja ${id}: Załadowano stronę główną`);

    for (let i = 0; i < ACTIONS_PER_INSTANCE; i++) {
      const akcja = losowaAkcja();

      switch (akcja) {
        case 'Login':
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

      // Opóźnienie między akcjami
      await new Promise(r => setTimeout(r, Math.random() * 2000));

      // Powrót po każdej akcji
      await powrot(driver, id);
    }

  } catch (err) {
    console.log(`Instancja ${id}: Błąd krytyczny - ${err.message}`);
  } finally {
    await driver.quit();
    console.log(`Instancja ${id}: Koniec`);
  }
}

// Uruchomienie testu głównego z wieloma instancjami
describe('Test obciążeniowy aplikacji', function () {
  this.timeout(300000); // Limit czasu na wykonanie całego testu

  it('Uruchamia wiele instancji równolegle', async function () {
    const wszystkie = [];

    for (let i = 0; i < INSTANCES; i++) {
      wszystkie.push(uruchomInstancje(i));
    }

    await Promise.all(wszystkie);

    console.log('\n=== ANALIZA WYKONANYCH AKCJI ===');
    let suma = 0;
    for (const [akcja, liczba] of Object.entries(stats)) {
      console.log(`${akcja}: ${liczba}`);
      if (akcja !== 'Nieudane') suma += liczba;
    }
    console.log(`\nŁączna liczba udanych akcji: ${suma}`);
    console.log(`Liczba nieudanych akcji: ${stats.Nieudane}`);
  });
});
