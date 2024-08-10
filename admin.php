<?php 
include "header.php";
include "phpscript.php";
?>
<body>
<?php 
    include "top_header.php";
?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Додавання програми</h1>
                <form id="myForm" method="POST" action="your_php_handler.php">
                    <div class="mb-3">
                        <label class="form-label">Назва програми</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Вибір категорії</label>
                        <select class="form-select" aria-label="Default select example" name="category">
                            <?php 
                            foreach ($categorys as $category) {
                                ?>
                                <option value="<?php echo $category['category_name']; ?>"><?php echo $category['category_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Текст завдання</label>
                        <textarea id="text_task" class="form-control" rows="10" name="task"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Шаблон коду програми</label>
                        <textarea class="form-control" rows="10" name="text_proga" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Вхідні данні</label>
                                <textarea class="form-control" name="input" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Фейкові вхідні данні</label>
                                <textarea class="form-control" name="f_input" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Вихідні данні</label>
                                <textarea class="form-control" name="output" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Фейкові вихідні данні</label>
                                <textarea class="form-control" name="f_output" required></textarea>
                            </div>
                        </div>
                    </div>
                    
                   
                    
                    

                    <!-- Скрита передача коду вчителя для завдання -->
                    <input type="hidden" class="form-control" name="code" value="<?php echo $code; ?>" required>

                    <button type="button" id="submitButton" class="btn btn-primary" onclick="submitForm()">Submit</button>
                </form>
                <!-- Вивід результатів тут -->
                <div id="result"></div>
            </div>
            <div class="col-md-4">
                Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Perspiciatis eveniet magni temporibus, natus. Incidunt delectus quaerat aliquam hic autem omnis, facere consequatur quisquam quasi aut a odit, cumque, doloribus accusantium.
            </div>
        </div>
    </div>

<?php 
include "footer.php";
?>

<!-- Підключення CKEditor 5 з CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<script>
    // Ініціалізація CKEditor 5
    let editor;
    ClassicEditor
        .create(document.querySelector('#text_task'))
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });

    // Обробник події відправки форми
    function submitForm() {
        // Оновлення значення прихованого поля перед відправкою форми
        document.querySelector('textarea[name="task"]').value = editor.getData();

        // Отримуємо дані з форми
        var formData = new FormData(document.getElementById('myForm'));

        // Створюємо об'єкт XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Налаштовуємо відправку POST-запиту на php-скрипт
        xhr.open('POST', 'phpscript.php', true);

        // Вимикаємо кнопку під час обробки запиту
        document.getElementById('submitButton').disabled = true;

        // Обробник подій для відповіді від сервера
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                // Вимикаємо кнопку під час обробки запиту
                document.getElementById('submitButton').disabled = false;

                // Вивід результатів на сторінці
                document.getElementById('result').innerHTML = "Дані додані до бази даних";
                // Опціонально: очистити форму або виконати інші дії
                document.getElementById('myForm').reset();
                editor.setData(''); // Очистити редактор
            }
        };

        // Відправляємо дані форми на сервер
        xhr.send(formData);
    }
</script>
</body>
</html>
