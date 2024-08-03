<?php 
include "databases.php";

if(isset($_POST['id'])){
	// Отримання айді запису, який потрібно видалити
	$idToDelete = $_POST['id'];

	// SQL-запит на видалення запису з таблиці
	$sql = "DELETE FROM programs WHERE id = $idToDelete";

	if ($conn->query($sql) === TRUE) {
	    echo "Запис успішно видалено";
	} else {
	    echo "Помилка видалення запису: " . $conn->error;
	}
}

if(isset($_POST['task'])){
    // Отримання айді запису, який потрібно видалити
    $taskToDelete = $_POST['task'];

    // Підготовлений запит для видалення запису з таблиці tasks
    $stmt1 = $conn->prepare("DELETE FROM `tasks` WHERE `taskname` = ?");
    $stmt1->bind_param("s", $taskToDelete);

    // Виконання запиту і перевірка на успішність
    if ($stmt1->execute()) {
        echo "Запис успішно видалено";
    } else {
        echo "Помилка видалення запису: " . $conn->error;
    }

    $stmt1->close();

    // Підготовлений запит для видалення запису з таблиці taskclass
    $stmt2 = $conn->prepare("DELETE FROM `taskclass` WHERE `task_title` = ?");
    $stmt2->bind_param("s", $taskToDelete);

    // Виконання запиту і перевірка на успішність
    if ($stmt2->execute()) {
        echo "Запис успішно видалено";
    } else {
        echo "Помилка видалення запису: " . $conn->error;
    }

    $stmt2->close();

    // Підготовлений запит для видалення запису з таблиці tasklist
    $stmt3 = $conn->prepare("DELETE FROM `tasklist` WHERE `task_title` = ?");
    $stmt3->bind_param("s", $taskToDelete);

    // Виконання запиту і перевірка на успішність
    if ($stmt3->execute()) {
        echo "Запис успішно видалено";
    } else {
        echo "Помилка видалення запису: " . $conn->error;
    }

    $stmt3->close();
}


 ?>