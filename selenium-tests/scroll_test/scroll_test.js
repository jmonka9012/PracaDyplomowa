import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function scrollTest() {
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

    console.log('Przeglądarka uruchomiona.');

    // Przejście do strony i wypisanie w terminalu
    await driver.get('http://lvi.ddev.site/');
    console.log('Strona załadowana.');

    // Oczekiwanie na załadowanie elementu <body> i wypisanie w terminalu
    try {
      await driver.wait(until.elementLocated(By.css('body')), 10000);
      console.log('Element <body> znaleziony.');
    } catch {
      console.log('Element <body> nie został znaleziony.');
    }

    // Scroll w dół i prędkość scrolla
    await driver.executeScript(`window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });`);
    console.log('Scroll do dołu.');
    await driver.sleep(3000);

    // Scroll w górę i prędkość scrolla 
    await driver.executeScript(`window.scrollTo({ top: 0, behavior: 'smooth' });`);
    console.log('Scroll do góry.');
    await driver.sleep(2000);

    // Zamknięcie przeglądarki
    await driver.quit();
    console.log('Przeglądarka zamknięta, test zakończony.');
    
    // Gdy błąd, wypisz błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
