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

    // Ustawienie rozmiaru okna, by widzieć wszystkie okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Start testu logowania...');
    
    // Przejście do strony głównej
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(1000);

    // Kliknięcie w link "Login"
    const loginLink = await driver.wait(until.elementLocated(By.linkText('Login')), 5000);
    await loginLink.click();
    console.log('Kliknięto "Login"');

    await driver.sleep(1500);

    // Znalezienie pól do logowania
    const usernameInput = await driver.wait(until.elementLocated(By.css('input[type="text"]')), 5000);
    const passwordInput = await driver.wait(until.elementLocated(By.css('input[type="password"]')), 5000);
    await driver.sleep(500);

    // Wprowadzenie danych logowania bzdrura (brak konta)
    await usernameInput.sendKeys('bzdura');
    await passwordInput.sendKeys('123');

    // Przewinięcie lekko w dół
    await driver.executeScript('window.scrollBy(0, window.innerHeight / 3);');
    
    await driver.sleep(800);

    // Kliknięcie przycisku "Zaloguj się"
    const submitButton = await driver.wait(
      until.elementLocated(By.css('input[type="submit"][value="Zaloguj się"]')),
      5000
    );
    await submitButton.click();
    console.log('Kliknięto "Zaloguj się"');

    await driver.sleep(4000);
    await driver.quit();

    // Gdy błąd, wypisz błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
