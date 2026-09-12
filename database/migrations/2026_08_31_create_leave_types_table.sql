CREATE TABLE IF NOT EXISTS `leave_types` (
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
('Leave Without Pay', 'working_days', 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `calculation_method` = VALUES(`calculation_method`),
  `is_active` = VALUES(`is_active`);
