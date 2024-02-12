<?php
session_start();
include('includes/db_connection.php');

if(isset($_SESSION['user_id']) && isset($_GET['tour_id'])) {
    $user_id = $_SESSION['user_id'];
    $tour_id = $_GET['tour_id'];

    // Добавляем бронирование в базу данных
    $sql = "INSERT INTO bookings (user_id, tour_id, date_booked) VALUES ('$user_id', '$tour_id', NOW())";
    if(mysqli_query($conn, $sql)) {
        // Получаем информацию о бронировании
        $booking_id = mysqli_insert_id($conn);
        $sql = "SELECT * FROM bookings WHERE id = '$booking_id'";
        $result = mysqli_query($conn, $sql);
        $booking = mysqli_fetch_assoc($result);

        // Отправляем подтверждение бронирования на электронную почту пользователя
        $to = "example@example.com"; // Замените на адрес электронной почты пользователя
        $subject = "Подтверждение бронирования";
        $message = "Здравствуйте,\n\n";
        $message .= "Ваше бронирование успешно подтверждено.\n\n";
        $message .= "ID бронирования: " . $booking['id'] . "\n";
        $message .= "Дата бронирования: " . $booking['date_booked'] . "\n";
        // Добавьте другие детали бронирования, если необходимо
        $headers = "From: example@example.com\r\n";
        // Для отладки можно использовать функцию mail() или библиотеку для отправки писем, например, PHPMailer
        // mail($to, $subject, $message, $headers);

        // Перенаправляем пользователя на страницу подтверждения
        header("Location: confirmation_success.php");
        exit();
    } else {
        // Если произошла ошибка при добавлении бронирования в базу данных
        echo "Ошибка при бронировании тура.";
    }
} else {
    // Если пользователь не аутентифицирован или не указан ID тура
    // Перенаправляем пользователя на главную страницу или страницу входа
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение бронирования</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <h1>Бронирование подтверждено</h1>
        <p>Спасибо за ваше бронирование! Детали бронирования были отправлены на вашу электронную почту.</p>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
