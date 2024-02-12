<?php
session_start();
// Подключение к базе данных
include('../includes/db_connection.php');

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение ID пользователя
$user_id = $_SESSION['user_id'];

// SQL запрос для получения списка бронирований пользователя
$sql = "SELECT * FROM bookings WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - История бронирований</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include('../header.php'); ?>
    <div class="content">
        <h1>История бронирований</h1>
        <?php
        // Проверка наличия результатов запроса
        if (mysqli_num_rows($result) > 0) {
            // Если есть бронирования, выводим их
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='booking'>";
                echo "<h2>Бронирование #" . $row['id'] . "</h2>";
                echo "<p>Тур: " . $row['tour_id'] . "</p>";
                echo "<p>Дата бронирования: " . $row['date_booked'] . "</p>";
                // Добавьте дополнительные детали бронирования, если необходимо
                echo "</div>";
            }
        } else {
            // Если нет бронирований, выводим сообщение об отсутствии истории бронирований
            echo "<p>У вас пока нет ни одного бронирования.</p>";
        }

        // Закрываем соединение с базой данных
        mysqli_close($conn);
        ?>
    </div>
    <?php include('../footer.php'); ?>
</body>
</html>
