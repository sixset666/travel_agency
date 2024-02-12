<?php
session_start();
include('includes/db_connection.php');

if(isset($_GET['tour_id'])) {
    $tour_id = $_GET['tour_id'];
    $sql = "SELECT * FROM tours WHERE id = '$tour_id'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1) {
        $tour = mysqli_fetch_assoc($result);
    } else {
        // Если тур с указанным ID не найден, перенаправляем пользователя на главную страницу
        header("Location: index.php");
        exit();
    }
} else {
    // Если не указан ID тура, перенаправляем пользователя на главную страницу
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Подробности тура</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <?php
        if(isset($tour)) {
            echo "<h1>{$tour['name']}</h1>";
            echo "<p>{$tour['description']}</p>";
            echo "<p>Цена: {$tour['price']} руб.</p>";
            echo "<p>Продолжительность: {$tour['duration']} дней</p>";
            // Здесь можно добавить другие детали тура, такие как маршрут, фотографии и т.д.
        } else {
            echo "<p>Тур не найден.</p>";
        }
        ?>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
