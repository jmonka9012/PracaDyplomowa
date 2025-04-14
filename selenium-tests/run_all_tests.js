import { execSync } from 'child_process';
import fs from 'fs';
import path from 'path';

const TESTS_FOLDER = './selenium-tests';
const LOG_FILE = './selenium-tests/logs/logs.txt';

// Pobranie listy podfolderów testów, z pominięciem folderu 'logs'
const testFolders = fs.readdirSync(TESTS_FOLDER, { withFileTypes: true })
  .filter(entry => entry.isDirectory() && entry.name !== 'logs')
  .map(entry => entry.name);

console.log('\n=== ROZPOCZĘCIE URUCHAMIANIA WSZYSTKICH TESTÓW SELENIUM ===\n');

// Wyczyszczenie pliku logów przed rozpoczęciem uruchamiania testów
fs.writeFileSync(LOG_FILE, '');

// Iteracja po każdym folderze z testem i uruchamianie skryptu testowego za pomocą npm
for (const testName of testFolders) {
  console.log(`Uruchamianie testu: ${testName}`);

  try {
    // Wywołanie testu przy użyciu polecenia npm run test z przekazanym parametrem pliku testowego
    execSync(`npm run test --file=${testName}`, { stdio: 'inherit' });
  } catch (error) {
    console.log(`[BŁĄD] Wystąpił problem podczas uruchamiania testu: ${testName}`);
  }
}

// Odczytanie zawartości pliku logów w celu określenia statusów testów
const logsContent = fs.readFileSync(LOG_FILE, 'utf-8').split('\n');

// Analiza ostatnich wpisów logu w celu określenia poprawności wykonania każdego testu
const testResults = {};
for (const testName of testFolders) {
  const successLine = logsContent.reverse().find(line =>
    line.includes(`${testName}_Passed`)
  );
  logsContent.reverse();

  if (successLine) {
    const passed = successLine.includes(': true');
    testResults[testName] = passed;
  } else {
    testResults[testName] = false;
  }
}

// Wyświetlenie podsumowania wykonanych testów
console.log('\n=== PODSUMOWANIE WYNIKÓW TESTÓW ===');
let successCount = 0;

for (const [test, passed] of Object.entries(testResults)) {
  const status = passed ? 'SUKCES' : 'BŁĄD';
  if (passed) successCount++;
  console.log(`[${status}] ${test}`);
}

console.log(`\n=== PODSUMOWANIE KOŃCOWE: ${successCount}/${testFolders.length} TESTÓW ZAKOŃCZONYCH SUKCESEM ===`);
