CREATE TABLE IF NOT EXISTS `leave_types` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `annual_entitlement_value` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `calculation_method` ENUM('working_days', 'calendar_days') NOT NULL DEFAULT 'working_days',
  `carry_forward` TINYINT(1) NOT NULL DEFAULT 0,
  `carry_forward_limit` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_leave_type_name` (`name`),
  KEY `idx_leave_types_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `leave_types`
  (`name`, `annual_entitlement_value`, `calculation_method`, `carry_forward`, `carry_forward_limit`, `is_active`)
VALUES
  ('Annual Leave', 30.00, 'working_days', 1, 15.00, 1),
  ('Sick Leave', 15.00, 'working_days', 0, 0.00, 1),
  ('Maternity Leave', 90.00, 'calendar_days', 0, 0.00, 1),
  ('Paternity Leave', 10.00, 'working_days', 0, 0.00, 1),
  ('Study Leave', 5.00, 'working_days', 0, 0.00, 1),
  ('Leave Without Pay', 0.00, 'working_days', 0, 0.00, 1)
ON DUPLICATE KEY UPDATE
  `annual_entitlement_value` = VALUES(`annual_entitlement_value`),
  `calculation_method` = VALUES(`calculation_method`),
  `carry_forward` = VALUES(`carry_forward`),
  `carry_forward_limit` = VALUES(`carry_forward_limit`),
  `is_active` = VALUES(`is_active`);
