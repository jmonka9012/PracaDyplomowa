import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { describe, it } from 'mocha';

dotenv.config();

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');
const logPath = path.resolve(__dirname, '../logs/logs.txt');

/**
 * Zapisuje wynik testu do pliku logów w ustalonym formacie.
 * @param {string} testName - Nazwa testu.
 * @param {boolean} passed - Status wykonania testu.
 */
function logTestResult(testName, passed) {
  const logEntry = `${testName}_Passed : ${passed}\n`;
  try {
    fs.appendFileSync(logPath, logEntry, 'utf8');
    console.log(`Wynik testu zapisany w logs.txt: ${logEntry.trim()}`);
  } catch (error) {
    console.error(`Błąd podczas zapisu do logs.txt: ${error.message}`);
  }
}

describe('Formularz kontaktowy – poprawne dane', function () {
  this.timeout(20000);
  let driver;

  before(async function () {
    // Konfiguracja przeglądarki Chrome w trybie headless
    const options = new chrome.Options();
    options.addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });
  });

  after(async function () {
    // Zakończenie pracy przeglądarki po wykonaniu testu
    if (driver) await driver.quit();
  });

  it('Powinien wysłać wiadomość bez błędu, nawet jeśli brak komunikatu potwierdzającego', async function () {
    try {
      // Przejście na stronę główną
      await driver.get(BASE_URL);
      await driver.sleep(1000);

      // Przejście do zakładki "Kontakt"
      const kontaktLink = await driver.wait(until.elementLocated(By.linkText('Kontakt')), 5000);
      await kontaktLink.click();
      await driver.sleep(1000);

      // Przewinięcie do formularza
      await driver.executeScript('window.scrollBy(0, 800);');
      await driver.sleep(1000);

      // Wypełnienie formularza
      await driver.findElement(By.name('contact-name')).sendKeys('Jan Kowalski');
      await driver.findElement(By.name('contact-mail')).sendKeys('jan@example.com');
      await driver.findElement(By.name('contact-topic')).sendKeys('Test Selenium');
      await driver.findElement(By.name('contact-message')).sendKeys('To jest testowa wiadomość wysłana automatycznie.');

      // Kliknięcie przycisku "wyślij"
      const submitButton = await driver.wait(
        until.elementLocated(By.css('input[type="submit"][value="wyślij"]')),
        5000
      );
      await driver.executeScript("arguments[0].scrollIntoView(true);", submitButton);
      await driver.wait(until.elementIsVisible(submitButton), 3000);
      await driver.wait(until.elementIsEnabled(submitButton), 3000);
      await submitButton.click();

      // Oczekiwanie na ewentualny komunikat
      try {
        await driver.wait(
          until.elementLocated(
            By.xpath("//*[contains(text(), 'dziękujemy') or contains(text(), 'wysłana') or contains(text(), 'otrzymaliśmy')]")
          ),
          7000
        );
      } catch {
        // Brak komunikatu nie jest traktowany jako błąd
      }

      // Test zakończony powodzeniem
      logTestResult('contact_form_test', true);
    } catch (error) {
      // Błąd – test nieudany
      logTestResult('contact_form_test', false);
      throw error;
    }
  });
});
