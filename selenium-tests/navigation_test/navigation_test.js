import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Import funkcji logującej wynik testu

// Załaduj zmienne środowiskowe z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, '');
const testName = 'navigation_test';

(async function runNavigationTest() {
  let driver;
  let passed = true; // Domyślnie zakładamy, że test zakończy się sukcesem

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Inicjalizacja WebDrivera
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Przeglądarka została uruchomiona.');

    // Przejście na stronę główną
    await driver.get(BASE_URL);
    console.log('Strona główna została załadowana.');
    await driver.sleep(3500); // Dodatkowe opóźnienie dla stabilności

    // Funkcja klikająca w podany link w menu
    const clickMenu = async (linkText) => {
      try {
        const link = await driver.wait(until.elementLocated(By.linkText(linkText)), 5000);
        await link.click();
        console.log(`Kliknięto w link: ${linkText}`);
        await driver.sleep(2000); // Pozwól stronie się załadować po kliknięciu
      } catch (err) {
        console.warn(`Nie znaleziono linku: "${linkText}"`);
        passed = false;
      }
    };

    // Lista pozycji menu do przetestowania
    const menuItems = ['Blog', 'Single', 'Kontakt', 'Home'];
    for (const item of menuItems) {
      await clickMenu(item);
    }

    // Zamknięcie przeglądarki po zakończeniu testu
    await driver.quit();
    console.log('Przeglądarka zamknięta. Test zakończony.');

    // Zalogowanie wyniku testu
    logTestResult(testName, passed);

  } catch (error) {
    console.error('Wystąpił błąd krytyczny:', error.message);
    if (driver) await driver.quit();
    logTestResult(testName, false, error.message); // Logujemy niepowodzenie
  }
})();
