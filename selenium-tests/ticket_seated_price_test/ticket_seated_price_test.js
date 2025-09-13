import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';
import assert from 'assert';

dotenv.config();
const raw = (process.env.APP_URL || '').replace(/"/g, '').trim();
const BASE_URL = raw.replace(/^https:\/\//i, 'http://');

// Zwraca losową liczbę całkowitą od 1 do min(max, 50)
function getRandomQuantity(max) {
  return Math.floor(Math.random() * Math.min(max, 50)) + 1;
}

// Zwraca losowe indeksy z tablicy
function getRandomIndexes(arrayLength, count) {
  const indexes = new Set();
  while (indexes.size < count) {
    indexes.add(Math.floor(Math.random() * arrayLength));
  }
  return Array.from(indexes);
}

describe('seat_price_calculation_test', function () {
  this.timeout(30000);

  it('prawidłowo oblicza cenę dla miejsc siedzących', async function () {
    let driver;
    let testPassed = false;

    try {
      const options = new chrome.Options().addArguments('--headless=new', '--no-sandbox', '--disable-dev-shm-usage');

      driver = await new Builder()
        .forBrowser('chrome')
        .setChromeOptions(options)
        .build();

      await driver.manage().window().setRect({ width: 1400, height: 1000 });

      await driver.get(`${BASE_URL}/wydarzenia`);
      await driver.wait(until.elementLocated(By.css('.event .link-stretched')), 10000);
      await driver.findElement(By.css('.event .link-stretched')).click();
      await driver.wait(until.urlContains('/wydarzenia/wydarzenie/'), 10000);

      await driver.wait(until.elementLocated(By.css('.scene')), 10000).click();

      const seats = await driver.wait(
        until.elementsLocated(By.css('.hall__seat:not(.taken)')),
        10000
      );

      console.log('Dostępne miejsca:', seats.length);

      const toSelect = Math.min(getRandomQuantity(seats.length), 5);
      console.log('Ilość do wybrania:', toSelect);

      const selectedIndexes = getRandomIndexes(seats.length, toSelect);
      let expectedSum = 0;

      for (let i = 0; i < selectedIndexes.length; i++) {
        const seat = seats[selectedIndexes[i]];
        const tooltipText = await seat
          .findElement(By.css('.hall__seat-tooltip'))
          .getAttribute('textContent');

        const priceMatch = tooltipText.match(/Cena:\s*([\d.,]+)\s*PLN/);
        const price = priceMatch ? parseFloat(priceMatch[1].replace(',', '.')) : 0;

        expectedSum += price;
        console.log(`  Miejsce #${i + 1} cena: ${price}`);
        await seat.click();
        await driver.sleep(100);
      }

      console.log('Oczekiwana suma:', expectedSum);

      const summaryDivs = await driver.findElements(By.css('.mr-lg-40px'));
      let finalQty = null;
      let finalPrice = null;

      for (const div of summaryDivs) {
        const txt = (await div.getText()).trim();
        const qtyMatch = txt.match(/Ilość wybranych miejsc siedzących:\s*(\d+)/);
        const priceMatch = txt.match(/Cena wybranych miejsc siedzących:\s*([\d.,]+)\s*PLN/);
        if (qtyMatch) finalQty = parseInt(qtyMatch[1], 10);
        if (priceMatch) finalPrice = parseFloat(priceMatch[1].replace(',', '.'));
      }

      console.log('Finalna ilość:', finalQty);
      console.log('Finalna cena:', finalPrice);

      assert.strictEqual(finalQty, toSelect);
      assert.strictEqual(finalPrice, expectedSum);

      testPassed = true;

    } finally {
      if (driver) await driver.quit();
      logTestResult('seat_price_calculation_test', testPassed);
    }
  });
});
