import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function testSingleButton() {
  let driver;
  try {
    // Konfiguracja opcji przeglądarki
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
    await driver.manage().window().setRect({ width: 1280, height: 1024 });

    console.log('Przeglądarka uruchomiona.');
    await driver.get('http://lvi.ddev.site/');
    console.log('Strona główna załadowana.');
    //Czas oczekiwania
    await driver.sleep(2000);

    // Funkcja klikająca w link nawigacyjny
    const clickLink = async (linkText) => {
      const link = await driver.wait(until.elementLocated(By.linkText(linkText)), 5000);
      await link.click();
      console.log(`Kliknięto: ${linkText}`);
      await driver.sleep(2000);
    };
    //wybierz co ma kliknąć i gdzie wrócić
    await clickLink('Single');
    await clickLink('Home');
    // wypisz w terminalu stan testu
    await driver.quit();
    console.log('Przeglądarka zamknięta, test zakończony.');

    //Gdy błąd, wypisz błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
