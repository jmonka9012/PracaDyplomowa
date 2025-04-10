import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Ładowanie zmiennych środowiskowych z pliku .env
dotenv.config();

// Uzyskanie adresu URL aplikacji z pliku konfiguracyjnego
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, '');

// Nazwa testu, używana do logowania wyników
const testName = 'wrong_password_test';

(async function wrongPasswordTest() {
  let driver;

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
    console.log('Rozpoczęcie testu z błędnym hasłem...');

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

    // Wpisywanie danych logowania z błędnym hasłem
    await usernameInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('zlehaslo123');

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

    // Sprawdzanie, czy na stronie pojawił się komunikat o błędzie
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const lines = bodyText.split('\n');

    // Definiowanie słów kluczowych, które mogą wskazywać na błąd przy logowaniu
    const keywords = ['nie istnieje', 'błędne', 'niepoprawne', 'nieprawidłowe', 'invalid'];

    // Szukanie linii tekstu zawierającej słowa kluczowe
    const errorLine = lines.find(line =>
      keywords.some(keyword => line.toLowerCase().includes(keyword))
    );

    // Jeśli znaleziono komunikat błędu, test jest uznany za pomyślny
    if (errorLine) {
      console.log('Komunikat błędu:', errorLine);
      logTestResult(testName, true);
    } else {
      // Jeśli brak komunikatu o błędzie, test jest uzanany za nieudany
      console.log('Nie znaleziono komunikatu o błędzie.');
      logTestResult(testName, false, 'Brak komunikatu o błędzie przy złym haśle.');
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
