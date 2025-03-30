import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function moooltoTest() {
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

    // Rozszerzenie okna, dla lepszego widoku
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Uruchamiam stronę...');
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(1500);

    console.log('Szukam tytułu do podmiany...');

    // Podmiana tekstu + ustawienie koloru na biały
    await driver.executeScript(`
      const headings = document.querySelectorAll('h1, h2, h3');

      headings.forEach(el => {
        if (el.innerText.toUpperCase().includes("ORGANIZZARE")) {
          el.innerText = "MOOOLTOOO BEEENEEE";
          el.style.color = "#ffffff"; // ustawiamy biały kolor
        }
      });
    `);

    console.log('Zmieniono na MOOOLTOOO BEEENEEE i ustawiono biały kolor!');

    // Poczekaj chwilę, żeby było widać efekt
    await driver.sleep(5000);
    await driver.quit();
    //Gdy błąd, wyśletl błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
