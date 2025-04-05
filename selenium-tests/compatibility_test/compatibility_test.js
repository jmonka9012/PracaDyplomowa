import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import edge from 'selenium-webdriver/edge.js';

(async function compatibilityAndResponsiveTest() {
  const browsers = ['chrome', 'MicrosoftEdge', 'chromium']; // Lista testowanych przeglądarek
  const devices = [
    { width: 1920, height: 1080, label: 'Desktop (Full HD)' },
    { width: 2560, height: 1440, label: 'Desktop (27-inch QHD)' },
    { width: 1280, height: 1024, label: 'Desktop (19-inch)' },
    { width: 768, height: 1024, label: 'Tablet (iPad Pro 12.9")' },
    { width: 800, height: 1280, label: 'Tablet (Galaxy Tab S8)' },
    { width: 430, height: 932, label: 'Phone (iPhone 15 Pro Max)' },
    { width: 384, height: 854, label: 'Phone (Samsung Galaxy S25)' }
  ];

  for (const browser of browsers) {
    for (const device of devices) {
      let driver;
      try {
        console.log(`\n${browser} | ${device.label} (${device.width}x${device.height})`);

        // Konfiguracja przeglądarki na podstawie typu
        if (browser === 'chrome' || browser === 'chromium') {
          const options = new chrome.Options();
          options.addArguments(
            '--headless', // Tryb bez interfejsu graficznego
            '--disable-dev-shm-usage',
            '--no-sandbox',
            '--disable-gpu'
          );
          if (browser === 'chromium') {
            options.addArguments('--remote-debugging-port=9222');
          }
          driver = await new Builder().forBrowser('chrome').setChromeOptions(options).build();
        } else if (browser === 'MicrosoftEdge') {
          const options = new edge.Options();
          options.addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox', '--disable-gpu');
          driver = await new Builder().forBrowser('MicrosoftEdge').setEdgeOptions(options).build();
        }

        // Ustawienie wymiarów okna przeglądarki
        await driver.manage().window().setRect({ width: device.width, height: device.height });

        // Załadowanie strony głównej aplikacji
        await driver.get('http://lvi.ddev.site/');
        const title = await driver.getTitle();
        console.log(`Tytuł strony: "${title}"`);

        // Weryfikacja obecności nagłówka na stronie
        const header = await driver.findElements(By.css('header'));
        if (header.length > 0) {
          console.log('Nagłówek został odnaleziony.');
        } else {
          console.warn('Brak nagłówka na stronie.');
        }

        // Zakończenie sesji testowej
        await driver.quit();
        console.log('Test zakończony pomyślnie.\n');

      } catch (err) {
        // Obsługa wyjątków i zamknięcie przeglądarki w przypadku błędu
        console.error(`Błąd w ${browser} - ${device.label}:`, err);
        if (driver) await driver.quit();
      }
    }
  }
})();
