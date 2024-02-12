<?php
session_start();
if (!isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: ..admin/login");
    exit();
}
include('../includes/db_connection.php');

// Проверяем, передан ли идентификатор тура в запросе
if (isset($_GET['id'])) {
    $tour_id = $_GET['id'];

    // Получаем информацию о туре из базы данных
    $sql = "SELECT * FROM tours WHERE id = $tour_id";
    $result = mysqli_query($conn, $sql);
    $tour = mysqli_fetch_assoc($result);

    // Проверяем, был ли найден тур с указанным идентификатором
    if (!$tour) {
        // Если тур не найден, выводим сообщение об ошибке или выполняем другие действия
        echo "Тур не найден.";
        exit();
    }
} else {
    // Если идентификатор тура не передан, выводим сообщение об ошибке или выполняем другие действия
    echo "Идентификатор тура не указан.";
    exit();
}

// Проверяем, была ли отправлена форма для обновления тура
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    // Проверяем, был ли загружен файл изображения
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Указываем путь для сохранения изображения
        $uploadDirectory = '../images/';
        $fileName = $_FILES['image']['name'];
        $targetFile = $uploadDirectory . $fileName;

        // Перемещаем файл изображения из временной директории в указанную
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Файл успешно загружен, сохраняем данные в базу данных
            $sql = "UPDATE tours SET name='$name', description='$description', price=$price, duration='$duration', image_path='$targetFile' WHERE id=$tour_id";

            // Выполняем запрос
            if (mysqli_query($conn, $sql)) {
                // Если обновление прошло успешно, перенаправляем на страницу с управлением турами
                header("Location: tours.php");
                exit();
            } else {
                // Если произошла ошибка, выводим сообщение об ошибке или выполняем другие действия
                echo "Ошибка при обновлении тура: " . mysqli_error($conn);
            }
        } else {
            // Ошибка при перемещении файла изображения
            echo "Ошибка при загрузке изображения.";
        }
    } else {
        // Файл изображения не был загружен или произошла ошибка
        echo "Ошибка: файл изображения не был загружен или произошла ошибка.";
    }
}

// Закрываем соединение с базой данных
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tour</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>

    <div class="content">
        <h2>Редактирование тура</h2>
        <form action="edit_tour.php?id=<?php echo $tour['id']; ?>" method="post" enctype="multipart/form-data">
            <label for="name">Название:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $tour['name']; ?>" required><br><br>
            <label for="description">Описание:</label><br>
            <textarea id="description" name="description" rows="4" cols="50"
                required><?php echo $tour['description']; ?></textarea><br><br>
            <label for="price">Цена:</label><br>
            <input type="number" id="price" name="price" value="<?php echo $tour['price']; ?>" required><br><br>
            <label for="duration">DПродолжительность:</label><br>
            <input type="text" id="duration" name="duration" value="<?php echo $tour['duration']; ?>" required><br><br>
            <label for="image">Изображение:</label>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <button type="submit">Обновить тур</button>
        </form>
    </div>

    <?php include('../footer.php'); ?>
</body>

</html>
