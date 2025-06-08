<?php
require_once 'config.php';

// Уничтожаем сессию
session_destroy();

// Перенаправляем на главную страницу
redirect('index.php');
?>