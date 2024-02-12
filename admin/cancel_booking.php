<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin/login.php");
    exit();
}

// Проверяем, передан ли идентификатор бронирования в запросе
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Удаляем бронирование из базы данных
    $sql = "DELETE FROM bookings WHERE id = $booking_id";

    if (mysqli_query($conn, $sql)) {
        // Если удаление прошло успешно, перенаправляем на страницу с бронированиями
        header("Location: bookings.php");
        exit();
    } else {
        // Если произошла ошибка, выводим сообщение об ошибке или выполняем другие действия
        echo "Ошибка при отмене бронирования: " . mysqli_error($conn);
    }
} else {
    // Если идентификатор бронирования не передан, выводим сообщение об ошибке или выполняем другие действия
    echo "Идентификатор бронирования не указан.";
    exit();
}

// Закрываем соединение с базой данных
mysqli_close($conn);
?>
