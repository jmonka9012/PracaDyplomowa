import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Adres aplikacji pobierany z .env
const BASE_URL = process.env.APP_URL;

(async function rapidLoginClickTest() {
  let driver;

  try {
    // Konfiguracja opcji dla Chrome – bez trybu graficznego
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage'); // unika problemów z pamięcią współdzieloną
    options.addArguments('--no-sandbox'); // potrzebne w środowiskach kontenerowych
    options.addArguments('--remote-debugging-port=9222'); // port do zdalnego debugowania

    // Tworzenie instancji drivera
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozdzielczości okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Wchodzę na stronę...');
    await driver.get(BASE_URL);
    await driver.sleep(100); // krótki czas na pełne załadowanie

    let sukcesy = 0; // licznik poprawnych kliknięć
    let błędy = 0;   // licznik błędów

    console.log('Rozpoczynam klikanie "Login"...');

    // Główna pętla testowa – 100 prób kliknięcia w link "Login"
    for (let i = 0; i < 100; i++) {
      try {
        // Szukanie linku "Login" i kliknięcie
        const loginBtn = await driver.wait(until.elementLocated(By.linkText('Login')), 100);
        await loginBtn.click();

        // Oczekiwanie na pojawienie się formularza logowania
        await driver.wait(until.elementLocated(By.css('form input[type="text"]')), 200);
        sukcesy++;
      } catch {
        // W przypadku błędu (np. brak elementu w DOM) – inkrementuj błędy
        błędy++;
      }

      // Powrót do strony głównej po każdej iteracji
      await driver.get(BASE_URL);
    }

    // Podsumowanie wyników
    console.log(`Kliknięć ogólnie: 100`);
    console.log(`Udane przejścia do logowania: ${sukcesy}`);
    console.log(`Nieudane/błędne kliknięcia: ${błędy}`);

    // Zakończenie sesji
    await driver.quit();
  } catch (error) {
    // Obsługa wyjątków ogólnych
    console.error('Błąd ogólny:', error);
    if (driver) await driver.quit();
  }
})();
