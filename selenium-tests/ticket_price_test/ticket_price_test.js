import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

dotenv.config();
const raw = (process.env.APP_URL || '').replace(/"/g, '').trim();
const BASE_URL = raw.replace(/^https:\/\//i, 'http://');

// Zwraca losową liczbę od 1 do min(max, 50)
function getRandomQuantity(max) {
  return Math.floor(Math.random() * Math.min(max, 50)) + 1;
}

(async function ticketPriceCalculationTest() {
  let driver;
  let testPassed = false;

  try {
    const options = new chrome.Options();
    options.addArguments('--headless=new', '--disable-dev-shm-usage', '--no-sandbox');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Rozpoczęcie testu: kalkulacja cen biletów');

    // Przejście do listy wydarzeń
    await driver.get(`${BASE_URL}/wydarzenia`);
    await driver.wait(until.elementLocated(By.css('.event')), 5000);

    // Otwarcie pierwszego wydarzenia z listy
    await driver.findElement(By.css('.event .link-stretched')).click();
    await driver.wait(until.urlContains('/wydarzenia/wydarzenie/'), 5000);

    // Kliknięcie na element sceny
    await driver.wait(until.elementLocated(By.css('.scene')), 5000).click();

    // Odczyt informacji o sali i cenie biletów
    const seatInfo = await driver.wait(
      until.elementLocated(By.css('.hall__seat-cont--info')),
      5000
    );
    const hallText = (await seatInfo.getText()).trim().split('\n');

    const occupiedMatch = hallText[0].match(/(\d+)\/(\d+)/);
    const priceMatch = hallText[1].match(/([\d.,]+) PLN/);

    const occupied = parseInt(occupiedMatch[1], 10);
    const totalSeats = parseInt(occupiedMatch[2], 10);
    const pricePerTicket = parseFloat(priceMatch[1].replace(',', '.'));

    const available = totalSeats - occupied;
    const quantity = getRandomQuantity(Math.max(1, available));

    // Wprowadzenie liczby biletów
    const input = await seatInfo.findElement(By.css('.stand-input'));
    await input.clear();
    await input.sendKeys(quantity.toString());
    await driver.sleep(500);

    // Oczekiwanie na wyświetlenie podsumowania
    await driver.wait(
      until.elementLocated(By.xpath("//div[contains(text(), 'Cena wybranych miejsc')]")),
      5000
    );

    // Odczyt danych podsumowania
    const summary = await driver.findElements(By.css('.mr-lg-40px'));
    let finalQty = null;
    let finalPrice = null;

    for (const el of summary) {
      const txt = (await el.getText()).trim();
      if (txt.includes('Ilość wybranych miejsc')) {
        finalQty = parseInt(txt.match(/: (\d+)/)[1], 10);
      }
      if (txt.includes('Cena wybranych miejsc')) {
        finalPrice = parseFloat(txt.match(/: ([\d.,]+) PLN/)[1].replace(',', '.'));
      }
    }

    const expectedPrice = pricePerTicket * finalQty;

    // Logi w terminalu
    console.log(`Wybrana ilość: ${finalQty}`);
    console.log(`Wyświetlona cena: ${finalPrice}`);
    console.log(`Oczekiwana cena: ${expectedPrice}`);

    // Weryfikacja poprawności kalkulacji
    if (finalQty && finalPrice === expectedPrice) {
      testPassed = true;
    }

    logTestResult('ticket_price_calculation_test', testPassed);
  } catch (error) {
    console.error('Błąd wykonania testu:', error.message);
    logTestResult('ticket_price_calculation_test', false);
  } finally {
    await driver.quit();
  }
})();
