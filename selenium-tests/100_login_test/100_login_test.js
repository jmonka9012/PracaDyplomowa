import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';
import dotenv from 'dotenv';
import fs from 'fs';

dotenv.config();
const raw = (process.env.APP_URL || '').replace(/"/g, '').trim();
const BASE_URL = raw.replace(/^https:\/\//i, 'http://');

// Ścieżka do istniejącego pliku logs.txt
const logPath = '\\\\wsl.localhost\\Ubuntu\\home\\pgalimski\\inzynierka\\PracaDyplomowa\\selenium-tests\\Automated-Tests\\logs\\logs.txt';

// Funkcja zapisująca wynik testu w istniejącym pliku logs.txt
function logTestResult(testName, passed) {
  const logEntry = `${testName}_Passed : ${passed}\n`;
  try {
    fs.appendFileSync(logPath, logEntry, 'utf8');
    console.log(`Wynik testu zapisany w logs.txt: ${logEntry.trim()}`);
  } catch (error) {
    console.error(`Błąd podczas zapisywania do logs.txt: ${error.message}`);
  }
}

(async function rapidLoginAttemptTest() {
  let driver;
  let testPassed = false;

  try {
    const options = new chrome.Options();
    options.addArguments('--disable-dev-shm-usage');       // Optymalizacja zużycia pamięci
    options.addArguments('--no-sandbox');                   // Wyłączenie sandboxa
    options.addArguments('--remote-debugging-port=9222');   // Port debugowania (opcjonalny)

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

    // Ustawiamy rozmiar okna (niezbędne dla niektórych elementów strony)

    await driver.manage().window().setRect({ width: 1400, height: 1000 });

    console.log('=== Rozpoczęcie testu: 100 błędnych prób logowania ===');
    console.log(`Przejście na stronę logowania: ${BASE_URL}/login`);
    await driver.get(`${BASE_URL}/login`);
    await driver.sleep(500);

    // Pętla – 100 razy próbujemy zalogować się na fałszywego użytkownika


    let successCount = 0;
    let errorCount = 0;
    const attempts = 100;

    for (let i = 0; i < attempts; i++) {
      try {
        console.log(`Próba nr ${i + 1}: logowanie z błędnymi danymi`);

      // Znajdujemy pola do wpisania loginu, hasła i przycisk "Zaloguj"


        const usernameInput = await driver.wait(until.elementLocated(By.css('input[name="login"]')), 3000);
        const passwordInput = await driver.wait(until.elementLocated(By.css('input[name="password"]')), 3000);
        const submitButton = await driver.wait(until.elementLocated(By.css('input[type="submit"]')), 3000);

      // Upewniamy się, że przycisk jest widoczny na ekranie


        await driver.executeScript("arguments[0].scrollIntoView(true);", submitButton);
        await driver.sleep(300);

        // Czyścimy pola i wpisujemy fałszywe dane logowania

        await usernameInput.clear();
        await passwordInput.clear();
        await usernameInput.sendKeys(`fakeuser${i}@example.com`);
        await passwordInput.sendKeys('wrongpassword');

        // Czekamy aż przycisk będzie aktywny, a potem klikamy

        await driver.wait(until.elementIsVisible(submitButton), 3000);
        await driver.wait(until.elementIsEnabled(submitButton), 3000);
        await submitButton.click();

        // Oczekujemy na pojawienie się komunikatu błędu

        const errorElement = await driver.wait(
          until.elementLocated(By.css('.error-msg')),
          5000
        );
        const errorText = await errorElement.getText();

        // Sprawdzamy, czy komunikat jest zgodny z oczekiwaniami


        if (errorText.includes('Podany użytkownik nie istnieje')) {
          console.log(`Komunikat błędu poprawnie wykryty: "${errorText}"`);
          successCount++;
        } else {
          console.log(`Komunikat błędu niezgodny: "${errorText}"`);
          errorCount++;
        }

        await driver.get(`${BASE_URL}/login`);
        await driver.sleep(100);
      } catch (err) {
        console.log(`Błąd podczas próby nr ${i + 1}: ${err.message}`);
        errorCount++;
        await driver.get(`${BASE_URL}/login`);
        await driver.sleep(100);
      }
    }

    // Podsumowanie testu

    console.log('=== Podsumowanie testu ===');
    console.log(`Liczba prób: ${attempts}`);
    console.log(`Poprawnie obsłużone błędne logowania: ${successCount}`);
    console.log(`Nieudane próby (brak komunikatu lub błąd): ${errorCount}`);

    // Uznajemy test za zaliczony, jeśli co najmniej 90% prób zakończyło się poprawnym komunikatem błędu


    if (successCount >= 0.9 * attempts) {
      testPassed = true;
      console.log('Test zaliczony – ponad 90% prób zakończonych poprawnym komunikatem błędu.');
    } else {
      console.log('Test niezaliczony – zbyt mało poprawnych komunikatów błędu.');
    }
    // Zamykanie przeglądarki
    await driver.quit();
  } catch (error) {
    console.error('Błąd podczas wykonywania testu:', error.message);
    if (driver) await driver.quit();
  } finally {
    logTestResult('100_login_test', testPassed);
  }
})();
