import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function runNavigationTest() {
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

    // Ustawienie rozmiaru okna, żeby widzieć wszystkie okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Przeglądarka uruchomiona.');

    // Przejście do strony głównej
    await driver.get('http://lvi.ddev.site/');
    console.log('Strona główna załadowana.');

    await driver.sleep(3500);

    // Funkcja klikająca w link tekstowy i wypisyjące w terminalu, co zostało zrobione i ustawienie czasu
    const clickMenu = async (linkText) => {
      try {
        const link = await driver.wait(
          until.elementLocated(By.linkText(linkText)),
          5000
        );
        await link.click();
        console.log(`Kliknięto: ${linkText}`);
        await driver.sleep(2000);
      } catch (err) {
        console.log(`Link "${linkText}" nie został znaleziony.`);
      }
    };

    // Klikanie w kolejne zakładki i powrót do home
    const menuItems = ['Blog', 'Single', 'Kontakt', 'Home'];
    for (const item of menuItems) {
      await clickMenu(item);
    }
    // Zamknięcie przeglądarki

    await driver.quit();
    console.log('Przeglądarka zamknięta, test zakończony.');

    // Gdy błąd, wypisz błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
