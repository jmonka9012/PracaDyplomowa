import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, '');

// Test z błędnym hasłem
(async function wrongPasswordTest() {
  let driver;
  try {
    // Ustawienia dla przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Inicjalizacja WebDrivera dla Chrome
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Rozpoczęcie testu z błędnym hasłem...');

    // Przejście do strony głównej aplikacji
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Zlokalizowanie i kliknięcie linku "Login"
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Login')), 5000);
    await loginLink.click();
    console.log('Kliknięto "Login"');

    await driver.sleep(1500);

    // Zlokalizowanie pól do wprowadzenia nazwy użytkownika i hasła
    const usernameInput = await driver.wait(until.elementLocated(By.css('input[type="text"]')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.css('input[type="password"]')), 5000);
    await driver.sleep(500);

    // Wprowadzenie błędnych danych logowania
    await usernameInput.sendKeys('pgalimski');
    await passwordInput.sendKeys('zlehaslo123');

    // Przewinięcie strony
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    await driver.sleep(800);

    // Zlokalizowanie i kliknięcie przycisku "Zaloguj się"
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Kliknięto "Zaloguj się"');

    await driver.sleep(1500);

    // Sprawdzenie, czy na stronie znajduje się komunikat o błędzie
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const lines = bodyText.split('\n');

    // Wyszukiwanie słów kluczowych w komunikacie błędu
    const keywords = ['nie istnieje', 'błędne', 'niepoprawne', 'nieprawidłowe', 'invalid'];

    const errorLine = lines.find(line =>
      keywords.some(keyword => line.toLowerCase().includes(keyword))
    );

    // Informacja o wyniku testu
    if (errorLine) {
      console.log('Komunikat błędu:', errorLine);
    } else {
      console.log('Nie znaleziono komunikatu o błędzie.');
    }

    await driver.sleep(3000);
    await driver.quit();

  } catch (error) {
    // Obsługa błędów
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
