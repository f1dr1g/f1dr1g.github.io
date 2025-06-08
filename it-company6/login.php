<?php
require_once 'config.php';

// Если пользователь уже авторизован, перенаправляем на главную
if (isLoggedIn()) {
    redirect('index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username)) {
        $errors[] = 'Имя пользователя обязательно';
    }
    
    if (empty($password)) {
        $errors[] = 'Пароль обязателен';
    }
    
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            redirect('index.php');
        } else {
            $errors[] = 'Неверное имя пользователя или пароль';
        }
    }
}

$page_title = 'Вход в систему';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - IT Company</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header__container">
                <img src="logo.png" width="100" height="auto" alt="Логотип сайта">
                <nav class="header__nav">
                    <a href="index.php" class="header__link">Главная</a>
                    <a href="about.php" class="header__link">О нас</a>
                    <a href="services.php" class="header__link">Услуги</a>
                    <a href="login.php" class="header__link header__link--active">Вход</a>
                    <a href="register.php" class="header__link">Регистрация</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="card">
                <div class="card__header">
                    Вход в систему
                </div>
                <div class="card__body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert--error">
                            <ul style="margin: 0; padding-left: 1rem;">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo escape($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="form">
                        <div class="form__group">
                            <label for="username" class="form__label">Имя пользователя или Email:</label>
                            <input type="text" id="username" name="username" class="form__input" 
                                   value="<?php echo escape($_POST['username'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="password" class="form__label">Пароль:</label>
                            <input type="password" id="password" name="password" class="form__input" required>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn">Войти</button>
                            <a href="register.php" class="btn btn--secondary">Нет аккаунта?</a>
                        </div>
                    </form>
                    
                    <div class="alert alert--warning mt-2">
                        <strong>Тестовые данные:</strong><br>
                        Администратор: admin / password<br>
                        Пользователь: john_doe / password
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 IT Company. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>