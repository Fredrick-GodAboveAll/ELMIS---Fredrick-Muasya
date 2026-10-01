-- Move financial-year ownership from holiday lists to individual holiday rows.
-- Merge same-named annual lists, preserving each holiday's original FY.

START TRANSACTION;

ALTER TABLE holidays
  ADD COLUMN financial_year_id INT UNSIGNED NULL AFTER holiday_list_id;

UPDATE holidays h
JOIN holiday_lists hl ON hl.id = h.holiday_list_id
SET h.financial_year_id = hl.financial_year_id;

ALTER TABLE holidays
  DROP INDEX uq_holiday_list_date,
  MODIFY financial_year_id INT UNSIGNED NOT NULL,
  ADD KEY idx_holidays_financial_year_id (financial_year_id),
  ADD CONSTRAINT fk_holidays_financial_year
    FOREIGN KEY (financial_year_id) REFERENCES financial_years (id)
    ON UPDATE CASCADE ON DELETE RESTRICT;

UPDATE holiday_lists keeper
JOIN (
  SELECT name, MIN(id) AS keeper_id, MAX(is_active) AS is_active
  FROM holiday_lists
  GROUP BY name
  HAVING COUNT(*) > 1
) duplicates ON duplicates.keeper_id = keeper.id
SET keeper.is_active = duplicates.is_active;

UPDATE holidays h
JOIN holiday_lists duplicate ON duplicate.id = h.holiday_list_id
JOIN (
  SELECT name, MIN(id) AS keeper_id
  FROM holiday_lists
  GROUP BY name
  HAVING COUNT(*) > 1
) duplicates ON duplicates.name = duplicate.name
SET h.holiday_list_id = duplicates.keeper_id
WHERE duplicate.id <> duplicates.keeper_id;

DELETE duplicate
FROM holiday_lists duplicate
JOIN (
  SELECT name, MIN(id) AS keeper_id
  FROM holiday_lists
  GROUP BY name
  HAVING COUNT(*) > 1
) duplicates ON duplicates.name = duplicate.name
WHERE duplicate.id <> duplicates.keeper_id;

ALTER TABLE holiday_lists
  DROP FOREIGN KEY fk_holiday_lists_financial_year,
  DROP INDEX idx_holiday_lists_financial_year_id,
  DROP INDEX uq_holiday_list_name_fy,
  DROP INDEX uq_holiday_list_default_financial_year,
  DROP COLUMN default_financial_year_id,
  DROP COLUMN is_default,
  DROP COLUMN financial_year_id,
  ADD UNIQUE KEY uq_holiday_list_name (name);

ALTER TABLE holidays
  ADD UNIQUE KEY uq_holiday_list_financial_year_date (holiday_list_id, financial_year_id, holiday_date);

COMMIT;
