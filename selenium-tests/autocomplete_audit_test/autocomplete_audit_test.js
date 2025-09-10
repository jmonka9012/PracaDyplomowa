// Import wymaganych modułów
import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const raw = (process.env.APP_URL || '').replace(/"/g, '').trim();
const BASE_URL = raw.replace(/^https:\/\//i, 'http://');

// Ustalanie ścieżek dla zapisu wyników
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const outputPath = path.join(__dirname, 'autocomplete_audit.json');

(async function autocompleteAuditTest() {
  let driver;
  let testPassed = false;

  try {
<<<<<<< HEAD:selenium-tests/autocomplete_audit_test/autocomplete_audit_test.js
    // Konfiguracja przeglądarki Chrome
=======
    // Konfiguracja przeglądarki Chrome w trybie headless
>>>>>>> 354460e (update testów automatycznych):selenium-tests/Automated-Tests/autocomplete_audit_test/autocomplete_audit_test.js
    const options = new chrome.Options();
    options.addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    // Uruchomienie przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie wymiarów okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('=== Rozpoczęcie testu: audyt atrybutów autocomplete w formularzu rejestracji ===');

    // Przejście na stronę logowania i przejście do formularza rejestracji
    await driver.get(`${BASE_URL}/login`);
    await driver.sleep(1000);

    const registerLink = await driver.findElement(By.css('a.read-more'));
    await registerLink.click();
    await driver.sleep(1000);

    // Pobranie wszystkich pól formularza (input i textarea)
    const elements = await driver.findElements(By.css('input, textarea'));

    // Lista dopuszczalnych wartości dla atrybutu autocomplete
    const validValues = new Set([
      'name', 'honorific-prefix', 'given-name', 'additional-name', 'family-name',
      'nickname', 'email', 'username', 'new-password', 'current-password',
      'organization-title', 'company', 'street-address', 'address-line1', 'address-line2',
      'address-line3', 'country', 'country-name', 'postal-code', 'tel', 'url'
    ]);

    // Tablica wyników audytu oraz mapa użytych identyfikatorów
    const auditItems = [];
    const seenIds = new Map();

    // Analiza każdego pola formularza
    for (const el of elements) {
      const autocomplete = await el.getAttribute('autocomplete');
      const name = await el.getAttribute('name');
      const id = await el.getAttribute('id');
      const type = await el.getAttribute('type');

      const warnings = [];

      // Sprawdzenie poprawności wartości atrybutu autocomplete
      if (autocomplete && !validValues.has(autocomplete)) {
        warnings.push('Niepoprawna wartość autocomplete');
      }

      // Sprawdzenie unikalności identyfikatorów pól
      if (id && seenIds.has(id)) {
        warnings.push('Zduplikowane ID');
      } else if (id) {
        seenIds.set(id, true);
      }

      // Raport ostrzeżeń w konsoli
      if (warnings.length > 0) {
        console.log(`Pole "${name || id || type}" ma problemy: ${warnings.join(', ')}`);
      }

      // Zapisanie wyników analizy danego pola
      auditItems.push({ name, id, type, autocomplete, warnings });
    }

    // Przygotowanie danych raportu z audytu
    const now = new Date();
    const auditData = {
      generatedAtUTC: now.toISOString(),
      generatedAtLocal: now.toLocaleString('pl-PL'),
      fields: auditItems
    };

    // Usunięcie poprzedniego pliku raportu, jeśli istnieje
    if (fs.existsSync(outputPath)) {
      fs.unlinkSync(outputPath);
    }

    // Zapis raportu do pliku JSON
    fs.writeFileSync(outputPath, JSON.stringify(auditData, null, 2));

    // Podsumowanie ostrzeżeń
    const totalWarnings = auditItems.filter(item => item.warnings.length > 0).length;
    console.log(`Znaleziono ${totalWarnings} pól z ostrzeżeniami`);
    console.log(`Raport audytu zapisano w: ${outputPath}`);
    console.log(`Raport wygenerowano: ${auditData.generatedAtLocal}`);

    // Kryterium zaliczenia testu – wystąpienie co najmniej jednego ostrzeżenia
    testPassed = totalWarnings > 0;
    logTestResult('autocomplete_audit_test', testPassed);

  } catch (err) {
    console.error('Błąd wykonania testu:', err.message);
    logTestResult('autocomplete_audit_test', false);
  } finally {
    // Zamykanie przeglądarki po zakończeniu testu
    if (driver) await driver.quit();
  }
})();
