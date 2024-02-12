<?php
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: ../admin/login");
    exit();
}
include('../includes/db_connection.php');

// Получаем список всех пользователей из базы данных
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Админ-панель</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="tours.php">Управление турами</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookings.php">Управление бронированиями</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Управление пользователями</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="content">
        <h2>Список пользователей</h2>
        <ul class="list-group">
            <?php foreach ($users as $user): ?>
                <li class="list-group-item">
                    <?php echo $user['username']; ?>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Редактировать</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm">Удалить</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <h2>Добавить нового пользователя</h2>
        <form action="add_user.php" method="post">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Добавить пользователя</button>
        </form>
    </div>
</body>
</html>
