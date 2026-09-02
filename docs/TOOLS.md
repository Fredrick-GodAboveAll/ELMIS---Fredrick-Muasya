# Tools

This document describes the lightweight tools provided in the `app/Controllers/ToolsController.php` and the related service `app/Services/LeaveCalculator.php`.

## Leave Calculator

Purpose
- Small, isolated calculator for counting leave days between two dates without touching application data.

Location
- Service: `app/Services/LeaveCalculator.php`
- Test page: `app/Views/tools/leave_calculator.php`
- Controller: `app/Controllers/ToolsController.php`
- Route: `/tools/leave-calculator` (GET & POST)

How it works
- The UI accepts:
  - `start_date` (required)
  - `leave_type` (required)
  - `number_of_days` (required)

- Note: The calculation method is automatically determined from the selected leave type. The service API still supports an explicit `calculation_method` parameter, but the test UI deliberately does not expose that option.

- Behavior:
  - The calculator determines the calculation method from the leave type (using the temporary internal map) and computes the automatic end date and return-to-work date.
  - The calculator does NOT consider public holidays, entitlements, proration, carry-forward, balances, approvals, or any DB interactions.

Additional outputs
- The calculator workflow produces both the leave end date and the return-to-work date when calculating from `start_date` + `number_of_days`.
- Global rule: leaves cannot start on Saturday or Sunday — the calculator will return a validation error: "Leave cannot start on Saturday or Sunday." if a weekend start is provided.

Return-to-work rules
- For any end date the return-to-work date is the next Monday–Friday working day following the leave end date. Examples:
  - End on Friday => Return on Monday
  - End on Saturday or Sunday => Return on Monday
  - End on Thursday => Return on Friday

Internal mapping (small examples)
- `annual` -> `working_days`
- `sick` -> `working_days`
- `maternity` -> `calendar_days`
- `compassionate` -> `working_days`
- `casual` -> `working_days`
- `paternity` -> `working_days`

These mappings live inside `LeaveCalculator::inferMethodFromLeaveType()` and are intentionally minimal so they can be replaced with a DB-driven lookup later.

PRG (POST-Redirect-GET)
- The Tools controller uses a PRG pattern: after a POST calculation the controller stores the result or error in session flash and redirects to GET to avoid accidental form resubmission when refreshing the page.
-
**Design notes — Calculator workflow and Leave Type ownership**

Yes — **exactly.** And you caught the important distinction.

### What we're doing with the calculator RIGHT NOW
The tool is proving this workflow:

```
Start Date
  +
Leave Type
  +
Number of Days
  ↓
Calculator knows the leave type's rule
  ↓
Calculation Method
  ↓
Automatic End Date
  ↓
Return to Work Date
```
So yes, **the calculator is already testing the automatic behavior**.

The hard-coded map is simply how we're telling the calculator *for now* what each leave type means.

---

### And yes — when adding a Leave Type, the rule belongs to the Leave Type
**Absolutely.**

That's why your Leave Type setup has:

> **Calculation Method**
When an admin creates a leave type, they should define its rule:

```
Leave Type:          Maternity
Annual Entitlement:  90
Calculation Method:  Calendar Days
Carry Forward:       No
```
Another:

```
Leave Type:          Annual Leave
Annual Entitlement:  30
Calculation Method:  Working Days
Carry Forward:       Yes
Carry Forward Limit: 15
```
So the important concept is:

> **The Leave Type owns the calculation rule.**
The calculator shouldn't have to permanently maintain a separate list of rules. Our hard-coded map is just **temporary for this standalone calculator tool** while we're perfecting the mathematics.

Later, when the real system is built, the conceptual flow will be:

```
Leave Type
   │
   ├── Entitlement
   ├── Calculation Method ← this is the rule
   ├── Carry Forward
   └── Carry Forward Limit
        │
        ↓
    Leave Calculator
        │
    ┌─────┴─────┐
    ↓           ↓
  End Date    Return Date
```
So **yes, you absolutely need that rule when adding a Leave Type.**

And this is why I like what we're doing now: we're using the calculator tool to **prove the mathematics before we connect that mathematics to the actual Leave Type configuration.**

We're not building two different systems. We're **testing the engine first**, then later the real Leave Type data will become the source of those rules.

---
Generated on 2026-09-02 by the developer tools assistant.
