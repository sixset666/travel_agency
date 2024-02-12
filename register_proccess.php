<?php
session_start();

// Подключение к базе данных
include('includes/db_connection.php');

// Получение данных из формы
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
    
// Хеширование пароля (рекомендуется для безопасности)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL-запрос для добавления пользователя в базу данных
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

// Выполнение SQL-запроса
if (mysqli_query($conn, $sql)) {
    // Если запрос выполнен успешно, перенаправляем пользователя на страницу входа
    header("Location: login.php");
    exit();
} else {
    // Если произошла ошибка при выполнении запроса, выводим сообщение об ошибке
    echo "Ошибка: " . mysqli_error($conn);
}       

// Закрываем соединение с базой данных
mysqli_close($conn);
?>
