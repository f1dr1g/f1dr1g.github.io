<?php
require_once 'config.php';

// Проверяем авторизацию и права администратора
if (!isLoggedIn() || !isAdmin()) {
    redirect('../index.php');
}

$message = '';
$message_type = '';

// Обработка удаления пользователя
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $user_id = (int)$_GET['delete'];
    
    // Нельзя удалить самого себя
    if ($user_id !== $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$user_id])) {
            $message = 'Пользователь успешно удален';
            $message_type = 'success';
        } else {
            $message = 'Ошибка при удалении пользователя';
            $message_type = 'error';
        }
    } else {
        $message = 'Нельзя удалить самого себя';
        $message_type = 'warning';
    }
}

// Обработка изменения роли
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_role'])) {
    $user_id = (int)$_POST['user_id'];
    $new_role = $_POST['role'];
    
    if ($user_id !== $_SESSION['user_id'] && in_array($new_role, ['user', 'admin'])) {
        $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        if ($stmt->execute([$new_role, $user_id])) {
            $message = 'Роль пользователя успешно изменена';
            $message_type = 'success';
        } else {
            $message = 'Ошибка при изменении роли';
            $message_type = 'error';
        }
    }
}

// Получаем всех пользователей с их статистикой
$stmt = $pdo->query("
    SELECT u.*, 
           COUNT(p.id) as projects_count,
           MAX(p.created_at) as last_project_date
    FROM users u 
    LEFT JOIN projects p ON u.id = p.user_id 
    GROUP BY u.id 
    ORDER BY u.created_at DESC
");
$users = $stmt->fetchAll();

$page_title = 'Управление пользователями';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - IT Company</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header__container">
                <img src="logo.png" width="100" height="auto" alt="Логотип сайта">
                <nav class="header__nav">
                    <a href="../index.php" class="header__link">Главная</a>
                    <a href="../about.php" class="header__link">О нас</a>
                    <a href="../services.php" class="header__link">Услуги</a>
                    <a href="../projects.php" class="header__link">Проекты</a>
                    <a href="../employees.php" class="header__link">Сотрудники</a>
                    <a href="users.php" class="header__link header__link--active">Пользователи</a>
                    <a href="../logout.php" class="header__link">Выход (<?php echo escape($_SESSION['username']); ?>)</a>
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

            <div class="card">
                <div class="card__header">
                    Управление пользователями
                </div>
                <div class="card__body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table__header">
                                <tr>
                                    <th class="table__cell">ID</th>
                                    <th class="table__cell">Пользователь</th>
                                    <th class="table__cell">Email</th>
                                    <th class="table__cell">Роль</th>
                                    <th class="table__cell">Проекты</th>
                                    <th class="table__cell">Регистрация</th>
                                    <th class="table__cell">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr class="table__row">
                                        <td class="table__cell"><?php echo $user['id']; ?></td>
                                        <td class="table__cell">
                                            <strong><?php echo escape($user['username']); ?></strong>
                                            <?php if ($user['id'] === $_SESSION['user_id']): ?>
                                                <span style="color: #27ae60; font-size: 0.8rem;">(Вы)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="table__cell"><?php echo escape($user['email']); ?></td>
                                        <td class="table__cell">
                                            <?php if ($user['id'] === $_SESSION['user_id']): ?>
                                                <span style="color: #e74c3c; font-weight: bold;">
                                                    <?php echo $user['role'] === 'admin' ? 'Администратор' : 'Пользователь'; ?>
                                                </span>
                                            <?php else: ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <select name="role" onchange="this.form.submit()" class="form__select" style="width: auto; padding: 0.25rem;">
                                                        <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Пользователь</option>
                                                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Администратор</option>
                                                    </select>
                                                    <input type="hidden" name="change_role" value="1">
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td class="table__cell">
                                            <strong><?php echo $user['projects_count']; ?></strong>
                                            <?php if ($user['last_project_date']): ?>
                                                <br><small>Последний: <?php echo date('d.m.Y', strtotime($user['last_project_date'])); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="table__cell">
                                            <?php echo date('d.m.Y', strtotime($user['created_at'])); ?>
                                        </td>
                                        <td class="table__cell">
                                            <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                                <a href="?delete=<?php echo $user['id']; ?>" class="btn btn--danger" 
                                                   onclick="return confirm('Вы уверены, что хотите удалить этого пользователя? Все его проекты также будут удалены!')">
                                                   Удалить
                                                </a>
                                            <?php else: ?>
                                                <span style="color: #95a5a6;">Текущий пользователь</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Статистика -->
            <div class="card">
                <div class="card__header">
                    Общая статистика
                </div>
                <div class="card__body">
                    <?php
                    $stats = [
                        'total_users' => count($users),
                        'admin_users' => count(array_filter($users, fn($u) => $u['role'] === 'admin')),
                        'regular_users' => count(array_filter($users, fn($u) => $u['role'] === 'user')),
                        'total_projects' => array_sum(array_column($users, 'projects_count'))
                    ];
                    ?>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div style="text-align: center; padding: 1rem; background: #ecf0f1; border-radius: 8px;">
                            <h3 style="color: #3498db; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $stats['total_users']; ?></h3>
                            <p>Всего пользователей</p>
                        </div>
                        
                        <div style="text-align: center; padding: 1rem; background: #ecf0f1; border-radius: 8px;">
                            <h3 style="color: #e74c3c; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $stats['admin_users']; ?></h3>
                            <p>Администраторов</p>
                        </div>
                        
                        <div style="text-align: center; padding: 1rem; background: #ecf0f1; border-radius: 8px;">
                            <h3 style="color: #27ae60; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $stats['regular_users']; ?></h3>
                            <p>Обычных пользователей</p>
                        </div>
                        
                        <div style="text-align: center; padding: 1rem; background: #ecf0f1; border-radius: 8px;">
                            <h3 style="color: #f39c12; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $stats['total_projects']; ?></h3>
                            <p>Всего проектов</p>
                        </div>
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