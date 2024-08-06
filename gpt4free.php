<?php 

$condition = "Відповідь давай тільки українською мовою. Є завдання написати програму з такою умовою:";

$code_program = "Ось код програми, вірно написана програма ? відповідає вона завданню ? ВАЖЛИВО!!! Не пиши код вірної програми.не використовуй кітайську мову у відповідях";

$userCode = $_POST["user_code"];

// Объединяем строки
$combinedText = $condition . "\n" . $progaText . "\n" . $userCode . "\n" . $code_program;


// Имя временного файла
$inputFileName = "input_gpt" . $userLogin . ".txt";

// Убедитесь, что текст закодирован в UTF-8
$encodedText = mb_convert_encoding($combinedText, 'UTF-8', 'auto');

// Запись данных в файл
file_put_contents($inputFileName, $encodedText);

// Имя Python-скрипта
$pythonScript = 'gpt4free.py';

// Запуск Python-скрипта и передача данных через файл
$output_gpt = shell_exec("python $pythonScript < $inputFileName");



echo $output_gpt;
unlink("input_gpt{$userLogin}.txt");
?>
