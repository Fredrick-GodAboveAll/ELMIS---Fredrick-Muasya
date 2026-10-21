USE `leave_management`;

-- 1) Join-table count
SELECT COUNT(*) AS validity_pairs
FROM employment_term_status_validity;

-- 2) Valid combinations by term and status
SELECT et.code AS term, es.code AS status
FROM employment_term_status_validity v
JOIN employment_terms et ON et.id = v.term_id
JOIN employment_statuses es ON es.id = v.status_id
ORDER BY et.code, es.sort_order;

-- 3) Employee foreign-key count
SELECT COUNT(*) AS employee_fk_count
FROM information_schema.TABLE_CONSTRAINTS
WHERE TABLE_SCHEMA = 'leave_management'
  AND TABLE_NAME = 'employees'
  AND CONSTRAINT_TYPE = 'FOREIGN KEY';

-- 4) Current employee pairs
SELECT e.payroll_number, e.full_name, et.code AS term, es.code AS status
FROM employees e
JOIN employment_terms et ON et.id = e.employment_term_id
JOIN employment_statuses es ON es.id = e.employment_status_id;

-- 5) Invalid pair demonstration (COMMENTED OUT on purpose)
-- This should fail with a foreign-key error in MySQL because the pair is not valid.
-- INSERT INTO employees (
--   payroll_number, full_name, id_number, date_of_birth, designation,
--   gender_id, employment_term_id, employment_status_id, job_group_id,
--   special_need_id, department_id, rod_date
-- ) VALUES (
--   '99999', 'INVALID EMPLOYEE', '99999999', '1995-01-01', 'Test Role',
--   (SELECT id FROM genders WHERE code = 'M'),
--   (SELECT id FROM employment_terms WHERE code = 'Intern'),
--   (SELECT id FROM employment_statuses WHERE code = 'contract'),
--   (SELECT id FROM job_groups WHERE code = 'J'),
--   (SELECT id FROM special_needs WHERE code = 'none'),
--   1,
--   '2030-01-01'
-- );
