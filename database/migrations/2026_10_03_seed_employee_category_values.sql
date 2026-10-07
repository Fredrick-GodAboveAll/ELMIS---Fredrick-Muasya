INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Permanent', 'Permanent', 'General Staff Policy', 1, 1
FROM employee_categories c
WHERE c.slug = 'terms'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Contract', 'Contract', 'Contract Staff Policy', 2, 1
FROM employee_categories c
WHERE c.slug = 'terms'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Intern', 'Intern', 'Intern Policy', 3, 1
FROM employee_categories c
WHERE c.slug = 'terms'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Casual', 'Casual', 'Casual Policy', 4, 1
FROM employee_categories c
WHERE c.slug = 'terms'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Probation', 'probation', NULL, 1, 1
FROM employee_categories c
WHERE c.slug = 'status'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Confirmed', 'permanent', NULL, 2, 1
FROM employee_categories c
WHERE c.slug = 'status'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Confirmed', 'contract', NULL, 3, 1
FROM employee_categories c
WHERE c.slug = 'status'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Suspended', 'suspended', NULL, 4, 1
FROM employee_categories c
WHERE c.slug = 'status'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Resigned', 'resigned', NULL, 5, 1
FROM employee_categories c
WHERE c.slug = 'status'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Retiring', 'retiring', 'Terminal leave unlocked', 6, 1
FROM employee_categories c
WHERE c.slug = 'status'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Male', 'M', 'Paternity leave applies', 1, 1
FROM employee_categories c
WHERE c.slug = 'gender'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Female', 'F', 'Maternity leave applies', 2, 1
FROM employee_categories c
WHERE c.slug = 'gender'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'PWD', '4', NULL, 1, 1
FROM employee_categories c
WHERE c.slug = 'need'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'None', '0', NULL, 2, 1
FROM employee_categories c
WHERE c.slug = 'need'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'H', 'H', NULL, 1, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'J', 'J', NULL, 2, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'K', 'K', NULL, 3, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'L', 'L', NULL, 4, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'M', 'M', NULL, 5, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'N', 'N', NULL, 6, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'P', 'P', NULL, 7, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'Q', 'Q', NULL, 8, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;

INSERT INTO employee_category_values
  (category_id, label, payroll_code, effect, sort_order, is_active)
SELECT c.id, 'R', 'R', NULL, 9, 1
FROM employee_categories c
WHERE c.slug = 'job'
ON DUPLICATE KEY UPDATE
  label = VALUES(label),
  effect = VALUES(effect),
  sort_order = VALUES(sort_order),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;
