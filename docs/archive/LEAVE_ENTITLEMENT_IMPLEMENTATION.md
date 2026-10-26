# Leave Entitlement Implementation Guide

## Overview

This module follows the ELMIS architecture rules already present in the project:

- `leave_types` stores the definition of leave categories and calculation logic.
- `financial_years` stores the financial-year periods.
- `leave_entitlements` stores the actual entitlement rule for a leave type within a financial year.
- `leave_policies`, `leave_policy_details`, and `leave_allocations` are separate downstream layers and are not mixed into the entitlement setup screens.

The UI work for Leave Entitlement was completed without redesigning the project structure. The page now reads from the actual database tables and displays the live entitlement rows from the `leave_entitlements` table.

---

## Database rules already in the project

The canonical schema is defined in `config/database.sql` and the relevant tables are:

### 1. `financial_years`

Used to define each financial period.

Fields:
- `id`
- `label` — example: `2026/2027`
- `start_date`
- `end_date`
- `is_current`
- `created_at`
- `updated_at`

Important rules:
- `label` is unique.
- `start_date` and `end_date` are unique together.
- This table is the master list of FY periods used across leave processing.

### 2. `leave_types`

Used to define the leave category itself.

Fields:
- `id`
- `name`
- `calculation_method` (`working_days` or `calendar_days`)
- `is_active`
- `created_at`
- `updated_at`

Important rules:
- `name` is unique.
- This table should not hold FY-specific rules.
- It is only the definition of the leave type.

### 3. `leave_entitlements`

This is the working table for year-specific entitlement rules.

Fields:
- `id`
- `financial_year_id`
- `leave_type_id`
- `entitlement`
- `carry_forward`
- `carry_forward_limit`
- `pro_rata_allowed`
- `created_at`
- `updated_at`

Important rules:
- A given financial year and leave type combination is unique.
- This is the actual entitlement configuration record.
- It belongs to the financial year, not to the leave type master definition.

### 4. Related downstream tables

The project already includes:
- `leave_policies`
- `leave_policy_details`
- `leave_policy_assignments`
- `leave_allocations`

These depend on the entitlement layer but are separate from the setup screens.

---

## Architectural decision respected

The work kept the project aligned with the original design constraints:

- No redesign of the architecture.
- No reintroduction of entitlement logic into `leave_types`.
- No new tables created.
- Only the UI and controller logic were connected to the existing schema.

---

## What was implemented

### 1. Leave Entitlement landing page

The page at `app/Views/leave_management/leave_setup/leave_entitlement.php` now reads live FY data instead of hard-coded values.

It displays:
- Financial year label
- Date range
- Leave type count / rule count
- Current status
- Entitlement row links to the selected FY detail page

### 2. FY detail page

The page at `app/Views/leave_management/leave_setup/leave_entitlement_detail.php` now reads the selected FY from the URL and loads the entitlement rows from the database.

If a year has actual records, the page shows them in the main view. If it has no entitlement rows, it displays the empty-state message and the add form offcanvas.

### 3. Controller and service layer

New and updated code:
- `app/Models/LeaveEntitlement.php`
- `app/Services/LeaveEntitlementService.php`
- `app/Controllers/LeaveController.php`

The controller now:
- loads the FY summary for the main list
- resolves the selected FY from the query string
- fetches the entitlement rows for that FY
- passes the data into the view

### 4. Query-string design

The route remains simple and practical for ELMIS:

- `/leave-entitlements`
- `/leave-entitlements/detail?year=2026/2027`

This keeps the URL readable without exposing internal DB identifiers. The backend still validates the year value and queries the database safely.

---

## SQL logic used

The page summary uses a join between `financial_years` and `leave_entitlements` and derives counts for each financial year.

The detail page uses a query that joins:
- `financial_years`
- `leave_entitlements`
- `leave_types`

so the page can render actual data like:
- leave type name
- entitlement value
- carry forward status
- carry forward limit
- calculation method

---

## Notes for the next phase

The current implementation intentionally does not yet add the save logic to the database. The user requested to build the page flow and connect the live reading of entitlement data first. That part is now in place.

The next non-UI step would be:
- POST form validation for the offcanvas
- insert/update logic into `leave_entitlements`
- duplicate prevention by `financial_year_id + leave_type_id`
- authorization validation for the selected financial year

---

## Summary

This module is now connected to the real ELMIS schema in the correct place:

- `financial_years` = year definition
- `leave_types` = leave type definition
- `leave_entitlements` = FY-specific rule configuration

The main Leave Entitlement page and the FY detail page now display actual entitlement data from the database rather than placeholder card values.
