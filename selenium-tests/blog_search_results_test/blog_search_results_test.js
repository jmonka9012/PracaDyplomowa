// Import wymaganych modułów
import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych i normalizacja adresu bazowego aplikacji
dotenv.config();
const BASE_URL = (process.env.APP_URL || '')
  .replace(/"/g, '')
  .trim()
  .replace(/^https:\/\//i, 'http://');

// Fraza, której szukamy na blogu
const SEARCH_TERM = 'Muzyka Metalowa w 2025';

(async function blogSearchResultsTest() {
  let driver;
  let success = false;
  let message = '';

  try {
    // Konfiguracja przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage', '--no-sandbox', '--headless=new');

    // Utworzenie instancji przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozdzielczości okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('=== Rozpoczęcie testu: wyszukiwanie na blogu ===');

    // Krok 1: Wejście na stronę główną
    await driver.get(BASE_URL);

    // Krok 2: Przejście do sekcji „Blog”
    const blogLink = await driver.wait(until.elementLocated(By.linkText('Blog')), 5000);
    await blogLink.click();

    // Krok 3: Wpisanie frazy wyszukiwania
    const searchInput = await driver.wait(until.elementLocated(By.name('search')), 5000);
    await searchInput.sendKeys(SEARCH_TERM);

    // Krok 4: Kliknięcie przycisku „Szukaj”
    const searchButton = await driver.findElement(By.css('button[type="submit"]'));
    await searchButton.click();

    // Krok 5: Poczekanie na wyniki wyszukiwania
    await driver.wait(until.elementLocated(By.css('.post-item__title a')), 10000);

    // Pobranie wszystkich tytułów wpisów (bez trzymania referencji do elementów)
    const titleTexts = await driver.executeScript(() => {
      return Array.from(document.querySelectorAll('.post-item__title a'))
        .map(el => el.textContent.trim().toLowerCase());
    });

    // Logowanie liczby wyników
    console.log(`Znaleziono ${titleTexts.length} wyników wyszukiwania.`);

    // Sprawdzenie, czy szukany wpis istnieje w wynikach
    const found = titleTexts.includes(SEARCH_TERM.toLowerCase());

    if (found) {
      success = true;
      message = `Znaleziono wpis: "${SEARCH_TERM}"`;
    } else {
      message = `Nie znaleziono wpisu: "${SEARCH_TERM}"`;
    }

    console.log(message);

  } catch (err) {
    // Obsługa błędów
    message = `Błąd wykonania testu: ${err.message}`;
    console.error(message);
  } finally {
    // Zamknięcie przeglądarki i zapis wyniku do logów
    if (driver) await driver.quit();
    logTestResult('blog_search_results_test', success, message);
  }
})();
