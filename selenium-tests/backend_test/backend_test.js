// Import wymaganych modułów
import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Pobranie podstawowego URL aplikacji
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '');
const testName = 'backend_test';

(async function backendTest() {
  let driver;
  let success = false;
  let message = '';

  try {
    // Konfiguracja przeglądarki Chrome w trybie headless
    const options = new chrome.Options();
    options.addArguments('--headless', '--no-sandbox', '--disable-dev-shm-usage', '--disable-gpu');

    // Utworzenie instancji przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozdzielczości okna przeglądarki
    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    console.log('=== Rozpoczęcie testu backendu administracyjnego ===');

    // Wejście na stronę główną aplikacji
    await driver.get(BASE_URL);

    // Przejście do formularza logowania
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Zaloguj')), 10000);
    await loginLink.click();

    // Wprowadzenie danych logowania
    const loginInput = await driver.wait(until.elementLocated(By.name('login')), 10000);
    const passwordInput = await driver.findElement(By.name('password'));
    const submitBtn = await driver.findElement(By.css('input[type="submit"]'));

    await loginInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('12341234');
    await submitBtn.click();

    // Weryfikacja poprawnego zalogowania – oczekiwanie na stronę "moje konto"
    await driver.wait(until.urlMatches(/\/moje-konto(\?page=\d+)?/), 10000);

    // Sprawdzenie dostępności linku "Backend"
    const backendLinks = await driver.findElements(By.linkText('Backend'));
    if (backendLinks.length === 0) {
      throw new Error('Brak dostępu do panelu Backend – użytkownik nie ma uprawnień administratora.');
    }

    // Wejście do panelu administracyjnego
    await backendLinks[0].click();
    await driver.wait(until.urlContains('/admin'), 10000);

    // Pobranie i wyświetlenie listy opcji dostępnych w panelu Backend
    const opcje = await driver.findElements(By.css('p.fw-bold.fs-24'));
    console.log('\nLista dostępnych opcji w panelu Backend:');
    for (const opcja of opcje) {
      const text = await opcja.getText();
      if (text.trim().length > 0) {
        console.log(`- ${text.trim()}`);
      }
    }

    // Zakończenie testu pomyślnie
    success = true;
    message = 'Test zakończony pomyślnie – dostęp do panelu Backend został potwierdzony.';
    console.log(message);

  } catch (err) {
    // Obsługa błędów testu
    message = `Błąd wykonania testu: ${err.message}`;
    console.error(message);
  } finally {
    // Zamknięcie przeglądarki i zapis wyniku testu do logów
    if (driver) await driver.quit();
    logTestResult(testName, success, message);
  }
})();
