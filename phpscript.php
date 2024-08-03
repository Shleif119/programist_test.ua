<?php 

	include "databases.php";
	session_start();
	if( isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	}


	// Отримуємо сод адміна для класу по його логіну
	$stmt = $conn->prepare("SELECT code FROM admins WHERE login = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->bind_result($code);
	$stmt->fetch();
	$stmt->close();

	// Отримуємо сод адміна для класу по його логіну
	$stmt = $conn->prepare("SELECT code FROM users WHERE login = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->bind_result($code);
	$stmt->fetch();
	$stmt->close();

	$category_result = mysqli_query($conn,"SELECT * FROM `category`");
	while($category_name = mysqli_fetch_assoc($category_result))
	{
		$categorys[] = $category_name;
	}

	$program_result = mysqli_query($conn,"SELECT * FROM `programs`");
	while($program_name = mysqli_fetch_assoc($program_result))
	{
		$programs[] = $program_name;
	}

	$task_result = mysqli_query($conn,"SELECT * FROM `tasklist`");
	while($task_name = mysqli_fetch_assoc($task_result))
	{
		$tasks[] = $task_name;
	}

	$count_result = mysqli_query($conn,"SELECT * FROM `tasklist`");
	while($count = mysqli_fetch_assoc($count_result))
	{
	    $counts[] = $count;
	}

	$stmt = null;
	if (isset($_POST['title']) and isset($_POST['category']) and isset($_POST['task']) and isset($_POST['text_proga']) and isset($_POST['input']) and isset($_POST['output']) and isset($_POST['f_input']) and isset($_POST['f_output']) and isset($_POST['code']))
	{
	    $title = $_POST['title'];
	    $category = $_POST['category'];
	    $task = $_POST['task'];
	    $text_proga = $_POST['text_proga'];
	    $input = $_POST['input'];
	    $output = $_POST['output'];
	    $f_input = $_POST['f_input'];
	    $f_output = $_POST['f_output'];
	    $code = $_POST['code'];

	    $stmt = $conn->prepare("INSERT INTO `programs` (`id`, `category`, `title`, `progatext`, `progatest`, `progatemplate`, `input`, `output`, `f_in`, `f_out`, `code`) VALUES (NULL, ?, ?, ?, '', ?, ?, ?, ?, ?, ?)");
	    $stmt->bind_param("ssssssssi", $category, $title, $task, $text_proga, $input, $output, $f_input, $f_output, $code);
	    
	    if ($stmt->execute() !== TRUE) {
	        echo "Помилка: " . $stmt->error;
	    }
	}


	if (isset($_POST["taskname"])) {
	    // Отримання даних з форми
	    $taskname = $_POST["taskname"];

	    // Встановлення кодування
	    $conn->set_charset("utf8mb4");

	    $tsk = mysqli_query($conn,"INSERT INTO `tasklist` (`id`, `task_title`, `code`) VALUES (NULL, '$taskname', '$code')") ;

	    // Лічильник кількості записів
	    $countTasks = 0;

	    // Вставка даних в таблицю
	    foreach ($_POST as $key => $value) {
            if (preg_match('/^myCheckbox_(\d+)$/', $key, $matches) && !empty($value)) {
                // Отримання номера пункту (в даному випадку, id)
                $pointNumber = $matches[1];
                echo $pointNumber;
                // Вставка даних в таблицю для кожного вибраного пункту
                $stmt = $conn->prepare("INSERT INTO tasks (taskname, checkbox_data) VALUES (?, ?)");
                $stmt->bind_param("ss", $taskname, $pointNumber);
                
                if ($stmt->execute() !== TRUE) {
                    echo "Помилка: " . $stmt->error;
                }
                else {
                    // Збільшуємо лічильник кількості записів
                    $countTasks++;
                }
            }
        }

        // Оновлення значення лічильника кількості записів в таблиці tasklist
        $updateStmt = $conn->prepare("UPDATE tasklist SET count_task = ? WHERE task_title = ?");
        $updateStmt->bind_param("is", $countTasks, $taskname);
        $updateStmt->execute();
        $updateStmt->close();

	    
	    if (!isset($stmt)) {
	        echo "Не вибрано жодного пункту.";
	    } else {
	        echo "Дані успішно додані до таблиці.";
	    }
	    
	    // Закриваємо з'єднання з базою даних
	    $stmt->close();
	    $conn->close();
	}


if(isset($_POST['access']) && $_POST['access'] == "user")
{
	if (
	    isset($_POST['name']) &&
	    isset($_POST['sename']) &&
	    isset($_POST['login']) &&
	    isset($_POST['class']) &&
	    isset($_POST['pass']) &&
	    isset($_POST['code']) &&
	    !empty($_POST['code']) &&
	    !empty($_POST['name']) &&
	    !empty($_POST['sename']) &&
	    !empty($_POST['login']) &&
	    !empty($_POST['class']) &&
	    !empty($_POST['pass'])
	) {
	    // Підключення до бази даних
	    include "databases.php";

	    // Отримання значень з форми
	    $name = mysqli_real_escape_string($conn, $_POST['name']);
	    $sename = mysqli_real_escape_string($conn, $_POST['sename']);
	    $login = mysqli_real_escape_string($conn, $_POST['login']);
	    $class = mysqli_real_escape_string($conn, $_POST['class']);
	    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
	    $code = $_POST['code'];


	    // Перевірка, чи існує користувач з таким логіном вже
	      $check_query = "SELECT * FROM users WHERE login='$login'";
	      $check_result = mysqli_query($conn, $check_query);

	      // Якщо знайдено користувача з таким логіном, вивести повідомлення і припинити виконання скрипту
	      if (mysqli_num_rows($check_result) > 0) {
	          echo "Користувач з таким логіном вже існує.";
	          exit; // Завершуємо виконання скрипту
	      }

	      // Якщо користувач з таким логіном не знайдений, виконати додавання нового користувача
	      $query = "INSERT INTO users (name, sename, login, class, pass, code, access) VALUES ('$name', '$sename', '$login', '$class', '$pass', '$code', 'user')";

	      if (mysqli_query($conn, $query)) {
	          echo "Дані успішно додані до бази даних!";
	      } else {
	          echo "Помилка при вставці даних: " . mysqli_error($conn);
	      }
	  }
}
else
{
	if (
	    isset($_POST['name']) &&
	    isset($_POST['sename']) &&
	    isset($_POST['login']) &&
	    isset($_POST['pass']) &&
	    !empty($_POST['name']) &&
	    !empty($_POST['sename']) &&
	    !empty($_POST['login']) &&
	    !empty($_POST['pass'])
	) {
	    // Підключення до бази даних
	    include "databases.php";

	    // Отримання значень з форми
	    $name = mysqli_real_escape_string($conn, $_POST['name']);
	    $sename = mysqli_real_escape_string($conn, $_POST['sename']);
	    $login = mysqli_real_escape_string($conn, $_POST['login']);
	    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
	    $code = mt_rand(1000, 9999); 

	    // Перевірка, чи існує користувач з таким логіном вже
	      $check_query = "SELECT * FROM admins WHERE login='$login'";
	      $check_result = mysqli_query($conn, $check_query);

	      // Якщо знайдено користувача з таким логіном, вивести повідомлення і припинити виконання скрипту
	      if (mysqli_num_rows($check_result) > 0) {
	          echo "Користувач з таким логіном вже існує.";
	          exit; // Завершуємо виконання скрипту
	      }

	      // Якщо користувач з таким логіном не знайдений, виконати додавання нового користувача
	      $query = "INSERT INTO admins (name, sename, login, pass, code, access) VALUES ('$name', '$sename', '$login', '$pass', '$code', 'admin')";

	      if (mysqli_query($conn, $query)) {
	          echo "Дані успішно додані до бази даних!";
	      } else {
	          echo "Помилка при вставці даних: " . mysqli_error($conn);
	      }
	  }
}


    
 ?>