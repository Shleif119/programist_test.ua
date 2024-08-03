<?php 

$condition = "Відповідь давай тільки українською мовою. Є завдання написати програму з такою умовою:";

$code_program = "Ось код програми, вірно написана програма ? відповідає вона завданню ? ВАЖЛИВО!!! Не пиши код вірної програми";

$userCode = $_POST["user_code"];

// Объединяем строки
$combinedText = $condition . "\n" . $progaText . "\n" . $userCode . "\n" . $code_program;

// Записываем в текстовый файл
$inputFile = 'input.txt';
file_put_contents($inputFile, $combinedText);

// Запуск Python-скрипта
$pythonScript = 'gpt4free.py';
$output_gpt = shell_exec("python $pythonScript 2>&1");

// // Запись результата выполнения Python-скрипта в файл
// $outputFile = 'output.txt';
// file_put_contents($outputFile, $output_gpt);

// // Вывод результата
// echo "Текст успешно записан в файл $inputFile<br>";
// echo "Результат выполнения Python-скрипта записан в файл $outputFile<br>";

echo $output_gpt;

?>
