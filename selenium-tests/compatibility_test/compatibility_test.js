import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import edge from 'selenium-webdriver/edge.js';
import dotenv from 'dotenv';

// Wczytaj zmienne środowiskowe z .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // usuwa ewentualne cudzysłowy z wartości zmiennej

(async function compatibilityAndResponsiveTest() {
  // Lista przeglądarek do testu
  const browsers = ['chrome', 'MicrosoftEdge', 'chromium'];

  // Lista rozdzielczości ekranów i urządzeń do testowania responsywności
  const devices = [
    { width: 1920, height: 1080, label: 'Desktop (Full HD)' },
    { width: 2560, height: 1440, label: 'Desktop (27-inch QHD)' },
    { width: 1280, height: 1024, label: 'Desktop (19-inch)' },
    { width: 768, height: 1024, label: 'Tablet (iPad Pro 12.9")' },
    { width: 800, height: 1280, label: 'Tablet (Galaxy Tab S8)' },
    { width: 430, height: 932, label: 'Phone (iPhone 15 Pro Max)' },
    { width: 384, height: 854, label: 'Phone (Samsung Galaxy S25)' }
  ];

  // Iteracja przez każdą przeglądarkę
  for (const browser of browsers) {
    // Iteracja przez każde urządzenie / rozdzielczość
    for (const device of devices) {
      let driver;
      try {
        console.log(`\n${browser} | ${device.label} (${device.width}x${device.height})`);

        // Konfiguracja opcji przeglądarek
        if (browser === 'chrome' || browser === 'chromium') {
          const options = new chrome.Options();
          options.addArguments(
            '--headless',                   // tryb w tle
            '--disable-dev-shm-usage',     // unika błędów w kontenerach
            '--no-sandbox',                // wymagane dla wielu środowisk
            '--disable-gpu'                // wyłącza akcelerację GPU
          );

          if (browser === 'chromium') {
            options.addArguments('--remote-debugging-port=9222'); // debug port dla Chromium
          }

          driver = await new Builder()
            .forBrowser('chrome')
            .setChromeOptions(options)
            .build();

        } else if (browser === 'MicrosoftEdge') {
          const options = new edge.Options();
          options.addArguments(
            '--headless',                   // tryb w tle 
            '--disable-dev-shm-usage',      // unika błędów w kontenerach 
            '--no-sandbox',                 // wymagane dla wielu środowisk
            '--disable-gpu'                 //wyłącza akcelerację GPU
          );

          driver = await new Builder()
            .forBrowser('MicrosoftEdge')
            .setEdgeOptions(options)
            .build();
        }

        // Ustawienie wymiarów okna
        await driver.manage().window().setRect({
          width: device.width,
          height: device.height
        });

        // Wejście na testowaną stronę
        await driver.get(BASE_URL);

        // Sprawdzenie tytułu strony
        const title = await driver.getTitle();
        console.log(`Tytuł strony: "${title}"`);

        // Sprawdzenie obecności nagłówka
        const header = await driver.findElements(By.css('header'));
        if (header.length > 0) {
          console.log('Nagłówek został odnaleziony.');
        } else {
          console.warn('Brak nagłówka na stronie.');
        }

        // Zakończenie sesji przeglądarki
        await driver.quit();
        console.log('Test zakończony pomyślnie.\n');

      } catch (err) {
        // Wypisanie błędu i zamknięcie drivera, jeśli wystąpi wyjątek
        console.error(`Błąd w ${browser} - ${device.label}:`, err);
        if (driver) await driver.quit();
      }
    }
  }
})();
