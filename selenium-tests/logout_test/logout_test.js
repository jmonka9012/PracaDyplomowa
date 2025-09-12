import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const raw = (process.env.APP_URL || '').replace(/"/g, '').trim();
const BASE_URL = raw.replace(/^https:\/\//i, 'http://');

// Ścieżka do folderu zrzutów ekranu
const screenshotDir = path.resolve('./selenium-tests/logs/screenshots');

// Główna funkcja testowa – logowanie i wylogowanie użytkownika
(async function logoutTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--window-size=1920,1080');
    // options.addArguments('--headless=new'); // Można włączyć do uruchomienia bez GUI

    // Inicjalizacja WebDrivera
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Przejście na stronę główną
    console.log('Przejście na stronę główną...');
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Kliknięcie w przycisk logowania
    console.log('Kliknięcie w przycisk logowania...');
    const loginLink = await driver.findElement(By.css('header a[href$="/login"]'));
    await loginLink.click();
    await driver.wait(until.urlContains('/login'), 5000);

    // Wprowadzenie danych logowania
    console.log('Wprowadzenie danych logowania...');
    await driver.findElement(By.id('login')).sendKeys('pgalimski');
    await driver.findElement(By.id('password')).sendKeys('12341234');
    await driver.findElement(By.css('input[type="submit"]')).click();
    await driver.sleep(2000);

    // Oczekiwanie na pojawienie się „Moje konto”
    console.log('Sprawdzenie obecności „Moje konto”...');
    await driver.wait(
      until.elementLocated(By.xpath('//header//a[contains(text(),"Moje konto")]')),
      7000
    );

    // Kliknięcie „Wyloguj”
    console.log('Kliknięcie przycisku „Wyloguj”...');
    const logoutBtn = await driver.findElement(By.xpath('//header//a[contains(text(),"Wyloguj")]'));
    await logoutBtn.click();
    await driver.sleep(2000);

    // Weryfikacja wylogowania – ponowne pojawienie się linku „Zaloguj”
    console.log('Weryfikacja wylogowania...');
    await driver.wait(
      until.elementLocated(By.css('header a[href$="/login"]')),
      7000
    );

    testPassed = true;
    console.log('Test zakończony pomyślnie.');

  } catch (error) {
    console.error('Błąd testu:', error.message);
  } finally {
    // Zapis zrzutu ekranu niezależnie od wyniku
    try {
      fs.mkdirSync(screenshotDir, { recursive: true });
      const screenshot = await driver.takeScreenshot();
      const filePath = path.join(screenshotDir, `logout_final_${Date.now()}.png`);
      fs.writeFileSync(filePath, screenshot, 'base64');
      console.log(`Zapisano zrzut ekranu: ${filePath}`);
    } catch (e) {
      console.warn('Nie udało się zapisać zrzutu ekranu:', e.message);
    }

    // Zamknięcie przeglądarki i zapis wyniku testu
    if (driver) await driver.quit();
    logTestResult('logout_test', testPassed);
  }
})();
