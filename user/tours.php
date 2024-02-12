<?php
session_start();
// Подключение к базе данных
include('../includes/db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Доступные туры</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="content">
        <h1>Доступные туры</h1>
        <?php
        // SQL запрос для получения списка доступных туров
        $sql = "SELECT * FROM tours";
        $result = mysqli_query($conn, $sql);

        // Проверка наличия результатов запроса
        if (mysqli_num_rows($result) > 0) {
            // Если есть доступные туры, выводим их
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='tour'>";
                echo "<h2>" . $row['name'] . "</h2>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p>Цена: $" . $row['price'] . "</p>";
                // Добавьте кнопку для бронирования или дополнительные действия
                echo "</div>";
            }
        } else {
            // Если нет доступных туров, выводим сообщение об отсутствии туров
            echo "<p>Извините, в данный момент нет доступных туров.</p>";
        }

        // Закрываем соединение с базой данных
        mysqli_close($conn);
        ?>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>

