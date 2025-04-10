import fs from 'fs';
import path from 'path';

export function logTestResult(testName, passed) {
  const logLine = `${testName}_Passed : ${passed}\n`;
  const logPath = path.resolve('selenium-tests/logs/logs.txt');
  fs.appendFileSync(logPath, logLine, 'utf8');
}
