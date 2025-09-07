import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const raw = (process.env.APP_URL || '').replace(/"/g, '').trim();
const BASE_URL = raw.replace(/^https:\/\//i, 'http://');

// Główna funkcja testowa: weryfikacja działania wyszukiwarki bloga
(async function blogSearchResultsTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--headless=new');
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');

    // Inicjalizacja przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozdzielczości okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Rozpoczęcie testu: wyszukiwanie na blogu');

    // Otwarcie strony głównej
    await driver.get(BASE_URL);
    await driver.sleep(1000); // Krótkie oczekiwanie na załadowanie strony

    // Przejście do sekcji „Blog” poprzez kliknięcie linku
    const blogLink = await driver.wait(until.elementLocated(By.linkText('Blog')), 5000);
    await blogLink.click();
    await driver.sleep(2000);

    // Zlokalizowanie pola wyszukiwania i wpisanie frazy „test”
    const searchInput = await driver.wait(
      until.elementLocated(By.css('input[type="search"], input[type="text"]')),
      5000
    );
    await searchInput.sendKeys('test');
    await searchInput.sendKeys('\n'); // Zatwierdzenie wyszukiwania
    await driver.sleep(2000);

    // Pobranie wyników wyszukiwania (np. wpisów blogowych)
    const results = await driver.findElements(By.css('article, .post, .blog-entry'));
    const resultCount = results.length;

    // Wyświetlenie i zapisanie liczby wyników w logach
    console.log(`Liczba wyników wyszukiwania: ${resultCount}`);
    logTestResult('blog_search_results_test', true, `Znaleziono ${resultCount} wyników`);

    testPassed = true;

  } catch (error) {
    // Obsługa wyjątków i zapisanie błędu w logach
    console.error('Błąd wykonania testu:', error.message);
    logTestResult('blog_search_results_test', false, error.message);
  } finally {
    // Zamknięcie przeglądarki, niezależnie od wyniku testu
    await driver.quit();
  }
})();
