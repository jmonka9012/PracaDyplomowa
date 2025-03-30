import { Builder } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function changeBackgroundImage() {
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

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    // Przejście do strony głównej
    console.log('Otwieram stronę...');
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(1000);

    // Ścieżka do obrazu tła
    const imageUrl = 'http://lvi.ddev.site/build/assets/Klepsydrabasicplakat_converted.jpg';

    // Podmiana tła strony
    console.log('Zmiana tła strony...');
    await driver.executeScript(`
      document.body.style.backgroundImage = 'url("${imageUrl}")';
      document.body.style.backgroundSize = 'cover';
      document.body.style.backgroundRepeat = 'no-repeat';
      document.body.style.backgroundPosition = 'center';
    `);
    
    // Potwierdzenie, że kod się wykonał
    await driver.sleep(500);
    console.log('Tło zmienione! Czekam kilka sekund...');

    // Oczekiwanie kilku sekund, aby zobaczyć efekt
    await driver.sleep(5000);

    // Koniec testu, zamyka przeglądarkę
    console.log('Zamykam przeglądarkę...');
    await driver.quit();

    // Gdy błąd, wypisz błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
