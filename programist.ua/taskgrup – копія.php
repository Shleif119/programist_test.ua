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
                        <div class="col-4">
                            <input type="checkbox" id="codeCheck" name="codeCheck">
                            <label for="codeCheck">Тільки мої завдання</label>



                            <script>
                                    document.getElementById('codeCheck').addEventListener('change', function() {
                                        const isChecked = this.checked;
                                        const xhr = new XMLHttpRequest();
                                        xhr.open('GET', `server.php?codeCheck=${isChecked}`, true);
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === 4 && xhr.status === 200) {
                                                document.getElementById('programContainer').innerHTML = xhr.responseText;
                                            }
                                        };
                                        xhr.send();
                                    });

                                    // Инициализировать загрузку данных при загрузке страницы
                                    window.onload = function() {
                                        const isChecked = document.getElementById('codeCheck').checked;
                                        const xhr = new XMLHttpRequest();
                                        xhr.open('GET', `server.php?codeCheck=${isChecked}`, true);
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === 4 && xhr.status === 200) {
                                                document.getElementById('programContainer').innerHTML = xhr.responseText;
                                            }
                                        };
                                        xhr.send();
                                    }
                                </script>

                        </div>
                    </div>
                   
                    
            </div>
        </div>
        <div class="row">
            <!-- Блок зі сторінки server.php де відбуваєтся перевірка на код програм для вивода -->
            <div id="programContainer"></div>
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