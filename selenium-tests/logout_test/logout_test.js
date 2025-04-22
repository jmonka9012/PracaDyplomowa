import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Załadowanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/"/g, '');

// Główna funkcja testowa realizująca scenariusz logowania i wylogowania użytkownika
(async function logoutTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja przeglądarki w trybie headless
    const options = new chrome.Options();
    options.addArguments('--headless=new'); // nowy tryb headless
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--window-size=1920,1080');

    // Inicjalizacja przeglądarki z określonymi parametrami
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Przejście na stronę główną aplikacji
    console.log('Przejście na stronę główną...');
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Kliknięcie przycisku logowania w nagłówku
    console.log('Kliknięcie w przycisk logowania...');
    await driver.findElement(By.css('header a[href$="/login"]')).click();
    await driver.wait(until.urlContains('/login'), 5000);

    // Wprowadzenie danych logowania w formularzu
    console.log('Wprowadzenie danych logowania...');
    await driver.findElement(By.id('login')).sendKeys('pgalimski');
    await driver.findElement(By.id('password')).sendKeys('12341234');
    await driver.findElement(By.css('input[type="submit"]')).click();
    await driver.sleep(2000);

    // Oczekiwanie na pojawienie się przycisku „Moje konto”, co potwierdza udane logowanie
    console.log('Oczekiwanie na dostępność sekcji „Moje konto”...');
    await driver.wait(until.elementLocated(By.xpath('//header//a[contains(text(),"Moje konto")]')), 7000);

    // Kliknięcie przycisku „Wyloguj” w nagłówku
    console.log('Kliknięcie przycisku „Wyloguj”...');
    const logoutBtn = await driver.findElement(By.xpath('//header//a[contains(text(),"Wyloguj")]'));
    await logoutBtn.click();
    await driver.sleep(2000);

    // Weryfikacja, że użytkownik został poprawnie wylogowany (ponownie widoczny link do logowania)
    console.log('Weryfikacja wylogowania...');
    await driver.wait(until.elementLocated(By.css('header a[href$="/login"]')), 7000);
    testPassed = true;

  } catch (error) {
    // Obsługa błędów testu i wyświetlenie komunikatu diagnostycznego i zamknięcie przeglądarki oraz zapisanie wyniku testu
    console.error('Błąd testu:', error.message);
  } finally {
    await driver.quit();
    logTestResult('logout_test', testPassed);
  }
})();
