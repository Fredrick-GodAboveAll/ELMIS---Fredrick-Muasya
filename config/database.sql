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
  `code` VARCHAR(10) UNIQUE, -- short code, e.g. 'ADMIN', 'ENG'
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


-- -----------------------------------------------------------
-- Financial Years
-- -----------------------------------------------------------

CREATE TABLE financial_years (
id INT AUTO_INCREMENT PRIMARY KEY,
label VARCHAR(9) NOT NULL UNIQUE, -- e.g. '2025/2026'
start_date DATE NOT NULL, -- 1 July
end_date DATE NOT NULL, -- 30 June
is_current BOOLEAN NOT NULL DEFAULT 0
);


-- -----------------------------------------------------------
-- Developer Guide: Adding Tables, Columns, and Inserts
-- -----------------------------------------------------------
-- This section provides conventions, examples, and best practices
-- for adding new tables and data to this project.
-- Place migration .sql files under `database/migrations/` and
-- keep `config/database.sql` as the canonical schema snapshot.

/*
Conventions
- Use snake_case for table and column names.
- Use singular or plural table names consistently (current schema uses plural: `users`, `employees`).
- Use explicit column types (e.g., INT UNSIGNED, VARCHAR(255), TIMESTAMP, DATE).
- Use `id` or explicit primary key naming. For legacy tables we sometimes use `payroll_number` as primary key.
- Use `created_at` and `updated_at` TIMESTAMP columns with default values when appropriate.

Creating a new table (example)
--------------------------------
-- Create a migration file in `database/migrations/` such as `2026_08_15_create_projects_table.sql`.
-- Use the following template as a starting point:

-- Example: projects table
CREATE TABLE `projects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `owner_id` INT UNSIGNED DEFAULT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- If `owner_id` references `employees(id)` or similar, add the foreign key constraint:
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_owner` FOREIGN KEY (`owner_id`) REFERENCES `employees`(`payroll_number`)
    ON UPDATE CASCADE ON DELETE SET NULL;

Inserting seed data (example)
--------------------------------
-- Prefer INSERT ... VALUES in migration or seed SQL files. Use transactions when inserting multiple related rows.
START TRANSACTION;
INSERT INTO `projects` (`name`, `description`, `owner_id`, `start_date`) VALUES
('HR Onboarding', 'Onboarding project for new hires', 10737, '2026-09-01');
COMMIT;

Best practices and notes
-------------------------
- Always create a migration file for schema changes; do NOT edit historical migration files after they have been applied to environments.
- Keep `config/database.sql` updated as an authoritative snapshot (for new developers and CI setups).
- Use UUIDs only when necessary; the project predominantly uses integer keys.
- When adding foreign keys, choose appropriate `ON UPDATE` and `ON DELETE` behaviors (CASCADE, SET NULL, RESTRICT) depending on business logic.
- Add indexes for columns used in WHERE/JOIN clauses to improve query performance. Add `INDEX` lines in the CREATE TABLE statement.
- Wrap multi-statement migrations in `START TRANSACTION; ... COMMIT;` where supported to avoid partial schema application.
- Validate new schema locally by importing the migration into a test database and running application integration tests.

Rolling back changes
---------------------
- For simple additions, use `DROP TABLE IF EXISTS table_name;` in a rollback migration.
- For column removals, prefer creating a new migration that ALTERs the table to DROP the column, rather than editing old migrations.
- Keep a clear changelog message in the migration filename and file header comment.

Data migrations and transformations
-----------------------------------
- When modifying existing columns (type/nullable), create a data migration that:
  1. Adds the new column (temporary),
  2. Migrates and cleans data into the new column,
  3. Drops old column and renames new column as needed.

Testing schema changes
-----------------------
- Run the migration against a fresh local database created from `config/database.sql` plus your new migration to verify no conflicts.
- Add tests (integration or migration tests) that confirm expected table structures and constraints.

Version control and code review
-------------------------------
- Commit migration files with descriptive names and short headers explaining intent.
- Include SQL examples or notes if the migration requires manual actions in production (e.g., long-running conversions).

Security and sanitation
------------------------
- Avoid putting sensitive secrets or plaintext passwords in migration files.
- Use prepared statements in application code when inserting or selecting data — never interpolate user input directly into SQL.

If you want, I can:
- Create a sample migration file `database/migrations/2026_08_15_create_projects_table.sql` based on the example above.
- Add a small `scripts/` helper to run migrations locally with `mysql` CLI.
*/