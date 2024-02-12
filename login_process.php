<?php
session_start();

// Подключение к базе данных
include('includes/db_connection.php');

// Получение данных из формы
$email = $_POST['email'];
$password = $_POST['password'];

// Поиск пользователя в базе данных по email
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    // Пользователь найден, проверяем пароль
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
        // Пароль совпадает, устанавливаем сессию для пользователя
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        
        // Перенаправляем пользователя на главную страницу для аутентифицированных пользователей
        header("Location: user/index.php");
        exit();
    } else {
        // Если пароль не совпадает, перенаправляем пользователя обратно на страницу входа с сообщением об ошибке
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} else {
    // Если пользователь с указанным email не найден, перенаправляем пользователя обратно на страницу входа с сообщением об ошибке
    header("Location: login.php?error=user_not_found");
    exit();
}

// Закрываем соединение с базой данных
mysqli_close($conn);
?>
