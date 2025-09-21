import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { logTestResult } from '../logUtils.js'; // zakładam, że masz ten moduł

dotenv.config();

const BASE_URL = (process.env.APP_URL || '')
  .replace(/(^"|"$)/g, '')
  .replace(/^https:/i, 'http:');

const screenshotPath = '/home/pgalimski/inzynierka/PracaDyplomowa/selenium-tests/logs/screenshots/stripe_checkout.png';
const logPath = '/home/pgalimski/inzynierka/PracaDyplomowa/selenium-tests/logs/logs.txt';
const testName = 'buy_test';

(async function ticketPurchaseTest() {
  let driver;
  let passed = true;
  let logMessages = [];

  try {
    const options = new chrome.Options().addArguments('--no-sandbox', '--disable-dev-shm-usage');
    driver = await new Builder().forBrowser('chrome').setChromeOptions(options).build();
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    const log = msg => {
      console.log(msg);
      logMessages.push(msg);
    };

    log('Start testu zakupu biletu');

    await driver.get(BASE_URL);
    log('Strona główna otwarta');

    await driver.findElement(By.css('a.header__login[href*="/login"]')).click();
    log('Kliknięto "Zaloguj"');

    await driver.findElement(By.css('input[name="login"]')).sendKeys('pgalimski');
    await driver.findElement(By.css('input[name="password"]')).sendKeys('12341234');
    log('Wpisano dane logowania');

    await driver.findElement(By.css('input[type="submit"][value="Zaloguj się"]')).click();
    await driver.wait(until.elementLocated(By.xpath("//h1[contains(.,'Mój profil')]")), 15000);
    log('Zalogowano pomyślnie');

    await driver.get(`${BASE_URL}/wydarzenia`);
    await driver.findElement(By.css('.event .link-stretched')).click();
    await driver.wait(until.urlContains('/wydarzenia/'), 15000);
    log('Wybrano wydarzenie');

    await driver.findElement(By.css('.scene')).click();
    const seats = await driver.findElements(By.css('.hall__seat:not(.taken)'));
    if (!seats.length) throw new Error('Brak dostępnych miejsc');
    await seats[0].click();
    log('Wybrane miejsce');

    try {
      const standingInput = await driver.findElement(By.css('.hall__seat-cont .stand-input'));
      await standingInput.clear();
      await standingInput.sendKeys('1');
      log('Wpisano bilet stojący');
    } catch {
      log('Brak pola na bilet stojący — pomijam');
    }

    await driver.findElement(By.xpath("//button[contains(text(),'Kup bilety')]")).click();
    await driver.wait(until.urlContains('/kupuj'), 15000);
    await driver.findElement(By.css('form input[type="submit"], form button[type="submit"]')).click();
    log('Wysłano formularz zamówienia');

    await driver.wait(until.urlContains('checkout.stripe.com'), 20000);
    const currentUrl = await driver.getCurrentUrl();
    log(`Przekierowano na Stripe Checkout: ${currentUrl}`);

    // Poczekaj na iframe Stripe i chwilę na załadowanie
    const stripeIframe = await driver.wait(until.elementLocated(By.css('iframe[src*="stripe.com"]')), 15000);
    log('Iframe Stripe wykryty');

    await driver.sleep(3000); // dodatkowe oczekiwanie na pełne załadowanie formularza

    const screenshot = await driver.takeScreenshot();
    fs.mkdirSync(path.dirname(screenshotPath), { recursive: true });
    fs.writeFileSync(screenshotPath, screenshot, 'base64');
    log(`Screenshot zapisany: ${screenshotPath}`);

    log('Test zakończony na wejściu do Stripe Checkout — sukces');

  } catch (error) {
    const msg = `Błąd w teście: ${error.message}`;
    console.error(msg);
    logMessages.push(msg);
    passed = false;
  } finally {
    if (driver) await driver.quit();
    const finalMsg = `Test zakończony: ${passed ? 'sukces' : 'niepowodzenie'}`;
    console.log(finalMsg);
    logMessages.push(finalMsg);

    fs.mkdirSync(path.dirname(logPath), { recursive: true });
    fs.appendFileSync(logPath, logMessages.join('\n') + '\n\n');

    // Dodaj potwierdzenie do logów systemowych
    logTestResult(testName, passed);
  }
})();
