import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js'; // Logowanie wyników testu

// Załaduj zmienne środowiskowe z pliku .env
dotenv.config();
const BASE_URL = (process.env.APP_URL || '').replace(/(^"|"$)/g, '').replace(/^https:/i, 'http:');
const testName = 'register_test';

(async function registerAndLoginUser() {
  let driver;
  let passed = true;

  try {
    // Konfiguracja przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Przeglądarka uruchomiona.');

    // Przejście na stronę rejestracji
    await driver.get(`${BASE_URL}/rejestracja`);
    console.log('Załadowano stronę rejestracji.');
    await driver.sleep(2000);
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 2);');

    // Generowanie danych testowego użytkownika
    const firstNames = ['Anna', 'Marek', 'Kamil', 'Ola', 'Michał'];
    const lastNames = ['Kowalska', 'Nowak', 'Wiśniewska', 'Kamiński', 'Zieliński'];
    const first = firstNames[Math.floor(Math.random() * firstNames.length)];
    const last = lastNames[Math.floor(Math.random() * lastNames.length)];
    const login = `${first[0]}${last}`.replace('ł', 'l');
    const email = `${login.toLowerCase()}@fikcja.pl`;
    const password = 'Test1234!';

    console.log(`Utworzono dane testowego konta: login=${login}, email=${email}`);

    // Wypełnienie formularza rejestracyjnego
    const registrationFields = await driver.findElements(By.css('form:nth-of-type(2) input'));
    if (registrationFields.length >= 6) {
      await registrationFields[0].sendKeys(login);       // Login
      await registrationFields[1].sendKeys(email);       // Email
      await registrationFields[2].sendKeys(first);       // Imię
      await registrationFields[3].sendKeys(last);        // Nazwisko
      await registrationFields[4].sendKeys(password);    // Hasło
      await registrationFields[5].sendKeys(password);    // Potwierdzenie hasła
    } else {
      console.error('Brakuje pól formularza rejestracji.');
      passed = false;
      await driver.quit();
      return logTestResult(testName, false, 'Brak pól formularza rejestracji');
    }

    // Zaznaczenie zgody na regulamin
    const termsCheckbox = await driver.findElement(By.css('form:nth-of-type(2) input[type="checkbox"]'));
    await termsCheckbox.click();
    await driver.sleep(1000);

    // Kliknięcie przycisku rejestracji
    const registerButton = await driver.wait(until.elementLocated(By.css('form:nth-of-type(2) input[type="submit"]')), 5000);
    await registerButton.click();
    await driver.sleep(3000);

    // Sprawdzenie sukcesu rejestracji
    const pageContent = await driver.findElement(By.tagName('body')).getText();
    const registrationSuccess = pageContent.split('\n').find(line =>
      /utworzono|sukces|zarejestrowano|konto|Moje konto/i.test(line)
    );

    if (registrationSuccess) {
      console.log('Rejestracja zakończona sukcesem:', registrationSuccess);
    } else {
      console.error('Brak potwierdzenia udanej rejestracji.');
      passed = false;
    }

    // Przejście do formularza logowania
    await driver.get(`${BASE_URL}/login`);
    await driver.sleep(2000);

    const loginFields = await driver.findElements(By.css('form:nth-of-type(1) input'));
    if (loginFields.length >= 2) {
      await loginFields[0].sendKeys(login);     // Login
      await loginFields[1].sendKeys(password);  // Hasło
    } else {
      console.error('Nie znaleziono pól logowania.');
      passed = false;
      await driver.quit();
      return logTestResult(testName, false, 'Brak pól formularza logowania');
    }

    // Kliknięcie przycisku logowania
    const loginButton = await driver.findElement(By.css('form:nth-of-type(1) input[type="submit"]'));
    await loginButton.click();
    await driver.sleep(3000);

    // Weryfikacja poprawnego logowania
    const pageText = await driver.findElement(By.tagName('body')).getText();
    const welcomeMessage = pageText.split('\n').find(line => line.includes('Witaj ponownie'));

    if (welcomeMessage) {
      console.log('Logowanie zakończone sukcesem:', welcomeMessage);
    } else {
      console.error('Brak komunikatu powitalnego po zalogowaniu.');
      passed = false;
    }

    await driver.quit();
    console.log('Test zakończony.');

    logTestResult(testName, passed);

  } catch (err) {
    console.error('Wystąpił błąd podczas testu:', err.message);
    if (driver) await driver.quit();
    logTestResult(testName, false, err.message);
  }
})();
