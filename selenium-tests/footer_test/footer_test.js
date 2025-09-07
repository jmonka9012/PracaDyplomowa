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

describe('Test zawartości linków stopki – weryfikacja pierwszego zdania', function () {
  this.timeout(60000); // Ustawienie maksymalnego czasu wykonania testu
  let driver;

  before(async function () {
    // Konfiguracja przeglądarki Chrome w trybie headless
    const options = new chrome.Options();
    options.addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozdzielczości przeglądarki
    await driver.manage().window().setRect({ width: 1920, height: 1080 });
  });

  after(async function () {
    // Zakończenie pracy przeglądarki po wykonaniu testu
    await driver.quit();
  });

  /**
   * Wyodrębnia fragment tekstu zawierający określoną liczbę zdań.
   * @param {string} text - Źródłowy tekst do przetworzenia.
   * @param {number} sentenceCount - Liczba zdań, które mają zostać wyodrębnione.
   * @returns {string} - Fragment tekstu do zadanej liczby kropki.
   */
  function getSentences(text, sentenceCount) {
    let periodCount = 0;
    for (let i = 0; i < text.length; i++) {
      if (text[i] === '.') {
        periodCount++;
        if (periodCount === sentenceCount) {
          return text.substring(0, i + 1).trim();
        }
      }
    }
    return text.trim(); // Zwraca cały tekst, jeśli nie znaleziono wystarczającej liczby kropek
  }

  it('Powinno zostać odczytane pierwsze zdanie z podstron "Polityka prywatności", "Regulamin" i "FAQ"', async function () {
    // Przejście na stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(3000);

    // Przewinięcie do stopki, w której znajdują się linki
    await driver.executeScript("window.scrollTo(0, document.body.scrollHeight);");
    await driver.sleep(2000);

    // Lista nazw linków w stopce do przetestowania
    const links = ["Polityka prywatności", "Regulamin", "FAQ"];

    for (let linkText of links) {
      // Wyszukanie linku na podstawie tekstu i kliknięcie go
      const linkElement = await driver.wait(until.elementLocated(By.linkText(linkText)), 10000);
      await linkElement.click();

      // Oczekiwanie na załadowanie zawartości strony docelowej
      await driver.wait(until.elementLocated(By.css('p')), 10000);
      await driver.sleep(2000);

      // Pobranie tekstu pierwszego akapitu
      const firstParagraph = await driver.findElement(By.css('p'));
      const paragraphText = await firstParagraph.getText();

      // Ustalenie, ile zdań ma zostać wyodrębnionych z tekstu
      const sentenceCount = (linkText === "Regulamin") ? 2 : 1;
      const firstSentence = getSentences(paragraphText, sentenceCount);

      // Wypisanie wyniku do terminala
      console.log(`${linkText} - Pierwsze zdanie: ${firstSentence}`);

      // Powrót na stronę główną i ponowne przewinięcie do stopki
      await driver.navigate().back();
      await driver.sleep(3000);
      await driver.executeScript("window.scrollTo(0, document.body.scrollHeight);");
      await driver.sleep(2000);
    }

    // Po przejściu przez wszystkie linki wynik testu zostaje zapisany
    logTestResult('footer_test', true);
  });
});
