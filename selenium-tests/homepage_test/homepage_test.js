import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function runLocalAppTest() {
  let driver;
  try {
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--no-sandbox');
    options.addArguments('--remote-debugging-port=9222');

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    console.log('Przeglądarka uruchomiona. Wczytywanie aplikacji...');
    await driver.get('https://lvi.ddev.site');
    console.log('Strona załadowana.');

    const title = await driver.getTitle();
    console.log('Tytuł strony:', title);

    const body = await driver.wait(until.elementLocated(By.css('body')), 10000);
    console.log('Element <body> znaleziony:', !!body);

    // ⏳ Zamknij przeglądarkę po 5 sekundach
    setTimeout(async () => {
      console.log('Zamykam przeglądarkę po 5 sekundach...');
      await driver.quit();
    }, 5000);

  } catch (error) {
    console.error('Błąd:', error);
    if (driver) await driver.quit();
  }
})();
