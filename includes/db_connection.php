<?php
// Подключение к базе данных MySQL
$servername = "localhost";
$username = "user"; // Замените на ваше имя пользователя MySQL
$password = "123"; // Замените на ваш пароль MySQL
$database = "tourism_agency"; // Замените на название вашей базы данных
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>
