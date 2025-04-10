import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Import logowania wyników testów

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usunięcie cudzysłowów z wartości
const testName = 'navbar_links_test';

(async function runNavbarLinksTest() {
  let driver;
  let passed = true; // Domyślnie zakładamy, że test zakończy się sukcesem

  try {
    // Konfiguracja opcji Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');
    options.addArguments('--window-size=1280,800');

    // Inicjalizacja WebDrivera
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    console.log('Uruchomiono przeglądarkę.');
    await driver.get(BASE_URL);
    console.log('Załadowano stronę główną.');
    await driver.sleep(2000);

    // Lista oczekiwanych linków w nawigacji
    const links = ['Home', 'Blog', 'Single', 'Kontakt', 'CE', 'Jacek CE'];

    // Iteracja przez każdy link i weryfikacja jego widoczności
    for (const text of links) {
      try {
        const element = await driver.wait(until.elementLocated(By.linkText(text)), 5000);
        const isDisplayed = await element.isDisplayed();
        console.log(`Link "${text}" widoczny: ${isDisplayed}`);
        if (!isDisplayed) passed = false;
      } catch (err) {
        console.warn(`Nie znaleziono linku: "${text}"`);
        passed = false;
      }
    }

    await driver.sleep(2000);
    console.log('Zamykanie przeglądarki.');
    await driver.quit();

    // Logowanie wyniku testu
    logTestResult(testName, passed);

  } catch (error) {
    console.error('Wystąpił błąd krytyczny:', error);
    if (driver) await driver.quit();
    logTestResult(testName, false); // Logowanie niepowodzenia
  }
})();
