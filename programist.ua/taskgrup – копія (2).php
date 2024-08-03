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
                <form id="myForm" >
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control" id="taskname" name="taskname">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary" onclick="ValueAndSubmit();">Встановити значення та відправити на сервер</button>
                        </div>
                        <div class="col-4"></div>
                    </div>
                   
                    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php 
                    foreach ($categorys as $category) {
                        ?>
                        <h2><?php echo $category['category_name']; ?></h2>
                        <div class="accordion" id="accordionFlushExample">
                            <?php
                            foreach ($programs as $program) {
                                if($category['category_name'] == $program['category'])
                                {
                                    ?>
                                    <div class="accordion-item">
                                        <h4 class="accordion-header">
                                            <div class="row1">
                                                <div class="col1">
                                                    <button id="myButton<?php echo $program['id']; ?>" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#<?php echo "id",$program['id']; ?>" aria-expanded="false"
                                                            aria-controls="flush-collapseOne"
                                                            onclick="autoResize(document.getElementById('myTextarea<?php echo $program['id']; ?>'))">
                                                        <?php echo $program['id']." "; ?><?php echo $program['title']; ?>
                                                    </button>
                                                </div>
                                                <div class="col2">
                                                    <button class="btn btn-outline-danger" onclick="deleteData<?php echo $program['id']; ?>()">X</button>

                                                    <script>
                                                    function deleteData<?php echo $program['id']; ?>() {
                                                        // Отримання айді запису
                                                        var idToDelete = <?php echo $program['id']; ?>;

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
                                                        xhr.send("id=" + idToDelete);
                                                    }
                                                    </script>
                                                </div>
                                                <div class="col3">
                                                    <input type="checkbox" id="myCheckbox_<?php echo $program['title']; ?>" name="myCheckbox_<?php echo $program['id']; ?>" value="<?php echo $program['id']; ?>">
                                                </div>
                                            </div>
                                        </h4>

                                        <div id="<?php echo "id",$program['id']; ?>" class="accordion-collapse collapse"
                                             data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <?php echo $program['progatext']; ?><br><br>

                                                <div class="col-11">
                                                    <table class="table table-info">
                                                        <tr>
                                                             <td>Вхідні данні</td>
                                                             <td>Вихідні данні</td>
                                                           </tr>
                                                           <tr>
                                                             <td class="table-light">
                                                                <textarea class="text-in-out" id="myTextarea1<?php echo $program['id']; ?>"><?php echo $program['f_in']; ?>
                                                                </textarea></td>
                                                             <td class="table-light">
                                                                <textarea class="text-in-out" id="myTextarea<?php echo $program['id']; ?>"  ><?php echo $program['f_out']; ?>
                                                                </textarea>
                                                                <script>
                                                                // Викликаємо функцію autoResize при завантаженні сторінки
                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                    autoResize(document.getElementById('myTextarea1<?php echo $program['id']; ?>'));
                                                                });

                                                                function autoResize(textarea) {
                                                                    textarea.style.height = 'auto'; // Спочатку встановлюємо висоту на автоматичну
                                                                    textarea.style.height = (textarea.scrollHeight + 0) + 'px'; // Змінюємо висоту textarea на висоту його вмісту плюс додатковий відступ
                                                                    // console.log(textarea.scrollHeight);
                                                                }
                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                    autoResize(document.getElementById('myTextarea<?php echo $program['id']; ?>'));
                                                                });

                                                                function autoResize(textarea) {
                                                                    textarea.style.height = 'auto'; // Спочатку встановлюємо висоту на автоматичну
                                                                    textarea.style.height = (textarea.scrollHeight + 0) + 'px'; // Змінюємо висоту textarea на висоту його вмісту плюс додатковий відступ
                                                                    // console.log(textarea.scrollHeight);
                                                                }
                                                                </script>
                                                            </td>
                                                         </tr>
                                                     </table>
                                                </div>


                                                <?php 
                                                // Значення $program['id']
                                                $id = $program['id'];
                                                    $sql1 = "SELECT taskname, checkbox_data FROM tasks WHERE checkbox_data = $id";
                                                    $result1 = $conn->query($sql1);

                                                    if ($result1->num_rows > 0) {
                                                        
                                                        // Виводимо дані для кожного рядка результату запиту
                                                        while($row1 = $result1->fetch_assoc()) {
                                                            
                                                            $resultFromPHP = "true";

                                                            ?>
                                                            <div class="alert alert-info task-on" role="alert">
                                                              <?php echo $row1["taskname"]; ?>
                                                            </div>
                                                            <script>
                                                                // Отримуємо результат вашого запиту PHP і зберігаємо його у змінній
                                                                var resultFromPHP = "<?php echo $resultFromPHP; ?>";

                                                                // Якщо умова виконується, змінюємо колір тексту кнопки на зелений
                                                                if (resultFromPHP == "true") {
                                                                    document.getElementById("myButton<?php echo $program['id']; ?>").style.color = "red";
                                                                }
                                                            </script>
                                                            <?php
                                                        }

                                                    }
                                                    
                                                 ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }

                            }
                            ?>
                        </div>
                        <?php
                    }
                 ?>

                <button onclick="ValueAndSubmit();">Встановити значення та відправити на сервер</button>
            </div>
            </form>
            <div class="container" id="message-container">
                <!-- Решта вашого коду ... -->
            </div>
        </div>
    </div>
	<script>

        
		function ValueAndSubmit() {
                var formData = new FormData(document.getElementById("myForm"));

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "phpscript.php", true);

                xhr.onload = function () {
                    if (xhr.status == 200) {
                        document.getElementById("message-container").innerHTML = xhr.responseText;
                    } else {
                        document.getElementById("message-container").innerHTML = "Помилка під час відправлення форми.";
                    }
                };

                xhr.send(formData);
            }

	</script>

<?php 
include "footer.php";
 ?>