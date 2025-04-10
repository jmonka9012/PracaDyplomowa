import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Funkcja do logowania wyników testów

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usunięcie potencjalnych cudzysłowów

(async function runLoginTest() {
  let driver;
  const testName = 'login_test';
  let passed = false;

  try {
    // Konfiguracja opcji przeglądarki Chrome 
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Inicjalizacja WebDrivera
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Rozpoczynanie testu logowania...');
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Kliknięcie w link logowania
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Login')), 5000);
    await loginLink.click();
    console.log('Przejście do formularza logowania');
    await driver.sleep(1500);

    // Wprowadzenie niepoprawnych danych logowania
    const usernameInput = await driver.wait(until.elementLocated(By.css('input[type="text"]')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.css('input[type="password"]')), 5000);
    await driver.sleep(500);
    await usernameInput.sendKeys('bzdura');
    await passwordInput.sendKeys('123');

    // Przewinięcie widoku w dół (jeśli formularz nie jest w pełni widoczny)
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

    await driver.sleep(3000);
    await driver.quit();
  } catch (error) {
    console.error('Wystąpił błąd podczas testu logowania:', error);
    if (driver) await driver.quit();
  } finally {
    // Logowanie wyniku testu (sukces/porażka)
    logTestResult(testName, passed);
  }
})();
