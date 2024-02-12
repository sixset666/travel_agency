<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: user/index.php");
    exit();
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        <form action="register_proccess.php" method="post" onsubmit="return validateForm()">
            <label for="username">Имя:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Подтвердите пароль:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
    </div>

    <script>
        function validateForm() {
            var name = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            // Проверка наличия имени
            if (name == "") {
                alert("Введите ваше имя");
                return false;
            }

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

            // Проверка совпадения пароля и его подтверждения
            if (password != confirm_password) {
                alert("Пароли не совпадают");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
