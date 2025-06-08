<?php
require_once 'config.php';

$page_title = 'Главная';
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
                    <a href="index.php" class="header__link header__link--active">Главная</a>
                    <a href="about.php" class="header__link">О нас</a>
                    <a href="services.php" class="header__link">Услуги</a>
                    <?php if (isLoggedIn()): ?>
                        <a href="projects.php" class="header__link">Проекты</a>
                        <a href="employees.php" class="header__link">Сотрудники</a>
                        <?php if (isAdmin()): ?>
                            <a href="admin_users.php" class="header__link">Пользователи</a>
                        <?php endif; ?>
                        <a href="logout.php" class="header__link">Выход (<?php echo escape($_SESSION['username']); ?>)</a>
                    <?php else: ?>
                        <a href="login.php" class="header__link">Вход</a>
                        <a href="register.php" class="header__link">Регистрация</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="card">
                <div class="card__header">
                    Добро пожаловать в IT Company
                </div>
                <div class="card__body">
                    <h2>Ваш надежный партнер в мире IT</h2>
                    <p>Мы предоставляем полный спектр IT-услуг для развития вашего бизнеса:</p>
                    <ul style="margin: 1rem 0; padding-left: 2rem;">
                        <li>Разработка веб-приложений</li>
                        <li>Мобильная разработка</li>
                        <li>UI/UX дизайн</li>
                        <li>DevOps и администрирование</li>
                        <li>Консультации по IT-стратегии</li>
                    </ul>
                    
                    <?php if (!isLoggedIn()): ?>
                        <div class="text-center mt-2">
                            <a href="register.php" class="btn btn--success">Зарегистрироваться</a>
                            <a href="login.php" class="btn">Войти в систему</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center mt-2">
                            <a href="projects.php" class="btn">Мои проекты</a>
                            <a href="employees.php" class="btn btn--secondary">Сотрудники</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (isLoggedIn()): ?>
                <div class="card">
                    <div class="card__header">
                        Быстрая статистика
                    </div>
                    <div class="card__body">
                        <?php
                        // Получаем статистику для текущего пользователя
                        if (isAdmin()) {
                            $stmt = $pdo->query("SELECT COUNT(*) as total_projects FROM projects");
                            $total_projects = $stmt->fetch()['total_projects'];
                            
                            $stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users WHERE role = 'user'");
                            $total_users = $stmt->fetch()['total_users'];
                            
                            $stmt = $pdo->query("SELECT COUNT(*) as total_employees FROM employees");
                            $total_employees = $stmt->fetch()['total_employees'];
                        } else {
                            $stmt = $pdo->prepare("SELECT COUNT(*) as total_projects FROM projects WHERE user_id = ?");
                            $stmt->execute([$_SESSION['user_id']]);
                            $total_projects = $stmt->fetch()['total_projects'];
                            $total_users = null;
                            
                            $stmt = $pdo->prepare("SELECT COUNT(*) as total_employees FROM employees WHERE user_id = ?");
                            $stmt->execute([$_SESSION['user_id']]);
                            $total_employees = $stmt->fetch()['total_employees'];
                            
                        }
                        ?>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <div style="text-align: center; padding: 1rem; background: #ecf0f1; border-radius: 8px;">
                                <h3 style="color: #272250; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $total_projects; ?></h3>
                                <p><?php echo isAdmin() ? 'Всего проектов' : 'Моих проектов'; ?></p>
                            </div>
                            
                            <div style="text-align: center; padding: 1rem; background: #ecf0f1; border-radius: 8px;">
                                <h3 style="color: #189a9f; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $total_employees; ?></h3>
                                <p>Сотрудников</p>
                            </div>
                            
                            <?php if (isAdmin()): ?>
                                <div style="text-align: center; padding: 1rem; background: #ecf0f1; border-radius: 8px;">
                                    <h3 style="color: #b3483d; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $total_users; ?></h3>
                                    <p>Пользователей</p>
                                </div>
                            <?php endif; ?>
                        </div>
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