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
 * @param {string} testName - nazwa testu
 * @param {boolean} passed - wynik testu
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

(async function wrongPasswordTest() {
  const testName = 'wrong_password_test';
  let driver;

  try {
    // Konfiguracja Chrome w trybie headless
    const options = new chrome.Options()
      .addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log(`Rozpoczęcie testu: ${testName}`);

    // Wejście na stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(500);

    // Otwarcie strony logowania
    const loginLink = await driver.findElement(By.css('a.header-login[href$="/login"]'));
    await loginLink.click();
    console.log('Kliknięto "Zaloguj"');
    await driver.sleep(1000);

    // Wypełnienie formularza logowania błędnymi danymi
    const usernameInput = await driver.findElement(By.css('input[name="login"]'));
    const passwordInput = await driver.findElement(By.css('input[name="password"]'));
    await usernameInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('zlehaslo123');

    // Kliknięcie przycisku "Zaloguj się"
    const submitBtn = await driver.findElement(By.css('input[type="submit"][value="Zaloguj się"]'));
    await submitBtn.click();
    console.log('Kliknięto "Zaloguj się"');
    await driver.sleep(1500);

    // Sprawdzenie, czy wciąż jesteśmy na stronie logowania
    const currentUrl = await driver.getCurrentUrl();
    const stillOnLoginPage = currentUrl.includes('/login');

    // Sprawdzenie komunikatu błędu
    let errorMessageFound = false;
    try {
      const errorMsg = await driver.findElement(By.css('.error-msg')).getText();
      if (errorMsg.toLowerCase().includes('niepoprawne') || errorMsg.toLowerCase().includes('błędne')) {
        errorMessageFound = true;
        console.log(`Znaleziono komunikat błędu: ${errorMsg}`);
      }
    } catch {
      errorMessageFound = false;
    }

    // Sprawdzenie, czy formularz logowania nadal jest widoczny
    let loginFormStillVisible = false;
    try {
      await driver.findElement(By.css('input[name="login"]'));
      loginFormStillVisible = true;
    } catch {
      loginFormStillVisible = false;
    }

    // Ocena końcowa testu
    const testPassed = stillOnLoginPage && errorMessageFound && loginFormStillVisible;
    logTestResult(testName, testPassed);

    console.log(`Zakończenie testu: ${testName}`);
    await driver.quit();
  } catch (error) {
    console.error(`Błąd testu: ${error.message}`);
    logTestResult(testName, false);
    if (driver) await driver.quit();
  }
})();
