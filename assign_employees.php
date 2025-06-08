<?php
require_once 'config.php';

// Проверяем авторизацию
if (!isLoggedIn()) {
    redirect('login.php');
}

$project_id = (int)($_GET['id'] ?? 0);

if (!$project_id) {
    redirect('projects.php');
}

// Получаем проект
if (isAdmin()) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ? AND user_id = ?");
    $stmt->execute([$project_id, $_SESSION['user_id']]);
}

$project = $stmt->fetch();

if (!$project) {
    redirect('projects.php');
}

$message = '';
$message_type = '';

// Обработка назначения сотрудника
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['assign'])) {
        $employee_id = (int)$_POST['employee_id'];
        $role = trim($_POST['role'] ?? '');
        
        if ($employee_id && $role) {
            // Проверяем, не назначен ли уже этот сотрудник
            $stmt = $pdo->prepare("SELECT id FROM project_employees WHERE project_id = ? AND employee_id = ?");
            $stmt->execute([$project_id, $employee_id]);
            
            if (!$stmt->fetch()) {
                // Проверяем, принадлежит ли сотрудник текущему пользователю
                if (isAdmin()) {
                    $stmt = $pdo->prepare("SELECT id FROM employees WHERE id = ?");
                    $stmt->execute([$employee_id]);
                } else {
                    $stmt = $pdo->prepare("SELECT id FROM employees WHERE id = ? AND user_id = ?");
                    $stmt->execute([$employee_id, $_SESSION['user_id']]);
                }
                
                if ($stmt->fetch()) {
                    $stmt = $pdo->prepare("INSERT INTO project_employees (project_id, employee_id, role) VALUES (?, ?, ?)");
                    if ($stmt->execute([$project_id, $employee_id, $role])) {
                        $message = 'Сотрудник успешно назначен на проект';
                        $message_type = 'success';
                    } else {
                        $message = 'Ошибка при назначении сотрудника';
                        $message_type = 'error';
                    }
                } else {
                    $message = 'У вас нет доступа к этому сотруднику';
                    $message_type = 'error';
                }
            } else {
                $message = 'Этот сотрудник уже назначен на проект';
                $message_type = 'warning';
            }
        }
    } elseif (isset($_POST['remove'])) {
        $assignment_id = (int)$_POST['assignment_id'];
        
        $stmt = $pdo->prepare("DELETE FROM project_employees WHERE id = ? AND project_id = ?");
        if ($stmt->execute([$assignment_id, $project_id])) {
            $message = 'Сотрудник удален с проекта';
            $message_type = 'success';
        } else {
            $message = 'Ошибка при удалении сотрудника';
            $message_type = 'error';
        }
    }
}

// Получаем всех сотрудников текущего пользователя
if (isAdmin()) {
    $stmt = $pdo->query("SELECT * FROM employees ORDER BY name");
} else {
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE user_id = ? ORDER BY name");
    $stmt->execute([$_SESSION['user_id']]);
}
$all_employees = $stmt->fetchAll();

// Получаем назначенных сотрудников
$stmt = $pdo->prepare("
    SELECT pe.*, e.name, e.position, e.email 
    FROM project_employees pe 
    JOIN employees e ON pe.employee_id = e.id 
    WHERE pe.project_id = ? 
    ORDER BY pe.assigned_at DESC
");
$stmt->execute([$project_id]);
$assigned_employees = $stmt->fetchAll();
$page_title = 'Назначить сотрудников';
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
            <?php if ($message): ?>
                <div class="alert alert--<?php echo $message_type; ?>">
                    <?php echo escape($message); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card__header">
                    Назначение сотрудников: <?php echo escape($project['title']); ?>
                </div>
                <div class="card__body">
                    <?php if (empty($all_employees)): ?>
                        <div class="alert alert--warning">
                            У вас пока нет сотрудников. <a href="add_employee.php">Добавьте сотрудников</a> перед назначением на проект.
                        </div>
                    <?php else: ?>
                        <form method="POST" class="form">
                            <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
                                <div class="form__group">
                                    <label for="employee_id" class="form__label">Сотрудник:</label>
                                    <select id="employee_id" name="employee_id" class="form__select" required>
                                        <option value="">Выберите сотрудника</option>
                                        <?php foreach ($all_employees as $employee): ?>
                                            <?php
                                            // Проверяем, не назначен ли уже этот сотрудник
                                            $already_assigned = false;
                                            foreach ($assigned_employees as $assigned) {
                                                if ($assigned['employee_id'] == $employee['id']) {
                                                    $already_assigned = true;
                                                    break;
                                                }
                                            }
                                            if ($already_assigned) continue;
                                            ?>
                                            <option value="<?php echo $employee['id']; ?>">
                                                <?php echo escape($employee['name'] . ' - ' . $employee['position']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form__group">
                                    <label for="role" class="form__label">Роль в проекте:</label>
                                    <input type="text" id="role" name="role" class="form__input" 
                                           placeholder="Например: Ведущий разработчик" required>
                                </div>
                                
                                <div class="form__group">
                                    <button type="submit" name="assign" class="btn btn--success">Назначить</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card__header">
                    Назначенные сотрудники
                </div>
                <div class="card__body">
                    <?php if (empty($assigned_employees)): ?>
                        <p class="text-center">На проект пока не назначены сотрудники.</p>
                    <?php else: ?>
                        <table class="table">
                            <thead class="table__header">
                                <tr>
                                    <th class="table__cell">Сотрудник</th>
                                    <th class="table__cell">Должность</th>
                                    <th class="table__cell">Роль в проекте</th>
                                    <th class="table__cell">Email</th>
                                    <th class="table__cell">Назначен</th>
                                    <th class="table__cell">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assigned_employees as $assignment): ?>
                                    <tr class="table__row">
                                        <td class="table__cell"><?php echo escape($assignment['name']); ?></td>
                                        <td class="table__cell"><?php echo escape($assignment['position']); ?></td>
                                        <td class="table__cell"><?php echo escape($assignment['role']); ?></td>
                                        <td class="table__cell"><?php echo escape($assignment['email']); ?></td>
                                        <td class="table__cell"><?php echo date('d.m.Y', strtotime($assignment['assigned_at'])); ?></td>
                                        <td class="table__cell">
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="assignment_id" value="<?php echo $assignment['id']; ?>">
                                                <button type="submit" name="remove" class="btn btn--danger" 
                                                        onclick="return confirm('Удалить сотрудника с проекта?')">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-2">
                <a href="projects.php" class="btn btn--secondary">Вернуться к проектам</a>
                <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn">Редактировать проект</a>
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