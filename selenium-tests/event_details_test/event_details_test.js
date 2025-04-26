import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; 

// Wczytanie zmiennych środowiskowych
dotenv.config();

// Pobranie adresu aplikacji z pliku .env
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, '');

// Nazwa testu używana w logach
const testName = 'event_details_test';

// Główna funkcja testowa wykonywana asynchronicznie
(async function eventDetailsTest() {
  let driver;
  let passed = true; // Flaga określająca powodzenie testu

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--headless', '--disable-dev-shm-usage', '--no-sandbox');

    // Inicjalizacja sterownika Selenium WebDriver
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    console.log('Rozpoczęcie testu szczegółów wydarzenia.');

    // Przejście na stronę główną aplikacji
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Oczekiwanie na przycisk "Zobacz więcej" i kliknięcie w niego
    const zobaczWiecejBtn = await driver.wait(
      until.elementLocated(By.xpath("//a[contains(., 'Zobacz więcej') and contains(@class, 'event-link')]")),
      10000
    );
    await zobaczWiecejBtn.click();
    console.log('Kliknięto przycisk "Zobacz więcej".');

    // Oczekiwanie na załadowanie strony szczegółów wydarzenia
    await driver.wait(until.urlContains('/wydarzenia/'), 10000);

    // Weryfikacja obecności treści charakterystycznej dla szczegółów wydarzenia
    const tytulWydarzenia = await driver.findElements(
      By.xpath("//*[contains(text(), '2025') or contains(text(), 'Lorem') or contains(text(), 'Wydarzenie')]")
    );

    if (tytulWydarzenia.length === 0) {
      // W przypadku braku oczekiwanej treści oznaczenie testu jako niezaliczony
      console.log('Nie znaleziono oczekiwanej treści na stronie wydarzenia.');
      passed = false;
      logTestResult(testName, false, 'Nie znaleziono szczegółów wydarzenia.');
    } else {
      // W przypadku powodzenia oznaczenie testu jako zaliczony
      console.log('Test zakończony pomyślnie – szczegóły wydarzenia są dostępne.');
      logTestResult(testName, true);
    }

    // Krótkie wstrzymanie wykonania przed zamknięciem przeglądarki
    await driver.sleep(3000);

    // Zamykanie sesji przeglądarki
    await driver.quit();

  } catch (error) {
    // Obsługa ewentualnych błędów w trakcie wykonania testu
    console.error('Błąd wykonania testu:', error.message);

    // Zamknięcie przeglądarki w przypadku wystąpienia błędu
    if (driver) await driver.quit();

    // Rejestracja niepowodzenia testu
    logTestResult(testName, false, error.message);
  }
})();
