<?php
// В начале файла добавьте:
error_reporting(E_ALL);
ini_set('display_errors', 1);

// И проверяйте полученные данные:
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

// Если данные приходят - продолжаем выполнение

// 1. Подключение к БД
$conn = mysqli_connect('localhost', 'root', '', 'отдел кадров');

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// 2. Получаем данные из формы
$fio = $_POST['fullName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$position = $_POST['position'];
$message = $_POST['message'] ?? '';
$experience = $_POST['experience'] ?? 0;

// 3. Обрабатываем файл
$resume_file = '';
if (isset($_FILES['resumeFile'])) { // Исправлено: $_FILES вместо $_FILE$
    $file_name = time() . '_' . $_FILES['resumeFile']['name']; // Исправлена конкатенация
    if (move_uploaded_file($_FILES['resumeFile']['tmp_name'], 'uploads/' . $file_name)) {
        $resume_file = $file_name;
    }
}

// 4. Сохраняем в БД
$sql = "INSERT INTO резюме (фис, email, телефон, желаемая_должность, опыт_лет, сообщение, файл_резюме)
    VALUES ('$fio', '$email', '$phone', '$position', '$experience', '$message', '$resume_file')";

if (mysqli_query($conn, $sql)) {
    // Успех - редирект обратно
    header('Location: главная.html?success=1');
    exit();
} else {
    echo "Ошибка: " . mysqli_error($conn);
}

mysqli_close($conn);
?>