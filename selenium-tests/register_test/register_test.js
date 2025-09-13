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
    const options = new chrome.Options()
      .addArguments('--disable-dev-shm-usage')
      .addArguments('--no-sandbox')
      .addArguments('--window-size=1400,1000');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    console.log('Przeglądarka uruchomiona.');

    // Przejście do strony głównej i kliknięcie w link rejestracji
    await driver.get(BASE_URL);
    await driver.sleep(500);
    const registerLink = await driver.findElement(By.css('a.header-login[href*="/rejestracja"]'));
    await registerLink.click();
    console.log('Kliknięto "Rejestruj".');

    // Oczekiwanie na sekcję rejestracji
    await driver.wait(until.elementLocated(By.id('rcol')), 5000);
    const registerSection = await driver.findElement(By.id('rcol'));
    await driver.wait(until.elementIsVisible(registerSection), 5000);

    // Generowanie danych testowego użytkownika
    const firstNames = ['Anna', 'Marek', 'Kamil', 'Ola', 'Michał'];
    const lastNames = ['Kowalska', 'Nowak', 'Wiśniewska', 'Kamiński', 'Zieliński'];
    const first = firstNames[Math.floor(Math.random() * firstNames.length)];
    const last = lastNames[Math.floor(Math.random() * lastNames.length)];
    const login = `${first[0]}${last}`.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    const email = `${login.toLowerCase()}@test.pl`;
    const password = 'Abc123!';

    console.log(`Testowe konto: login=${login}, email=${email}`);

    // Wypełnianie pól formularza rejestracyjnego z wywołaniem eventów input
    const usernameField = await registerSection.findElement(By.css('input[autocomplete="name"]'));
    await usernameField.sendKeys(login);
    await driver.executeScript("arguments[0].dispatchEvent(new Event('input', { bubbles: true }));", usernameField);

    const emailField = await registerSection.findElement(By.css('input[autocomplete="email"]'));
    await emailField.sendKeys(email);
    await driver.executeScript("arguments[0].dispatchEvent(new Event('input', { bubbles: true }));", emailField);

    const firstNameField = await registerSection.findElement(By.css('input[autocomplete="first_name"]'));
    await firstNameField.sendKeys(first);
    await driver.executeScript("arguments[0].dispatchEvent(new Event('input', { bubbles: true }));", firstNameField);

    const lastNameField = await registerSection.findElement(By.css('input[autocomplete="last_name"]'));
    await lastNameField.sendKeys(last);
    await driver.executeScript("arguments[0].dispatchEvent(new Event('input', { bubbles: true }));", lastNameField);

    const passwordField = await registerSection.findElement(By.id('register-password'));
    await passwordField.sendKeys(password);
    await driver.executeScript("arguments[0].dispatchEvent(new Event('input', { bubbles: true }));", passwordField);

    const confirmPasswordField = await registerSection.findElement(By.id('register-password-confirm'));
    await confirmPasswordField.sendKeys(password);
    await driver.executeScript("arguments[0].dispatchEvent(new Event('input', { bubbles: true }));", confirmPasswordField);

    // Czekaj na walidację frontendową
    await driver.sleep(2000);

    // Zaznaczenie zgody na regulamin
    const termsCheckbox = await registerSection.findElement(By.id('confirmation'));
    await driver.executeScript('arguments[0].scrollIntoView();', termsCheckbox);
    await termsCheckbox.click();
    await driver.sleep(500);

    // Sprawdzenie przycisku rejestracji
    const registerButton = await registerSection.findElement(By.css('input[type="submit"][value="zarejestruj się"]'));
    let btnClass = await registerButton.getAttribute('class');
    console.log('Klasa przycisku PRZED:', btnClass);

    // Oczekiwanie aż przycisk zostanie odblokowany
    let enabled = false;
    for (let i = 0; i < 10; i++) {
      const disabledAttr = await registerButton.getAttribute('disabled');
      btnClass = await registerButton.getAttribute('class');
      console.log(`Sprawdzenie ${i}: disabled=${disabledAttr}, class=${btnClass}`);
      if (disabledAttr === null && !btnClass.includes('disabled')) {
        enabled = true;
        break;
      }
      await driver.sleep(500);
    }

    if (!enabled) {
      console.error('Przycisk rejestracji nie został odblokowany.');
      passed = false;
    } else {
      // Kliknięcie przycisku i oczekiwanie na reakcję strony
      await registerButton.click();
      await driver.sleep(3000);

      const bodyText = await driver.findElement(By.tagName('body')).getText();
      if (!bodyText.includes('Witaj ponownie') && !bodyText.includes('Moje konto')) {
        console.error('Brak potwierdzenia rejestracji.');
        passed = false;
      } else {
        console.log('Rejestracja zakończona sukcesem.');
      }
    }

    // Próba logowania
    await driver.get(`${BASE_URL}/login`);
    await driver.wait(until.elementLocated(By.tagName('form')), 5000);
    const loginFields = await driver.findElements(By.css('form input'));
    await loginFields[0].sendKeys(login);
    await loginFields[1].sendKeys(password);
    await driver.findElement(By.css('form input[type="submit"]')).click();
    await driver.sleep(2000);

    const afterLoginText = await driver.findElement(By.tagName('body')).getText();
    if (afterLoginText.includes('Witaj ponownie')) {
      console.log('Logowanie zakończone sukcesem.');
    } else {
      console.error('Logowanie nie powiodło się.');
      passed = false;
    }

    await driver.quit();
    logTestResult(testName, passed);
  } catch (e) {
    console.error('Błąd testu:', e);
    if (driver) await driver.quit();
    logTestResult(testName, false, e.message);
  }
})();
