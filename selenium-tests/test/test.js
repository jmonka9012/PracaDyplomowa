import { assert } from 'chai';
import { Builder, By, Browser, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import chromedriver from 'chromedriver';

describe('Test Głównej', () => {
    let driver;

    before(async () => {
        const options = new chrome.Options()
            .addArguments('--headless=new', '--no-sandbox')
            .setChromeBinaryPath('/usr/bin/google-chrome');

        driver = await new Builder()
            .forBrowser(Browser.CHROME)
            .setChromeOptions(options)
            .build();
    });

    after(async () => {
        await driver.quit();
    });

    it('Powinien załadować stronę główną', async () => {
        await driver.get('http://lvi.ddev.site/');
        const title = await driver.getTitle();
        assert.equal(title, 'Organizzare Eventare', 'Tytuł strony powinien być "Organizarre Eventare"');
    });
});
