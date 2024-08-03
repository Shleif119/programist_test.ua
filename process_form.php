<?php 
session_start();
echo $_SESSION['user_id'];
// print_r($_POST);
	include "databases.php";


	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    // Отримуємо дані з форми
	    $title = $_POST['title'];
	    $class_id = $_POST['class']; // Припускаючи, що значення поля 'class' є ID класу
	    $code = $_POST['code'];

	    
	    // Підготовка SQL-запиту для вставки даних
	    $sql = "INSERT INTO taskclass (task_title, class_id, code) VALUES (?, ?, ?)";

	    // Підготовка і виконання підготовленого SQL-запиту для запобігання SQL-ін'єкціям
	    $stmt = $conn->prepare($sql);
	    $stmt->bind_param("ssi", $title, $class_id, $code); // 's' - рядок, 'i' - ціле число
	    $stmt->execute();

	    // Перевірка успішності вставки
	            if ($stmt->affected_rows > 0) {
	                echo "Дані успішно додані до таблиці.";
	            } else {
	                echo "Помилка при вставці даних: " . $conn->error;
	            }

	            // Закриваємо підготований запит і з'єднання з базою даних
	            $stmt->close();


	}
?>