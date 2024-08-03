<?php

include "databases.php";
// Перевірка, чи надіслано дані POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $email = $_POST['login']; // Поле для введення електронної пошти
    $password = $_POST['pass']; // Поле для введення паролю

    // Підготовка запиту для перевірки логіна та паролю в базі даних
    $sql = "SELECT * FROM users WHERE login = ? AND pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password); // 's' - рядок
    $stmt->execute();
    $result = $stmt->get_result();
    

    // Перевірка, чи знайдено користувача з введеним логіном та паролем
    if ($result->num_rows > 0) {
        // Якщо користувача знайдено, створюємо сесію з ім'ям користувача
        session_start();
        $_SESSION['username'] = $email;
        $_SESSION['role'] = "user";
        

        // // Перенаправляємо користувача на іншу сторінку (наприклад, до особистого кабінету)
        header("Location: user_task_list.php");
        exit;
    } else {
        // Підготовка запиту для перевірки логіна та паролю в базі даних
        $sql = "SELECT * FROM admins WHERE login = ? AND pass = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password); // 's' - рядок
        $stmt->execute();
        $result = $stmt->get_result();

        // $row = $result->fetch_assoc();
        // // Отримуємо значення поля 'access'
        // $access = $row['access'];

        if ($result->num_rows > 0) {
            // Якщо користувача знайдено, створюємо сесію з ім'ям користувача
            session_start();
            $_SESSION['username'] = $email;
            $_SESSION['role'] = "admin";
            // // Перенаправляємо користувача на іншу сторінку (наприклад, до особистого кабінету)
            header("Location: user_task_list.php");
            exit;
        }
        else
        {
            // Якщо логін та/або пароль неправильні, виводимо повідомлення про помилку
            echo "Неправильний логін або пароль.";
        }

    }

    // Закриваємо підготований запит і з'єднання з базою даних
    $stmt->close();
    $conn->close();
}
?>
