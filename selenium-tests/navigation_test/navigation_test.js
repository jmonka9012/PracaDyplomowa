import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Narzędzie logujące wynik testu

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Pobranie adresu URL aplikacji z konfiguracji środowiska
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');
const testName = 'navigation_test'; // Nazwa testu (do logów i plików)

(async function runNavigationTest() {
  console.log('Test nawigacji został uruchomiony');

  let driver;
  let passed = true; // Domyślna wartość, test uznany za zaliczony, jeśli nic nie pójdzie nie tak

  try {
    // Konfiguracja opcji przeglądarki Chrome w trybie headless
    const options = new chrome.Options();
    options.addArguments('--headless=new');              // Tryb headless (bez GUI)
    options.addArguments('--disable-dev-shm-usage');     // Optymalizacja zasobów dla Linux/WSL
    options.addArguments('--no-sandbox');                // Wyłączenie sandboxa (niezbędne np. w CI/CD)

    // Inicjalizacja WebDrivera z Chrome
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie okna przeglądarki oraz timeoutów
    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    await driver.manage().setTimeouts({ implicit: 5000 });

    // Wejście na stronę główną aplikacji
    await driver.get(BASE_URL);
    console.log('Załadowano stronę główną');
    await driver.sleep(1000); // Krótkie opóźnienie na załadowanie zasobów

    // Znalezienie elementu nawigacji
    const nav = await driver.wait(until.elementLocated(By.css('nav.header-nav')), 5000);

    // Pobranie wszystkich linków (a) w obrębie nawigacji
    const links = await nav.findElements(By.css('a'));

    console.log('Znalezione linki w navbarze:');
    const menuItems = []; // Przechowuje linki widoczne i możliwe do kliknięcia

    // Iteracja przez każdy znaleziony link
    for (const link of links) {
      const text = await link.getText();                // Pobranie tekstu linku
      const href = await link.getAttribute('href');     // Pobranie atrybutu href

      if (text.trim() !== '') {
        console.log(`- ${text} (${href})`);
        menuItems.push({ label: text.trim(), href });   // Zapisanie tylko niepustych linków
      }
    }

    // Klikanie po kolei w każdy zapisany link
    for (const { label, href } of menuItems) {
      try {
        // Znalezienie linku po jego widocznym tekście
        const element = await driver.findElement(By.linkText(label));
        console.log(`Klikam w "${label}"`);
        await element.click();
        await driver.sleep(1200); // Krótkie oczekiwanie na załadowanie strony

        // Sprawdzenie, czy URL po kliknięciu zawiera ostatni segment z href
        const currentUrl = await driver.getCurrentUrl();
        if (!currentUrl.includes(href.split('/').pop())) {
          console.warn(`Nie przeszedłeś poprawnie na stronę "${label}". Obecny URL: ${currentUrl}`);
          passed = false;
        }

        // Powrót do strony głównej po każdym kliknięciu
        await driver.get(BASE_URL);
        await driver.sleep(1000);
      } catch (err) {
        console.warn(`Nie udało się kliknąć w: "${label}"`);
        passed = false;
      }
    }

    // Zakończenie testu
    console.log('Test nawigacji zakończony');
    console.log(`Wynik końcowy: ${passed ? 'SUKCES' : 'BŁĘDY'}`);

    // Zamknięcie przeglądarki
    await driver.quit();

    // Logowanie do pliku wynikowego
    logTestResult(testName, passed, passed ? undefined : 'Niektóre linki w navbarze nie działają lub są niewidoczne');

  } catch (error) {
    // Obsługa nieoczekiwanych błędów
    console.error('Wystąpił błąd krytyczny:', error.message);
    if (driver) await driver.quit();

    // Logujemy wynik negatywny z komunikatem błędu
    logTestResult(testName, false, error.message);
  }
})();
