<?php
session_start();

// Проверяем, авторизован ли уже какой-то пользователь
if(isset($_SESSION['user_id'])) {
    // Если пользователь уже авторизован, перенаправляем его на главную страницу пользователя
    header("Location: ../user/index.php");
    exit();
} elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Если у пользователя роль администратора, перенаправляем его на главную страницу администратора
    header("Location: index.php");
    exit();
}


// Проверяем, была ли отправлена форма входа
if(isset($_POST['submit'])) {
    // Получаем данные из формы
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверяем введенные данные в базе данных
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // Проверяем, был ли найден пользователь с указанным именем пользователя
    if(mysqli_num_rows($result) === 1) {
        // Пользователь найден, проверяем пароль
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password']) && $row['role'] === 'admin') {
            // Пароль совпадает и пользователь - администратор, устанавливаем сессию для администратора
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            // Перенаправляем администратора на главную страницу администратора
            header("Location: index.php");
            exit();
        } else {
            // Если пароль не совпадает или пользователь не администратор, выводим сообщение об ошибке
            $error_message = "Неверное имя пользователя или пароль";
        }
    } else {
        // Если пользователь с указанным именем пользователя не найден, выводим сообщение об ошибке
        $error_message = "Неверное имя пользователя или пароль";
    }
}

// Закрываем соединение с базой данных
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель - Вход</title>
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    <div class="login-container">
        <h1>Вход в административную панель</h1>
        <?php if(isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="submit">Войти</button>
        </form>
    </div>
</body>
</html>
