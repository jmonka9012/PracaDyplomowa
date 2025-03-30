import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function runNavbarLinksTest() {
  let driver;
  try {
    // Konfiguracja przeglądarki
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');
    options.addArguments('--window-size=1280,800');

    // Uruchomienie przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    console.log('Przeglądarka uruchomiona.');

    // Przejście do strony głównej
    await driver.get('http://lvi.ddev.site/');
    console.log('Strona główna załadowana.');

    await driver.sleep(2000);

    // Lista linków do sprawdzenia
    const links = ['Home', 'Blog', 'Single', 'Kontakt', 'CE', 'Jacek CE'];

    // Sprawdzenie widoczności każdego linku i wypisanie w terminalu
    for (const text of links) {
      try {
        const element = await driver.wait(until.elementLocated(By.linkText(text)), 5000);
        const isDisplayed = await element.isDisplayed();
        console.log(`Link "${text}" widoczny: ${isDisplayed}`);
      } catch (err) {
        console.log(`Link "${text}" nie został znaleziony.`);
      }
    }
    // Koniec testu, zamyka przeglądarkę 
    await driver.sleep(2000);
    await driver.quit();
    console.log('Przeglądarka zamknięta, test zakończony.');

    // Gdy błąd, wypisz błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
