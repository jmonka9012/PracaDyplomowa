import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

// Załadowanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Ustalenie ścieżki pliku i katalogu na podstawie URL
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Pobranie adresu bazowego aplikacji
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');

// Określenie ścieżki do pliku logu testowego
const logPath = path.resolve(__dirname, '../logs/logs.txt');

/**
 * Funkcja zapisująca wynik testu do pliku oraz wyświetlająca go w terminalu
 * @param {string} testName - nazwa testu
 * @param {boolean} passed - wynik testu (true/false)
 */
function logTestResult(testName, passed) {
  const logEntry = `${testName}_Passed : ${passed}\n`;
  try {
    fs.appendFileSync(logPath, logEntry, 'utf8');
    console.log(logEntry.trim());
  } catch (error) {
    console.error(`Błąd podczas zapisu do pliku logs.txt: ${error.message}`);
  }
}

/**
 * Test weryfikujący zachowanie aplikacji w przypadku próby nieautoryzowanego dostępu do panelu administratora
 */
(async function unauthorizedAccessAdminTest() {
  const testName = 'unauthorized_access_test';
  let driver;

  try {
    // Konfiguracja przeglądarki Chrome w trybie headless
    const options = new chrome.Options();
    options.addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    // Inicjalizacja instancji przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    // Wyświetlenie informacji o rozpoczęciu testu
    console.log(`Rozpoczęcie testu: ${testName}`);

    // Przejście na stronę główną aplikacji
    console.log(`Otwieranie strony głównej: ${BASE_URL}`);
    await driver.get(BASE_URL);

    // Wyszukanie i kliknięcie przycisku "Zaloguj"
    console.log('Klikanie przycisku "Zaloguj" na stronie głównej.');
    const loginButton = await driver.findElement(By.css('a[href$="/login"]'));
    await loginButton.click();

    // Próba przejścia bezpośrednio do panelu administratora bez wcześniejszego logowania
    const adminUrl = `${BASE_URL}/admin`;
    console.log(`Próba otwarcia strony administratora: ${adminUrl}`);
    await driver.get(adminUrl);

    // Oczekiwanie na przekierowanie na stronę logowania
    console.log('Weryfikacja, czy nastąpiło przekierowanie na stronę logowania.');
    await driver.wait(until.urlContains('/login'), 10000);

    // Pobranie aktualnego adresu URL
    const currentUrl = await driver.getCurrentUrl();
    console.log(`Aktualny adres URL: ${currentUrl}`);

    // Sprawdzenie, czy użytkownik został poprawnie przekierowany na stronę logowania
    if (currentUrl.includes('/login')) {
      logTestResult(testName, true);
    } else {
      logTestResult(testName, false);
    }

    // Zakończenie pracy przeglądarki
    console.log(`Zakończenie testu: ${testName}`);
    await driver.quit();

  } catch (error) {
    // Obsługa błędów pojawiających się podczas wykonywania testu
    console.error(`Błąd testu: ${error.message}`);
    logTestResult(testName, false);
    if (driver) await driver.quit();
  }
})();
