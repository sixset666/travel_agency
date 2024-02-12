<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin/login");
    exit();
}
include('../includes/db_connection.php');

// Проверяем, передан ли идентификатор пользователя в запросе
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Получаем информацию о пользователе из базы данных
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // Проверяем, был ли найден пользователь с указанным идентификатором
    if (!$user) {
        // Если пользователь не найден, выводим сообщение об ошибке или выполняем другие действия
        echo "Пользователь не найден.";
        exit();
    }
} else {
    // Если идентификатор пользователя не передан, выводим сообщение об ошибке или выполняем другие действия
    echo "Идентификатор пользователя не указан.";
    exit();
}

// Проверяем, была ли отправлена форма для обновления пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Хэшируем пароль, если он был изменен
    if ($password !== $user['password']) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $password;
    }

    // SQL запрос для обновления пользователя
    $sql = "UPDATE users SET username='$username', password='$hashed_password', role='$role' WHERE id=$user_id";

    // Выполняем запрос
    if (mysqli_query($conn, $sql)) {
        // Если обновление прошло успешно, перенаправляем на страницу со списком пользователей
        header("Location: users.php");
        exit();
    } else {
        // Если произошла ошибка, выводим сообщение об ошибке или выполняем другие действия
        echo "Ошибка при обновлении пользователя: " . mysqli_error($conn);
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
    <title>Редактировать пользователя</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    <header>
        <h1>Редактировать пользователя</h1>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="tours.php">Управление турами</a></li>
                <li class="nav-item"><a class="nav-link" href="bookings.php">Управление бронированиями</a></li>
            </ul>
        </nav>
    </header>
    <div class="content">
        <h2>Изменить данные пользователя</h2>
        <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="post">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Новый пароль:</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="role">Роль:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>Пользователь</option>
                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Администратор</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Обновить пользователя</button>
        </form>
    </div>
</body>
</html>
