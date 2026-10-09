INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Permanent', 'Permanent', 'General Staff Policy', 1, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'terms'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Contract', 'Contract', 'Contract Staff Policy', 2, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'terms'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Intern', 'Intern', 'Intern Policy', 3, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'terms'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Casual', 'Casual', 'Casual Policy', 4, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'terms'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Probation', 'probation', NULL, 1, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'status'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Confirmed', 'permanent', NULL, 2, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'status'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Confirmed', 'contract', NULL, 3, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'status'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Suspended', 'suspended', NULL, 4, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'status'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Resigned', 'resigned', NULL, 5, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'status'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Retiring', 'retiring', 'Terminal leave unlocked', 6, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'status'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Male', 'M', 'Paternity leave applies', 1, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'gender'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Female', 'F', 'Maternity leave applies', 2, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'gender'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'PWD', '4', NULL, 1, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'need'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'None', '0', NULL, 2, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'need'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'H', 'H', NULL, 1, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'J', 'J', NULL, 2, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'K', 'K', NULL, 3, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'L', 'L', NULL, 4, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'M', 'M', NULL, 5, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'N', 'N', NULL, 6, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'P', 'P', NULL, 7, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'Q', 'Q', NULL, 8, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, 'R', 'R', NULL, 9, 1
FROM `employee_categories` `ec`
WHERE `ec`.`slug` = 'job'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);
