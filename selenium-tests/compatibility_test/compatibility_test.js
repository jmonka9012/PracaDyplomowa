import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import edge from 'selenium-webdriver/edge.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Import funkcji logowania wyniku testu

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:'); // Usunięcie ewentualnych cudzysłowów z adresu URL

(async function compatibilityAndResponsiveTest() {
  const testName = 'compatibility_test';
  let allPassed = true;

  // Lista przeglądarek do testowania
  const browsers = ['chrome', 'MicrosoftEdge', 'chromium'];

  // Zdefiniowane rozmiary ekranów reprezentujące różne urządzenia
  const devices = [
    { width: 1920, height: 1080, label: 'Desktop (Full HD)' },
    { width: 2560, height: 1440, label: 'Desktop (27-inch QHD)' },
    { width: 1280, height: 1024, label: 'Desktop (19-inch)' },
    { width: 768, height: 1024, label: 'Tablet (iPad Pro 12.9")' },
    { width: 800, height: 1280, label: 'Tablet (Galaxy Tab S8)' },
    { width: 430, height: 932, label: 'Phone (iPhone 15 Pro Max)' },
    { width: 384, height: 854, label: 'Phone (Samsung Galaxy S25)' }
  ];

  // Iteracja po wszystkich kombinacjach przeglądarek i rozdzielczości
  for (const browser of browsers) {
    for (const device of devices) {
      let driver;
      try {
        console.log(`\n${browser} | ${device.label} (${device.width}x${device.height})`);

        // Konfiguracja przeglądarki Chrome i Chromium
        if (browser === 'chrome' || browser === 'chromium') {
          const options = new chrome.Options();
          options.addArguments(
            '--headless',
            '--disable-dev-shm-usage',
            '--no-sandbox',
            '--disable-gpu'
          );
          if (browser === 'chromium') {
            options.addArguments('--remote-debugging-port=9222');
          }

          driver = await new Builder()
            .forBrowser('chrome')
            .setChromeOptions(options)
            .build();
        }

        // Konfiguracja przeglądarki Microsoft Edge
        else if (browser === 'MicrosoftEdge') {
          const options = new edge.Options();
          options.addArguments(
            '--headless',
            '--disable-dev-shm-usage',
            '--no-sandbox',
            '--disable-gpu'
          );

          driver = await new Builder()
            .forBrowser('MicrosoftEdge')
            .setEdgeOptions(options)
            .build();
        }

        // Ustawienie rozdzielczości okna
        await driver.manage().window().setRect({
          width: device.width,
          height: device.height
        });

        // Przejście na testowaną stronę
        await driver.get(BASE_URL);

        // Pobranie tytułu strony
        const title = await driver.getTitle();
        console.log(`Tytuł strony: "${title}"`);

        // Weryfikacja obecności elementu
        const header = await driver.findElements(By.css('header'));
        if (header.length > 0) {
          console.log('Nagłówek został odnaleziony.');
        } else {
          console.warn('Brak nagłówka na stronie.');
        }

        // Zakończenie sesji przeglądarki
        await driver.quit();
        console.log('Test zakończony pomyślnie.');
      } catch (err) {
        // Obsługa błędów testu
        console.error(`Błąd w ${browser} - ${device.label}:`, err.message);
        logTestResult(testName, false, `Błąd w ${browser} - ${device.label}: ${err.message}`);
        allPassed = false;
        if (driver) await driver.quit();
      }
    }
  }

  // Zapis ogólnego wyniku testu
  if (allPassed) {
    logTestResult(testName, true);
  }
})();
