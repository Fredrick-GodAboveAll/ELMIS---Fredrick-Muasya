-- Legacy note:
-- Holiday lists are persistent records and do not belong to a single financial year.
-- The financial-year scope belongs on each holiday row, not on the list itself.
--
-- This migration is intentionally a no-op because the final model is enforced by
-- 2026_10_02_holiday_lists_persist_across_financial_years.sql.
--
-- Keeping this migration as a no-op avoids reintroducing a default-per-FY rule that
-- conflicts with the business requirement: one list can be reused across FYs, and
-- each FY gets its own holiday rows under the same list.

SELECT 1;
