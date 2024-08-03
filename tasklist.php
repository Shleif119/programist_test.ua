<?php 
include "header.php";
include "phpscript.php";
?>

<body>
    <script src="js/myscript.js"></script>
    <?php 
        include "top_header.php";
     ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="list">
                    <?php 
                        foreach ($tasks as $task) {
                            if ($task['code'] == $code)
                            {
                            ?>
                        <form id="myForm<?php echo $task['id']; ?>" method="POST">
                            <div class="card card-tasklist">
                                <div class="row">
                                    
                                    
                                    <div class="col-md-5">
                                        <?php echo $task['task_title']; 
                                        ?> <br><?php 
                                        
                                        // Виконайте запит до бази даних для вибірки всіх записів, де task_title збігається зі значенням $task['task_title']
                                        $sql = "SELECT class_id, task_title FROM taskclass WHERE task_title = '" . $task['task_title'] . "'";
                                        $result = $conn->query($sql);

                                        // Перевірте, чи є результати запиту
                                        if ($result->num_rows > 0) {
                                            // Виведіть дані для кожного рядка результату запиту
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <div class="alert alert-info task-on" role="alert">
                                                  <?php echo $row["class_id"]; ?>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo "0 results"; // Повідомлення про відсутність результатів
                                        }
                                         ?>
                                        <input style="display: none;" type="text" value="<?php echo $task['task_title']; ?>" name="title">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-5">
                                                <select name="class" id="" class="form-select mb-2">
                                                                        
                                                <?php 
                                                    $class_result = mysqli_query($conn,"SELECT * FROM `class`");
                                                    while($class_name = mysqli_fetch_assoc($class_result))
                                                    {
                                                        ?>
                                                            <option value="<?php echo $class_name['class_id']; ?>"><?php echo $class_name['class_title']; ?></option>
                                                        <?php
                                                    }
                                                 ?>
                                                </select>
                                            </div>
                                            <input type="hidden" value="<?php echo $code; ?>" name="code">
                                            <div class="col-5">
                                                <button class="btn btn-primary" onclick="Value<?php echo $task['id']; ?>();">Додати клас</button> <?php  ?>
                                            </div>
                                            <div class="col-2">
                                                <button class="btn btn-outline-danger" onclick="deleteData<?php echo $task['id']; ?>()">X</button>

                                                <script>
                                                function deleteData<?php echo $task['id']; ?>() {
                                                    // Отримання айді запису
                                                    var taskToDelete = "<?php echo $task['task_title']; ?>";

                                                    // Створення нового об'єкту XMLHttpRequest
                                                    var xhr = new XMLHttpRequest();

                                                    // Налаштування запиту
                                                    xhr.open("POST", "delete_data.php", true);
                                                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                                                    // Обробка відповіді від сервера
                                                    xhr.onreadystatechange = function() {
                                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                                            alert(xhr.responseText); // Виведення повідомлення про успішне видалення
                                                        }
                                                    };

                                                    // Відправка запиту на сервер
                                                    xhr.send("task=" + taskToDelete);
                                                }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                            <?php
                            }
                        }
                     ?>
                </div>
                <div class="container" id="message-container">
                    <!-- Решта вашого коду ... -->
                </div>
            </div>
        </div>
    </div>

        <?php 
        foreach ($tasks as $task) {
            ?>
            <script>
                function Value<?php echo $task['id']; ?>() {
                        var formData = new FormData(document.getElementById("myForm<?php echo $task['id']; ?>"));

                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "process_form.php", true);

                        xhr.onload = function () {
                            if (xhr.status == 200) {
                                document.getElementById("message-container").innerHTML = xhr.responseText;
                                document.getElementById("message-container").innerHTML = "Всьо окай.";
                            } else {
                                document.getElementById("message-container").innerHTML = "Помилка під час відправлення форми.";
                            }
                        };

                        xhr.send(formData);
                    }

            </script>
            <?php
        }
         ?>
        
  

<?php 
include "footer.php";
 ?>