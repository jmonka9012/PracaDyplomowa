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

    // Przejście do strony
    await driver.get('http://lvi.ddev.site/');
    console.log('Strona załadowana.');

    // Oczekiwanie na <body>
    try {
      await driver.wait(until.elementLocated(By.css('body')), 10000);
      console.log('Element <body> znaleziony.');
    } catch {
      console.log('Element <body> nie został znaleziony.');
    }

    // Funkcja do stopniowego scrollowania
    const smoothScroll = async (direction) => {
      await driver.executeAsyncScript(function (dir, callback) {
        let currentPosition = dir === 'down' ? 0 : document.body.scrollHeight;
        const distance = 100;
        const delay = 200;

        const scrollInterval = setInterval(() => {
          currentPosition += dir === 'down' ? distance : -distance;
          window.scrollTo(0, currentPosition);

          if ((dir === 'down' && currentPosition >= document.body.scrollHeight) ||
              (dir === 'up' && currentPosition <= 0)) {
            clearInterval(scrollInterval);
            callback();
          }
        }, delay);
      }, direction);
    };

    // Scroll w dół
    await smoothScroll('down');
    console.log('Scroll do dołu zakończony.');
    await driver.sleep(2000);

    // Scroll w górę
    await smoothScroll('up');
    console.log('Scroll do góry zakończony.');
    await driver.sleep(2000);

    // Zamknięcie przeglądarki
    await driver.quit();
    console.log('Przeglądarka zamknięta, test zakończony.');
    
    //Gdy błąd, wybierz błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
