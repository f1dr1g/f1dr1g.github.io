<?php
require_once 'config.php';
$page_title = 'Услуги';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Управление проектами</title>
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
                    <a href="services.php" class="header__link header__link--active">Услуги</a>
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
                    Основные функции
                </div>
                <div class="card__body">
                    <p class="text-center" style="font-size: 1.1rem; margin-bottom: 2rem;">
                        Мы предлагаем удобный инструмент для управления проектами и сотрудниками
                    </p>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                        <!-- Управление проектами -->
                        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 2rem; background: white;">
                            <div style="width: 60px; height: 60px; background: #2ca1db; border-radius: 50%; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">📂</div>
                            <h3 style="color: #2c3e50; margin-bottom: 1rem;">Управление проектами</h3>
                            <p style="margin-bottom: 1.5rem; color: #666;">Создавайте проекты, устанавливайте сроки, назначайте ответственных и отслеживайте прогресс</p>
                            <h4 style="margin-bottom: 0.5rem;">Возможности:</h4>
                            <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem; color: #666;">
                                <li>Добавление этапов и задач</li>
                                <li>Контроль дедлайнов</li>
                                <li>Индивидуальные или командные проекты</li>
                                <li>Статусы: Новый, В работе, Завершён</li>
                            </ul>
                        </div>
                        <!-- Управление сотрудниками -->
                        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 2rem; background: white;">
                            <div style="width: 60px; height: 60px; background: #189a9f; border-radius: 50%; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">👥</div>
                            <h3 style="color: #2c3e50; margin-bottom: 1rem;">Управление сотрудниками</h3>
                            <p style="margin-bottom: 1.5rem; color: #666;">Добавляйте сотрудников, настраивайте роли и следите за их активностью в проектах</p>
                            <h4 style="margin-bottom: 0.5rem;">Возможности:</h4>
                            <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem; color: #666;">
                                <li>Добавление и удаление сотрудников</li>
                                <li>Назначение ролей (менеджер, разработчик, наблюдатель)</li>
                                <li>Отслеживание загруженности</li>
                                <li>Фильтрация по отделам и ролям</li>
                            </ul>
                        </div>
                        <!-- Фильтрация и поиск -->
                        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 2rem; background: white;">
                            <div style="width: 60px; height: 60px; background: #b3483d; border-radius: 50%; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🔍</div>
                            <h3 style="color: #2c3e50; margin-bottom: 1rem;">Фильтрация и поиск</h3>
                            <p style="margin-bottom: 1.5rem; color: #666;">Быстро находите нужные проекты и сотрудников с помощью фильтров и поиска</p>
                            <h4 style="margin-bottom: 0.5rem;">Возможности:</h4>
                            <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem; color: #666;">
                                <li>Фильтр по статусу, дате, ответственному лицу</li>
                                <li>Поиск по названию проекта или имени сотрудника</li>
                                <li>Группировка по категориям</li>
                                <li>Сортировка по приоритету</li>
                            </ul>
                        </div>
                    
                        <!-- Безопасность -->
                        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 2rem; background: white;">
                            <div style="width: 60px; height: 60px; background: #272250; border-radius: 50%; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🔒</div>
                            <h3 style="color: #2c3e50; margin-bottom: 1rem;">Безопасность</h3>
                            <p style="margin-bottom: 1.5rem; color: #666;">Ваши данные надёжно защищены и доступны только авторизованным пользователям</p>
                            <h4 style="margin-bottom: 0.5rem;">Возможности:</h4>
                            <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem; color: #666;">
                                <li>Регистрация через email и парольх</li>
                                <li>Пароли хранятся в зашифрованном виде</li>
                                <li>Только авторизованные пользователи видят данные</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card__header">
                    Как мы работаем
                </div>
                <div class="card__body">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                        <div style="text-align: center;">
                            <div style="width: 50px; height: 50px; background: #2ca1db; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">1</div>
                            <h4>Регистрация</h4>
                            <p style="color: #666; font-size: 0.9rem;">Создайте аккаунт и начните использовать систему</p>
                        </div>
                        <div style="text-align: center;">
                            <div style="width: 50px; height: 50px; background: #189a9f; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">2</div>
                            <h4>Настройка</h4>
                            <p style="color: #666; font-size: 0.9rem;">Добавьте проекты и сотрудников, настройте роли</p>
                        </div>
                        <div style="text-align: center;">
                            <div style="width: 50px; height: 50px; background: #b3483d; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">3</div>
                            <h4>Работа</h4>
                            <p style="color: #666; font-size: 0.9rem;">Назначайте задачи и следите за прогрессом</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!isLoggedIn()): ?>
                <div class="card">
                    <div class="card__body text-center">
                        <h3>Хотите попробовать?</h3>
                        <p>Зарегистрируйтесь и начните управлять проектами уже сегодня</p>
                        <a href="register.php" class="btn btn--success">Зарегистрироваться</a>
                        <a href="login.php" class="btn">Войти</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Управление проектами. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>