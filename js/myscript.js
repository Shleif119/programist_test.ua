// function submitForm() {
//     // Отримуємо дані з форми
//     var formData = new FormData(document.getElementById('myForm'));

//     // Створюємо об'єкт XMLHttpRequest
//     var xhr = new XMLHttpRequest();

//     // Налаштовуємо відправку POST-запиту на php-скрипт
//     xhr.open('POST', 'phpscript.php', true);

//     // Вимикаємо кнопку під час обробки запиту
//     document.getElementById('submitButton').disabled = true;

//     // Обробник подій для відповіді від сервера
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4) {
//             // Вимикаємо кнопку під час обробки запиту
//             document.getElementById('submitButton').disabled = false;

//             // Вивід результатів на сторінці
//             document.getElementById('result').innerHTML = "Дані додані до бази даних";
//             // Опціонально: очистити форму або виконати інші дії
//             document.getElementById('myForm').reset();
//         }
//     };

//     // Відправляємо дані форми на сервер
//     xhr.send(formData);
// }




