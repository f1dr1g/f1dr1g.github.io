<?php
require_once 'config.php';

// Проверяем авторизацию
if (!isLoggedIn()) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Обработка удаления проекта
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $project_id = (int)$_GET['delete'];
    
    // Проверяем права доступа
    if (isAdmin()) {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
    }
    
    $params = isAdmin() ? [$project_id] : [$project_id, $_SESSION['user_id']];
    
    if ($stmt->execute($params)) {
        $message = 'Проект успешно удален';
        $message_type = 'success';
    } else {
        $message = 'Ошибка при удалении проекта';
        $message_type = 'error';
    }
}

// Фильтры
$status_filter = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');

// Построение запроса
$where_conditions = [];
$params = [];

if (!isAdmin()) {
    $where_conditions[] = "p.user_id = ?";
    $params[] = $_SESSION['user_id'];
}

if ($status_filter) {
    $where_conditions[] = "p.status = ?";
    $params[] = $status_filter;
}

if ($search) {
    $where_conditions[] = "(p.title LIKE ? OR p.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Получаем проекты
$sql = "SELECT p.*, u.username 
        FROM projects p 
        LEFT JOIN users u ON p.user_id = u.id 
        $where_clause 
        ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$projects = $stmt->fetchAll();

$page_title = 'Проекты';
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
                    <a href="projects.php" class="header__link header__link--active">Проекты</a>
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
            <?php if ($message): ?>
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
                                   value="<?php echo escape($search); ?>" placeholder="Название или описание">
                        </div>
                        
                        <div class="filters__group">
                            <label for="status" class="form__label">Статус:</label>
                            <select id="status" name="status" class="form__select">
                                <option value="">Все статусы</option>
                                <option value="planning" <?php echo $status_filter === 'planning' ? 'selected' : ''; ?>>Планирование</option>
                                <option value="in_progress" <?php echo $status_filter === 'in_progress' ? 'selected' : ''; ?>>В работе</option>
                                <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Завершен</option>
                                <option value="on_hold" <?php echo $status_filter === 'on_hold' ? 'selected' : ''; ?>>Приостановлен</option>
                            </select>
                        </div>
                        
                        <div class="filters__group">
                            <button type="submit" class="btn">Фильтровать</button>
                            <a href="projects.php" class="btn btn--secondary">Сбросить</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card__header">
                    <div class="flex justify-between align-center">
                        <span><?php echo isAdmin() ? 'Все проекты' : 'Мои проекты'; ?></span>
                        <a href="add_project.php" class="btn btn--success">Добавить проект</a>
                    </div>
                </div>
                <div class="card__body">
                    <?php if (empty($projects)): ?>
                        <p class="text-center">Проекты не найдены.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table__header">
                                    <tr>
                                        <th class="table__cell">Название</th>
                                        <th class="table__cell">Статус</th>
                                        <th class="table__cell">Бюджет</th>
                                        <th class="table__cell">Даты</th>
                                        <?php if (isAdmin()): ?>
                                            <th class="table__cell">Владелец</th>
                                        <?php endif; ?>
                                        <th class="table__cell">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($projects as $project): ?>
                                        <tr class="table__row">
                                            <td class="table__cell">
                                                <strong><?php echo escape($project['title']); ?></strong>
                                                <?php if ($project['description']): ?>
                                                    <br><small><?php echo escape(substr($project['description'], 0, 100)); ?>...</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="table__cell">
                                                <?php
                                                $status_labels = [
                                                    'planning' => 'Планирование',
                                                    'in_progress' => 'В работе',
                                                    'completed' => 'Завершен',
                                                    'on_hold' => 'Приостановлен'
                                                ];
                                                echo $status_labels[$project['status']] ?? $project['status'];
                                                ?>
                                            </td>
                                            <td class="table__cell">
                                                <?php echo $project['budget'] ? number_format($project['budget'], 0, ',', ' ') . ' ₽' : '-'; ?>
                                            </td>
                                            <td class="table__cell">
                                                <?php if ($project['start_date']): ?>
                                                    <small>Начало: <?php echo date('d.m.Y', strtotime($project['start_date'])); ?></small><br>
                                                <?php endif; ?>
                                                <?php if ($project['end_date']): ?>
                                                    <small>Конец: <?php echo date('d.m.Y', strtotime($project['end_date'])); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <?php if (isAdmin()): ?>
                                                <td class="table__cell"><?php echo escape($project['username']); ?></td>
                                            <?php endif; ?>
                                            <td class="table__cell">
                                                <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn btn--warning">Редактировать</a>
                                                <a href="assign_employees.php?id=<?php echo $project['id']; ?>" class="btn btn--secondary">Сотрудники</a>
                                                <a href="?delete=<?php echo $project['id']; ?>" class="btn btn--danger" 
                                                   onclick="return confirm('Вы уверены, что хотите удалить этот проект?')">Удалить</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
        document.getElementById('status').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</body>
</html>