<?php 
include "header.php";
include "phpscript.php";




// Отримання значення параметра task з URL
$taskname = $_GET['task'] ?? '';
if (isset($_GET['class_nam'])) {
  $activ_class = $_GET['class_nam'];
}
else {
  $activ_class = "7v";
}


// Запит до бази даних, щоб отримати checkbox_data для заданого taskname
$sql_tasks = "SELECT checkbox_data FROM tasks WHERE taskname = ?";
$stmt_tasks = $conn->prepare($sql_tasks);
$stmt_tasks->bind_param("s", $taskname);
$stmt_tasks->execute();
$result_tasks = $stmt_tasks->get_result();

// Масив для зберігання checkbox_data
$checkbox_data_array = array();
while ($row_tasks = $result_tasks->fetch_assoc()) {
    $checkbox_data_array[] = $row_tasks['checkbox_data'];
}

// Запит до бази даних, щоб отримати title, де id відповідає значенням з $checkbox_data_array
$titles = array();
foreach ($checkbox_data_array as $checkbox_data) {
    $sql_programs = "SELECT * FROM programs WHERE id = ?";
    $stmt_programs = $conn->prepare($sql_programs);
    $stmt_programs->bind_param("s", $checkbox_data);
    $stmt_programs->execute();
    $result_programs = $stmt_programs->get_result();
    
    while ($row_programs = $result_programs->fetch_assoc()) {
        $titles[] = $row_programs;
    }
}

$res_class = mysqli_query($conn,"SELECT * FROM `class`");

?>
<body>

  <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="errorModalLabel">Помилка</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body-content">
          Програма написана не вірно, переконайтесь що вихідні данні співпадають з зразком.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
        </div>
      </div>
    </div>
  </div>

    <?php 
        include "top_header.php";
     ?>

<div class="container">

    <div class="nav-clas">
      <ul>
        <?php 
        while($class_id = mysqli_fetch_assoc($res_class))
        {
        ?>
          <li><a class="btn btn-light" href="admin_task_list.php?class_nam=<?php echo $class_id['class_id']; ?>">Завдання<?php echo " ".$class_id['class_title']." "; ?>клас</a></li>
          <?php
        }
         ?>
        
      </ul>
    </div>

                <div class="accordion-body">
                  <div class="container1">

                      <div class="row">
                          <div class="col-md-3">
                            <!-- Вивід коду вчителя для класу -->

                            <div class="card mb-3">
                              <div class="card-body">
                                  <h5 class="card-title">Код для учня</h5>
                                  <p class="card-text code"><?php echo $code; ?></p>
                                </div>
                              </div>

                              <h2>Список завдань <?php echo $activ_class;?>:</h2>

                              <div class="task-list-user">
                                  <ol class="list-group list-group-numbered">
                                  <?php 
                                  $class_id['class_id'] = $activ_class;
                                  // Отримуємо список завдань, які відповідають класу користувача
                                  $sql = "SELECT task_title FROM taskclass WHERE class_id = ? AND code = '$code'";
                                  $stmt = $conn->prepare($sql);
                                  $stmt->bind_param("s", $class_id['class_id']);
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  while ($row = $result->fetch_assoc()) {
                                      $url = "admin_task_list.php?class_nam=".$activ_class."&task=" . urlencode($row['task_title']);
                                      ?><li class="list-group-item"><?php echo "<a href=\"$url\">" . htmlspecialchars($row['task_title']) . "</a></li>";
                                  }
                                  ?>
                                  </ol>
                              </div>
                          </div>
                          <div class="col-md-9">

                              <?php 
                                  // include "result_user.php";
                               ?>


                              <h2> <?php echo $taskname; ?> </h2>

                              <div class="accordion" id="accordionExample">
                              <?php 

                              // Виведення списку знайдених titles
                              $count = 0;
                              foreach ($titles as $title) {
                                  $count = $count +1;
                                  ?>


                                    <div class="accordion-item">
                                      <h2 class="accordion-header">
                                        <button class="accordion-button
                                        <?php 
                                        if ($count != 1){
                                          echo " collapsed ";
                                        }
                                        ?> " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>" aria-expanded="true" aria-controls="collapseOne" onclick="autoResize(document.getElementById('myTextarea<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>'))">
                                         <Strong>Задача <?php echo $title['id']; ?>.</Strong> <?php echo "__".$title['title']; ?>
                                        </button>
                                      </h2>
                                      <div id="collapseOne<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>" class="accordion-collapse collapse

                                        <?php 
                                        if ($count == 1){
                                            echo " show ";
                                           
                                        }
                                        ?>
                                       " data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                          <h5>Текст завдання</h5>
                                          <p><?php echo $title['progatext']; ?></p>
                                          <h5>Додайте код для перевірки</h5>

                                          <form id="python_form<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>" method="post">
                                          <textarea class="form-control" id="user_code<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>" name="user_code" rows="10"></textarea><br>
                                          
                                          <h5>Данні для перевірки</h5>
                                          <table class="table table-info">
                                              <tr>
                                                   <td>Вхідні данні</td>
                                                   <td>Вихідні данні</td>
                                                   <td><strong>Перевірка</strong></td>
                                                 </tr>
                                                 <tr>
                                                   <td class="table-light">
                                                      <textarea class="text-in-out" id="myTextarea1<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>"><?php echo $title['f_in']; ?>
                                                      </textarea></td>
                                                   <td class="table-light">
                                                      <textarea class="text-in-out" id="myTextarea<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>"  ><?php echo $title['f_out']; ?>
                                                      </textarea>
                                                      <script>
                                                      // Викликаємо функцію autoResize при завантаженні сторінки
                                                      document.addEventListener('DOMContentLoaded', function() {
                                                          autoResize(document.getElementById('myTextarea1<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>'));
                                                      });

                                                      function autoResize(textarea) {
                                                          textarea.style.height = 'auto'; // Спочатку встановлюємо висоту на автоматичну
                                                          textarea.style.height = (textarea.scrollHeight + 0) + 'px'; // Змінюємо висоту textarea на висоту його вмісту плюс додатковий відступ
                                                          // console.log(textarea.scrollHeight);
                                                      }
                                                      document.addEventListener('DOMContentLoaded', function() {
                                                          autoResize(document.getElementById('myTextarea<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>'));
                                                      });

                                                      function autoResize(textarea) {
                                                          textarea.style.height = 'auto'; // Спочатку встановлюємо висоту на автоматичну
                                                          textarea.style.height = (textarea.scrollHeight + 0) + 'px'; // Змінюємо висоту textarea на висоту його вмісту плюс додатковий відступ
                                                          // console.log(textarea.scrollHeight);
                                                      }
                                                      </script>
                                                  </td>
                                                   
                                                   
                                                   <?php 

                                                   // Отримуємо результат для поточного title
                                                   $sql_result = "SELECT * FROM result WHERE login = ? AND id_proga = ?";
                                                   $stmt_result = $conn->prepare($sql_result);
                                                   $stmt_result->bind_param("si", $_SESSION['username'], $title['id']);
                                                   $stmt_result->execute();
                                                   $result_result = $stmt_result->get_result();

                                                   // Перевіряємо, чи є результат
                                                   if ($result_result->num_rows > 0) {
                                                       // Є результат, тому встановлюємо клас відповідно
                                                       echo '<td id="result'.$title['id'].$class_id['class_id'].'" class="table-success">Завдання виконано</td>';
                                                   } else {
                                                       // Немає результату, клас залишається "table-danger"
                                                       echo '<td id="result'.$title['id'].$class_id['class_id'].'" class="table-danger">Завдання не виконано</td>';
                                                   }


                                                    ?>

                                                 </tr>
                                          </table>
                                          <div class="text-error" id="text-error<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>"></div>
                                          <?php 
                                              if ($result_result->num_rows < 1) {
                                                  ?>
                                                  <button class="b-show btn btn-primary" id="but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>" type="button" onclick="sendPythonCode<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>();" style="display: block;">Відправити програму</button>

                                                  <button class="btn btn-primary" type="button" disabled id="load-but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>" style="display: none;">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    Завантаження...
                                                  </button>

                                                  <?php
                                              }
                                           ?>
                                          <script>
                                          function sendPythonCode<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>() {
                                              var pythonCode = document.getElementById("user_code<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>").value; // Получаем код Python из текстового поля
                                              var inputData = <?php echo json_encode($title['input']); ?>;
                                              var outputData = <?php echo json_encode($title['output']); ?>;
                                              var progaText = <?php echo json_encode($title['progatext']); ?>;

                                              document.getElementById('but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>').style.display = 'none';
                                              document.getElementById('load-but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>').style.display = 'block';

                                              var taskname = "<?php echo $taskname; ?>";

                                              var titleId = <?php echo $title['id']; ?>; // Отримуємо ID заголовка
                                              var userLogin = "<?php echo $_SESSION['username']; ?>"; // Отримуємо логін користувача з сесії

                                              var xhr = new XMLHttpRequest(); // Создаем объект XMLHttpRequest

                                              xhr.open("POST", "python_handler.php", true); // Настраиваем запрос
                                              xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                                              xhr.onreadystatechange = function() { // Обработка ответа от сервера
                                                  if (xhr.readyState == 4 && xhr.status == 200) {
                                                      var output = xhr.responseText.trim(); // Получаем результат выполнения кода Python и удаляем лишние пробелы

                                                      console.log("User2 Login:", pythonCode);
                                                      console.log("sdf - ",output);

                                                      // Получаем элемент <td>, в котором нужно изменить класс
                                                      var tableData = document.getElementById("result<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>");
                                                      var buttonData = document.getElementById("but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>");

                                                      var textData = document.getElementById("text-error<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>");

                                                      
                                                      // Если результат выполнения кода Python - "true"
                                                      if (output === "true") {
                                                          // Изменяем класс на "table-success"
                                                          tableData.className = "table-success";
                                                          buttonData.className = "b-hidden";
                                                          // Изменяем текст ячейки на "Завдання виконано"
                                                          tableData.innerText = "Завдання виконано";
                                                          document.getElementById('load-but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>').style.display = 'none';
                                                      } else {
                                                          // Если результат выполнения кода Python - "false", то оставляем класс "table-danger"
                                                          // и текст ячейки "Завдання не виконано"
                                                          tableData.className = "table-danger";
                                                          tableData.innerText = "Завдання не виконано";
                                                          
                                                          // Обновляем содержимое модального окна
                                                          document.getElementById('modal-body-content').textContent = output;

                                                          document.getElementById('but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>').style.display = 'block';
                                                          document.getElementById('load-but<?php echo $title['id']; ?><?php echo $class_id['class_id']; ?>').style.display = 'none';

                                                          var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                                                                         errorModal.show();

                                                          // textData.className = "text-error";
                                                          // textData.innerText = "Не вірна відповідь.";
                                                      }
                                                  }
                                              };

                                          //     // Відправляємо код Python, вхідні та очікувані вихідні дані на сервер
                                              xhr.send("user_code=" + encodeURIComponent(pythonCode) + "&input_data=" + encodeURIComponent(inputData) + "&output_data=" + encodeURIComponent(outputData) + "&title_id=" + titleId + "&user_login=" + encodeURIComponent(userLogin) + "&taskname=" + encodeURIComponent(taskname) + "&progatext=" + encodeURIComponent(progaText));
                                          }

                                          </script>

                                          </form>
                                          
                                        </div>
                                      </div>
                                    </div>


                                  <?php
                              }
                              

                              // Закриття з'єднання з базою даних

                               ?>
                               </div>
                          </div>


                  <?php 
                  foreach ($titles as $title) {
                  ?>


                      <?php
                  }
                  ?>
                </div>
              </div>








    </div>
</div>

<?php
include "footer.php";
?>
