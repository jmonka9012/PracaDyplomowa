import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

dotenv.config();
const BASE_URL = (process.env.APP_URL || '')
  .replace(/(^"|"$)/g, '')
  .replace(/^https:/i, 'http:');
const testName = 'success_login_test';

(async function successLoginTest() {
  let driver;
  let passed = true;

  try {
    // 1. Uruchom Chrome
    const options = new chrome.Options()
      .addArguments('--disable-dev-shm-usage')
      .addArguments('--no-sandbox');
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Rozpoczęcie testu poprawnego logowania...');

    // 2. Otwórz stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // 3. Kliknij "Zaloguj"
    const loginLink = await driver.wait(
      until.elementLocated(By.css('a.header-login[href$="/login"]')),
      5000
    );
    await loginLink.click();
    console.log('Kliknięto "Zaloguj"');
    await driver.sleep(1000);

    // 4. Wypełnij formularz
    const usernameInput = await driver.wait(
      until.elementLocated(By.css('input[name="login"]')),
      5000
    );
    const passwordInput = await driver.wait(
      until.elementLocated(By.css('input[name="password"]')),
      5000
    );
    await usernameInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('12341234');

    // 5. Scroll i kliknij "Zaloguj się"
    await driver.executeScript('window.scrollBy(0, window.innerHeight/3);');
    await driver.sleep(500);
    const submitBtn = await driver.wait(
      until.elementLocated(
        By.css('input[type="submit"][value="Zaloguj się"]')
      ),
      5000
    );
    await submitBtn.click();
    console.log('Kliknięto "Zaloguj się"');

    // 6. Czekaj na nagłówek "Mój profil"
    await driver.wait(
      until.elementLocated(By.xpath("//h1[contains(normalize-space(.),'Mój profil')]")),
      7000
    );

    // 7. Pobierz tekst strony i sprawdź login
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const normalized = bodyText.replace(/\./g, '').toLowerCase();

    if (normalized.includes('pgalimski')) {
      console.log('Zalogowano pomyślnie — profil widoczny.');
    } else {
      console.error('Nie znaleziono danych profilu użytkownika.');
      passed = false;
    }

    // 8. Zakończ
    await driver.quit();
    logTestResult(testName, passed);
  } catch (error) {
    console.error('Błąd:', error.message);
    if (driver) await driver.quit();
    logTestResult(testName, false, error.message);
  }
})();
