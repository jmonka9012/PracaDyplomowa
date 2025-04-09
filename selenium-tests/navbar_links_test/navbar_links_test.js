import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usunięcie cudzysłowów z adresu

(async function runNavbarLinksTest() {
  let driver;

  try {
    // Konfiguracja opcji przeglądarki (głównie pod CI)
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');
    options.addArguments('--window-size=1280,800');

    // Uruchomienie przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    console.log('Przeglądarka uruchomiona.');

    // Przejście na stronę główną
    await driver.get(BASE_URL);
    console.log('Strona główna załadowana.');

    await driver.sleep(2000); // Czekanie na załadowanie widoku

    // Lista linków do sprawdzenia w navbarze
    const links = ['Home', 'Blog', 'Single', 'Kontakt', 'CE', 'Jacek CE'];

    // Przeglądanie i sprawdzanie widoczności linków
    for (const text of links) {
      try {
        const element = await driver.wait(until.elementLocated(By.linkText(text)), 5000);
        const isDisplayed = await element.isDisplayed();
        console.log(`Link "${text}" widoczny: ${isDisplayed}`);
      } catch (err) {
        console.log(`Link "${text}" nie został znaleziony.`);
      }
    }

    await driver.sleep(2000); // Krótkie opóźnienie przed zamknięciem

    // Zamykanie przeglądarki
    await driver.quit();
    console.log('Przeglądarka zamknięta, test zakończony.');

  } catch (error) {
    // Obsługa błędów krytycznych
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
