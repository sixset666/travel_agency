<?php
session_start();
include('includes/db_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Главная</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h1>Добро пожаловать в TravelEase!</h1>
        <!-- Здесь можно добавить контент главной страницы -->
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
