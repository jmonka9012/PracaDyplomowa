import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';

// Wczytanie zmiennych środowiskowych z pliku .env
dotenv.config();
const BASE_URL = process.env.APP_URL.replace(/(^"|"$)/g, ''); // Usuwa cudzysłowy jeśli występują

(async function runLoginTest() {
  let driver;

  try {
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Start testu logowania...');

    // Przejście na stronę główną
    await driver.get(BASE_URL);
    await driver.sleep(1000);

    // Kliknięcie w link "Login"
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Login')), 5000);
    await loginLink.click();
    console.log('Kliknięto "Login"');

    await driver.sleep(1500);

    // Wyszukiwanie pól loginu i hasła
    const usernameInput = await driver.wait(until.elementLocated(By.css('input[type="text"]')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.css('input[type="password"]')), 5000);
    await driver.sleep(500);

    // Wprowadzenie przykładowych danych
    await usernameInput.sendKeys('bzdura');
    await passwordInput.sendKeys('123');

    // Scrollowanie w dół do przycisku
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    await driver.sleep(800);

    // Kliknięcie przycisku "Zaloguj się"
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Kliknięto "Zaloguj się"');

    await driver.sleep(1500);

    // Pobranie i analiza treści z <body>
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const lines = bodyText.split('\n');

    // Wyszukiwanie słów kluczowych wskazujących na błąd
    const keywords = ['nie istnieje', 'błędne', 'niepoprawne', 'nieprawidłowe', 'invalid'];

    const errorLine = lines.find(line =>
      keywords.some(keyword => line.toLowerCase().includes(keyword))
    );

    if (errorLine) {
      console.log('Komunikat błędu:', errorLine);
    } else {
      console.log('Nie znaleziono komunikatu o błędzie.');
    }

    await driver.sleep(3000);
    await driver.quit();
      // wypisz Błąd, gdy błąd 
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
