<?php
require_once 'config.php';

// Если пользователь уже авторизован, перенаправляем на главную
if (isLoggedIn()) {
    redirect('index.php');
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Валидация
    if (empty($username)) {
        $errors[] = 'Имя пользователя обязательно';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Имя пользователя должно содержать минимум 3 символа';
    }
    
    if (empty($email)) {
        $errors[] = 'Email обязателен';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email';
    }
    
    if (empty($password)) {
        $errors[] = 'Пароль обязателен';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Пароль должен содержать минимум 6 символов';
    }
    
    if ($password !== $confirm_password) {
        $errors[] = 'Пароли не совпадают';
    }
    
    // Проверка уникальности
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = 'Пользователь с таким именем или email уже существует';
        }
    }
    
    // Регистрация
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$username, $email, $hashed_password])) {
            $success = 'Регистрация успешна! Теперь вы можете войти в систему.';
        } else {
            $errors[] = 'Ошибка при регистрации';
        }
    }
}

$page_title = 'Регистрация';
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
                    <a href="login.php" class="header__link">Вход</a>
                    <a href="register.php" class="header__link header__link--active">Регистрация</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="card">
                <div class="card__header">
                    Регистрация нового пользователя
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
                    
                    <?php if ($success): ?>
                        <div class="alert alert--success">
                            <?php echo escape($success); ?>
                        </div>
                        <div class="text-center">
                            <a href="login.php" class="btn">Войти в систему</a>
                        </div>
                    <?php else: ?>
                        <form method="POST" class="form">
                            <div class="form__group">
                                <label for="username" class="form__label">Имя пользователя:</label>
                                <input type="text" id="username" name="username" class="form__input" 
                                       value="<?php echo escape($_POST['username'] ?? ''); ?>" required>
                            </div>
                            
                            <div class="form__group">
                                <label for="email" class="form__label">Email:</label>
                                <input type="email" id="email" name="email" class="form__input" 
                                       value="<?php echo escape($_POST['email'] ?? ''); ?>" required>
                            </div>
                            
                            <div class="form__group">
                                <label for="password" class="form__label">Пароль:</label>
                                <input type="password" id="password" name="password" class="form__input" required>
                            </div>
                            
                            <div class="form__group">
                                <label for="confirm_password" class="form__label">Подтвердите пароль:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form__input" required>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn--success">Зарегистрироваться</button>
                                <a href="login.php" class="btn btn--secondary">Уже есть аккаунт?</a>
                            </div>
                        </form>
                    <?php endif; ?>
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