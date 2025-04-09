import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytaj zmienne środowiskowe z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usuwa cudzysłowy z adresu URL, jeśli są

(async function stressLoginTest() {
  let driver;
  try {
    // Konfiguracja przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage'); // Poprawka na środowiska z ograniczoną pamięcią
    options.addArguments('--no-sandbox');             // Wymagane w wielu środowiskach CI/CD
    options.addArguments('--remote-debugging-port=9222'); // Opcjonalnie do debugowania

    // Inicjalizacja WebDrivera
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Otwieram stronę...');
    await driver.get(BASE_URL);
    await driver.sleep(1000); // Krótkie czekanie na załadowanie

    console.log('Szukanie przycisku "Login"...');
    const loginBtn = await driver.findElement(By.linkText('Login'));

    // Przygotowanie do testu stresowego
    let success = 0;
    let failed = 0;
    const startTime = Date.now();
    const duration = 3000; // Czas trwania testu w milisekundach (3 sekundy)

    console.log('Rozpoczynam szybkie klikanie...');

    // Pętla szybkiego klikania w "Login"
    while (Date.now() - startTime < duration) {
      try {
        await loginBtn.click(); // Próba kliknięcia
        success++;
      } catch (e) {
        failed++;
      }
    }

    console.log('Klikanie zakończone.');
    console.log(`Udane kliknięcia: ${success}`);
    console.log(`Nieudane próby: ${failed}`);

    await driver.sleep(2000); // Mała przerwa przed zamknięciem

    console.log('Zamykam przeglądarkę...');
    await driver.quit();

  } catch (error) {
    // Obsługa ewentualnych błędów
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
