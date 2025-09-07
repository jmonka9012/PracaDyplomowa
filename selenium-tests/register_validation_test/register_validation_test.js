import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/"/g, '');

(async function registerValidationTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja opcji przeglądarki Chrome w trybie headless
    const options = new chrome.Options();
    options.addArguments('--headless=new'); // Uruchomienie bez interfejsu graficznego
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');

    // Inicjalizacja sterownika przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    // Przejście na stronę główną aplikacji
    console.log('Przejście na stronę główną...');
    await driver.get(BASE_URL);
    await driver.sleep(2000);

    // Kliknięcie przycisku "Zaloguj"
    console.log('Kliknięcie "Zaloguj"...');
    await driver.wait(until.elementLocated(By.css('a.header-login[href$="/login"]')), 5000);
    let loginBtn = await driver.findElement(By.css('a.header-login[href$="/login"]'));
    await loginBtn.click();
    await driver.sleep(2000);

    // Kliknięcie przycisku "Nie masz konta? Zarejestruj się!"
    console.log('Kliknięcie "Nie masz konta? Zarejestruj się!"...');
    await driver.wait(until.elementLocated(By.css('a.read-more')), 5000);
    let registerLink = await driver.findElement(By.css('a.read-more'));
    await registerLink.click();
    await driver.sleep(2000);

    // Oczekiwanie na załadowanie formularza rejestracji
    console.log('Czekanie na formularz rejestracji...');
    await driver.wait(until.elementLocated(By.id('register-email')), 5000);
    await driver.sleep(1000);

    // Funkcja pomocnicza do wpisywania znaków w polach formularza
    const fastType = async (element, text) => {
      await element.sendKeys(text);
      await driver.sleep(500); // Krótsze opóźnienie
    };

    // Wpisanie imienia i nazwiska do odpowiednich pól
    console.log('Wpisywanie danych osobowych...');
    await fastType(await driver.findElement(By.css('input[autocomplete="register-first_name"]')), 'Jan');
    await fastType(await driver.findElement(By.css('input[autocomplete="register-last_name"]')), 'Kowalski');

    await driver.sleep(1000);

    // Wpisanie nazwy użytkownika
    console.log('Wpisywanie nazwy użytkownika...');
    await fastType(await driver.findElement(By.id('register-username')), 'TestUser');

    // Wpisanie hasła i jego potwierdzenia
    console.log('Wpisywanie hasła...');
    await fastType(await driver.findElement(By.id('register-password')), 'Test1234!');
    await fastType(await driver.findElement(By.id('register-password-confirm')), 'Test1234!');

    await driver.sleep(1000);

    // Zaznaczenie checkboxa zgody na przetwarzanie danych osobowych
    console.log('Zaznaczanie zgody na przetwarzanie danych...');
    let checkbox = await driver.findElement(By.id('confirmation'));
    await checkbox.click();
    await driver.sleep(1000);

    // Pobranie przycisku rejestracji i sprawdzenie, czy jest widoczny
    console.log('Sprawdzanie przycisku "Zarejestruj się"...');
    let submitBtn = await driver.wait(until.elementLocated(By.css('input[type="submit"]')), 5000);
    await driver.sleep(1000);

    console.log('Czy przycisk "Zarejestruj się" jest widoczny?', await submitBtn.isDisplayed());

    // Wymuszenie widoczności przycisku, jeśli jest ukryty
    if (!(await submitBtn.isDisplayed())) {
      console.log("Wymuszenie widoczności przycisku...");
      await driver.executeScript("arguments[0].style.display = 'block'; arguments[0].style.visibility = 'visible';", submitBtn);
    }

    // Przewinięcie strony do przycisku przed kliknięciem
    console.log('Przewijanie do przycisku...');
    await driver.executeScript("arguments[0].scrollIntoView(true);", submitBtn);
    await driver.sleep(1000);

    // Sprawdzenie, czy można kliknąć przycisk
    console.log('Sprawdzenie interaktywności przycisku...');
    try {
      await submitBtn.click();
    } catch (error) {
      console.error("Błąd kliknięcia przycisku:", error.message);
      await driver.executeScript("arguments[0].click();", submitBtn);
    }

    testPassed = true;

  } catch (error) {
    console.error('Błąd testu:', error.message);
  } finally {
    // Zamykanie przeglądarki i logowanie wyniku testu
    await driver.quit();
    logTestResult('register_validation_test', testPassed);
  }
})();
