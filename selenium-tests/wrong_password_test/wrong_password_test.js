import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytaj zmienne środowiskowe z pliku .env
dotenv.config();
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');
const testName = 'wrong_password_test';

(async function wrongPasswordTest() {
  let driver;

  try {
    // Konfiguracja opcji przeglądarki
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Uruchomienie przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Rozpoczęcie testu z błędnym hasłem...');

    // Przejście na stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Kliknięcie przycisku "Zaloguj"
    const loginLink = await driver.wait(
      until.elementLocated(By.css('a.header-login[href$="/login"]')),
      5000
    );
    await loginLink.click();
    console.log('Kliknięto "Zaloguj"');

    await driver.sleep(1000);

    // Wprowadzenie błędnych danych logowania
    const usernameInput = await driver.wait(until.elementLocated(By.id('login')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.id('password')), 5000);
    await usernameInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('zlehaslo123');

    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    await driver.sleep(500);

    // Kliknięcie przycisku "Zaloguj się"
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Kliknięto "Zaloguj się"');

    await driver.sleep(1500);

    // Weryfikacja komunikatu błędu
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const keywords = ['nie istnieje', 'błędne', 'niepoprawne', 'nieprawidłowe', 'invalid'];

    const foundKeyword = keywords.find(keyword =>
      bodyText.toLowerCase().includes(keyword)
    );

    if (foundKeyword) {
      console.log(`Znaleziono komunikat o błędzie zawierający: "${foundKeyword}"`);
      logTestResult(testName, true);
    } else {
      console.warn('Nie znaleziono komunikatu o błędzie.');
      logTestResult(testName, false, 'Brak komunikatu o błędzie przy złym haśle.');
    }

    // Zamknięcie przeglądarki po zakończeniu testu
    await driver.quit();

  } catch (error) {
    // Obsługa błędów i zamknięcie przeglądarki
    console.error('Błąd:', error);
    if (driver) await driver.quit();
    logTestResult(testName, false, error.message);
  }
})();
