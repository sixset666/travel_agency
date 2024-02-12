<?php
// Управление сессиями пользователей
session_start();

// Проверка на аутентификацию пользователя
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Проверка на аутентификацию администратора
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}
?>
