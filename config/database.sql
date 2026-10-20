-- Canonical schema for the Leave Management system.
-- Use this file to create and initialize the application database.
-- Example: `mysql -u root -p < config/database.sql`
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
-- Departments table
-- -----------------------------------------------------------

CREATE TABLE `departments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_departments_code` (`code`),
  UNIQUE KEY `uq_departments_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Sample departments
-- -----------------------------------------------------------
INSERT INTO `departments` (`code`, `name`, `is_active`) VALUES
('HRM', 'Human Resources', 1),
('FCE', 'Finance', 1),
('ENG', 'Energy', 1),
('OPS', 'Operations', 1);

-- -----------------------------------------------------------
-- Typed lookup tables for employee classification
-- -----------------------------------------------------------

CREATE TABLE `genders` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_genders_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employment_terms` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(20) NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_employment_terms_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employment_statuses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(20) NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_employment_statuses_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `job_groups` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_job_groups_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `special_needs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(20) NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_special_needs_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `genders` (`code`, `label`, `is_active`) VALUES
('M', 'Male', 1),
('F', 'Female', 1);

INSERT INTO `employment_terms` (`code`, `label`, `is_active`) VALUES
('Permanent', 'Permanent', 1),
('Contract', 'Contract', 1),
('Intern', 'Intern', 1);

INSERT INTO `employment_statuses` (`code`, `label`, `description`, `is_active`) VALUES
('probation', 'Probation', 'Employee is on probation', 1),
('permanent', 'Confirmed (P&P)', 'Permanent and pensionable employee', 1),
('contract', 'Contract', 'Fixed-term contract employee', 1),
('suspended', 'Suspended', 'Suspended from active service', 1),
('resigned', 'Resigned', 'Employee has resigned', 1),
('retiring', 'Retiring', 'Employee is approaching retirement', 1),
('retired', 'Retired', 'Employee has retired', 1);

INSERT INTO `job_groups` (`code`, `label`, `is_active`) VALUES
('H', 'H', 1),
('J', 'J', 1),
('K', 'K', 1),
('L', 'L', 1),
('M', 'M', 1),
('N', 'N', 1),
('P', 'P', 1),
('Q', 'Q', 1),
('R', 'R', 1);

INSERT INTO `special_needs` (`code`, `label`, `is_active`) VALUES
('none', 'None', 1),
('pwd', 'PWD', 1);

-- -----------------------------------------------------------
-- Employees table
-- -----------------------------------------------------------

CREATE TABLE `employees` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `payroll_number` VARCHAR(20) NOT NULL,
  `full_name` VARCHAR(150) NOT NULL,
  `id_number` VARCHAR(30) NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `designation` VARCHAR(150) NOT NULL,
  `gender_id` INT UNSIGNED NOT NULL,
  `employment_term_id` INT UNSIGNED NOT NULL,
  `employment_status_id` INT UNSIGNED NOT NULL,
  `job_group_id` INT UNSIGNED NOT NULL,
  `special_need_id` INT UNSIGNED DEFAULT NULL,
  `department_id` INT UNSIGNED NOT NULL,
  `rod_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_employees_payroll_number` (`payroll_number`),
  UNIQUE KEY `uq_employees_id_number` (`id_number`),
  KEY `idx_employees_gender_id` (`gender_id`),
  KEY `idx_employees_employment_term_id` (`employment_term_id`),
  KEY `idx_employees_employment_status_id` (`employment_status_id`),
  KEY `idx_employees_job_group_id` (`job_group_id`),
  KEY `idx_employees_special_need_id` (`special_need_id`),
  KEY `idx_employees_department_id` (`department_id`),
  CONSTRAINT `fk_employees_gender`
    FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_employees_employment_term`
    FOREIGN KEY (`employment_term_id`) REFERENCES `employment_terms` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_employees_employment_status`
    FOREIGN KEY (`employment_status_id`) REFERENCES `employment_statuses` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_employees_job_group`
    FOREIGN KEY (`job_group_id`) REFERENCES `job_groups` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_employees_special_need`
    FOREIGN KEY (`special_need_id`) REFERENCES `special_needs` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_employees_department`
    FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `employees` (
  `payroll_number`, `full_name`, `id_number`, `date_of_birth`, `designation`,
  `gender_id`, `employment_term_id`, `employment_status_id`, `job_group_id`,
  `special_need_id`, `department_id`, `rod_date`
) VALUES
('20001', 'MS AMINA HASSAN', '11111111', '1990-03-10', 'HR Officer',
  (SELECT `id` FROM `genders` WHERE `code` = 'F'),
  (SELECT `id` FROM `employment_terms` WHERE `code` = 'Permanent'),
  (SELECT `id` FROM `employment_statuses` WHERE `code` = 'permanent'),
  (SELECT `id` FROM `job_groups` WHERE `code` = 'J'),
  (SELECT `id` FROM `special_needs` WHERE `code` = 'none'),
  1,
  '2045-01-01'),

('20002', 'MR JOHN OTIENO', '22222222', '2001-06-15', 'Intern',
  (SELECT `id` FROM `genders` WHERE `code` = 'M'),
  (SELECT `id` FROM `employment_terms` WHERE `code` = 'Intern'),
  (SELECT `id` FROM `employment_statuses` WHERE `code` = 'probation'),
  (SELECT `id` FROM `job_groups` WHERE `code` = 'H'),
  (SELECT `id` FROM `special_needs` WHERE `code` = 'none'),
  2,
  '2027-06-15'),

('20003', 'MS GRACE MWANGI', '33333333', '1967-11-20', 'Energy Analyst',
  (SELECT `id` FROM `genders` WHERE `code` = 'F'),
  (SELECT `id` FROM `employment_terms` WHERE `code` = 'Permanent'),
  (SELECT `id` FROM `employment_statuses` WHERE `code` = 'retiring'),
  (SELECT `id` FROM `job_groups` WHERE `code` = 'K'),
  (SELECT `id` FROM `special_needs` WHERE `code` = 'pwd'),
  3,
  '2026-12-31'),

('20004', 'MR PETER KAMAU', '44444444', '1993-08-05', 'Operations Officer',
  (SELECT `id` FROM `genders` WHERE `code` = 'M'),
  (SELECT `id` FROM `employment_terms` WHERE `code` = 'Contract'),
  (SELECT `id` FROM `employment_statuses` WHERE `code` = 'contract'),
  (SELECT `id` FROM `job_groups` WHERE `code` = 'L'),
  (SELECT `id` FROM `special_needs` WHERE `code` = 'none'),
  4,
  '2027-08-05'),

('20005', 'MS MARY WANJIKU', '55555555', '1996-04-25', 'HR Assistant',
  (SELECT `id` FROM `genders` WHERE `code` = 'F'),
  (SELECT `id` FROM `employment_terms` WHERE `code` = 'Permanent'),
  (SELECT `id` FROM `employment_statuses` WHERE `code` = 'permanent'),
  (SELECT `id` FROM `job_groups` WHERE `code` = 'J'),
  (SELECT `id` FROM `special_needs` WHERE `code` = 'none'),
  1,
  '2045-04-25');

-- -----------------------------------------------------------
-- Financial Years (1 July to 30 June)
-- -----------------------------------------------------------

CREATE TABLE `financial_years` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(9) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `is_current` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_financial_year_label` (`label`),
  UNIQUE KEY `uq_financial_year_dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Leave types table
-- -----------------------------------------------------------

CREATE TABLE `leave_types` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `calculation_method` ENUM('working_days', 'calendar_days') NOT NULL DEFAULT 'working_days',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_leave_type_name` (`name`),
  KEY `idx_leave_types_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `leave_types` (`name`, `calculation_method`, `is_active`) VALUES
('Annual Leave', 'working_days', 1),
('Sick Leave', 'working_days', 1),
('Maternity Leave', 'calendar_days', 1),
('Paternity Leave', 'working_days', 1),
('Study Leave', 'working_days', 1),
('Leave Without Pay', 'working_days', 1);

-- -----------------------------------------------------------
-- Leave management schema aligned to ELMIS employee identity
-- employee references use `employee_id` and not `payroll_number`.
-- -----------------------------------------------------------

CREATE TABLE `holiday_lists` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_holiday_list_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `holidays` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `holiday_list_id` INT UNSIGNED NOT NULL,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `holiday_date` DATE NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `is_weekly_off` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_holiday_list_financial_year_date` (`holiday_list_id`, `financial_year_id`, `holiday_date`),
  CONSTRAINT `fk_holidays_holiday_list`
    FOREIGN KEY (`holiday_list_id`) REFERENCES `holiday_lists` (`id`)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_holidays_financial_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_entitlements` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `leave_type_id` INT UNSIGNED NOT NULL,
  `entitlement` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `pro_rata_allowed` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_entitlement_year_type` (`financial_year_id`, `leave_type_id`),
  CONSTRAINT `fk_entitlement_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_entitlement_type`
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_policies` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_leave_policy_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_policy_details` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `leave_policy_id` INT UNSIGNED NOT NULL,
  `leave_entitlement_id` INT UNSIGNED NOT NULL,
  `allocation` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `carry_forward` TINYINT(1) NOT NULL DEFAULT 0,
  `carry_forward_limit` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_policy_entitlement` (`leave_policy_id`, `leave_entitlement_id`),
  KEY `idx_policy_details_policy` (`leave_policy_id`),
  KEY `idx_policy_details_entitlement` (`leave_entitlement_id`),
  CONSTRAINT `fk_policy_details_policy`
    FOREIGN KEY (`leave_policy_id`) REFERENCES `leave_policies` (`id`)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_policy_details_entitlement`
    FOREIGN KEY (`leave_entitlement_id`) REFERENCES `leave_entitlements` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_policy_assignments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT UNSIGNED NOT NULL,
  `leave_policy_id` INT UNSIGNED NOT NULL,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `effective_from` DATE NULL,
  `effective_to` DATE NULL,
  `status` ENUM('active', 'cancelled') NOT NULL DEFAULT 'active',
  `active_key` VARCHAR(64) GENERATED ALWAYS AS (
    CASE WHEN `status` = 'active'
      THEN CONCAT(`employee_id`, '-', `financial_year_id`)
      ELSE NULL
    END
  ) STORED,
  `assigned_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_active_employee_year` (`active_key`),
  KEY `idx_policy_assignments_employee_id` (`employee_id`),
  KEY `idx_policy_assignments_policy` (`leave_policy_id`),
  KEY `idx_policy_assignments_year` (`financial_year_id`),
  CONSTRAINT `fk_policy_assignments_employee_id`
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_policy_assignments_policy`
    FOREIGN KEY (`leave_policy_id`) REFERENCES `leave_policies` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_policy_assignments_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_allocations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT UNSIGNED NOT NULL,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `leave_type_id` INT UNSIGNED NOT NULL,
  `leave_entitlement_id` INT UNSIGNED NOT NULL,
  `leave_policy_assignment_id` INT UNSIGNED NOT NULL,
  `new_allocation` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `carry_forward` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `opening_balance` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `allocated_from` DATE NOT NULL,
  `allocated_to` DATE NOT NULL,
  `status` ENUM('active', 'cancelled') NOT NULL DEFAULT 'active',
  `active_key` VARCHAR(64) GENERATED ALWAYS AS (
    CASE WHEN `status` = 'active'
      THEN CONCAT(`employee_id`, '-', `financial_year_id`, '-', `leave_type_id`)
      ELSE NULL
    END
  ) STORED,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_active_employee_year_type` (`active_key`),
  KEY `idx_allocations_employee_id` (`employee_id`),
  KEY `idx_allocations_year` (`financial_year_id`),
  KEY `idx_allocations_type` (`leave_type_id`),
  KEY `idx_allocations_entitlement` (`leave_entitlement_id`),
  KEY `idx_allocations_assignment` (`leave_policy_assignment_id`),
  CONSTRAINT `fk_allocations_employee_id`
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_allocations_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_allocations_type`
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_allocations_entitlement`
    FOREIGN KEY (`leave_entitlement_id`) REFERENCES `leave_entitlements` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_allocations_assignment`
    FOREIGN KEY (`leave_policy_assignment_id`) REFERENCES `leave_policy_assignments` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_allocation_adjustments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `leave_allocation_id` INT UNSIGNED NOT NULL,
  `employee_id` INT UNSIGNED NOT NULL,
  `adjustment_days` DECIMAL(6,2) NOT NULL,
  `reason` VARCHAR(255) NOT NULL,
  `adjustment_date` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_adjustments_allocation` (`leave_allocation_id`),
  KEY `idx_adjustments_employee_id` (`employee_id`),
  CONSTRAINT `fk_adjustments_allocation`
    FOREIGN KEY (`leave_allocation_id`) REFERENCES `leave_allocations` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_adjustments_employee_id`
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_applications` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT UNSIGNED NOT NULL,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `leave_type_id` INT UNSIGNED NOT NULL,
  `leave_allocation_id` INT UNSIGNED NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `is_half_day` TINYINT(1) NOT NULL DEFAULT 0,
  `days` DECIMAL(6,2) NOT NULL,
  `opening_balance` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `balance_after` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `application_date` DATE NULL,
  `ref_no` VARCHAR(100) NULL,
  `letter_date` DATE NULL,
  `attachment_path` VARCHAR(255) NULL,
  `status` ENUM('recorded', 'received', 'cancelled') NOT NULL DEFAULT 'recorded',
  `remarks` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_applications_employee_id` (`employee_id`),
  KEY `idx_applications_year` (`financial_year_id`),
  KEY `idx_applications_type` (`leave_type_id`),
  KEY `idx_applications_allocation` (`leave_allocation_id`),
  KEY `idx_applications_dates` (`start_date`, `end_date`),
  CONSTRAINT `fk_applications_employee_id`
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_applications_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_applications_type`
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_applications_allocation`
    FOREIGN KEY (`leave_allocation_id`) REFERENCES `leave_allocations` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_ledger` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT UNSIGNED NOT NULL,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `leave_type_id` INT UNSIGNED NOT NULL,
  `leave_allocation_id` INT UNSIGNED NOT NULL,
  `leave_application_id` INT UNSIGNED NULL,
  `adjustment_id` INT UNSIGNED NULL,
  `transaction_type` ENUM(
    'allocation',
    'carry_forward',
    'leave_taken',
    'adjustment',
    'cancellation',
    'expiry',
    'reversal'
  ) NOT NULL,
  `transaction_date` DATE NOT NULL,
  `days` DECIMAL(6,2) NOT NULL,
  `balance_before` DECIMAL(6,2) NOT NULL,
  `balance_after` DECIMAL(6,2) NOT NULL,
  `description` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ledger_employee_id` (`employee_id`),
  KEY `idx_ledger_year` (`financial_year_id`),
  KEY `idx_ledger_type` (`leave_type_id`),
  KEY `idx_ledger_allocation` (`leave_allocation_id`),
  KEY `idx_ledger_application` (`leave_application_id`),
  KEY `idx_ledger_date` (`transaction_date`),
  CONSTRAINT `fk_ledger_employee_id`
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_ledger_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_ledger_type`
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_ledger_allocation`
    FOREIGN KEY (`leave_allocation_id`) REFERENCES `leave_allocations` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_ledger_application`
    FOREIGN KEY (`leave_application_id`) REFERENCES `leave_applications` (`id`)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT `fk_ledger_adjustment`
    FOREIGN KEY (`adjustment_id`) REFERENCES `leave_allocation_adjustments` (`id`)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_carry_forwards` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT UNSIGNED NOT NULL,
  `leave_type_id` INT UNSIGNED NOT NULL,
  `from_financial_year_id` INT UNSIGNED NOT NULL,
  `to_financial_year_id` INT UNSIGNED NOT NULL,
  `previous_balance` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `allowed_limit` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `carried_forward` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `expired_days` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_employee_type_year_transition` (
    `employee_id`,
    `leave_type_id`,
    `from_financial_year_id`,
    `to_financial_year_id`
  ),
  CONSTRAINT `fk_cf_employee_id`
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_cf_type`
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_cf_from_year`
    FOREIGN KEY (`from_financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_cf_to_year`
    FOREIGN KEY (`to_financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
- Use `id` as the real database primary key for employees. `payroll_number` is a business identifier and must stay unique but not be used as a foreign key target in leave tables.
- Use `created_at` and `updated_at` TIMESTAMP columns with default values when appropriate.
- For leave and HR-related tables, prefer `employee_id` -> `employees.id` as the foreign-key relationship.

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

-- If `owner_id` references `employees`, use the numeric employee ID, not payroll_number:
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_owner` FOREIGN KEY (`owner_id`) REFERENCES `employees`(`id`)
    ON UPDATE CASCADE ON DELETE SET NULL;

Inserting seed data (example)
--------------------------------
-- Prefer INSERT ... VALUES in migration or seed SQL files. Use transactions when inserting multiple related rows.
START TRANSACTION;
INSERT INTO `projects` (`name`, `description`, `owner_id`, `start_date`) VALUES
('HR Onboarding', 'Onboarding project for new hires', 1, '2026-09-01');
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
- Do not create foreign keys from leave tables to `employees.payroll_number`; the correct target is `employees.id`.
- Keep financial-year logic aligned to the annual cycle 1 July to 30 June and calculate the financial year from the leave start date.

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

-- -----------------------------------------------------------
-- Sample data inserts for all tables
-- -----------------------------------------------------------

INSERT INTO `password_resets` (`email`, `token`, `expires_at`) VALUES
('admin@example.com', 'reset-token-001', '2026-09-15 12:00:00'),
('user@example.com', 'reset-token-002', '2026-09-16 12:00:00');

INSERT INTO `login_attempts` (`email`, `ip_address`, `user_agent`, `success`, `attempted_at`) VALUES
('admin@example.com', '192.168.1.10', 'Mozilla/5.0', 1, '2026-09-01 08:15:00'),
('user@example.com', '192.168.1.20', 'Mozilla/5.0', 0, '2026-09-01 09:20:00');

INSERT INTO `email_verification_tokens` (`email`, `token`, `expires_at`) VALUES
('admin@example.com', 'verify-admin-001', '2026-09-15 12:00:00'),
('user@example.com', 'verify-user-001', '2026-09-15 12:00:00');

INSERT INTO `financial_years` (`id`, `label`, `start_date`, `end_date`, `is_current`) VALUES
(1, '2025/2026', '2025-07-01', '2026-06-30', 0),
(2, '2026/2027', '2026-07-01', '2027-06-30', 1);

INSERT INTO `holiday_lists` (`id`, `name`, `is_active`) VALUES
(1, 'National Holidays', 1),
(2, 'Regional Holidays', 1);

INSERT INTO `holidays` (`id`, `holiday_list_id`, `financial_year_id`, `holiday_date`, `name`, `is_weekly_off`) VALUES
(1, 1, 2, '2026-01-01', 'New Year Day', 0),
(2, 1, 2, '2026-03-20', 'Good Friday', 0),
(3, 1, 2, '2026-05-01', 'Labour Day', 0),
(4, 1, 2, '2026-06-01', 'Madaraka Day', 0),
(5, 2, 2, '2026-08-15', 'Assumption Day', 0);

INSERT INTO `leave_entitlements` (`id`, `financial_year_id`, `leave_type_id`, `entitlement`, `pro_rata_allowed`) VALUES
(1, 2, 1, 30.00, 1),
(2, 2, 2, 10.00, 1),
(3, 2, 3, 90.00, 1),
(4, 2, 4, 10.00, 1),
(5, 2, 5, 5.00, 1),
(6, 2, 6, 0.00, 1);

INSERT INTO `leave_policies` (`id`, `name`, `description`, `is_active`) VALUES
(1, 'Standard Staff Leave Policy', 'Default ELMIS leave policy for all staff', 1),
(2, 'Executive Leave Policy', 'Special policy for senior staff', 1);

INSERT INTO `leave_policy_details` (`id`, `leave_policy_id`, `leave_entitlement_id`, `allocation`, `carry_forward`, `carry_forward_limit`) VALUES
(1, 1, 1, 30.00, 1, 15.00),
(2, 1, 2, 10.00, 0, 0.00),
(3, 1, 3, 90.00, 0, 0.00),
(4, 1, 4, 10.00, 0, 0.00),
(5, 1, 5, 5.00, 0, 0.00),
(6, 1, 6, 0.00, 0, 0.00);

INSERT INTO `leave_policy_assignments` (`id`, `employee_id`, `leave_policy_id`, `financial_year_id`, `effective_from`, `effective_to`, `status`) VALUES
(1, 1, 1, 2, '2026-07-01', NULL, 'active'),
(2, 2, 1, 2, '2026-07-01', NULL, 'active');

INSERT INTO `leave_allocations` (`id`, `employee_id`, `financial_year_id`, `leave_type_id`, `leave_entitlement_id`, `leave_policy_assignment_id`, `new_allocation`, `carry_forward`, `opening_balance`, `allocated_from`, `allocated_to`, `status`) VALUES
(1, 1, 2, 1, 1, 1, 30.00, 0.00, 0.00, '2026-07-01', '2027-06-30', 'active'),
(2, 2, 2, 1, 1, 2, 30.00, 0.00, 0.00, '2026-07-01', '2027-06-30', 'active');

INSERT INTO `leave_allocation_adjustments` (`id`, `leave_allocation_id`, `employee_id`, `adjustment_days`, `reason`, `adjustment_date`) VALUES
(1, 1, 1, 2.00, 'Administrative correction for annual leave entitlement', '2026-08-10');

INSERT INTO `leave_applications` (`id`, `employee_id`, `financial_year_id`, `leave_type_id`, `leave_allocation_id`, `start_date`, `end_date`, `is_half_day`, `days`, `opening_balance`, `balance_after`, `application_date`, `ref_no`, `letter_date`, `status`, `remarks`) VALUES
(1, 1, 2, 1, 1, '2026-08-10', '2026-08-14', 0, 5.00, 30.00, 25.00, '2026-08-03', 'L-2026-001', '2026-08-05', 'received', 'Annual leave recorded for annual leave schedule'),
(2, 2, 2, 2, 2, '2026-09-02', '2026-09-03', 0, 2.00, 10.00, 8.00, '2026-08-27', 'L-2026-002', '2026-08-29', 'recorded', 'Medical leave logged for review');

INSERT INTO `leave_ledger` (`id`, `employee_id`, `financial_year_id`, `leave_type_id`, `leave_allocation_id`, `leave_application_id`, `adjustment_id`, `transaction_type`, `transaction_date`, `days`, `balance_before`, `balance_after`, `description`) VALUES
(1, 1, 2, 1, 1, NULL, NULL, 'allocation', '2026-07-01', 30.00, 0.00, 30.00, 'Annual leave allocation for FY 2026/2027'),
(2, 1, 2, 1, 1, 1, NULL, 'leave_taken', '2026-08-15', 5.00, 30.00, 25.00, 'Annual leave consumed during August 2026'),
(3, 2, 2, 2, 2, NULL, NULL, 'allocation', '2026-07-01', 10.00, 0.00, 10.00, 'Sick leave allocation for FY 2026/2027');

INSERT INTO `leave_carry_forwards` (`id`, `employee_id`, `leave_type_id`, `from_financial_year_id`, `to_financial_year_id`, `previous_balance`, `allowed_limit`, `carried_forward`, `expired_days`) VALUES
(1, 1, 1, 1, 2, 12.00, 15.00, 12.00, 0.00),
(2, 2, 1, 1, 2, 8.00, 15.00, 8.00, 0.00);