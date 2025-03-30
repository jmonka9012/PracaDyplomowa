import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function klepsydraTest() {
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

    // Ustawienie dużego okna, żeby wszystko było widoczne
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Uruchamiam stronę...');
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(1500);
    //Komunikat w terminalu
    console.log('Zamieniam teksty w menu na klepsydry...');

    // Zmiana tekstów w górnym pasku na emotki klepsydry
    await driver.executeScript(`
      const navLinks = document.querySelectorAll('nav a, header a, .navbar a');

      navLinks.forEach(link => {
        const txt = link.innerText.trim();

        if (txt === "Home") link.innerText = "⏳";
        if (txt === "Blog") link.innerText = "⏳⏳";
        if (txt === "Single") link.innerText = "⏳⏳⏳";
        if (txt === "Kontakt") link.innerText = "⏳⏳⏳⏳";
        if (txt === "CE") link.innerText = "⏳⏳⏳⏳⏳";
        if (txt === "Jacek CE") link.innerText = "⏳⏳⏳⏳⏳⏳";
        if (txt === "Toggle") link.innerText = "⏳⏳⏳⏳⏳⏳⏳";
        if (txt === "Login") link.innerText = "⏳⏳⏳⏳⏳⏳⏳⏳";
        if (txt === "Register") link.innerText = "⏳⏳⏳⏳⏳⏳⏳⏳⏳";
      });
    `);

    console.log('Klepsydry wstawione!');

    // Poczekaj chwilę, żeby zobaczyć efekt
    await driver.sleep(5000);

    // Zamknięcie przeglądarki
    await driver.quit();
    //Gdy błąd, wyświetl błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
