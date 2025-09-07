import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych
dotenv.config();
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');
const testName = 'success_login_test';

(async function successLoginTest() {
  let driver;
  let passed = true;

  try {
    // Konfiguracja przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Rozpoczęcie testu poprawnego logowania...');

    // Wejście na stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Kliknięcie przycisku logowania
    const loginBtn = await driver.wait(
      until.elementLocated(By.css('a.header-login[href$="/login"]')),
      5000
    );
    await loginBtn.click();
    console.log('Kliknięto "Zaloguj"');

    await driver.sleep(1500);

    // Wypełnienie formularza logowania
    const usernameInput = await driver.wait(until.elementLocated(By.css('input[name="login"]')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.css('input[name="password"]')), 5000);
    await usernameInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('12341234');

    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    await driver.sleep(800);

    // Kliknięcie przycisku "Zaloguj się"
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Kliknięto "Zaloguj się"');

    await driver.sleep(1500);

    // Sprawdzenie obecności komunikatu powitalnego
    const introDiv = await driver.wait(until.elementLocated(By.css('.ma-lcol-intro')), 5000);
    const text = await introDiv.getText();

    if (text.toLowerCase().includes('witaj ponownie')) {
      console.log('Zalogowano pomyślnie!');
      logTestResult(testName, true);
    } else {
      console.log('Nie znaleziono potwierdzenia logowania.');
      passed = false;
      logTestResult(testName, false, 'Brak potwierdzenia "Witaj ponownie"');
    }

    await driver.sleep(3000);
    await driver.quit();

  } catch (error) {
    // Obsługa błędów
    console.error('Błąd:', error);
    if (driver) await driver.quit();
    logTestResult(testName, false, error.message);
  }
})();
