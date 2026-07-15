-- Add security features to users table
ALTER TABLE `users` ADD COLUMN `failed_login_attempts` INT DEFAULT 0 AFTER `last_login`;
ALTER TABLE `users` ADD COLUMN `locked_until` TIMESTAMP NULL AFTER `failed_login_attempts`;
ALTER TABLE `users` ADD COLUMN `email_verified` BOOLEAN DEFAULT FALSE AFTER `locked_until`;
ALTER TABLE `users` ADD COLUMN `email_verified_at` TIMESTAMP NULL AFTER `email_verified`;
ALTER TABLE `users` ADD COLUMN `password_changed_at` TIMESTAMP NULL AFTER `email_verified_at`;
ALTER TABLE `users` ADD COLUMN `session_started_at` TIMESTAMP NULL AFTER `password_changed_at`;

-- Create login attempts history table for audit
CREATE TABLE IF NOT EXISTS `login_attempts` (
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

-- Create email verification tokens table
CREATE TABLE IF NOT EXISTS `email_verification_tokens` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `expires_at` TIMESTAMP NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
