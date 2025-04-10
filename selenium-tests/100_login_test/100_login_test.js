import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Logowanie wyniku testu

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/"/g, '');

(async function rapidLoginClickTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja opcji przeglądarki
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Inicjalizacja sterownika
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    // Otwarcie strony bazowej
    console.log('Przejście na stronę główną aplikacji');
    await driver.get(BASE_URL);
    await driver.sleep(100);

    // Inicjalizacja liczników wyników
    let sukcesy = 0;
    let błędy = 0;

    console.log('Rozpoczęcie szybkiego klikania w "Login"');

    // Wykonanie 100 prób kliknięcia w przycisk "Login"
    for (let i = 0; i < 100; i++) {
      try {
        // Wyszukiwanie i klikanie przycisku "Login"
        const loginBtn = await driver.wait(until.elementLocated(By.linkText('Login')), 100);
        await loginBtn.click();

        // Oczekiwanie na pojawienie się formularza logowania
        await driver.wait(until.elementLocated(By.css('form input[type="text"]')), 200);

        // Zliczanie udanego przejścia
        sukcesy++;
      } catch {
        // Zliczanie błędnego przejścia
        błędy++;
      }

      // Powrót na stronę główną
      await driver.get(BASE_URL);
    }

    // Podsumowanie wyników
    console.log(`Liczba prób: 100`);
    console.log(`Udane przejścia do logowania: ${sukcesy}`);
    console.log(`Nieudane próby: ${błędy}`);

    // Ocena powodzenia testu
    if (sukcesy >= 90) testPassed = true;

    // Zamykanie przeglądarki
    await driver.quit();
  } catch (error) {
    console.error('Błąd podczas wykonywania testu:', error);
    if (driver) await driver.quit();
  } finally {
    // Zapis wyniku testu do pliku logów
    logTestResult('100_login_test', testPassed);
  }
})();
