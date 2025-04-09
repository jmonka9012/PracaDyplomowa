import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytaj zmienne środowiskowe z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usuwa ewentualne cudzysłowy z adresu

(async function registerAndLoginUser() {
  let driver;

  try {
    // Konfiguracja przeglądarki 
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage'); // Lepsze działanie w środowiskach z ograniczoną pamięcią
    options.addArguments('--no-sandbox'); // Konieczne w wielu środowiskach CI/CD
    options.addArguments('--remote-debugging-port=9222'); // Dla trybu zdalnego debugowania

    // Inicjalizacja drivera
    driver = await new Builder().forBrowser('chrome').setChromeOptions(options).build();
    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Przeglądarka uruchomiona.');

    // Przejście do strony rejestracji
    await driver.get(`${BASE_URL}/rejestracja`);
    console.log('Załadowano stronę rejestracji.');

    await driver.sleep(2000); // Czekanie na załadowanie UI
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 2);'); // Scroll do formularza
    console.log('Przewinięto stronę.');

    // Generowanie danych testowych użytkownika
    const firstNames = ['Anna', 'Marek', 'Kamil', 'Ola', 'Michał'];
    const lastNames = ['Kowalska', 'Nowak', 'Wiśniewska', 'Kamiński', 'Zieliński'];
    const first = firstNames[Math.floor(Math.random() * firstNames.length)];
    const last = lastNames[Math.floor(Math.random() * lastNames.length)];
    const login = `${first[0]}${last}`.replace('ł', 'l');
    const email = `${login.toLowerCase()}@fikcja.pl`;
    const password = 'Test1234!';

    console.log(`Dane konta: login: ${login}, email: ${email}, hasło: ${password}`);

    // Wypełnienie formularza rejestracyjnego
    const registrationFields = await driver.findElements(By.css('form:nth-of-type(2) input'));
    if (registrationFields.length >= 6) {
      console.log('Wypełniam formularz rejestracji...');
      await registrationFields[0].sendKeys(login);
      await registrationFields[1].sendKeys(email);
      await registrationFields[2].sendKeys(first);
      await registrationFields[3].sendKeys(last);
      await registrationFields[4].sendKeys(password);
      await registrationFields[5].sendKeys(password);
    } else {
      console.error('Nie znaleziono wszystkich pól formularza rejestracji.');
      return;
    }

    // Akceptacja regulaminu
    const termsCheckbox = await driver.findElement(By.css('form:nth-of-type(2) input[type="checkbox"]'));
    await termsCheckbox.click();
    console.log('Zaznaczono zgodę na regulamin.');
    await driver.sleep(1000);

    // Kliknięcie przycisku "Zarejestruj się"
    const registerButton = await driver.wait(until.elementLocated(By.css('form:nth-of-type(2) input[type="submit"]')), 5000);
    await registerButton.click();
    console.log('Kliknięto przycisk rejestracji.');

    await driver.sleep(3000);

    // Weryfikacja rejestracji na podstawie tekstu na stronie
    const pageContent = await driver.findElement(By.tagName('body')).getText();
    const registrationSuccess = pageContent.split('\n').find(line =>
      /utworzono|sukces|zarejestrowano|konto|Moje konto/i.test(line)
    );

    if (registrationSuccess) {
      console.log('Rejestracja zakończona sukcesem:', registrationSuccess);
    } else {
      console.error('Nie znaleziono komunikatu potwierdzającego rejestrację.');
    }

    // Przejście do strony logowania
    await driver.get(`${BASE_URL}/login`);
    console.log('Przejście do strony logowania.');
    await driver.sleep(2000);

    // Wypełnienie formularza logowania
    const loginFields = await driver.findElements(By.css('form:nth-of-type(1) input'));
    if (loginFields.length >= 2) {
      console.log('Wypełniam formularz logowania...');
      await loginFields[0].sendKeys(login);
      await loginFields[1].sendKeys(password);
    } else {
      console.error('Nie znaleziono pól formularza logowania.');
      return;
    }

    // Kliknięcie przycisku logowania
    const loginButton = await driver.findElement(By.css('form:nth-of-type(1) input[type="submit"]'));
    await loginButton.click();
    console.log('Kliknięto "ZALOGUJ SIĘ".');
    await driver.sleep(3000);

    // Weryfikacja logowania po komunikacie
    const pageText = await driver.findElement(By.tagName('body')).getText();
    const welcomeMessage = pageText.split('\n').find(line => line.includes('Witaj ponownie'));

    if (welcomeMessage) {
      console.log('Logowanie zakończone sukcesem:', welcomeMessage);
    } else {
      console.error('Nie znaleziono komunikatu "Witaj ponownie".');
    }

    // Zamykanie drivera
    await driver.quit();
    console.log('Test zakończony pomyślnie.');

  } catch (err) {
    // Obsługa wyjątków i zamykanie drivera awaryjnie
    console.error('Błąd w trakcie testu:', err);
    if (driver) await driver.quit();
  }
})();
