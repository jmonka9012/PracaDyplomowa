import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Pobranie adresu URL aplikacji z konfiguracji
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');

// Nazwa testu, używana w logach
const testName = 'stress_login_test';

(async function stressLoginTest() {
  let driver;

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Inicjalizacja sterownika Selenium z Chrome
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Rozpoczęcie testu przeciążeniowego przycisku logowania...');

    // Liczniki sukcesów i błędów kliknięć
    let success = 0;
    let failed = 0;

    // Czas rozpoczęcia i czas trwania testu (3 sekundy)
    const startTime = Date.now();
    const duration = 3000;

    // Pętla wykonująca szybkie próby kliknięcia przez określony czas
    while (Date.now() - startTime < duration) {
      try {
        // Odwiedzenie strony głównej aplikacji
        await driver.get(BASE_URL);

        // Krótkie opóźnienie, aby strona się załadowała
        await driver.sleep(100);

        // Wyszukanie przycisku "Zaloguj" po selektorze CSS
        const loginBtn = await driver.wait(
          until.elementLocated(By.css('a.header-login[href$="/login"]')),
          500
        );

        // Kliknięcie przycisku logowania
        await loginBtn.click();
        success++; // Zliczanie udanego kliknięcia

      } catch {
        failed++; // Zliczanie nieudanego kliknięcia
      }
    }

    // Podsumowanie wyników testu
    console.log('Klikanie zakończone.');
    console.log(`Udane kliknięcia: ${success}`);
    console.log(`Nieudane próby: ${failed}`);

    // Warunek zaliczenia testu: przynajmniej jedno udane kliknięcie
    if (success === 0) {
      logTestResult(testName, false, 'Brak udanych kliknięć przycisku logowania.');
    } else {
      logTestResult(testName, true);
    }

    // Zamykanie przeglądarki po zakończeniu testu
    await driver.quit();

  } catch (error) {
    // Obsługa błędów i zamykanie przeglądarki w razie wyjątku
    console.error('Błąd:', error);
    if (driver) await driver.quit();
    logTestResult(testName, false, error.message);
  }
})();
