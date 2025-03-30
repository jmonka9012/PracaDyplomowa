import { Builder } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function countCharactersTest() {
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

    // Rozmiar okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });
    // Wejście na stronę
    console.log('Uruchamiam stronę...');
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(1000);

    // Liczenie znaków bez spacji
    const charCount = await driver.executeScript(`
      const text = document.body.innerText;
      return text.replace(/\\s/g, '').length;
    `);
      // Wyświetla ilość znaków - wynik testu
    console.log(`Liczba znaków: ${charCount}`);
      // Czas wyświetlania strony
    await driver.sleep(3000);
    await driver.quit();
      // Wypisz błąd, gdy błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
