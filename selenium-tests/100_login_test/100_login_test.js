import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Logowanie wyniku testu

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/"/g, '');

// Asynchroniczna funkcja testująca szybkie klikanie w przycisk logowania
(async function rapidLoginClickTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');       // Optymalizacja zużycia pamięci
    options.addArguments('--no-sandbox');                   // Wyłączenie sandboxa 
    options.addArguments('--remote-debugging-port=9222');   // Port debugowania (opcjonalny)

    // Inicjalizacja sterownika przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Przejście na stronę główną aplikacji...');
    await driver.get(BASE_URL);
    await driver.sleep(100);

    // Liczniki sukcesów i błędów
    let successCount = 0;
    let errorCount = 0;
    const attempts = 100;

    console.log(`Rozpoczęcie ${attempts} prób kliknięcia przycisku "Zaloguj"...`);

    for (let i = 0; i < attempts; i++) {
      try {
        // Wyszukanie przycisku logowania po klasie CSS
        const loginBtn = await driver.wait(
          until.elementLocated(By.css('a.header-login')),
          200
        );
        await loginBtn.click();

        // Sprawdzenie, czy pojawił się formularz logowania
        await driver.wait(until.elementLocated(By.css('form input[type="text"]')), 300);

        successCount++;
      } catch (err) {
        // Zliczanie nieudanych prób (np. brak elementu lub timeout)
        errorCount++;
      }

      // Powrót do strony głównej przed kolejną iteracją
      await driver.get(BASE_URL);
    }

    // Raport z wynikami testu
    console.log(`Liczba prób: ${attempts}`);
    console.log(`Udane przejścia do logowania: ${successCount}`);
    console.log(`Nieudane próby: ${errorCount}`);

    // Ocena sukcesu testu — wymagane minimum 90% skuteczności
    if (successCount >= 90) {
      testPassed = true;
    }

    // Zamykanie przeglądarki po zakończeniu testu
    await driver.quit();

  } catch (error) {
    // Obsługa ewentualnych błędów testu
    console.error('Błąd podczas wykonywania testu:', error);
    if (driver) await driver.quit();
  } finally {
    // Zapisanie wyniku testu do logów
    logTestResult('100_login_test', testPassed);
  }
})();
