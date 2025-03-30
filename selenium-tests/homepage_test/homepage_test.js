import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function runLocalAppTest() {
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

<<<<<<< HEAD
    console.log('Przeglądarka uruchomiona. Wczytywanie aplikacji...');
    await driver.get('https://lvi.ddev.site');
=======
    console.log('Przeglądarka uruchomiona.');

    // Przejście do strony home, sprawdzenie czy w ogóle strona działa 
    await driver.get('http://lvi.ddev.site/');
>>>>>>> 1d7b77b (testy)
    console.log('Strona załadowana.');

    // Pobranie tytułu strony do terminalu
    const title = await driver.getTitle();
    console.log('Tytuł strony:', title);

    // Sprawdzenie, czy element <body> został załadowany
    await driver.wait(until.elementLocated(By.css('body')), 10000);
    console.log('Element <body> znaleziony.');

    // Oczekiwanie przed zamknięciem przeglądarki, by test trwał dłużej
    await driver.sleep(5000);
    await driver.quit();
    console.log('Przeglądarka zamknięta.');
    
    
  //gdy strona nie zadziała, wypisz błąd
  
  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
