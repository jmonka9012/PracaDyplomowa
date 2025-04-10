import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Ładowanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Uzyskanie adresu URL aplikacji z pliku konfiguracyjnego
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, '');

// Nazwa testu, używana do logowania wyników
const testName = 'success_login_test';

(async function successLoginTest() {
  let driver;
  let passed = true;  // Flaga określająca, czy test przeszedł pomyślnie

  try {
    // Konfiguracja opcji przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');  // Wyłączenie dev/shm dla dużych aplikacji
    options.addArguments('--no-sandbox');  // Wyłączenie sandboxa w celu uniknięcia błędów na systemach Linux
    options.addArguments('--remote-debugging-port=9222');  // Uruchomienie portu debugowania zdalnego

    // Budowanie instancji WebDrivera z wybranym profilem przeglądarki Chrome
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Rozpoczęcie testu poprawnego logowania...');

    // Otwieranie strony głównej aplikacji
    await driver.get(BASE_URL);
    await driver.sleep(1000);  // Czekamy 1 sekundę, by strona zdążyła się załadować

    // Czekamy na załadowanie i kliknięcie w link "Login"
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Login')), 5000);
    await loginLink.click();
    console.log('Kliknięto "Login"');

    await driver.sleep(1500);  // Czekamy chwilę, aby strona się zaktualizowała

    // Wyszukiwanie pól formularza logowania (nazwa użytkownika i hasło)
    const usernameInput = await driver.wait(until.elementLocated(By.css('input[type="text"]')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.css('input[type="password"]')), 5000);
    await driver.sleep(500);  // Czekamy chwilę, aby upewnić się, że pola są gotowe do użycia

    // Wpisywanie danych logowania
    await usernameInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('12341234');

    // Przewijanie strony, aby upewnić się, że przycisk "Zaloguj się" jest widoczny
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    await driver.sleep(800);  // Czekamy, aż przewinięcie się zakończy

    // Czekamy na załadowanie przycisku "Zaloguj się" i klikamy
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Kliknięto "Zaloguj się"');

    await driver.sleep(1500);  // Czekamy chwilę na reakcję po kliknięciu

    // Sprawdzanie, czy użytkownik jest zalogowany poprzez analizę tekstu na stronie
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const lines = bodyText.split('\n');

    // Wyszukiwanie fraz sugerujących, że użytkownik jest zalogowany
    const loggedIn = lines.find(line =>
      line.toLowerCase().includes('wyloguj') || line.toLowerCase().includes('logout')
    );

    if (loggedIn) {
      // Jeśli użytkownik jest zalogowany, test jest uznany za pomyślny
      console.log('Zalogowano pomyślnie!');
      logTestResult(testName, true);
    } else {
      // Jeśli brak potwierdzenia logowania, test jest uznany za nieudany
      console.log('Nie znaleziono potwierdzenia logowania.');
      passed = false;
      logTestResult(testName, false, 'Nie znaleziono potwierdzenia logowania.');
    }

    // Czekanie chwilę przed zamknięciem przeglądarki
    await driver.sleep(3000);
    await driver.quit();

  } catch (error) {
    // Obsługa błędów, logowanie błędu i zamykanie przeglądarki w przypadku awarii
    console.error('Błąd:', error);
    if (driver) await driver.quit();
    logTestResult(testName, false, error.message);
  }
})();
