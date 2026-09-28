ALTER TABLE `leave_policy_details`
  ADD COLUMN `carry_forward` TINYINT(1) NOT NULL DEFAULT 0 AFTER `allocation`,
  ADD COLUMN `carry_forward_limit` DECIMAL(6,2) NOT NULL DEFAULT 0.00 AFTER `carry_forward`;

ALTER TABLE `leave_entitlements`
  DROP COLUMN `carry_forward`,
  DROP COLUMN `carry_forward_limit`;
