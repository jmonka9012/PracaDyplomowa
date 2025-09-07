import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Pobranie adresu URL aplikacji z konfiguracji
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');

// Nazwa testu (dla systemu logowania wyników)
const testName = 'navbar_links_test';

// Lista głównych linków w navbarze (bez linków do CE)
const navPaths = [
  { path: '/o-nas', label: 'O nas' },
  { path: '/blog', label: 'Blog' },
  { path: '/post', label: 'Single (CE)' },
  { path: '/kontakt', label: 'Kontakt' }
];

// Linki akcji po prawej stronie nagłówka (logowanie, rejestracja, wydarzenie)
const actionLinks = [
  { label: 'Zaloguj', selector: 'a.header-login[href*="/login"]' },
  { label: 'Zarejestruj', selector: 'a.header-login[href*="/rejestracja"]' },
  { label: 'Zorganizuj wydarzenie', selector: 'a.btn-header[href*="/zorganizuj-wydarzenie"]' }
];

(async function runNavbarLinksTest() {
  console.log('Test się uruchomił');
  let driver;
  let passed = true;

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Inicjalizacja przeglądarki Chrome
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna i timeoutów
    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    await driver.manage().setTimeouts({ implicit: 5000 });

    // Wejście na stronę główną aplikacji
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    console.log('Rozpoczynam testowanie linków w navbarze...');

    // Sprawdzenie każdego z głównych linków w nawigacji
    for (const { path, label } of navPaths) {
      try {
        const selector = `nav.header-nav a[href*="${path}"]`;
        const element = await driver.wait(until.elementLocated(By.css(selector)), 5000);
        const isDisplayed = await element.isDisplayed();

        if (isDisplayed) {
          console.log(`Klikam w link: "${label}" -> ${path}`);
          await element.click();
          await driver.sleep(1000);

          // Sprawdzenie, czy faktycznie przeniosło na właściwy adres
          const currentUrl = await driver.getCurrentUrl();
          if (!currentUrl.includes(path)) {
            console.warn(`Nie przeszedłeś na stronę "${label}". Obecny URL: ${currentUrl}`);
            passed = false;
          }
        } else {
          console.warn(`Link "${label}" jest niewidoczny`);
          passed = false;
        }

        // Powrót na stronę główną po każdym kliknięciu
        await driver.get(BASE_URL);
        await driver.sleep(1000);
      } catch {
        console.warn(`Nie znaleziono linku: "${label}"`);
        passed = false;
      }
    }

    console.log('Testuję akcje nagłówka (logowanie, rejestracja, wydarzenie)...');

    // Testowanie linków akcji (po prawej stronie nagłówka)
    for (const { label, selector } of actionLinks) {
      try {
        const element = await driver.wait(until.elementLocated(By.css(selector)), 5000);
        const isDisplayed = await element.isDisplayed();

        if (isDisplayed) {
          console.log(`Klikam w: "${label}"`);
          await element.click();
          await driver.sleep(1000);

          const currentUrl = await driver.getCurrentUrl();
          if (label === 'Zaloguj' && !currentUrl.includes('/login')) passed = false;
          if (label === 'Zarejestruj' && !currentUrl.includes('/rejestracja')) passed = false;
          if (label === 'Zorganizuj wydarzenie' && !currentUrl.includes('/zorganizuj-wydarzenie')) passed = false;
        } else {
          console.warn(`Element "${label}" nie jest widoczny`);
          passed = false;
        }

        // Powrót na stronę główną po każdej akcji
        await driver.get(BASE_URL);
        await driver.sleep(1000);
      } catch {
        console.warn(`Nie znaleziono elementu: "${label}"`);
        passed = false;
      }
    }

    console.log('Test navbaru zakończony');
    await driver.quit();
  } catch (error) {
    console.error('Wystąpił błąd:', error.message);
    if (driver) await driver.quit();
    passed = false;
  } finally {
    // Logowanie wyniku testu do pliku
    logTestResult(testName, passed, passed ? undefined : 'Niektóre linki w navbarze nie działają lub są niewidoczne');
    console.log(`Wynik końcowy: ${passed ? 'SUKCES' : 'BŁĘDY'}`);
    process.exit(passed ? 0 : 1);
  }
})();
