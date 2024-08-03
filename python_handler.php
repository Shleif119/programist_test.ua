<?php
include "databases.php";

// Проверяем, был ли отправлен POST-запрос с кодом пользователя
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_code"])) {
    // Получаем код пользователя из POST-запроса
    $userCode = $_POST["user_code"];

    // Получаем входные данные
    $inputData = $_POST["input_data"];
    // Получаем ожидаемые выходные данные
    $outputData = $_POST["output_data"];

    $progaText = $_POST["progatext"];

    $taskname = $_POST["taskname"];

    // Отримуємо ідентифікатор заголовка та логін користувача
    $titleId = $_POST["title_id"];
    $userLogin = $_POST["user_login"];

    // Шаблон Python-програми з імпортами та налаштуваннями кодування
    $pythonTemplate = <<<PYTHON
    import sys
    import io

    # Встановлення потрібного кодування
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

    # Основний код програми
    %s
    PYTHON;

    // Вставляємо основний код програми Python до шаблону
    $pythonCode = sprintf($pythonTemplate, $userCode);

    // Зберігаємо код у файл
    $pythonCodeFile = fopen("user_code".$userLogin.".py", "w");
    fwrite($pythonCodeFile, $pythonCode);
    fclose($pythonCodeFile);


    // $inputDataFile = fopen("input_data.txt", "w");
    // fwrite($inputDataFile, $inputData);
    // fclose($inputDataFile);

    // Розділяємо рядок на окремі числа за допомогою функції explode()
    $numbers = explode(" ", $inputData);

    // Відкриваємо файл для запису
    $inputDataFile = fopen("input_data".$userLogin.".txt", "w");

    // Записуємо кожне число у файл, розділене переносом рядка
    foreach ($numbers as $number) {
        fwrite($inputDataFile, $number . "\n");
    }

    // Закриваємо файл
    fclose($inputDataFile);

    // Вызываем скрипт Python для выполнения кода
    $output = shell_exec("python user_code".$userLogin.".py < input_data".$userLogin.".txt");

    // // Записуємо результат програми в файл
    //     $outputFile = fopen("output_result".$userLogin.".txt", "w");
    //     fwrite($outputFile, $output);
    //     fclose($outputFile);

    // // Записуємо результат програми в файл
    //     $outputFile2 = fopen("ref_result".$userLogin.".txt", "w");
    //     fwrite($outputFile2, $outputData);
    //     fclose($outputFile2);

    $cleanedOutput = preg_replace('/\s+/', '', $output);
    $cleanedOutputData = preg_replace('/\s+/', '', $outputData);





    // echo $output;
    // echo $outputData;


    // Сравниваем выходные данные программы с ожидаемыми выходными данными
    if ($cleanedOutput === $cleanedOutputData) {

        // Якщо виконано вірно, записуємо результат у таблицю result
        $stmt = $conn->prepare("INSERT INTO result (login, task, id_proga, count) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("ssi", $userLogin, $taskname, $titleId);
        $stmt->execute();
        $stmt->close();

        // Если данные совпадают, возвращаем "true"
        echo "true";
    } else {
        // Если данные не совпадают, возвращаем "false"
        // //Робота з ШІ gpt
        include "gpt4free.php";
        
    }
    
    // Видаляємо файли після використання
        unlink("user_code{$userLogin}.py");
        unlink("input_data{$userLogin}.txt");
        // unlink("output.txt");
}
?>
