<?php
require_once 'config.php';

// Проверяем авторизацию
if (!isLoggedIn()) {
    redirect('login.php');
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'planning';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $budget = $_POST['budget'] ?? '';
    
    // Валидация
    if (empty($title)) {
        $errors[] = 'Название проекта обязательно';
    }
    
    if ($budget && !is_numeric($budget)) {
        $errors[] = 'Бюджет должен быть числом';
    }
    
    if ($start_date && $end_date && strtotime($start_date) > strtotime($end_date)) {
        $errors[] = 'Дата начала не может быть позже даты окончания';
    }
    
    // Сохранение
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description, status, start_date, end_date, budget) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $params = [
            $_SESSION['user_id'],
            $title,
            $description ?: null,
            $status,
            $start_date ?: null,
            $end_date ?: null,
            $budget ?: null
        ];
        
        if ($stmt->execute($params)) {
            $success = 'Проект успешно добавлен!';
            // Очищаем форму
            $_POST = [];
        } else {
            $errors[] = 'Ошибка при добавлении проекта';
        }
    }
}

$page_title = 'Добавить проект';
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
                    Добавить новый проект
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
                            <label for="title" class="form__label">Название проекта *:</label>
                            <input type="text" id="title" name="title" class="form__input" 
                                   value="<?php echo escape($_POST['title'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="description" class="form__label">Описание:</label>
                            <textarea id="description" name="description" class="form__textarea" 
                                      placeholder="Подробное описание проекта"><?php echo escape($_POST['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form__group">
                            <label for="status" class="form__label">Статус:</label>
                            <select id="status" name="status" class="form__select">
                                <option value="planning" <?php echo ($_POST['status'] ?? 'planning') === 'planning' ? 'selected' : ''; ?>>Планирование</option>
                                <option value="in_progress" <?php echo ($_POST['status'] ?? '') === 'in_progress' ? 'selected' : ''; ?>>В работе</option>
                                <option value="completed" <?php echo ($_POST['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Завершен</option>
                                <option value="on_hold" <?php echo ($_POST['status'] ?? '') === 'on_hold' ? 'selected' : ''; ?>>Приостановлен</option>
                            </select>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form__group">
                                <label for="start_date" class="form__label">Дата начала:</label>
                                <input type="date" id="start_date" name="start_date" class="form__input" 
                                       value="<?php echo escape($_POST['start_date'] ?? ''); ?>">
                            </div>
                            
                            <div class="form__group">
                                <label for="end_date" class="form__label">Дата окончания:</label>
                                <input type="date" id="end_date" name="end_date" class="form__input" 
                                       value="<?php echo escape($_POST['end_date'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="form__group">
                            <label for="budget" class="form__label">Бюджет (₽):</label>
                            <input type="number" id="budget" name="budget" class="form__input" 
                                   value="<?php echo escape($_POST['budget'] ?? ''); ?>" min="0" step="0.01">
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn--success">Добавить проект</button>
                            <a href="projects.php" class="btn btn--secondary">Отмена</a>
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