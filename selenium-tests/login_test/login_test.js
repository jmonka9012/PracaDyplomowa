import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');

// Nazwa testu do logowania wyników
const testName = 'login_test';

(async function runLoginTest() {
  let driver;
  let passed = false;

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Inicjalizacja WebDrivera z Chrome
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Rozpoczynanie testu logowania...');

    // Otwórz stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Kliknięcie przycisku logowania po klasie i href
    const loginLink = await driver.wait(
  until.elementLocated(By.css('a.header__login[href$="/login"]')),
  5000);

    await loginLink.click();
    console.log('Przejście do formularza logowania');
    await driver.sleep(1500);

    // Znalezienie pól formularza po ID
    const usernameInput = await driver.wait(until.elementLocated(By.id('login')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.id('password')), 5000);
    await driver.sleep(500);

    // Wprowadzenie niepoprawnych danych
    await usernameInput.sendKeys('bzdura');
    await passwordInput.sendKeys('123');

    // Przewinięcie widoku w dół (jeśli przycisk jest poza ekranem)
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    await driver.sleep(800);

    // Kliknięcie w przycisk "Zaloguj się"
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Formularz logowania został wysłany');
    await driver.sleep(1500);

    // Analiza treści strony po próbie logowania
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const lines = bodyText.split('\n');

    // Sprawdzenie obecności komunikatu błędu logowania
    const keywords = ['nie istnieje', 'błędne', 'niepoprawne', 'nieprawidłowe', 'invalid'];
    const errorLine = lines.find(line =>
      keywords.some(keyword => line.toLowerCase().includes(keyword))
    );

    if (errorLine) {
      console.log('Zidentyfikowano komunikat błędu:', errorLine);
      passed = true;
    } else {
      console.log('Brak komunikatu o błędzie logowania');
    }

    // Zamknięcie przeglądarki
    await driver.sleep(3000);
    await driver.quit();

  } catch (error) {
    // Obsługa błędów
    console.error('Wystąpił błąd podczas testu logowania:', error);
    if (driver) await driver.quit();
  } finally {
    // Logowanie wyniku testu
    logTestResult(testName, passed);
  }
})();
