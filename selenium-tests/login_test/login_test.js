import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function runLoginTest() {
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

    console.log('Start testu logowania...');

    // Wejście na stronę główną
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(1000);

    // Kliknięcie w przycisk Login w menu
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Login')), 5000);
    await loginLink.click();
    console.log('Kliknięto "Login"');

    await driver.sleep(1500); // Czekanie aż załaduje się formularz

    // Szukanie pól formularza (login + hasło)
    const usernameInput = await driver.wait(until.elementLocated(By.css('input[type="text"]')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.css('input[type="password"]')), 5000);
    await driver.sleep(500); // Mała pauza przed wpisywaniem

    // Wpisujemy błędne dane (mogą być dowolne)
    await usernameInput.sendKeys('bzdura');
    await passwordInput.sendKeys('123');

    // Przewijanie stronę lekko w dół – żeby było widać przycisk
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    await driver.sleep(800);

    // Kliknięcie "Zaloguj się"
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Kliknięto "Zaloguj się"');

    await driver.sleep(1500); // Czekanie na ewentualny komunikat

    // Zbieranie cały tekst z widocznej strony
    const bodyText = await driver.findElement(By.tagName('body')).getText();
    const lines = bodyText.split('\n'); // Dzielimy na linie

    // Słowa, które mogą występować w błędach
    const keywords = ['nie istnieje', 'błędne', 'niepoprawne', 'nieprawidłowe', 'invalid'];

    // Szukanie linii zawierającej potencjalny błąd
    const errorLine = lines.find(line =>
      keywords.some(keyword => line.toLowerCase().includes(keyword))
    );

    // jeżeli błąd nie znaleziono komunikatów lub są inne 
    if (errorLine) {
      console.log('Komunikat błędu:', errorLine);
    } else {
      console.log('Nie znaleziono komunikatu o błędzie.');
    }

    // Pauza przed zakończeniem testu
    await driver.sleep(3000);
    await driver.quit(); // Zamknięcie przeglądarki

  } catch (error) {
    // jeżeli błąd, wypisz błąd
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
