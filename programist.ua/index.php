<?php 
include "header.php";
include "phpscript.php";


// session_destroy();




 ?>
<body>
	<?php 
		include "top_header.php";
	 ?>
	<div class="container">
		<div class="row">
			
				

				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="exampleModalLabel">Реєстрація</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
				        
				        				<form id="registrationForm" class="">
				        				    <label for="validationDefault01" class="form-label">Имя</label>
				        				    <input type="text" class="form-control mb-2" id="validationDefault01" value="" name="name">
				        				    <label for="validationDefault01" class="form-label">Прізвище</label>
				        				    <input type="text" class="form-control mb-2" id="validationDefault01" value="" name="sename">
				        				    <label for="validationDefault01" class="form-label">Логін</label>
				        				    <input type="text" class="form-control mb-2" id="validationDefault01" value="" name="login">
				        				    <div class="mb-3">
				        				                    <label for="access" class="form-label">Рівень доступу</label>
				        				                    <select name="access" id="access" class="form-select mb-2" onchange="showHideFields()">
				        				                        <option value="user">Учень</option>
				        				                        <option value="admin">Вчитель</option>
				        				                    </select>
				        				                </div>

				        				                <div id="studentFields" style="display: none;">
				        				                    <div class="mb-3">
				        				                        <label for="class" class="form-label">Клас</label>
				        				                        <select name="class" id="class" class="form-select mb-2">
				        				                            <?php 
				        				                                $class_result = mysqli_query($conn,"SELECT * FROM `class`");
				        				                                while($class_name = mysqli_fetch_assoc($class_result))
				        				                                {
				        				                                    echo '<option value="'.$class_name['class_id'].'">'.$class_name['class_title'].'</option>';
				        				                                }
				        				                            ?>
				        				                        </select>
				        				                    </div>
				        				                    <div class="mb-3">
				        				                        <label for="code" class="form-label">Код вчителя</label>
				        				                        <input type="text" id="code" name="code" id="validationDefault01" class="form-control">
				        				                    </div>
				        				                </div>

				        				                <script>
				        				                        function showHideFields() {
				        				                            var accessLevel = document.getElementById('access').value;
				        				                            var studentFields = document.getElementById('studentFields');

				        				                            if (accessLevel === 'user') {
				        				                                studentFields.style.display = 'block';
				        				                            } else {
				        				                                studentFields.style.display = 'none';
				        				                            }
				        				                        }

				        				                        // Виклик функції під час завантаження сторінки
				        				                        document.addEventListener('DOMContentLoaded', function() {
				        				                            showHideFields();
				        				                        });
				        				                    </script>

				        				    <label for="validationDefault01" class="form-label mt-2">Пароль</label>
				        				    <input type="text" class="form-control" id="validationDefault01" value="" name="pass">
				        				    
				        				
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button class="btn btn-primary" type="button" onclick="ValueAndSubmit()" data-bs-dismiss="modal">Реєстрація</button>
				        </form>
				      </div>
				    </div>
				  </div>
				</div>
				
				
			
			<div class="col-md-3">
				<div id="message-container" class=""></div>
				<h2>Вхід на сайт</h2>
				<form method="POST" action="logincheck.php">
				  <div class="mb-3">
				    <label for="exampleInputEmail1" class="form-label">Введить логін</label>
				    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="login">
				    
				  </div>
				  <div class="mb-3">
				    <label for="exampleInputPassword1" class="form-label">Пароль</label>
				    <input type="password" class="form-control" id="exampleInputPassword1" name="pass">
				  </div>
				  
				  <button type="submit" class="btn btn-primary">Войти на сайт</button>
				  <!-- Button trigger modal -->
				<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
				  Реєстрація
				</button>
				</form>
			</div>
			<div class="col-md-9">
				
			</div>

		</div>
	</div>
<script>
	function ValueAndSubmit() {
	        var formData = new FormData(document.getElementById("registrationForm"));
	        var xhr = new XMLHttpRequest();
	        xhr.open("POST", "phpscript.php", true);

	        xhr.onload = function () {
	            if (xhr.status == 200) {
	                document.getElementById("message-container").innerHTML = xhr.responseText;
	                document.getElementById("message-container").className = "alert alert-warning";
	                
	                // Очистка полів форми після успішної відправки
	                document.getElementById("registrationForm").reset();
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