<?php
session_start();

// Подключение к базе данных
include('../includes/db_connection.php');

// Получение всех туров из базы данных
$sql = "SELECT * FROM tours";
$result = mysqli_query($conn, $sql);

// Создание массива туров
$tours = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tours[] = $row;
    }
}

// Закрытие соединения с базой данных
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Добро пожаловать</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>

    <div class="content">
        <h1>Добро пожаловать!</h1>
        <h2>Список туров</h2>
        <?php if (!empty($tours)): ?>
            <div class="tours">
                <?php foreach ($tours as $tour): ?>
                    <div class="tour-card">
                    <img class="card-img" src="<?php echo $tour['image_path']; ?>" alt="<?php echo $tour['name']; ?>">
                        <h2>
                            <?php echo $tour['name']; ?>
                        </h2>
                        <p>
                            <?php echo $tour['description']; ?>
                        </p>
                        <p>Цена:
                            <?php echo $tour['price']; ?>$
                        </p>
                        <p>Продолжительность:
                            <?php echo $tour['duration']; ?>$
                        </p>
                        <a href="booking.php?tour_id=<?php echo $tour['id']; ?>">Забронировать тур</a>


                       
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No tours available.</p>
        <?php endif; ?>
      

        <!-- Блок с описанием акций и специальных предложений -->
        <div class="special-offers">
            <h2>Специальные предложения</h2>
            <p>Только сегодня! Получите скидку 20% на все туры!</p>
        </div>

        <!-- Рекомендации по путешествиям -->
        <div class="travel-recommendations">
            <h2>Рекомендации по путешествиям</h2>
            <ul>
                <li>Экскурсия по Парижу</li>
                <li>Отдых на берегу моря в Греции</li>
                <li>Путешествие по Японии во время цветения сакуры</li>
            </ul>
        </div>

        <!-- Форма подписки на рассылку -->
        <div class="newsletter">
            <h2>Подпишитесь на нашу рассылку</h2>
            <form action="subscribe.php" method="post">
                <input type="email" name="email" placeholder="Введите ваш email" required>
                <button type="submit">Подписаться</button>
            </form>
        </div>

        <!-- Отзывы клиентов -->
        <div class="customer-reviews">
            <h2>Отзывы клиентов</h2>
            <ul>
                <li>"Отличное агентство! Мы полностью довольны нашим туром в Италию!" - Анна</li>
                <li>"Спасибо за отлично организованное путешествие в Таиланд! Будем рекомендовать вас всем друзьям!" -
                    Иван</li>
            </ul>
        </div>
        <?php
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        ?>
    </div>

    <?php include('../footer.php'); ?>
</body>

</html>