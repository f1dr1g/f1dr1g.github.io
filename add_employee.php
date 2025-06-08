<?php
require_once 'config.php';

// Проверяем авторизацию
if (!isLoggedIn()) {
    redirect('login.php');
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    // Валидация
    if (empty($name)) {
        $errors[] = 'Имя сотрудника обязательно';
    }
    
    if (empty($position)) {
        $errors[] = 'Должность обязательна';
    }
    
    if (empty($email)) {
        $errors[] = 'Email обязателен';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email';
    }
    
    // Сохранение
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO employees (user_id, name, position, email, phone) VALUES (?, ?, ?, ?, ?)");
        
        $params = [
            $_SESSION['user_id'],
            $name,
            $position,
            $email,
            $phone ?: null
        ];
        
        if ($stmt->execute($params)) {
            $success = 'Сотрудник успешно добавлен!';
            // Очищаем форму
            $_POST = [];
        } else {
            $errors[] = 'Ошибка при добавлении сотрудника';
        }
    }
}

$page_title = 'Добавить сотрудника';
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
                    <a href="projects.php" class="header__link">Проекты</a>
                    <a href="employees.php" class="header__link">Сотрудники</a>
                    <?php if (isAdmin()): ?>
                        <a href="admin_users.php" class="header__link">Пользователи</a>
                    <?php endif; ?>
                    <a href="logout.php" class="header__link">Выход (<?php echo escape($_SESSION['username']); ?>)</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <div class="card">
                <div class="card__header">
                    Добавить нового сотрудника
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
                    <?php endif; ?>
                    
                    <form method="POST" class="form">
                        <div class="form__group">
                            <label for="name" class="form__label">ФИО сотрудника *:</label>
                            <input type="text" id="name" name="name" class="form__input" 
                                   value="<?php echo escape($_POST['name'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="position" class="form__label">Должность *:</label>
                            <input type="text" id="position" name="position" class="form__input" 
                                   value="<?php echo escape($_POST['position'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="email" class="form__label">Email *:</label>
                            <input type="email" id="email" name="email" class="form__input" 
                                   value="<?php echo escape($_POST['email'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="phone" class="form__label">Телефон:</label>
                            <input type="tel" id="phone" name="phone" class="form__input" 
                                   value="<?php echo escape($_POST['phone'] ?? ''); ?>" 
                                   placeholder="+7-XXX-XXX-XXXX">
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn--success">Добавить сотрудника</button>
                            <a href="employees.php" class="btn btn--secondary">Отмена</a>
                        </div>
                    </form>
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