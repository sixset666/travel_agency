<?php
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: ..admin/login");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    // Проверяем, был ли загружен файл изображения
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Указываем путь для сохранения изображения
        $uploadDirectory = '../images/';
        $fileName = $_FILES['image']['name'];
        $targetFile = $uploadDirectory . $fileName;

        // Перемещаем файл изображения из временной директории в указанную
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Файл успешно загружен, сохраняем данные в базу данных
            $sql = "INSERT INTO tours (name, description, price, duration, image_path) VALUES ('$name', '$description', '$price', '$duration', '$targetFile')";
            if (mysqli_query($conn, $sql)) {
                // Тур успешно добавлен, перенаправляем на страницу с турами
                header("Location: tours.php");
                exit();
            } else {
                // Ошибка при добавлении тура
                echo "Ошибка: " . mysqli_error($conn);
            }
        } else {
            // Ошибка при перемещении файла изображения
            echo "Ошибка при загрузке изображения.";
        }
    } else {
        // Файл изображения не был загружен или произошла ошибка
        echo "Ошибка: файл изображения не был загружен или произошла ошибка.";
    }
}
?>
