INSERT INTO `employee_category_values` (
  `category_id`, `label`, `employee_value`, `effect`, `sort_order`, `is_active`
)
SELECT `ec`.`id`, `d`.`name`, CAST(`d`.`id` AS CHAR), NULL, `d`.`id`, 1
FROM `departments` `d`
CROSS JOIN `employee_categories` `ec`
WHERE `ec`.`slug` = 'dept'
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `employee_value` = VALUES(`employee_value`),
  `effect` = VALUES(`effect`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);
