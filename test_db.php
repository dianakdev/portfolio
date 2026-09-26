<?php
$conn = mysqli_connect('localhost', 'root', '', 'отдел кадров');
if ($conn) {
    echo "БД подключена!";
    mysqli_query($conn, "INSERT INTO резюме (фио, email) VALUES ('Тест', 'test@test.ru')");
    echo " Данные добавлены!";
} else {
    echo "Ошибка: " . mysqli_connect_error();
}
?>