import http from 'k6/http';
import { check, sleep } from 'k6';
import { textSummary } from 'https://jslib.k6.io/k6-summary/0.0.1/index.js';

// Pobranie zmiennej APP_URL z pliku .env lub ustawienie domyślnej wartości
const BASE_URL = (() => {
  try {
    // Odczyt pliku .env znajdującego się dwa poziomy wyżej
    const envText = open('../../.env');

    // Wyszukanie linii zawierającej zmienną APP_URL
    const match = envText
      .split('\n')
      .find((line) => line.trim().startsWith('APP_URL='));

    // Zwrot wartości zmiennej bez cudzysłowów, jeżeli została znaleziona
    return match ? match.split('=')[1].replace(/(^"|"$)/g, '').trim() : 'http://localhost:3000';
  } catch (error) {
    // W przypadku błędu odczytu, ustawienie wartości domyślnej
    return 'http://localhost:3000';
  }
})();

// Konfiguracja testu wydajnościowego
export const options = {
  vus: 1000,       // Liczba jednoczesnych wirtualnych użytkowników (Virtual Users)
  duration: '30s', // Czas trwania testu
};

// Główna funkcja wykonywana przez każdego wirtualnego użytkownika
export default function () {
  // Wysłanie zapytania HTTP GET do strony głównej aplikacji
  const res = http.get(BASE_URL);

  // Sprawdzenie poprawności odpowiedzi
  const testPassed = check(res, {
    'status is 200': (r) => r.status === 200,                     // Oczekiwany kod odpowiedzi to 200
    'response is not empty': (r) => r.body && r.body.length > 0, // Treść odpowiedzi nie jest pusta
  });

  // Symulacja czasu oczekiwania użytkownika przed kolejnym działaniem
  sleep(1);

  // Zwrot wyniku testu
  return testPassed;
}

// Funkcja zapisująca podsumowanie wyników testu do plików
export function handleSummary(data) {
  // Sprawdzenie, czy żadna z odpowiedzi nie zakończyła się błędem
  const testResult = data.metrics.http_req_failed.value === 0;

  // Obiekt zawierający uproszczoną informację o wyniku testu
  const resultLog = { logout_test_Passed: testResult };

  return {
    // Zapis uproszczonego wyniku testu (true/false)
    '../logs/logs.txt': JSON.stringify(resultLog, null, 2),

    // Zapis szczegółowego raportu testowego
    '../logs/details.txt': textSummary(data, {
      indent: ' ',
      enableColors: false,
    }),
  };
}
