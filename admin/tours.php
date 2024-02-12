<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin/login.php");
    exit();
}
include('../includes/db_connection.php');

// Получаем список всех туров из базы данных
$sql = "SELECT * FROM tours";
$result = mysqli_query($conn, $sql);
$tours = mysqli_fetch_all($result, MYSQLI_ASSOC);
$imagePath = "../images/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    
    // Загрузка изображения
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Проверяем, является ли файл изображением
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        // Перемещаем файл в папку с изображениями
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Файл успешно загружен, сохраняем данные в базу данных
            $sql = "INSERT INTO tours (name, description, price, duration, image) VALUES ('$name', '$description', '$price', '$duration', '$target_file')";
            if(mysqli_query($conn, $sql)) {
                // Тур успешно добавлен, перенаправляем на страницу с турами
                header("Location: tours.php");
                exit();
            } else {
                // Ошибка при добавлении тура
                echo "Ошибка: " . mysqli_error($conn);
            }
        } else {
            // Ошибка при загрузке изображения
            echo "Ошибка при загрузке изображения.";
        }
    } else {
        // Выбранный файл не является изображением
        echo "Выбранный файл не является изображением.";
    }
}

// Путь для сохранения загруженных изображений
$uploadDirectory = '../images/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление турами</title>
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
        <h2>Список туров</h2>
        <div class="row">
            <?php foreach ($tours as $tour): ?>
                <div class="col-md-4">
                    <div class="tour-card">
                    <img class="card-img" src="<?php echo $tour['image_path']; ?>" alt="<?php echo $tour['name']; ?>">
                        <h3><?php echo $tour['name']; ?></h3>
                        <p><?php echo $tour['description']; ?></p>
                        <p><strong>Цена:</strong> <?php echo $tour['price']; ?></p>
                        <p><strong>Продолжительность:</strong> <?php echo $tour['duration']; ?></p>
                        <a href="edit_tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-primary">Редактировать</a>
                        <a href="delete_tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-danger">Удалить</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <h2>Добавить новый тур</h2>
        <form action="add_tour.php" method="post" enctype="multipart/form-data">
            <label for="name">Название тура:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="description">Описание:</label><br>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
            <label for="price">Цена:</label>
            <input type="number" id="price" name="price" required><br><br>
            <label for="duration">Продолжительность:</label>
            <input type="text" id="duration" name="duration" required><br><br>
            <label for="image">Изображение:</label>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>
            <button type="submit">Добавить тур</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
