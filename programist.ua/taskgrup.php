<?php 
include "header.php";
include "phpscript.php";
?>

<body>
    <script src="js/myscript.js"></script>
    <?php 
        include "top_header.php";
        $check = 1;
        if (isset($_GET['check'])){
            $check = $_GET['check'];
        }

     ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="myForm" >
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Назва практичної роботи</label>
                            <input type="text" class="form-control mb-2" id="taskname" name="taskname">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary mb-2" onclick="ValueAndSubmit();">Встановити значення та відправити на сервер</button>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-light mb-2" href="taskgrup.php?check=1">Мої програми</a>
                            <a class="btn btn-light mb-2" href="taskgrup.php?check=2">Всі програми</a>
                        </div>
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
                            if ($check == 1)
                            {
                                foreach ($programs as $program) {
                                    if($category['category_name'] == $program['category'] && $program['code'] == $code)
                                    {
                                        include "check.php";
                                    }

                                }
                            }
                            else
                            {
                                foreach ($programs as $program) {
                                    if($category['category_name'] == $program['category'])
                                    {
                                        include "check.php";
                                    }

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