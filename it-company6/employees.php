<?php
require_once 'config.php';

// Проверяем авторизацию
if (!isLoggedIn()) {
    redirect('login.php');
}

// Обработка удаления сотрудника
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $employee_id = (int)$_GET['delete'];
    
    // Проверяем права доступа
    if (isAdmin()) {
        $stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("DELETE FROM employees WHERE id = ? AND user_id = ?");
    }
    
    $params = isAdmin() ? [$employee_id] : [$employee_id, $_SESSION['user_id']];
    
    if ($stmt->execute($params)) {
        $message = 'Сотрудник успешно удален';
        $message_type = 'success';
    } else {
        $message = 'Ошибка при удалении сотрудника';
        $message_type = 'error';
    }
}

// Фильтры
$position_filter = $_GET['position'] ?? '';
$search = trim($_GET['search'] ?? '');

// Построение запроса
$where_conditions = [];
$params = [];

// Добавляем условие для текущего пользователя (если не админ)
if (!isAdmin()) {
    $where_conditions[] = "user_id = ?";
    $params[] = $_SESSION['user_id'];
}

if ($position_filter) {
    $where_conditions[] = "position LIKE ?";
    $params[] = "%$position_filter%";
}

if ($search) {
    $where_conditions[] = "(name LIKE ? OR email LIKE ? OR position LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Получаем сотрудников
$sql = "SELECT * FROM employees $where_clause ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employees = $stmt->fetchAll();

// Получаем уникальные должности для фильтра
if (isAdmin()) {
    $stmt = $pdo->query("SELECT DISTINCT position FROM employees ORDER BY position");
} else {
    $stmt = $pdo->prepare("SELECT DISTINCT position FROM employees WHERE user_id = ? ORDER BY position");
    $stmt->execute([$_SESSION['user_id']]);
}
$positions = $stmt->fetchAll(PDO::FETCH_COLUMN);

$page_title = 'Сотрудники';
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
                    <a href="employees.php" class="header__link header__link--active">Сотрудники</a>
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
            <?php if (isset($message)): ?>
                <div class="alert alert--<?php echo $message_type; ?>">
                    <?php echo escape($message); ?>
                </div>
            <?php endif; ?>
            
            <!-- Фильтры -->
            <div class="filters">
                <form method="GET" class="filters__form">
                    <div class="filters__row">
                        <div class="filters__group">
                            <label for="search" class="form__label">Поиск:</label>
                            <input type="text" id="search" name="search" class="form__input" 
                                   value="<?php echo escape($search); ?>" placeholder="Имя, email или должность">
                        </div>
                        
                        <div class="filters__group">
                            <label for="position" class="form__label">Должность:</label>
                            <select id="position" name="position" class="form__select">
                                <option value="">Все должности</option>
                                <?php foreach ($positions as $position): ?>
                                    <option value="<?php echo escape($position); ?>" 
                                            <?php echo $position_filter === $position ? 'selected' : ''; ?>>
                                        <?php echo escape($position); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filters__group">
                            <button type="submit" class="btn">Фильтровать</button>
                            <a href="employees.php" class="btn btn--secondary">Сбросить</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card__header">
                    <div class="flex justify-between align-center">
                        <span><?php echo isAdmin() ? 'Все сотрудники' : 'Мои сотрудники'; ?></span>
                        <a href="add_employee.php" class="btn btn--success">Добавить сотрудника</a>
                    </div>
                </div>
                <div class="card__body">
                    <?php if (empty($employees)): ?>
                        <p class="text-center">Сотрудники не найдены.</p>
                    <?php else: ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                            <?php foreach ($employees as $employee): ?>
                                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 1.5rem; background: #f9f9f9;">
                                    <h3 style="margin-bottom: 0.5rem; color: #2c3e50;"><?php echo escape($employee['name']); ?></h3>
                                    <p style="color: #3498db; font-weight: bold; margin-bottom: 1rem;"><?php echo escape($employee['position']); ?></p>
                                    
                                    <div style="margin-bottom: 0.5rem;">
                                        <strong>Email:</strong> 
                                        <a href="mailto:<?php echo escape($employee['email']); ?>" style="color: #3498db;">
                                            <?php echo escape($employee['email']); ?>
                                        </a>
                                    </div>
                                    
                                    <?php if ($employee['phone']): ?>
                                        <div style="margin-bottom: 1rem;">
                                            <strong>Телефон:</strong> 
                                            <a href="tel:<?php echo escape($employee['phone']); ?>" style="color: #3498db;">
                                    <?php echo escape($employee['phone']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php
                                    // Получаем проекты сотрудника
                                    $stmt = $pdo->prepare("
                                        SELECT p.title, pe.role 
                                        FROM project_employees pe 
                                        JOIN projects p ON pe.project_id = p.id 
                                        WHERE pe.employee_id = ? 
                                        ORDER BY pe.assigned_at DESC 
                                        LIMIT 3
                                    ");
                                    $stmt->execute([$employee['id']]);
                                    $employee_projects = $stmt->fetchAll();
                                    ?>
                                    
                                    <?php if (!empty($employee_projects)): ?>
                                        <div>
                                            <strong>Текущие проекты:</strong>
                                            <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                                                <?php foreach ($employee_projects as $proj): ?>
                                                    <li style="margin-bottom: 0.25rem;">
                                                        <?php echo escape($proj['title']); ?>
                                                        <small style="color: #666;">(<?php echo escape($proj['role']); ?>)</small>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="mt-2">
                                        <a href="edit_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn--warning">Редактировать</a>
                                        <a href="?delete=<?php echo $employee['id']; ?>" class="btn btn--danger" 
                                           onclick="return confirm('Вы уверены, что хотите удалить этого сотрудника?')">Удалить</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
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

    <script>
        // Автоматическая отправка формы при изменении фильтров
        document.getElementById('position').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</body>
</html>