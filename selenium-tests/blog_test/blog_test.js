import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function blogNavigationTest() {
  let driver;
  try {
    // Konfiguracja opcji dla przeglądarki, większy ekran itp.
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');
    options.addArguments('--window-size=1280,1024');

    // Inicjalizacja WebDrivera
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Przejście do strony głównej
    await driver.get('http://lvi.ddev.site/');
    
    // Oczekiwanie na załadowanie strony
    await driver.sleep(3500);

    // Znalezienie i kliknięcie w bloga
    const blogLink = await driver.wait(until.elementLocated(By.linkText('Blog')), 5000);
    await blogLink.click();

    // Oczekiwanie na załadowanie nowej strony
    await driver.sleep(2000);

    // Pobranie aktualnego adresu strony i wyświetlenie go w terminalu
    const currentUrl = await driver.getCurrentUrl();
    console.log('Aktualny adres strony:', currentUrl);

    // Zamknięcie przeglądarki z opóźnieniem itp. 
    await driver.sleep(2000);
    await driver.quit();
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
