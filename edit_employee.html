<?php
require_once 'config.php';

// Проверяем авторизацию
if (!isLoggedIn()) {
    redirect('login.php');
}

$employee_id = (int)($_GET['id'] ?? 0);

if (!$employee_id) {
    redirect('employees.php');
}

// Получаем сотрудника
if (isAdmin()) {
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->execute([$employee_id]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ? AND user_id = ?");
    $stmt->execute([$employee_id, $_SESSION['user_id']]);
}

$employee = $stmt->fetch();

if (!$employee) {
    redirect('employees.php');
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
    
    // Обновление
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE employees SET name = ?, position = ?, email = ?, phone = ? WHERE id = ?");
        
        $params = [
            $name,
            $position,
            $email,
            $phone ?: null,
            $employee_id
        ];
        
        if ($stmt->execute($params)) {
            $success = 'Данные сотрудника успешно обновлены!';
            // Обновляем данные сотрудника
            $employee['name'] = $name;
            $employee['position'] = $position;
            $employee['email'] = $email;
            $employee['phone'] = $phone;
        } else {
            $errors[] = 'Ошибка при обновлении данных сотрудника';
        }
    }
}

$page_title = 'Редактировать сотрудника';
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
                    Редактировать сотрудника: <?php echo escape($employee['name']); ?>
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
                                   value="<?php echo escape($_POST['name'] ?? $employee['name']); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="position" class="form__label">Должность *:</label>
                            <input type="text" id="position" name="position" class="form__input" 
                                   value="<?php echo escape($_POST['position'] ?? $employee['position']); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="email" class="form__label">Email *:</label>
                            <input type="email" id="email" name="email" class="form__input" 
                                   value="<?php echo escape($_POST['email'] ?? $employee['email']); ?>" required>
                        </div>
                        
                        <div class="form__group">
                            <label for="phone" class="form__label">Телефон:</label>
                            <input type="tel" id="phone" name="phone" class="form__input" 
                                   value="<?php echo escape($_POST['phone'] ?? $employee['phone']); ?>" 
                                   placeholder="+7-XXX-XXX-XXXX">
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn--success">Сохранить изменения</button>
                            <a href="employees.php" class="btn btn--secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php
            // Получаем проекты сотрудника
            $stmt = $pdo->prepare("
                SELECT p.id, p.title, pe.role, pe.id as assignment_id
                FROM project_employees pe 
                JOIN projects p ON pe.project_id = p.id 
                WHERE pe.employee_id = ? 
                ORDER BY pe.assigned_at DESC
            ");
            $stmt->execute([$employee_id]);
            $employee_projects = $stmt->fetchAll();
            ?>
            
            <?php if (!empty($employee_projects)): ?>
                <div class="card mt-2">
                    <div class="card__header">
                        Проекты сотрудника
                    </div>
                    <div class="card__body">
                        <table class="table">
                            <thead class="table__header">
                                <tr>
                                    <th class="table__cell">Проект</th>
                                    <th class="table__cell">Роль</th>
                                    <th class="table__cell">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employee_projects as $project): ?>
                                    <tr class="table__row">
                                        <td class="table__cell"><?php echo escape($project['title']); ?></td>
                                        <td class="table__cell"><?php echo escape($project['role']); ?></td>
                                        <td class="table__cell">
                                            <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn">Открыть проект</a>
                                            <form method="POST" action="assign_employees.php?id=<?php echo $project['id']; ?>" style="display: inline;">
                                                <input type="hidden" name="assignment_id" value="<?php echo $project['assignment_id']; ?>">
                                                <button type="submit" name="remove" class="btn btn--danger" 
                                                        onclick="return confirm('Удалить сотрудника с проекта?')">Удалить с проекта</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 IT Company. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>