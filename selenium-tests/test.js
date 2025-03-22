import { Builder, By, Browser, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import chromedriver from 'chromedriver';
import assert from 'assert';

// path do chromedrivera
console.log('ChromeDriver path:', chromedriver.path);

(async function googleTest() {
  let driver;

  try {
    // konfig chroma
    let options = new chrome.Options();

    // Webdriver używa chromedrivera
    driver = await new Builder()
      .forBrowser(Browser.CHROME)
      .setChromeOptions(options)
      .build();

    // idzie na strone google
    await driver.get('https://www.google.com');

    // czeka aż nazwa strony zmieni się na google
    await driver.wait(until.titleIs('Google'), 10000);
    let title = await driver.getTitle();
    assert.equal(title, 'Google');

    console.log('Test passed! Google page loaded successfully.');
  } catch (e) {
    console.error('Test failed:', e);
  } finally {
    if (driver) {
      await driver.quit();
    }
  }
})();