import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

// Konfiguracja zmiennych środowiskowych
dotenv.config();
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Adres bazowy aplikacji
const BASE_URL = (process.env.APP_URL || '')
  .replace(/(^"|"$)/g, '')
  .replace(/^https:/i, 'http:');

// Ścieżka do pliku logów
const logPath = path.resolve(__dirname, '../logs/logs.txt');

/**
 * Zapisuje wynik testu do pliku logów.
 * @param {string} testName - Nazwa testu
 * @param {boolean} passed - Wynik testu
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

(async function unauthorizedAccessAdminTest() {
  const testName = 'unauthorized_access_test';
  let driver;

  try {
    // Konfiguracja Chrome w trybie headless
    const options = new chrome.Options()
      .addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    console.log(`Rozpoczęcie testu: ${testName}`);

    // Wejście na stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(500);

    // Wejście do formularza logowania (symulacja użytkownika niezalogowanego)
    const loginButton = await driver.findElement(By.css('a[href$="/login"]'));
    await loginButton.click();
    await driver.sleep(500);

    // Próba otwarcia strony administratora bez logowania
    const adminUrl = `${BASE_URL}/admin`;
    console.log(`Próba otwarcia strony administratora: ${adminUrl}`);
    await driver.get(adminUrl);
    await driver.sleep(1000);

    // Sprawdzenie aktualnego adresu URL
    const currentUrl = await driver.getCurrentUrl();
    console.log(`Aktualny adres URL: ${currentUrl}`);
    const redirectedToLogin = currentUrl.includes('/login');

    // Sprawdzenie obecności formularza logowania
    let loginFormDetected = false;
    try {
      await driver.findElement(By.css('input[name="login"]'));
      loginFormDetected = true;
    } catch {
      loginFormDetected = false;
    }

    // Sprawdzenie czy panel admina nie jest widoczny
    let adminPanelVisible = false;
    try {
      const bodyText = await driver.findElement(By.tagName('body')).getText();
      adminPanelVisible = bodyText.includes('Panel administratora') || bodyText.includes('Backend');
    } catch {
      adminPanelVisible = false;
    }

    // Ostateczna weryfikacja
    const testPassed = redirectedToLogin && loginFormDetected && !adminPanelVisible;
    logTestResult(testName, testPassed);

    console.log(`Zakończenie testu: ${testName}`);
    await driver.quit();

  } catch (error) {
    console.error(`Błąd testu: ${error.message}`);
    logTestResult('unauthorized_access_test', false);
    if (driver) await driver.quit();
  }
})();
