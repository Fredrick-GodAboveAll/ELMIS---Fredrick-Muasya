# ELMIS — Leave Change Plan and Current Implementation

This document maps what currently exists in the codebase, how the leave-related pieces are organised, and rules/recommendations for implementing the proposed 6-table leave flow (rules, allocations, applications). Use this as the single source of truth when planning migrations and code changes.

## Summary
- Current implemented tables/models: `employees`, `financial_years`, `leave_types`.
- Partial services implemented: `LeaveTypeService`, `LeaveCalculator`, `LeavePeriodService`.
- Placeholder services exist for allocations and applications.

## What the system already has (files + responsibilities)

- Models
  - `app/Models/Employee.php` — reads/writes `employees` table (fields used: `payroll_number`, `full_name`, `id_number`, `designation`, `job_group`, `employment_status`, `special_need`, `department_id`, `created_at`, `updated_at`).
  - `app/Models/FinancialYear.php` — manages `financial_years` table (fields used: `label`, `start_date`, `end_date`, `is_current`). Provides helpers: `findByDate`, `getCurrentPeriod`, `setCurrentPeriodByLatestStartDate`.
  - `app/Models/LeaveType.php` — manages `leave_types` table (fields used: `name`, `annual_entitlement_value`, `calculation_method`, `carry_forward`, `carry_forward_limit`, `is_active`). Creation and lookups implemented.

- Services
  - `app/Services/LeaveTypeService.php` — validation and creation logic for leave types, enforces calculation method (`working_days` or `calendar_days`), and carry-forward validation.
  - `app/Services/LeaveCalculator.php` — core date arithmetic rules: calculates days between two dates per calculation method, computes end date from start+days, enforces global business rule *'leave cannot start on weekend'*. Counts working days (Mon–Fri) when applicable.
  - `app/Services/LeavePeriodService.php` — resolves the `FinancialYear` for a given date.
  - `app/Services/LeaveService.php` — empty placeholder.
  - `app/Services/LeaveAllocationService.php` — empty placeholder.
  - `app/Services/LeaveApplicationService.php` — empty placeholder.

## Missing pieces to implement the 6-table flow

- Database tables not present (need migrations):
  - `leave_period_leave_types` (period-specific rules)
  - `leave_allocations` (per-employee opening balances & carried forward)
  - `leave_applications` (employee leave transactions/applications)

- Models and service logic to create/maintain allocations and applications.
- Controllers/views and reports that consume these tables.

## Rules & important business decisions (must be decided before implementation)

1. Cross-financial-year leave handling (critical)
   - Option A: Split an application that spans a boundary into two application records (one per FY). Pros: correct attribution for reporting and carry-forward. Cons: slightly more complex application logic.
   - Option B: Attribute the entire application to the FY containing the start date. Pros: simpler. Cons: may misrepresent per-FY balances.
   - Option C: Attribute by majority or configured rule. Avoid unless policy exists.
   - Recommendation: implement Option A (split on save) — it maps cleanly to carry-forward rules and reporting.

2. Day counting
   - `LeaveType` already supports `calculation_method` (`working_days` or `calendar_days`). Use `LeaveCalculator` for consistent logic.
   - `LeaveCalculator` enforces: leave cannot start on weekend. Keep this global rule or make it configurable if needed.

3. Carry-forward (CF)
   - The `leave_period_leave_types` (rules) table should store: `entitlement`, `carry_forward_allowed` (bool), `carry_forward_limit` (numeric) — these drive allocation creation.
   - Compute carried-forward value from the employee's ending balance but cap at `carry_forward_limit` as defined in the rule row for the period being opened.

4. Allocations vs derived balances
   - Keep `leave_allocations` as the canonical opening balance record for a given employee, FY, and leave type: `opening_entitlement`, `carried_forward`, `opening_balance`.
   - Compute current balance as `opening_balance - SUM(approved_leave_days_in_that_FY)`; store cached balance in `leave_allocations` only if performance requires it and provide a reconciliation job.

5. Approvals & auditing
   - `leave_applications` should include: `status` (pending/approved/rejected), `approver_id`, `approved_at`, `created_by`, `created_at`, `updated_at` and an audit/history table or immutable events for approvals and adjustments.

6. Indexing & constraints
   - Add foreign keys for `employee_id`, `financial_year_id`, `leave_type_id`. Add composite index on `(financial_year_id, leave_type_id)` in `leave_period_leave_types` and on `(employee_id, financial_year_id, leave_type_id)` in `leave_allocations`.

## Suggested minimal field lists (for migration authors)

- `leave_period_leave_types` (rules)
  - `id`, `financial_year_id`, `leave_type_id`, `entitlement` (decimal), `carry_forward_allowed` (tinyint), `carry_forward_limit` (decimal), `created_at`, `updated_at`.

- `leave_allocations`
  - `id`, `employee_id`, `financial_year_id`, `leave_type_id`, `opening_entitlement` (decimal), `carried_forward` (decimal), `opening_balance` (decimal), `created_at`, `updated_at`, `notes`.

- `leave_applications`
  - `id`, `employee_id`, `financial_year_id`, `leave_type_id`, `start_date`, `end_date`, `days` (decimal/int), `calculation_method`, `status`, `approver_id`, `approved_at`, `created_by`, `created_at`, `updated_at`, `external_reference`.
  - If implementing Option A splitting logic, add `parent_application_id` to group split fragments.

## Step-by-step implementation plan (practical)

1. Create migrations for the three tables above (add FK constraints and indexes). Add safe defaults and nullable fields where necessary.
2. Implement Eloquent-style or PDO models `LeavePeriodLeaveType`, `LeaveAllocation`, `LeaveApplication` mapped to the tables.
3. Implement `LeaveAllocationService` responsibilities:
   - Create allocation for each employee when a new FY is activated.
   - Calculate carried-forward amounts based on previous FY balances and rule caps.
   - Provide reconciliation endpoint/job.
4. Implement `LeaveApplicationService` responsibilities:
   - Create, validate (use `LeaveTypeService` + `LeaveCalculator`), approve/reject.
   - When saving an application spanning FY boundaries, split into fragments (Option A) and attach `parent_application_id`.
5. Add controller endpoints and update views/reports to use `leave_applications` and `leave_allocations` for authoritative data.
6. Add tests: unit tests for `LeaveCalculator`, integration tests for allocation creation and cross-FY splits, report tests to ensure sums match.
7. Deploy with careful migration order and a small data-migration script to populate `leave_allocations` from historical data (derive opening_balance from prior rules and past `leave_applications`).

## Testing & verification
- Unit test `LeaveCalculator` methods thoroughly (weekend rule, working vs calendar days).
- Integration test allocation creation for employees with edge cases (CF cap, negative balances, partial-year hiring).
- Run reconciliation job and compare computed balances vs cached balances (if used). Flag differences.

## Rollout notes
- Deploy migrations to a staging environment first.
- Seed a small subset of employees to validate reports.
- Provide backout scripts (drop new tables) if an urgent rollback is needed — but keep backups of production data.

## Quick references
- `app/Models/Employee.php`
- `app/Models/FinancialYear.php`
- `app/Models/LeaveType.php`
- `app/Services/LeaveTypeService.php`
- `app/Services/LeaveCalculator.php`
- `app/Services/LeavePeriodService.php`

---

If you want, I can now draft the actual migrations and the three model skeletons, or implement the allocation creation job next.
