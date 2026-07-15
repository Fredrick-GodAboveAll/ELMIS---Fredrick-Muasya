CREATE DATABASE IF NOT EXISTS `leave_management`
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `leave_management`;

-- Users table
CREATE TABLE `users` (
 `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
 `name` VARCHAR(100) NOT NULL,
 `email` VARCHAR(100) NOT NULL UNIQUE,
 `password` VARCHAR(255) NOT NULL,
 `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
 `last_login` TIMESTAMP NULL,
 `failed_login_attempts` INT DEFAULT 0,
 `locked_until` TIMESTAMP NULL,
 `email_verified` BOOLEAN DEFAULT FALSE,
 `email_verified_at` TIMESTAMP NULL,
 `password_changed_at` TIMESTAMP NULL,
 `session_started_at` TIMESTAMP NULL,
 `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password resets table
CREATE TABLE `password_resets` (
 `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
 `email` VARCHAR(100) NOT NULL,
 `token` VARCHAR(64) NOT NULL,
 `expires_at` TIMESTAMP NOT NULL,
 `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 INDEX `idx_email` (`email`),
 INDEX `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Login attempts history table for audit
CREATE TABLE `login_attempts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `user_agent` TEXT,
  `success` BOOLEAN DEFAULT FALSE,
  `attempted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_attempted_at` (`attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Email verification tokens table
CREATE TABLE `email_verification_tokens` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `expires_at` TIMESTAMP NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default users (password = 'password')
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified`) VALUES
('Admin User', 'admin@example.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', TRUE),
('Regular User', 'user@example.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', TRUE);

-- -----------------------------------------------------------
-- Departments table (future linking)
-- -----------------------------------------------------------
CREATE TABLE `departments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL UNIQUE,
  `head_of_department` INT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Employees table (flat, CSV-ready)
-- -----------------------------------------------------------
CREATE TABLE `employees` (
  `payroll_number` INT UNSIGNED PRIMARY KEY,
  `full_name` VARCHAR(150) NOT NULL,
  `id_number` VARCHAR(30) NOT NULL,
  `gender` ENUM('M','F') NOT NULL,
  `age` TINYINT UNSIGNED NOT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `designation` VARCHAR(150) NOT NULL,
  `job_group` VARCHAR(10) NOT NULL,
  `employment_status` VARCHAR(20) DEFAULT NULL,
  `engagement_type` VARCHAR(50) NOT NULL,
  `rod_date` DATE DEFAULT NULL,
  `special_need` TINYINT UNSIGNED DEFAULT 0 COMMENT '0 = no disability, 4 = disability',
  `department_id` INT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Sample departments and employees
-- -----------------------------------------------------------
INSERT INTO `departments` (`name`, `head_of_department`) VALUES
('Human Resources', NULL),
('Finance', NULL);

INSERT INTO `employees` (
  payroll_number, full_name, id_number, gender, age,
  date_of_birth, designation, job_group, employment_status,
  engagement_type, rod_date, special_need, department_id
) VALUES
(10737, 'MR JULIUS ODHIAMBO MBOGAH', '84', 'M', 63,
  '1963-04-15', 'Deputy Director - HRM & Development', 'R', '1',
  'Permanent', '2026-11-04', 0, 1),
(10738, 'MS ALICE WANJIKU KAMAU', '12345678', 'F', 34,
  '1990-08-20', 'Accountant', 'K', '1', 'Permanent', '2045-03-15', 0, 2);