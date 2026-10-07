INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT
  c.id,
  d.name,
  CAST(d.id AS CHAR),
  NULL,
  d.id,
  1
FROM departments d
CROSS JOIN employee_categories c
WHERE c.slug = 'dept'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;
