import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function registerAndLoginUser() {
  let driver;
  try {
    // Konfiguracja przeglądarki
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Uruchomienie przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawienie rozmiaru okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    console.log('Przeglądarka uruchomiona.');

    // Przejście do strony rejestracji
    await driver.get('http://lvi.ddev.site/rejestracja');
    console.log('Strona rejestracji załadowana.');

    // Krótkie oczekiwanie i przewinięcie strony
    await driver.sleep(2000);
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 2);');
    console.log('Przewinięto stronę w dół.');

    // Generowanie przykładowych danych użytkownika
    const firstNames = ['Anna', 'Marek', 'Kamil', 'Ola', 'Michał'];
    const lastNames = ['Kowalska', 'Nowak', 'Wiśniewska', 'Kamiński', 'Zieliński'];
    const first = firstNames[Math.floor(Math.random() * firstNames.length)];
    const last = lastNames[Math.floor(Math.random() * lastNames.length)];
    const login = `${first[0]}${last}`.replace('ł', 'l');
    const email = `${login.toLowerCase()}@fikcja.pl`;
    const password = 'Test1234!';

    console.log(`Wygenerowane dane: login: ${login}, e-mail: ${email}, hasło: ${password}`);

    // Wypełnianie formularza rejestracji
    const inputFields = await driver.findElements(By.css('form:nth-of-type(2) input'));
    if (inputFields.length >= 4) {
      console.log('Wypełnianie formularza rejestracji...');
      await inputFields[0].sendKeys(login);      // login
      await inputFields[1].sendKeys(email);      // e-mail
      await inputFields[2].sendKeys(password);   // hasło
      await inputFields[3].sendKeys(password);   // powtórzenie hasła
      console.log('Formularz rejestracji wypełniony.');
    } else {
      console.error('Nie znaleziono wszystkich pól formularza.');
      return;
    }

    // Zaznaczenie checkboxa z regulaminem
    const checkbox = await driver.findElement(By.css('form:nth-of-type(2) input[type="checkbox"]'));
    await checkbox.click();
    console.log('Zaznaczono checkbox regulaminu.');
    await driver.sleep(1000);

    // Kliknięcie przycisku "ZAREJESTRUJ SIĘ"
    const registerBtn = await driver.findElement(By.css('form:nth-of-type(2) input[type="submit"][value="ZAREJESTRUJ SIĘ"]'));
    await registerBtn.click();
    console.log('Kliknięto "ZAREJESTRUJ SIĘ".');

    // Czekanie na komunikat potwierdzający
    await driver.sleep(3000);
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const successMessage = bodyText.split('\n').find(line => /utworzono|sukces|zarejestrowano|konto/i.test(line));
    if (successMessage) {
      console.log('Rejestracja zakończona sukcesem:', successMessage);
    } else {
      console.error('Nie znaleziono komunikatu potwierdzającego rejestrację.');
    }

    // Przejście do zakładki logowania
    const loginTab = await driver.findElement(By.linkText('Login'));
    await loginTab.click();
    console.log('Przejście do strony logowania.');
    await driver.sleep(2000);

    // Wypełnianie formularza logowania
    const loginFields = await driver.findElements(By.css('form:nth-of-type(1) input'));
    if (loginFields.length >= 2) {
      console.log('Wypełnianie formularza logowania...');
      await loginFields[0].sendKeys(login);    // login
      await loginFields[1].sendKeys(password); // hasło
      console.log('Formularz logowania wypełniony.');
    } else {
      console.error('Nie znaleziono pól formularza logowania.');
      return;
    }

    // Kliknięcie przycisku "ZALOGUJ SIĘ"
    const loginBtn = await driver.findElement(By.css('form:nth-of-type(1) input[type="submit"][value="ZALOGUJ SIĘ"]'));
    await loginBtn.click();
    console.log('Kliknięto "ZALOGUJ SIĘ".');
    await driver.sleep(3000);

    // Sprawdzenie komunikatu "Witaj ponownie"
    const pageText = await driver.findElement(By.tagName('body')).getText();
    const welcomeMessage = pageText.split('\n').find(line => line.includes('Witaj ponownie'));
    if (welcomeMessage) {
      console.log('Logowanie zakończone sukcesem:', welcomeMessage);
    } else {
      console.error('Nie znaleziono komunikatu "Witaj ponownie".');
    }

    // Zakończenie testu i zamknięcie przeglądarki
    await driver.quit();
    console.log('Test zakończony pomyślnie.');

  } catch (err) {
    // Obsługa błędów:
    // Jeśli wystąpi błąd, zostanie on wypisany w konsoli.
    // Jeżeli przeglądarka została już uruchomiona, zostanie zamknięta.
    console.error('Błąd w trakcie testu:', err);
    if (driver) await driver.quit();
  }
})();
