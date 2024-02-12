<?php
session_start();

// Подключение к базе данных
include('../includes/db_connection.php');

// Проверка наличия сессии пользователя
if (!isset($_SESSION['user_id'])) {
    // Пользователь не аутентифицирован, перенаправляем на страницу входа
    header("Location: ../login.php");
    exit();
}

// Получение данных пользователя из сессии
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

// Получение данных о туре из GET-запроса
if (isset($_GET['tour_id'])) {
    $tour_id = $_GET['tour_id'];
} else {
    // Если не передан ID тура, выводим сообщение об ошибке и прерываем выполнение скрипта
    echo "ID тура не указан.";
    exit();
}

// Запись бронирования в базу данных
// Запись бронирования в базу данных
$sql = "INSERT INTO bookings (user_id, tour_id, date_booked) VALUES ('$user_id', '$tour_id', NOW())";

if(mysqli_query($conn, $sql)) {
    // Бронирование успешно сохранено
    header("Location: booking_success.php");
    exit();
} else {
    // Ошибка при сохранении бронирования
    echo "Ошибка при сохранении бронирования: " . mysqli_error($conn);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронирование тура</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Бронирование тура "<?php echo $tour['name']; ?>"</h1>
    
    <div class="tour-info">
        <p><strong>Описание:</strong> <?php echo $tour['description']; ?></p>
        <p><strong>Цена:</strong> <?php echo $tour['price']; ?>$</p>
        <!-- Дополнительная информация о туре, например, продолжительность и т. д. -->
    </div>
    
    <h2>Заполните форму для бронирования</h2>
    <form action="process_booking.php" method="post">
        <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
        <label for="name">Ваше имя:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Ваш email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <!-- Дополнительные поля для ввода данных, например, даты, количества человек и т. д. -->
        <button type="submit">Забронировать</button>
    </form>

    <a href="index.php">Вернуться на главную страницу</a>

</body>
</html>
