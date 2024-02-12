<?php
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: ..admin/login");
    exit();
}
include('../includes/db_connection.php');

// Получаем список всех бронирований из базы данных
$sql = "SELECT * FROM bookings";
$result = mysqli_query($conn, $sql);
$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление бронированиями</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <div class="container">
        <h2>Список бронирований</h2>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>ID бронирования</th>
                    <th>Имя пользователя</th>
                    <th>ID тура</th>
                    <th>Дата бронирования</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['id']; ?></td>
                        <td><?php echo $booking['user_id']; ?></td>
                        <td><?php echo $booking['tour_id']; ?></td>
                        <td><?php echo $booking['date_booked']; ?></td>
                        <td>
                            <a href="cancel_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-danger">Отменить</a>
                            <!-- Добавьте другие действия, если необходимо -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
