import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function rapidLoginClickTest() {
  let driver;
  try {
    // Konfiguracja przeglądarki
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    // Start przeglądarki
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Rozszerzenie okna
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Wchodzę na stronę...');
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(100);

    let sukcesy = 0;
    let błędy = 0;

    console.log('Rozpoczynam klikanie "Login"...');

    for (let i = 0; i < 100; i++) {
      try {
        // Szukam przycisku Login i klikam 100 razy
        const loginBtn = await driver.wait(until.elementLocated(By.linkText('Login')), 100);
        await loginBtn.click();

        // Czekam aż pojawi się formularz logowania (max 0.2 s)
        await driver.wait(until.elementLocated(By.css('form input[type="text"]')), 200);
        sukcesy++;
      } catch {
        błędy++;
      }

      // Cofnij z powrotem na stronę główną (jeśli się udało zalogować)
      await driver.get('http://lvi.ddev.site/');
    }
    // Ogólne założenia i wypis w terminalu wyniku
    console.log(`Kliknięć ogólnie: 100`);
    console.log(`Udane przejścia do logowania: ${sukcesy}`);
    console.log(`Nieudane/błędne kliknięcia: ${błędy}`);
    // Wyświetl błąd, gdy błąd
    await driver.quit();
  } catch (error) {
    console.error('Błąd ogólny:', error);
    if (driver) await driver.quit();
  }
})();
