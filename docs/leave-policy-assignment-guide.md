# Leave Policy Assignment Guide for Individual and Group Employees

## Overview

This document describes the proposed target design for leave policy assignment. It is not a description of the current live database schema. The project already has the foundation for leave policy management:

- `leave_policies` stores the policy itself
- `leave_policy_details` stores the leave entitlement values attached to each policy
- `leave_policy_assignments` stores the employee-to-policy assignment for a financial year
- `employees` stores the employee master record
- `employment_terms`, `confirmation_statuses`, `employment_statuses`, `genders`, `job_groups`, `departments`, and `special_needs` provide employee attributes

The key architectural correction is this:

Leave policy is determined by the employment relationship, not by org-chart or personal-attribute selection. The policy is selected from the employee’s current `(employment_term_id, confirmation_status_id)` pair. Everything else is either a lifecycle gate or a leave-type eligibility rule, not a policy-selection category.

This document replaces the previous rule-engine design with a direct deterministic mapping approach. The concrete schema changes described below are intended as the target implementation and will be introduced through migration files, not by changing the existing schema in place without a migration.

---

## Goal

We want the system to support the following:

1. Direct assignment of a leave policy to one employee.
2. Deterministic assignment of a leave policy to all employees based on their current employment relationship.
3. A single source of truth for policy selection: `employment_term_id` + `confirmation_status_id`.
4. A record of why a policy was assigned, and whether it came from a direct override or a mapping.
5. Leave-type eligibility handled at allocation generation, not at policy assignment time.

---

## Architecture

### 1. Policy selection is not based on department, job group, gender, or special need

The following are explicitly removed from policy assignment:

- `department` — never a policy category
- `job_group` — never a policy category (see the open decision in section 9)
- `special_need` — not a policy category; it belongs to leave-type eligibility if needed later
- `gender` — not a policy category; it belongs to leave-type eligibility (section 5)
- `employment_status` — not a policy category; it is a lifecycle gate (section 6)

This must be clear in the design: policy assignment is not driven by org chart, demographics, or role-group labels. It is driven by the employment relationship as recorded in `employment_terms` and `confirmation_statuses`.

### 2. Replace the rule-engine with `leave_policy_mappings`

Because `employment_term_confirmation_validity` already constrains valid combinations, the policy combination space is tiny and deterministic. A rule engine on top of that creates conflicts with no defined precedence.

Use a direct mapping table instead:

```sql
CREATE TABLE `leave_policy_mappings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employment_term_id` INT UNSIGNED NOT NULL,
  `confirmation_status_id` INT UNSIGNED NOT NULL,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `leave_policy_id` INT UNSIGNED NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_mapping_term_confirmation_year`
    (`employment_term_id`, `confirmation_status_id`, `financial_year_id`),
  KEY `idx_mapping_policy` (`leave_policy_id`),
  KEY `idx_mapping_year` (`financial_year_id`),
  CONSTRAINT `fk_mapping_term`
    FOREIGN KEY (`employment_term_id`) REFERENCES `employment_terms` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_mapping_confirmation`
    FOREIGN KEY (`confirmation_status_id`) REFERENCES `confirmation_statuses` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_mapping_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_mapping_policy`
    FOREIGN KEY (`leave_policy_id`) REFERENCES `leave_policies` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

`financial_year_id` is required because `leave_policy_details.leave_entitlement_id` points to `leave_entitlements`, and `leave_entitlements` is scoped to a single financial year. A policy's entitlement values are therefore year-specific. If mappings were not year-scoped, a mapping resolved for FY 2025/2026 would point to a policy whose entitlement values belong to FY 2025/2026 and would produce incorrect allocations when reused in FY 2026/2027. The mapping must be year-scoped to stay consistent with the entitlement and policy-detail layers.

This is the canonical mapping table for policy selection.

#### Seed mapping table

The project already has the validity constraints for `employment_terms` and `confirmation_statuses`. The mapping table should reflect those valid combinations.

| financial_year | employment_term | confirmation_status | leave_policy |
|---|---|---|---|
| 2026/2027 | Permanent | probation | Permanent Probation Policy |
| 2026/2027 | Permanent | confirmed | Permanent Confirmed Policy |
| 2026/2027 | Contract | not_applicable | Contract Policy |
| 2026/2027 | Intern | not_applicable | Intern Policy |
| 2026/2027 | Casual | not_applicable | Casual Policy (or none) |

Mappings are seeded per financial year. At the start of each new financial year, HR must confirm or re-seed the mappings for that year before running the reconciliation job. The reconciliation job must always resolve mappings using the target financial year, not the current one.

This table may optionally be validated against `employment_term_confirmation_validity` so only valid pairs can be mapped.

### 3. Keep `leave_policy_assignments` as the final employee-level record

This table remains the record that drives leave processing, but it must include better auditability and a correct uniqueness rule.

Suggested final structure:

```sql
CREATE TABLE `leave_policy_assignments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT UNSIGNED NOT NULL,
  `leave_policy_id` INT UNSIGNED NOT NULL,
  `financial_year_id` INT UNSIGNED NOT NULL,
  `effective_from` DATE NULL,
  `effective_to` DATE NULL,
  `status` ENUM('active', 'cancelled') NOT NULL DEFAULT 'active',
  `assignment_type` ENUM('individual', 'mapping') NOT NULL DEFAULT 'individual',
  `source_mapping_id` INT UNSIGNED NULL,
  -- created_by is intentionally not a foreign key to users:
  -- system-generated rows during reconciliation have created_by = NULL.
  `created_by` INT UNSIGNED NULL,
  `assigned_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cancelled_at` TIMESTAMP NULL,
  `cancel_reason` VARCHAR(255) NULL,
  `active_employee_id` INT UNSIGNED GENERATED ALWAYS AS (IF(`status` = 'active', `employee_id`, NULL)) STORED,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_active_employee_year` (`active_employee_id`, `financial_year_id`),
  KEY `idx_policy_assignments_employee_id` (`employee_id`),
  KEY `idx_policy_assignments_policy` (`leave_policy_id`),
  KEY `idx_policy_assignments_year` (`financial_year_id`),
  KEY `idx_policy_assignments_mapping` (`source_mapping_id`),
  CONSTRAINT `fk_policy_assignments_employee_id`
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_policy_assignments_policy`
    FOREIGN KEY (`leave_policy_id`) REFERENCES `leave_policies` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_policy_assignments_year`
    FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_assignments_source_mapping`
    FOREIGN KEY (`source_mapping_id`) REFERENCES `leave_policy_mappings` (`id`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

`ON DELETE RESTRICT` is intentional. If a mapping has generated any assignment — active or cancelled — the mapping cannot be deleted, because doing so would orphan historical audit records. HR should set `is_active = 0` on the mapping to retire it instead of deleting it. This preserves the answer to "why does this employee have this policy" for every assignment the mapping ever produced.

This fixes the issue with the old unique key pattern. The previous `UNIQUE(employee_id, financial_year_id, status)` was not a real one-active-assignment-per-employee-per-year rule because it still allowed multiple cancelled rows for the same employee. The generated column makes the uniqueness explicit for active rows only.

The `source_mapping_id` is important because without it, the system cannot answer the question: “Why does this employee have this policy?” That makes re-running mapping generation, corrective reconciliation, and audit review impossible.

---

## Individual assignment

### Direct assignment flow

The individual override path is simple and intentional.

This is used when HR directly assigns a policy for a one-off case, override, special arrangement, or exception.

Example insert:

```sql
INSERT INTO `leave_policy_assignments`
  (`employee_id`, `leave_policy_id`, `financial_year_id`, `effective_from`, `effective_to`, `status`, `assignment_type`, `created_by`)
VALUES
  (12, 3, 2, '2026-07-01', '2027-06-30', 'active', 'individual', 101);
```

This assignment is not generated from `leave_policy_mappings`. It is an explicit HR override.

### Individual assignment rules

- only one active assignment should exist per employee per financial year
- the assignment must record `assignment_type = 'individual'`
- **Individual override precedence:** when an employee already has an active assignment with `assignment_type = 'individual'` for the target financial year, the reconciliation job must skip that employee. The individual assignment is authoritative and takes precedence over any mapping-driven assignment. The reconciliation summary must report these employees under the `skipped_override` counter, separate from `skipped_noop`, so HR can distinguish deliberate overrides from employees whose assignment was already correct. If HR wants the mapping to take effect, they must first cancel the individual assignment manually. This preserves the purpose of the override path and prevents reconciliation from silently replacing HR decisions.
- individual assignments are useful for exceptions and edge cases, not for general policy logic

---

## Mapping-driven assignment

The system should resolve policy selection from `leave_policy_mappings` using the employee’s current `(employment_term_id, confirmation_status_id)` pair.

### The core rule

Policy selection is deterministic from:

- `employment_term_id`
- `confirmation_status_id`

Example mapping lookup:

```sql
SELECT id, leave_policy_id
FROM leave_policy_mappings
WHERE employment_term_id = :term_id
  AND confirmation_status_id = :confirmation_id
  AND financial_year_id = :year_id
  AND is_active = 1
LIMIT 1;
```

The `financial_year_id` filter is required — a mapping resolved without it may return a row from a different financial year and produce incorrect allocations. This matches the lookup in `generateAssignment` above.

When found, the system creates a row in `leave_policy_assignments` with:

- `assignment_type = 'mapping'`
- `source_mapping_id = mapping.id`
- `effective_from` = the effective date for the assignment
- `effective_to` = NULL unless an end date is required

This is the standard policy-generation path for employees.

### Example mapping set

| financial_year | employment_term | confirmation_status | leave_policy |
|---|---|---|---|
| 2026/2027 | Permanent | probation | Permanent Probation Policy |
| 2026/2027 | Permanent | confirmed | Permanent Confirmed Policy |
| 2026/2027 | Contract | not_applicable | Contract Policy |
| 2026/2027 | Intern | not_applicable | Intern Policy |
| 2026/2027 | Casual | not_applicable | Casual Policy (or none) |

### Important note

This document intentionally does not support department-, job-group-, gender-, or special-need-based policy assignment. If those concepts need to affect leave, they must be handled as leave-type eligibility or policy overrides, not as policy selection criteria.

### Mid-year mapping changes

If HR changes a mapping mid-year — for example, Permanent+Confirmed is repointed from Policy A to Policy B on 2027-01-15 — the following must hold:

- existing `leave_policy_assignments` rows created from the old mapping remain unchanged until reconciliation runs
- the next reconciliation run detects the mismatch between the active assignment's `leave_policy_id` and the current mapping's `leave_policy_id`
- the run cancels the old assignment with `effective_to` set to the day before the change and `cancel_reason = 'superseded by mapping reconciliation'`
- the run creates a new assignment with `effective_from` set to the change date, `assignment_type = 'mapping'`, and the new `source_mapping_id`
- `leave_allocations` for the affected employees are recalculated for the remainder of the financial year using the new policy's `leave_policy_details` and the appropriate pro-rata logic
- `leave_ledger` entries are written for the reversal of old allocations and the new allocation

Because `leave_policy_mappings` has no `effective_from` / `effective_to` columns, HR must run reconciliation deliberately after any mapping change. The reconciliation job is the mechanism by which mapping changes propagate to assignments. It is not automatic.

---

## Gender and leave-type eligibility

Gender is not a policy category. It belongs to leave-type eligibility.

Add a table like this:

```sql
CREATE TABLE `leave_type_gender_eligibility` (
  `leave_type_id` INT UNSIGNED NOT NULL,
  `gender_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`leave_type_id`, `gender_id`),
  CONSTRAINT `fk_ltge_type`
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_ltge_gender`
    FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Rule

- no rows for a leave type → eligible for all genders
- rows exist → eligible only for listed genders

Seed example:

- Maternity Leave → Female
- Paternity Leave → Male

This is important: a policy can contain Maternity Leave, but a male employee assigned that policy simply gets no `leave_allocations` row for it. Eligibility is enforced during allocation generation, not at policy assignment. That separation keeps policy assignment clean and deterministic.

A parallel table, such as `leave_type_special_need_eligibility`, can be added later using the same pattern if special-need-based leave eligibility becomes necessary.

---

## `employment_status` is a lifecycle gate, not a selector

`employment_status` never appears in `leave_policy_mappings` and never selects a policy. It gates whether the employee is eligible for leave processing.

### Behaviours

- `active` → eligible for assignment generation and allocation generation
- `suspended` → eligible for assignment generation (so the policy stays on record), but leave applications are blocked at the workflow layer. No new leave is processed, but the assignment record remains visible and auditable.
- `resigned` / `retired` → cancel the active assignment (`status = 'cancelled'`, `effective_to` = termination date, `cancel_reason` set), handle pending applications, freeze carry-forward

This means HR should maintain the employee record, and the system should react by cancellation or reassignment when a lifecycle event occurs.

---

## Transition handling

### Probation → Confirmed

1. HR updates `employees.confirmation_status_id` from `probation` to `confirmed`.
2. Look up `leave_policy_mappings` for `(employment_term_id, confirmed, financial_year_id)` using the financial year that contains the transition date. The `financial_year_id` filter is mandatory here for the same reason it is mandatory everywhere else — omitting it can resolve a mapping from a different year and produce incorrect allocations.
3. If the resulting `leave_policy_id` differs from the employee’s active assignment:
   - cancel the current assignment (`effective_to` = day before transition, `cancelled_at`, `cancel_reason = 'confirmation transition'`)
   - create a new assignment (`effective_from` = transition date, `assignment_type = 'mapping'`)
   - recalculate `leave_allocations` for the remainder of the year (pro-rata if allocations differ, carry-forward if applicable)
4. Write `leave_ledger` entries for the adjustment/reversal so the balance remains auditable.

### Resigned / Retired

1. HR updates `employees.employment_status_id`.
2. Cancel the active assignment with `effective_to` = termination date.
3. Flag or cancel pending `leave_applications`.
4. Freeze final balances and `leave_carry_forwards`.

Both transitions must be event-driven and idempotent. They must also be safe to re-run without double-posting adjustments.

A scheduled reconciliation job should sweep for drift between employee attributes and active assignments so the real enterprise state remains aligned with the policy records.

---

## Assignment algorithm

### Mapping generation logic

The replacement for the old rule-engine flow is:

```php
enum AssignmentResult: string {
    case Created         = 'created';
    case SkippedOverride = 'skipped_override';
    case SkippedStatus   = 'skipped_status';
    case SkippedNoop     = 'skipped_noop';
}

function generateAssignment(Employee $employee, int $financialYearId): AssignmentResult
{
    if (!in_array($employee->employment_status_code, ['active', 'suspended'], true)) {
        return AssignmentResult::SkippedStatus;
    }

    $mapping = $db->fetchOne(
        'SELECT id, leave_policy_id FROM leave_policy_mappings
         WHERE employment_term_id = :term
           AND confirmation_status_id = :confirmation
           AND financial_year_id = :year
           AND is_active = 1',
        [
            ':term'         => $employee->employment_term_id,
            ':confirmation' => $employee->confirmation_status_id,
            ':year'         => $financialYearId,
        ]
    );

    if (!$mapping) {
        throw new NoMappingException(
            "No policy mapping for term={$employee->employment_term_id}, "
          . "confirmation={$employee->confirmation_status_id}, year={$financialYearId}"
        );
    }

    $existingActive = findActiveAssignment($employee->id, $financialYearId);

    if ($existingActive && $existingActive->assignment_type === 'individual') {
        return AssignmentResult::SkippedOverride;
    }

    if ($existingActive && $existingActive->assignment_type === 'mapping'
        && $existingActive->leave_policy_id === $mapping['leave_policy_id']
        && $existingActive->source_mapping_id === $mapping['id']) {
        return AssignmentResult::SkippedNoop;
    }

    if ($existingActive) {
        cancelAssignment(
            $existingActive->id,
            reason: 'superseded by mapping reconciliation'
        );
    }

    createAssignment(
        $employee->id,
        $mapping['leave_policy_id'],
        $financialYearId,
        assignmentType: 'mapping',
        sourceMappingId: $mapping['id']
    );

    return AssignmentResult::Created;
}

function runReconciliation(array $employees, int $financialYearId): array
{
    $result = [
        'created'          => 0,
        'skipped_override' => 0,
        'skipped_status'   => 0,
        'skipped_noop'     => 0,
        'errors'           => [],
    ];

    $db->beginTransaction();
    try {
        foreach ($employees as $employee) {
            try {
                $status = generateAssignment($employee, $financialYearId);
                $result[$status->value]++;
            } catch (DomainException $e) {
                // Convention: every per-employee domain error (NoMappingException,
                // validation errors from createAssignment) must extend DomainException.
                // Infrastructure errors (PDOException, QueryException, etc.) do not
                // extend DomainException and will correctly abort the batch via the
                // outer catch below. Do not widen this catch to \Exception — that
                // would swallow infrastructure failures and let the batch "succeed"
                // with every employee in the error list.
                $result['errors'][] = [
                    'employee_id' => $employee->id,
                    'reason'      => $e->getMessage(),
                ];
            }
        }
        $db->commit();
    } catch (Throwable $e) {
        // Infrastructure failure only.
        $db->rollBack();
        throw $e;
    }

    return $result;
}
```

> `generateAssignment` returns a discriminated status (`created`, `skipped_override`, `skipped_noop`, `skipped_status`) rather than a nullable ID, so the reconciliation summary can report individual overrides and lifecycle skips separately from idempotent no-ops. Per-employee domain exceptions are caught and collected in `errors`; they do not abort the batch. This relies on a strict convention: every domain error thrown from `generateAssignment` or `createAssignment` must extend `DomainException`. Infrastructure failures (database loss, connection failure, query errors) do not extend `DomainException` and correctly roll back the whole run via the outer `catch (Throwable)`. The inner catch must stay on `DomainException` — widening it to `Exception` would swallow infrastructure failures and let the batch report success on a broken database. A single missing mapping or a single invalid row must never take down the whole reconciliation, and a single lost connection must never silently swallow the run.

### Allocation generation filter

```php
function generateAllocations(LeavePolicyAssignment $assignment): void
{
    $employee = getEmployee($assignment->employee_id);
    $details  = getPolicyDetails($assignment->leave_policy_id);

    foreach ($details as $detail) {
        if (!isEligibleForLeaveType($employee, $detail->leave_type_id)) {
            continue; // e.g. male employee, Maternity Leave
        }
        createAllocation($assignment, $detail);
    }
}
```

### Group generation requirements

The group case is not a separate policy-rule category. It is simply a reconciliation job that resolves the current mapping for all employees in the target cohort.

The job should be:

- transaction-safe
- idempotent
- preview-before-apply
- summary-based with created/skipped/error counts
- protected by `SELECT ... FOR UPDATE` or by the generated-column unique constraint

For example, the flow is:

1. resolve employees for the financial year
2. preview matched employees, no-mapping employees, individual overrides, and employees skipped due to employment status
3. begin transaction
4. check for existing active assignment
5. insert missing assignment rows
6. log summary
7. commit

This is the only “group assignment” model the system should support.

---

## Open decision: the executive-policy gap

> The current seed data includes a `Standard Staff Leave Policy` and an `Executive Leave Policy` (“special policy for senior staff”). With department and job_group removed as policy categories, there is no remaining dimension that distinguishes executives.

This must be treated as an explicit open decision. The project should not silently resolve it. This remains unresolved until HR confirms which of the following is correct: manual individual override, a separate policy tier, a third mapping dimension, or removal of the executive policy entirely.

### Options

1. Individual assignment override  
   HR manually assigns executives with `assignment_type = 'individual'`. Simple, but does not scale and breaks when roles change.

2. Keep `job_group_id` as a third mapping dimension  
   Mapping key becomes `(employment_term, confirmation_status, job_group)`. This reintroduces combinatorial growth and conflict risk.

3. Introduce an explicit `policy_tier` on employees  
   Example: `staff`, `senior`, `executive`. Extend the mapping key to `(employment_term, confirmation_status, tier)`. Cleaner than job_group, but it is a schema addition.

4. Drop `Executive Leave Policy`  
   If seniority is not actually a leave-policy differentiator, remove the concept.

Do not pick one in this document. Present all four and mark the decision as pending.

> Leaving it undefined means executives will silently fall through to the standard policy, which is not acceptable.

---

## Pages and user journeys

The UI should no longer have a “group/category” selector as a policy assignment category. The Create Assignment page has two modes only:

### 1. Individual assignment

Fields:

- employee
- policy
- financial year
- effective from
- effective to

This creates one row in `leave_policy_assignments` with `assignment_type = 'individual'`.

### 2. Mapping-driven assignment

Fields:

- employee or target employee list
- financial year
- preview of current policy based on `employment_term_id` + `confirmation_status_id`
- confirm generation button

This page should show what the employee’s current attributes map to and let HR confirm assignment generation.

### Overview page

Keep the overview page already used in the project:

- total employees
- assigned employees
- unassigned employees
- coverage percentage
- per-policy breakdown
- recent activity

### Employee policy detail page

This should show:

- employee name
- payroll number
- current policy
- effective dates
- source mapping (if mapping-generated)
- leave balance summary

---

## User journeys

### Individual assignment flow

1. Navigate to `Policy Assignments`
2. Click `Create assignment`
3. Select `Individual`
4. Choose employee
5. Choose policy
6. Choose financial year
7. Confirm
8. System inserts one row with `assignment_type = 'individual'`

### Mapping reconciliation flow

1. Navigate to `Policy Assignments`
2. Click `Run mapping` or `Generate assignments for FY`
3. System previews all employees, their current term/confirmation pair, and the resolved policy
4. System shows:
   - matched employees
   - employees with no mapping
   - employees skipped due to employment status
5. Confirm generation
6. System creates `leave_policy_assignments` rows with `assignment_type = 'mapping'` in one transaction
7. Summary is displayed: `created`, `skipped_override`, `skipped_status`, `skipped_noop`, and `errors`. `skipped_status` counts employees skipped because their employment status (`resigned`, `retired`) makes them ineligible for assignment; `skipped_override` counts employees with an active individual override; `skipped_noop` counts employees whose mapping already matches their active assignment. These three are reported separately so HR can tell deliberate overrides, lifecycle-ineligible employees, and already-correct assignments apart.

---

## Best practices

1. Never select a policy by department, job group, gender, special need, or employment status.
2. Policy selection is deterministic from `(employment_term_id, confirmation_status_id)` via `leave_policy_mappings`.
3. One active assignment per employee per financial year is enforced by the generated-column unique key.
4. Group generation must be transactional and idempotent.
5. Employee attribute changes (confirmation, employment status) must trigger event-driven reassignment, not silent drift.
6. Gender and other eligibility rules belong to leave types, not policies.
7. Every assignment must record its provenance: `assignment_type`, `source_mapping_id`, and `created_by`.
8. Keep policy logic centralized in the mapping and assignment layers, not in page logic.


---

## Final recommendation

The corrected model is:

- `leave_policy_mappings` selects the policy from `(employment_term_id, confirmation_status_id)`
- `leave_policy_assignments` is the per-employee, per-year record with full audit trail
- `leave_allocations` are generated from the assignment and filtered by leave-type eligibility
- `employment_status` gates and cancels assignments; it never selects a policy
- individual override is supported with `assignment_type = 'individual'`
- the executive-policy gap is an explicit open decision, not silently handled

This design keeps the business logic simple, deterministic, and auditable.

---

## Summary

If we want employees to carry the correct leave policy:

- one employee assignment = direct insert into `leave_policy_assignments`
- standard assignment generation = resolve `(employment_term_id, confirmation_status_id)` through `leave_policy_mappings`
- leave allocations = generated from the active assignment with leave-type eligibility filters applied
- transition events (confirmation change, resignation, retirement) = update and cancel assignments as needed
- the system must remain auditable and idempotent at every step

This is the architecture that best fits the ELMIS schema and the rules already present in the canonical database.

---

## Migration note

Schema changes should be added as a migration under `database/migrations/` per the conventions used by the project. Do not edit `config/database.sql` directly in this guide.

The required migration work is:

- add `leave_policy_mappings` (year-scoped, with `financial_year_id` in the unique key)
- add `leave_type_gender_eligibility`
- extend `leave_policy_assignments` with `assignment_type`, `source_mapping_id`, `created_by`, `cancelled_at`, `cancel_reason`, and the generated column `active_employee_id` plus the corrected unique key
- replace the existing `uq_active_employee_year` unique key with the generated-column version
- add the `runReconciliation` background job or scheduler entry point
- ensure the reconciliation job resolves mappings by target financial year, not current financial year

### Database compatibility note

The generated-column uniqueness pattern is a target-state design and is only valid on database engines that support generated stored columns with uniqueness constraints. This project is using MySQL-compatible SQL patterns, and the generated column approach is therefore appropriate for MySQL/MariaDB environments that support the feature. Before applying this migration, confirm the target database engine version supports the required generated-column syntax and indexing semantics. If the production environment is older or differs from the intended MySQL/MariaDB platform, this pattern must be adapted or replaced with an equivalent application-level uniqueness guard.

---

## Final note on executive policy

> Open decision: The executive leave-policy distinction is currently unresolved. Because department and job_group are explicitly not policy selectors, the project must flag this as an unresolved design question until HR decides whether the organisation wants an explicit policy tier, a third mapping dimension, a manual override model, or to remove the executive policy entirely.

This is intentionally not resolved in the core design, because silently defaulting executives to the standard policy would undermine correctness.
