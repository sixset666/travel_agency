<header>
    <nav>
        <ul>
            
           
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                <li><a href="../user/index.php">Главная</a></li>
                <li><a href="../user/history.php">История бронирований</a></li>
                <li><a href="../logout.php">Выйти</a></li>
            <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="index.php">Главная</a></li>
                <li><a href="../admin/tours.php">Админ-панель</a></li>
                <li><a href="../logout.php">Выйти</a></li>
            <?php else: ?>
                <li><a href="login.php">Вход</a></li>
                <li><a href="register.php">Регистрация</a></li>
                <li><a href="index.php">Главная</a></li>
            <?php endif; ?>
             <li><a href="../about.php">О нас</a></li>
        </ul>
    </nav>
</header>
