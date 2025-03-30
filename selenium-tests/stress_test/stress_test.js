import { Builder, By } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function stressLoginTest() {
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

    // Ustawienie rozmiaru okna przeglądarki
    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('Otwieram stronę...');
    await driver.get('http://lvi.ddev.site/');
    await driver.sleep(1000);

    // Szukanie i lokalizacja przycisku "Login"
    console.log('Szukanie przycisku "Login"...');
    const loginBtn = await driver.findElement(By.linkText('Login'));

    let success = 0; // Licznik udanych kliknięć
    let failed = 0; // Licznik nieudanych prób
    const startTime = Date.now(); // Start pomiaru czasu
    const duration = 3000; // Czas trwania testu (3 sekundy)

    // Powtarzanie kliknięcia w "Login" przez 3 sekundy
    console.log('Rozpoczynam szybkie klikanie...');
    while (Date.now() - startTime < duration) {
      try {
        await loginBtn.click();
        success++;
      } catch (e) {
        failed++;
      }
    }

    console.log('Klikanie zakończone.');
    console.log(`Udane kliknięcia: ${success}`);
    console.log(`Nieudane próby: ${failed}`);

    // Krótkie oczekiwanie przed zakończeniem testu
    await driver.sleep(2000);

    // Zamknięcie przeglądarki
    console.log('Zamykam przeglądarkę...');
    await driver.quit();
    //Wpisz błąd, gdy błąd
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
