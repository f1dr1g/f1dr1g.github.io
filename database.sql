-- Создание базы данных
CREATE DATABASE IF NOT EXISTS itCompany CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE itCompany;

-- Таблица пользователей
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица сотрудников (с привязкой к пользователю)
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Таблица проектов
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    status ENUM('planning', 'in_progress', 'completed', 'on_hold') DEFAULT 'planning',
    start_date DATE,
    end_date DATE,
    budget DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Таблица назначений сотрудников к проектам
CREATE TABLE project_employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    employee_id INT NOT NULL,
    role VARCHAR(100),
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    UNIQUE KEY unique_assignment (project_id, employee_id)
);

-- Вставка тестовых данных
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('john_doe', 'john@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Тестовые сотрудники для admin
INSERT INTO employees (user_id, name, position, email, phone) VALUES 
(1, 'Алексей Петров', 'Frontend Developer', 'alexey@company.com', '+7-900-123-4567'),
(1, 'Мария Иванова', 'Backend Developer', 'maria@company.com', '+7-900-234-5678');

-- Тестовые сотрудники для john_doe
INSERT INTO employees (user_id, name, position, email, phone) VALUES 
(2, 'Дмитрий Сидоров', 'UI/UX Designer', 'dmitry@company.com', '+7-900-345-6789'),
(2, 'Елена Козлова', 'Project Manager', 'elena@company.com', '+7-900-456-7890'),
(2, 'Андрей Новиков', 'DevOps Engineer', 'andrey@company.com', '+7-900-567-8901');