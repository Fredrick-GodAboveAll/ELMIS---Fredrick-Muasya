# Leave Types Page Guide

## Overview

The Leave Types page is the admin screen for managing leave definitions used across the HR/leave system. It allows an admin to view existing leave types and add a new one from the form in the offcanvas panel.

The current structure follows a simple MVC pattern:

- View: displays the page and modal data
- Controller: receives requests and calls the service
- Service: handles business validation and rules
- Model: talks to the database using PDO
- Database: stores the actual leave type records

---

## Current Connection Flow

### 1) Route
The page is exposed in the router:

- `GET /leave-types` -> `LeaveController@LeaveType`
- `POST /leave-types` -> `LeaveController@storeLeaveType`

This is defined in [routes/web.php](../routes/web.php).

### 2) Controller
The controller is responsible for:

- loading the page view
- loading leave type data from the service
- validating form input on create
- redirecting with flash messages

Main file:

- [app/Controllers/LeaveController.php](../app/Controllers/LeaveController.php)

### 3) Service
The service contains the business logic, such as:

- checking whether the leave type name is empty
- validating entitlement values
- validating calculation method
- validating carry-forward values
- checking duplicate names
- creating the record through the model

Main file:

- [app/Services/LeaveTypeService.php](../app/Services/LeaveTypeService.php)

### 4) Model
The model is a thin database layer for the `leave_types` table.

Responsibilities:

- fetch all active leave types
- check if a leave type name already exists
- insert new records

Main file:

- [app/Models/LeaveType.php](../app/Models/LeaveType.php)

### 5) Database table
The table stores the leave definition itself.

Core fields:

- `id`
- `name`
- `annual_entitlement_value`
- `calculation_method`
- `carry_forward`
- `carry_forward_limit`
- `is_active`
- `created_at`
- `updated_at`

Schema file:

- [config/database.sql](../config/database.sql)
- [database/migrations/2026_08_31_create_leave_types_table.sql](../database/migrations/2026_08_31_create_leave_types_table.sql)

---

## Page View

The page view is located at:

- [app/Views/leave_management/leave_setup/leave_types.php](../app/Views/leave_management/leave_setup/leave_types.php)

It contains:

- the page title and breadcrumb
- the Add Leave Type offcanvas button
- the list/table of leave types
- the per-row View action
- the modal showing leave type details
- the offcanvas form for creating a new leave type

---

## Suggested Service Behavior

The service should behave like a business-rule layer instead of a raw SQL wrapper.

### It should:

1. Accept raw form data from the controller.
2. Trim and normalize the input.
3. Validate required values.
4. Reject invalid values early.
5. Check for duplicate leave type names.
6. Convert values to canonical formats before saving.
7. Delegate actual database insertion to the model.
8. Throw exceptions for business validation problems so the controller can convert them into flash messages.

### Example rules

- leave name is required
- annual entitlement must be 0 or greater
- calculation method must be either `working_days` or `calendar_days`
- carry forward must be `0` or `1`
- carry forward limit cannot be negative
- if `carry_forward = 0`, limit should effectively be 0
- duplicate leave names should be rejected

This keeps validation clean and ensures the controller does not become too messy.

---

## Recommended Future Behavior

For version 2, the service should also support:

- fetching one leave type by id
- updating a leave type
- soft deleting or deactivating a leave type
- listing all active and inactive leave types separately
- optionally validating whether a leave type is currently used in employee leave calculations before deleting it

This is the right phase-1 system: simple, safe, and easy to extend.

---

## Recommended Architecture Rule

Keep the service responsible for business logic and keep the model responsible for database operations only.

That means:

- Controller: request handling and redirecting
- Service: rules and validation
- Model: SQL and PDO operations
- View: presentation only

This pattern is easy to maintain and fits the rest of the project.

---

## Final Recommendation

The current design is a good step 1 for this project. It is simple, aligned with the UI, and easy to expand later without over-engineering.

The page is already structured correctly for the next growth stage.
