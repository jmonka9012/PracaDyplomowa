import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { describe, it } from 'mocha';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Ustalenie ścieżek plików na podstawie lokalizacji bieżącego pliku
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Pobranie adresu URL aplikacji ze zmiennej środowiskowej
const BASE_URL = process.env.APP_URL?.replace(/(^"|"$)/g, '');

// Ustalenie lokalizacji pliku z logami
const logPath = path.resolve(__dirname, '../logs/logs.txt');
 
function logTestResult(testName, passed) {
  const logEntry = `${testName}_Passed : ${passed}\n`;
  try {
    fs.appendFileSync(logPath, logEntry, 'utf8');
    console.log(`Wynik testu zapisany w logs.txt: ${logEntry.trim()}`);
  } catch (error) {
    console.error(`Błąd podczas zapisywania do logs.txt: ${error.message}`);
  }
}

// Definicja scenariusza testowego przy użyciu frameworka Mocha
describe('Test ręcznego wyszukiwania wydarzeń', function () {
  // Ustawienie maksymalnego czasu trwania testu
  this.timeout(30000);

  let driver;

  // Konfiguracja przeglądarki przed rozpoczęciem testu
  before(async function () {
    const options = new chrome.Options();
    options.addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1920, height: 1080 });
  });

  // Zakończenie działania przeglądarki po zakończeniu testu
  after(async function () {
    await driver.quit();
  });

  // Główna część testu
  it('Znalezienie jednego wydarzenia dla frazy "motorhead"', async function () {
    console.log('=== Rozpoczęcie testu wyszukiwania wydarzeń ===');

    // Otwarcie strony głównej
    console.log(`Przechodzenie na stronę główną: ${BASE_URL}`);
    await driver.get(BASE_URL);
    await driver.sleep(3000);

    // Przejście do zakładki "Wydarzenia"
    console.log('Klikanie zakładki "Wydarzenia"...');
    const eventsTab = await driver.findElement(By.css('a[href$="/wydarzenia"]'));
    await eventsTab.click();
    await driver.wait(until.urlContains('/wydarzenia'), 10000);
    await driver.sleep(3000);

    // Wprowadzenie frazy wyszukiwania
    console.log('Wpisywanie frazy "motorhead" w pole wyszukiwania...');
    const searchInput = await driver.findElement(By.css('.search-input'));
    await searchInput.sendKeys('motorhead');
    await driver.sleep(2000);

    // Zatwierdzenie filtrowania
    console.log('Klikanie przycisku "Filtruj"...');
    const filterButton = await driver.findElement(By.css('#submitFilter'));
    await filterButton.click();
    await driver.wait(until.elementsLocated(By.css('.event')), 10000);
    await driver.sleep(3000);

    // Sprawdzenie liczby wyników
    console.log('Sprawdzanie liczby wyników...');
    const events = await driver.findElements(By.css('.event'));
    console.log(`Znalezione wydarzenia: ${events.length}`);

    // Walidacja rezultatu testu
    const testPassed = events.length === 1;
    logTestResult('search_manual_test', testPassed);

    console.log(`Test zakończony. Wynik: search_manual_test_Passed : ${testPassed}`);
  });
});
