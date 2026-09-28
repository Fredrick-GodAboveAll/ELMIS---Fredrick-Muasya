-- Migrate holiday lists to a direct relationship with financial_years.
-- This preserves the existing holiday row linkage while removing the legacy bridge table.

START TRANSACTION;

SET @holiday_list_has_year_column := (
  SELECT COUNT(*)
  FROM information_schema.columns
  WHERE table_schema = DATABASE()
    AND table_name = 'holiday_lists'
    AND column_name = 'financial_year_id'
);

SET @holiday_bridge_exists := (
  SELECT COUNT(*)
  FROM information_schema.tables
  WHERE table_schema = DATABASE()
    AND table_name = 'financial_year_holiday_lists'
);

SET @sql := IF(@holiday_list_has_year_column = 0,
  'ALTER TABLE `holiday_lists` ADD COLUMN `financial_year_id` INT UNSIGNED NULL AFTER `is_active`',
  'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql := IF(@holiday_bridge_exists > 0,
  'UPDATE `holiday_lists` hl
   LEFT JOIN `financial_year_holiday_lists` fyhl
     ON fyhl.holiday_list_id = hl.id
   SET hl.financial_year_id = fyhl.financial_year_id
   WHERE hl.financial_year_id IS NULL
     AND fyhl.financial_year_id IS NOT NULL',
  'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE `holiday_lists` hl
SET hl.financial_year_id = (
  SELECT fy.id
  FROM `financial_years` fy
  ORDER BY fy.start_date DESC
  LIMIT 1
)
WHERE hl.financial_year_id IS NULL
  AND EXISTS (SELECT 1 FROM `financial_years`); 

ALTER TABLE `holiday_lists`
  MODIFY `financial_year_id` INT UNSIGNED NOT NULL,
  ADD INDEX `idx_holiday_lists_financial_year_id` (`financial_year_id`),
  ADD CONSTRAINT `fk_holiday_lists_financial_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

DROP TABLE IF EXISTS `financial_year_holiday_lists`;

COMMIT;
