import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import { logTestResult } from '../logUtils.js';

// Załadowanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/"/g, '');

// Główna funkcja testowa weryfikująca walidację formularza rejestracji
(async function registerValidationErrorsTest() {
  let driver;
  let testPassed = false;

  try {
    // Konfiguracja opcji uruchomieniowych dla przeglądarki Chrome
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');

    // Inicjalizacja przeglądarki Chrome z określonymi parametrami
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie wymiarów okna 
    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    // Otwarcie strony głównej aplikacji
    console.log('Przejście na stronę główną');
    await driver.get(BASE_URL);
    await driver.sleep(2000);

    // Przejście do widoku logowania
    console.log('Otwarcie widoku logowania');
    await driver.findElement(By.css('a[href$="/login"]')).click();
    await driver.sleep(2000);

    // Przejście do formularza rejestracji
    console.log('Otwarcie formularza rejestracji');
    await driver.findElement(By.css('a.read-more')).click();
    await driver.sleep(2000);

    // Etap 1 – Próba rejestracji z błędnym adresem e-mail
    console.log('Uzupełnienie formularza z nieprawidłowym adresem e-mail');
    await driver.findElement(By.css('input[autocomplete="register-first_name"]')).sendKeys('Jan');
    await driver.findElement(By.css('input[autocomplete="register-last_name"]')).sendKeys('Kowalski');
    await driver.findElement(By.id('register-email')).sendKeys('test@@wrong.mail');
    await driver.findElement(By.id('register-password')).sendKeys('Test1234!');
    await driver.findElement(By.id('register-password-confirm')).sendKeys('Test1234!');
    await driver.findElement(By.id('confirmation')).click();
    await driver.sleep(1000);

    // Wprowadzenie nazwy użytkownika i wywołanie walidacji
    const usernameField1 = await driver.findElement(By.id('register-username'));
    await usernameField1.sendKeys('TestUser');
    await usernameField1.sendKeys('\t');

    // Sprawdzenie, czy wyświetlany jest komunikat błędu walidacyjnego
    const emailErrorElement = await driver.findElements(By.css('div.error-msg'));
    if (emailErrorElement.length === 0) {
      const registerBtn = await driver.findElement(By.css('.input-wrap.col-12 input[type="submit"][value="zarejestruj się"]'));
      console.log('Kliknięcie przycisku rejestracji z błędnym adresem e-mail');
      await registerBtn.click();
      await driver.sleep(2000);
    } else {
      console.log('Wykryto komunikat walidacyjny błędnego adresu e-mail – zablokowano rejestrację');
    }

    // Etap 2 – Próba rejestracji z poprawnym adresem e-mail i niezgodnością haseł
    await driver.get(BASE_URL);
    await driver.sleep(3000);
    await driver.findElement(By.css('a[href$="/login"]')).click();
    await driver.sleep(2000);
    await driver.findElement(By.css('a.read-more')).click();
    await driver.sleep(2000);

    // Uzupełnienie danych z poprawnym adresem e-mail i błędnym potwierdzeniem hasła
    console.log('Uzupełnienie formularza z poprawnym adresem e-mail i niezgodnym hasłem');
    await driver.findElement(By.css('input[autocomplete="register-first_name"]')).sendKeys('Jan');
    await driver.findElement(By.css('input[autocomplete="register-last_name"]')).sendKeys('Kowalski');
    await driver.findElement(By.id('register-email')).clear();
    await driver.findElement(By.id('register-email')).sendKeys('correct@email.com');
    await driver.findElement(By.id('register-password')).clear();
    await driver.findElement(By.id('register-password-confirm')).clear();
    await driver.findElement(By.id('register-password')).sendKeys('Test1234!');
    await driver.findElement(By.id('register-password-confirm')).sendKeys('WrongPass1');
    await driver.findElement(By.id('confirmation')).click();
    await driver.sleep(1000);

    // Weryfikacja stanu zaznaczenia checkboxa i ponowne zaznaczenie w razie potrzeby
    const checkbox = await driver.findElement(By.css('input[type="checkbox"][name="confirmation"]'));
    const isChecked = await checkbox.isSelected();
    if (!isChecked) {
      await checkbox.click();
      await driver.sleep(1000);
    }

    // Wprowadzenie nazwy użytkownika i aktywacja przycisku rejestracji
    const usernameField2 = await driver.findElement(By.id('register-username'));
    await usernameField2.sendKeys('TestUserXYZ');
    await usernameField2.sendKeys('\t');

    // Oczekiwanie na aktywację przycisku rejestracji i wykonanie kliknięcia
    const registerBtn = await driver.findElement(By.css('.input-wrap.col-12 input[type="submit"][value="zarejestruj się"]'));
    console.log('Oczekiwanie na możliwość kliknięcia przycisku rejestracji');
    await driver.wait(until.elementIsEnabled(registerBtn), 7000);
    await registerBtn.click();
    await driver.sleep(2000);

    // Sprawdzenie komunikatu walidacyjnego dotyczącego hasła
    const passwordErrorElement = await driver.wait(until.elementLocated(By.css('#register-password + .error-msg')), 5000);
    const passwordError = await passwordErrorElement.getText();
    console.log('Otrzymany komunikat walidacyjny hasła:', passwordError);

    testPassed = true;

  } catch (error) {
    // Obsługa błędów wykonania testu
    console.error('Błąd wykonania testu:', error.message);
  } finally {
    // Zakończenie sesji testowej i zapisanie wyniku testu
    await driver.quit();
    logTestResult('register_validation_errors_test', testPassed);
  }
})();
