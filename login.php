<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: user/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Вход</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Вход</h1>
        <form action="login_process.php" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Войти</button>
        </form>
        <p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
    </div>

    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            // Проверка наличия email
            if (email == "") {
                alert("Введите ваш email");
                return false;
            }

            // Проверка наличия пароля
            if (password == "") {
                alert("Введите ваш пароль");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>

