INSERT INTO `employee_categories` (
  `slug`, `title`, `icon`, `color`, `role`, `description`, `field`, `layout`, `sort_order`, `is_active`
) VALUES
  ('terms', 'Employment Terms', 'file-text', 'primary', 'base', 'Assigns the base policy package.', 'engagement_type', 'arrow', 1, 1),
  ('status', 'Employment Status', 'clock', 'warning', 'impact', 'Adjusts the base policy. Most values change nothing on their own.', 'employment_status', 'impact', 2, 1),
  ('gender', 'Gender', 'users', 'danger', 'impact', 'Maternity / paternity condition inside the policy.', 'gender', 'impact', 3, 1),
  ('need', 'Special Need', 'user', 'info', 'filter', 'Filtering and reporting only.', 'special_need', 'box', 4, 1),
  ('job', 'Job Group', 'git-branch', 'success', 'filter', 'Reporting and grouping only.', 'job_group', 'table', 5, 1),
  ('dept', 'Department', 'briefcase', 'primary', 'filter', 'Reporting and grouping only.', 'department_id', 'box', 6, 1)
ON DUPLICATE KEY UPDATE
  `title` = VALUES(`title`),
  `icon` = VALUES(`icon`),
  `color` = VALUES(`color`),
  `role` = VALUES(`role`),
  `description` = VALUES(`description`),
  `field` = VALUES(`field`),
  `layout` = VALUES(`layout`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);
