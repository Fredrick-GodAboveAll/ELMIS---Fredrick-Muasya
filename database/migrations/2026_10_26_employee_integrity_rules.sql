-- Migration: enforce special_need_id NOT NULL and confirmation-status term validity
-- Date: 2026-10-26

USE `leave_management`;

-- 1) Ensure no null special_need_id values exist before enforcing NOT NULL.
UPDATE `employees` e
SET e.`special_need_id` = (
    SELECT sn.`id`
    FROM `special_needs` sn
    WHERE sn.`code` = 'none'
)
WHERE e.`special_need_id` IS NULL;

-- 2) Enforce explicit special-need selection.
ALTER TABLE `employees`
  MODIFY `special_need_id` INT UNSIGNED NOT NULL;

-- 3) Create confirmation validity table.
CREATE TABLE IF NOT EXISTS `employment_term_confirmation_validity` (
  `term_id` INT UNSIGNED NOT NULL,
  `confirmation_status_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`term_id`, `confirmation_status_id`),
  KEY `idx_term_confirmation_validity_status_id` (`confirmation_status_id`),
  CONSTRAINT `fk_term_confirmation_validity_term`
    FOREIGN KEY (`term_id`) REFERENCES `employment_terms` (`id`)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_term_confirmation_validity_status`
    FOREIGN KEY (`confirmation_status_id`) REFERENCES `confirmation_statuses` (`id`)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4) Seed confirmation validity rules.
INSERT INTO `employment_term_confirmation_validity` (`term_id`, `confirmation_status_id`)
SELECT et.`id`, cs.`id`
FROM `employment_terms` et
JOIN `confirmation_statuses` cs
  ON (
    (et.`code` = 'Permanent' AND cs.`code` IN ('probation', 'confirmed'))
    OR
    (et.`code` IN ('Contract', 'Intern', 'Casual') AND cs.`code` = 'not_applicable')
  )
ON DUPLICATE KEY UPDATE `created_at` = CURRENT_TIMESTAMP;

-- 5) Correct the invalid sample employee record to satisfy the final HR rule.
UPDATE `employees` e
SET e.`designation` = 'Junior Officer',
    e.`employment_term_id` = (
        SELECT et.`id`
        FROM `employment_terms` et
        WHERE et.`code` = 'Permanent'
    )
WHERE e.`payroll_number` = '20002';

-- 6) Add the composite foreign key to enforce the validity table.
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_term_confirmation_validity`
  FOREIGN KEY (`employment_term_id`, `confirmation_status_id`)
  REFERENCES `employment_term_confirmation_validity` (`term_id`, `confirmation_status_id`)
  ON UPDATE CASCADE ON DELETE RESTRICT;

-- 7) Safety check: any null special_need_id should already be fixed before this migration.
-- The schema now enforces explicit selection of None or PWD.
