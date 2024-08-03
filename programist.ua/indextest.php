<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання коду від користувача
    $userCode = $_POST["user_code"];

    // Генерація введених даних (можна модифікувати відповідно до потреб)
    $inputData = "5\n10\n3";

    // Зберігання коду та введених даних в файлах
    $pythonCodeFile = fopen("user_code.py", "w");
    fwrite($pythonCodeFile, $userCode);
    fclose($pythonCodeFile);

    $inputDataFile = fopen("input_data.txt", "w");
    fwrite($inputDataFile, $inputData);
    fclose($inputDataFile);

    // Виклик Python скрипта для виконання коду
    $output = shell_exec("python user_code.py < input_data.txt");

    // Виведення результатів
    echo "<h2>Результати виконання коду:</h2>";
    echo "<pre>$output</pre>";
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="user_code">Вставте ваш код Python:</label><br>
    <textarea name="user_code" rows="10" cols="50"></textarea><br>
    
    <input type="submit" value="Перевірити код">
</form>
