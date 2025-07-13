import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych
dotenv.config();

// Ustawienie bazowego adresu aplikacji
const BASE_URL = process.env.APP_URL.replace(/"/g, '');

// Ścieżki do folderu logów i pliku wyjściowego
const logDir = path.resolve('selenium-tests/logs');
const outputPath = path.join(logDir, 'meta_audit.json');

// Lista stron do audytu meta tagów
const pagesToCheck = [
  '/',
  '/wydarzenia',
  '/o-nas',
  '/blog',
  '/kontakt',
  '/login'
];

(async function metaAuditTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja opcji przeglądarki (tryb bezgłowy i bezpieczeństwo kontenerów)
    const options = new chrome.Options();
    options.addArguments('--headless=new', '--disable-dev-shm-usage', '--no-sandbox');

    // Inicjalizacja przeglądarki
    driver = await new Builder().forBrowser('chrome').setChromeOptions(options).build();
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    // Upewnienie się, że katalog logów istnieje
    if (!fs.existsSync(logDir)) {
      fs.mkdirSync(logDir, { recursive: true });
    }

    // Usunięcie poprzedniego pliku raportu (jeśli istnieje)
    if (fs.existsSync(outputPath)) {
      fs.unlinkSync(outputPath);
    }

    console.log('Rozpoczęcie testu: audyt meta tagów');

    // Utworzenie nagłówka raportu z datą w formacie lokalnym i UTC
    const now = new Date();
    const report = {
      generatedAtUTC: now.toISOString(),
      generatedAtLocal: now.toLocaleString('pl-PL'),
      pages: []
    };

    // Iteracja przez listę podstron
    for (const pathSegment of pagesToCheck) {
      const url = `${BASE_URL}${pathSegment}`;
      await driver.get(url);
      await driver.sleep(1000);

      // Pobranie tytułu strony
      const title = await driver.getTitle();

      // Próba odczytu wybranych meta tagów
      const metaTags = {};
      for (const name of ['description', 'robots', 'keywords']) {
        try {
          const element = await driver.findElement(By.css(`meta[name="${name}"]`));
          metaTags[name] = await element.getAttribute('content');
        } catch {
          // Tag nie istnieje na stronie
          metaTags[name] = null;
        }
      }

      // Dodanie wyników do raportu
      report.pages.push({
        path: pathSegment,
        title,
        meta: metaTags
      });

     console.log(`Sprawdzono stronę: ${pathSegment}, title="${title}"`);

    }

    // Zapisanie raportu do pliku JSON
    fs.writeFileSync(outputPath, JSON.stringify(report, null, 2));
    console.log(`Zapisano audyt do: ${outputPath}`);

    testPassed = true;
    logTestResult('meta_audit_test', testPassed);

  } catch (error) {
    console.error('Błąd wykonania testu:', error.message);
    logTestResult('meta_audit_test', false);
  } finally {
    // Zakończenie działania przeglądarki
    await driver.quit();
  }
})();
