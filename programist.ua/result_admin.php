<?php 
include "header.php";
include "phpscript.php";

// Запит до бази даних для отримання списку класів
$sql_classes = "SELECT * FROM class";
$result_classes = $conn->query($sql_classes);

// Отримання списку класів
$classes = array();
while ($row_classes = $result_classes->fetch_assoc()) {
    $classes[] = $row_classes;
}

$selected_class_id = "5a";
$sql_users = "SELECT * FROM users WHERE class = '$selected_class_id' AND code = '$code'";
$result_users = $conn->query($sql_users);

// Обробка вибору класу
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["class_id"])) {
    $selected_class_id = $_POST["class_id"];

    // Запит до бази даних для отримання інформації про користувачів обраного класу
    $sql_users = "SELECT * FROM users WHERE class = '$selected_class_id' AND code = '$code'";
    $result_users = $conn->query($sql_users);
}

// Запит до бази даних для отримання списку тасків для обраного класу
$sql_tasks = "SELECT DISTINCT task_title FROM taskclass WHERE class_id = '$selected_class_id' AND code = '$code'";
$result_tasks = $conn->query($sql_tasks);

// Отримання списку тасків
$tasks = array();
while ($row_tasks = $result_tasks->fetch_assoc()) {
    $tasks[] = $row_tasks;
}

?>
<body>
	<?php 
		include "top_header.php";
	 ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="result-list">
					<h2>Виберіть клас:</h2>
					<form method="post">
						<div class="row">
							<div class="col-md-2">
								<select name="class_id" class="form-select mb-2">
									<?php foreach ($classes as $class) { ?>
										<option value="<?php echo $class['class_id']; ?>"><?php echo $class['class_title']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4">
								<input type="submit" class="btn btn-primary mb-2" value="Показати результати">
							</div>
							<div class="col-md-6">
								
							</div>
						</div>
						
						
					</form>
				</div>
				<div class="admin-res">
					<?php 
					// Виведення таблиці з оцінками для користувачів обраного класу
					if ($result_users->num_rows > 0) {
					    echo "<h2>Таблиця результатів для класу ".$selected_class_id."</h2>";
					    echo "<table>";
					    echo "<thead><tr><th>Name</th><th>Sename</th>";
					    foreach ($tasks as $task) {
					        echo "<th>".$task['task_title']."</th>";
					    }
					    echo "</tr></thead><tbody>";
					    while ($row_users = $result_users->fetch_assoc()) {
					        echo "<tr>";
					        echo "<td>".$row_users['name']."</td>";
					        echo "<td>".$row_users['sename']."</td>";
					        foreach ($tasks as $task) {
					            $sql_score = "SELECT SUM(count) AS total_score FROM result WHERE login = '".$row_users['login']."' AND task = '".$task['task_title']."'";
					            $result_score = $conn->query($sql_score);
					            $row_score = $result_score->fetch_assoc();
					            foreach ($counts as $count){
					                if($count['task_title'] == $task['task_title']){
					                	if ($row_score['total_score'] > 0){
					                		echo "<td>" . round(4 + (8 /$count['count_task']) * $row_score['total_score']) . "</td>";
					                	}
					                    else {
					                    	echo "<td></td>";
					                    }
					                }
					                
					            }
					            
					        }
					        echo "</tr>";
					    }
					    echo "</tbody></table>";
					} else {
					    echo "No users found for the selected class.";
					}
					 ?>
				</div>
			</div>
		</div>
	</div>

<?php include "footer.php"; ?>
