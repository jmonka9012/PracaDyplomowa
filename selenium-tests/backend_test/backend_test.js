import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Pobranie podstawowego URL aplikacji
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');

// Ustalenie nazwy testu do logowania wyników
const testName = 'backend_test';

// Główna funkcja testowa
(async function backendTest() {
  let driver;
  let success = false;
  let message = '';

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--no-sandbox', '--disable-dev-shm-usage', '--disable-gpu');

    // Parametr kontrolujący uruchamianie testu w trybie headless
    const HEADLESS = true;
    if (HEADLESS) {
      options.addArguments('--headless');
    }

    // Inicjalizacja sterownika Selenium WebDriver
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozdzielczości okna przeglądarki
    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    console.log('Rozpoczęcie testu backendu administracyjnego.');

    // Przejście na stronę główną aplikacji
    await driver.get(BASE_URL);

    // Oczekiwanie na pojawienie się i kliknięcie w link "Zaloguj"
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Zaloguj')), 10000);
    await loginLink.click();

    // Wypełnienie formularza logowania
    const loginInput = await driver.wait(until.elementLocated(By.name('login')), 10000);
    const passwordInput = await driver.findElement(By.name('password'));
    const submitBtn = await driver.findElement(By.css('input[type="submit"]'));

    await loginInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('12341234');
    await submitBtn.click();

    // Weryfikacja poprawnego zalogowania poprzez sprawdzenie obecności w URL
    await driver.wait(until.urlContains('/moje-konto'), 10000);

    // Nawigacja do panelu administracyjnego (backendu)
    const backendBtn = await driver.wait(until.elementLocated(By.linkText('Backend')), 10000);
    await backendBtn.click();

    // Weryfikacja poprawnego przejścia do sekcji administracyjnej
    await driver.wait(until.urlContains('/admin'), 10000);

    // Pobranie listy dostępnych opcji w panelu backend
    const opcje = await driver.findElements(By.css('p.fw-bold.fs-24'));

    console.log('\nLista dostępnych opcji w panelu backend:');
    for (const opcja of opcje) {
      const text = await opcja.getText();
      if (text.trim().length > 0) {
        console.log(`- ${text.trim()}`);
      }
    }

    // Oznaczenie testu jako zakończonego sukcesem
    success = true;
    message = 'Test zakończony pomyślnie.';
    console.log(message);

  } catch (err) {
    // Obsługa błędów wykonania testu
    message = err.message;
    console.error(`Błąd wykonania testu: ${message}`);
  } finally {
    // Zamykanie sesji przeglądarki i rejestracja wyniku testu
    if (driver) {
      await driver.quit();
    }
    logTestResult(testName, success, message);
  }
})();
