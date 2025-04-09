import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usunięcie cudzysłowów z adresu, jeżeli występują

(async function runNavigationTest() {
  let driver;

  try {
    // Konfiguracja opcji dla przeglądarki Chrome 
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage'); // Zapobiega problemom w środowiskach z małą ilością pamięci
    options.addArguments('--no-sandbox'); // Wymagane w niektórych środowiskach CI/CD
    options.addArguments('--remote-debugging-port=9222'); // Port debugowania (potrzebny w trybie zdalnym)

    // Inicjalizacja przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 }); // Ustawienie rozmiaru okna
    console.log('Przeglądarka uruchomiona.');

    // Przejście na stronę główną
    await driver.get(BASE_URL);
    console.log('Strona główna załadowana.');

    await driver.sleep(3500); // Czekanie na pełne załadowanie interfejsu

    // Funkcja klikająca w dany element menu po linkText
    const clickMenu = async (linkText) => {
      try {
        const link = await driver.wait(until.elementLocated(By.linkText(linkText)), 5000);
        await link.click();
        console.log(`Kliknięto: ${linkText}`);
        await driver.sleep(2000); // Krótkie czekanie po przejściu
      } catch (err) {
        console.log(`Link "${linkText}" nie został znaleziony.`);
      }
    };

    // Lista elementów menu do przejścia
    const menuItems = ['Blog', 'Single', 'Kontakt', 'Home'];
    for (const item of menuItems) {
      await clickMenu(item);
    }

    // Zamykanie przeglądarki
    await driver.quit();
    console.log('Przeglądarka zamknięta, test zakończony.');

  } catch (error) {
    // Obsługa błędów krytycznych
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
