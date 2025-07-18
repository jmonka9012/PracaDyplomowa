import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { logTestResult } from '../logUtils.js';

dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/"/g, '');

(async function autocompleteAuditTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja przeglądarki Chrome 
    const options = new chrome.Options();
    options.addArguments('--headless=new', '--disable-dev-shm-usage', '--no-sandbox');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Rozpoczęcie testu: audyt autocomplete w formularzu rejestracji');

    // Przejście do strony logowania, a następnie do formularza rejestracji
    await driver.get(`${BASE_URL}/login`);
    await driver.sleep(1000);

    const registerLink = await driver.findElement(By.css('a.read-more'));
    await registerLink.click();
    await driver.sleep(1000);

    // Pobranie wszystkich pól formularza (input, textarea)
    const elements = await driver.findElements(By.css('input, textarea'));

    // Dozwolone wartości dla atrybutu autocomplete
    const validValues = new Set([
      'name', 'honorific-prefix', 'given-name', 'additional-name', 'family-name',
      'nickname', 'email', 'username', 'new-password', 'current-password',
      'organization-title', 'company', 'street-address', 'address-line1', 'address-line2',
      'address-line3', 'country', 'country-name', 'postal-code', 'tel', 'url'
    ]);

    const auditItems = [];
    const seenIds = new Map();

    // Analiza każdego pola formularza
    for (const el of elements) {
      const autocomplete = await el.getAttribute('autocomplete');
      const name = await el.getAttribute('name');
      const id = await el.getAttribute('id');
      const type = await el.getAttribute('type');

      const warnings = [];

      // Weryfikacja poprawności wartości autocomplete
      if (autocomplete && !validValues.has(autocomplete)) {
        warnings.push('Niepoprawna wartość autocomplete');
      }

      // Weryfikacja unikalności ID
      if (id && seenIds.has(id)) {
        warnings.push('Zduplikowane ID');
      } else if (id) {
        seenIds.set(id, true);
      }

      auditItems.push({ name, id, type, autocomplete, warnings });
    }

    // Przygotowanie danych audytu z podwójnym zapisem daty (UTC i lokalna)
    const now = new Date();
    const auditData = {
      generatedAtUTC: now.toISOString(),
      generatedAtLocal: now.toLocaleString('pl-PL'),
      fields: auditItems
    };

    // Ścieżka do zapisu pliku z audytem
    const logDir = path.resolve('selenium-tests/logs');
    const outputPath = path.join(logDir, 'autocomplete_audit.json');

    // Tworzenie folderu logów, jeśli nie istnieje
    if (!fs.existsSync(logDir)) {
      fs.mkdirSync(logDir, { recursive: true });
    }

    // Usunięcie istniejącego pliku z audytem, jeśli istnieje
    if (fs.existsSync(outputPath)) {
      fs.unlinkSync(outputPath);
    }

    // Zapis danych audytu do pliku JSON
    fs.writeFileSync(outputPath, JSON.stringify(auditData, null, 2));

    console.log(`Zapisano audyt do: ${outputPath}`);
    console.log(`Zawiera ${auditItems.length} pól – raport wygenerowano: ${auditData.generatedAtLocal}`);

    testPassed = auditItems.length > 0;
    logTestResult('autocomplete_audit_test', testPassed);

  } catch (err) {
    console.error('Błąd wykonania testu:', err.message);
    logTestResult('autocomplete_audit_test', false);
  } finally {
    await driver.quit();
  }
})();
