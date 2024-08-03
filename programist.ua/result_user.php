<?php 

    $userLogin = $_SESSION['username'];

    // Запит до бази даних для отримання інформації про таски та їх кількість балів для конкретного користувача
    $sql1 = "SELECT task, SUM(count) AS total_score FROM result WHERE login = ? GROUP BY task";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $userLogin);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    
 ?>

 <h2>Таблиця результатів для користувача <?php echo $userLogin; ?></h2>
<div class="result">
    <table>
        <thead>
            <tr>
                <th>Назва роботи</th>
                <th>Виконано завдань</th>
                <th>Оцінка</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Виведення результатів запиту у вигляді таблиці
            if ($result1->num_rows > 0) {
                while ($row = $result1->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["task"] . "</td>";
                    echo "<td>" . $row["total_score"] . "</td>";
                    foreach ($counts as $count){
                        if($count['task_title'] == $row["task"]){
                            echo "<td>" . round(4 + (8 /$count['count_task']) * $row["total_score"]) . "</td>";
                        }
                    }
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Немає результатів для відображення</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>