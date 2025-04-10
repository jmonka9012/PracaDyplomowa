import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Ładowanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Uzyskanie adresu URL aplikacji z pliku konfiguracyjnego
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, '');

// Nazwa testu, używana do logowania wyników
const testName = 'stress_login_test';

(async function stressLoginTest() {
  let driver;
  let passed = true;  // Flaga określająca, czy test przeszedł pomyślnie

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');  // Wyłączenie dev/shm dla dużych aplikacji
    options.addArguments('--no-sandbox');  // Wyłączenie sandboxa w celu uniknięcia błędów na systemach Linux
    options.addArguments('--remote-debugging-port=9222');  // Uruchomienie portu debugowania zdalnego

    // Budowanie instancji WebDrivera z wybranym profilem przeglądarki Chrome
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    // Otwieranie strony głównej aplikacji
    console.log('Otwieram stronę...');
    await driver.get(BASE_URL);
    await driver.sleep(1000);  // Czekamy 1 sekundę, by strona zdążyła się załadować

    // Szukanie przycisku logowania
    console.log('Szukanie przycisku "Login"...');
    const loginBtn = await driver.findElement(By.linkText('Login'));

    // Zmienna do przechowywania liczby udanych i nieudanych prób kliknięcia
    let success = 0;
    let failed = 0;

    // Ustalamy czas trwania testu na 3000 ms (3 sekundy)
    const startTime = Date.now();
    const duration = 3000;

    console.log('Rozpoczynam szybkie klikanie...');
    while (Date.now() - startTime < duration) {
      try {
        // Kliknięcie w przycisk logowania
        await loginBtn.click();
        success++;  // Inkrementacja liczby udanych kliknięć
      } catch (e) {
        failed++;  // Inkrementacja liczby nieudanych prób kliknięcia
      }
    }

    // Po zakończeniu testu, wyświetlamy wyniki
    console.log('Klikanie zakończone.');
    console.log(`Udane kliknięcia: ${success}`);
    console.log(`Nieudane próby: ${failed}`);

    // Jeśli nie udało się wykonać żadnego kliknięcia, test uznaje się za nieudany
    if (success === 0) {
      passed = false;
      logTestResult(testName, false, 'Brak udanych kliknięć przycisku "Login"');
    } else {
      // Logowanie wyniku testu (sukces)
      logTestResult(testName, true);
    }

    // Czekanie 2 sekundy przed zamknięciem przeglądarki
    await driver.sleep(2000);
    console.log('Zamykam przeglądarkę...');
    await driver.quit();

  } catch (error) {
    // Obsługa błędów, logowanie błędu i zamykanie przeglądarki w przypadku awarii
    console.error('Błąd:', error);
    if (driver) await driver.quit();
    logTestResult(testName, false, error.message);
  }
})();
