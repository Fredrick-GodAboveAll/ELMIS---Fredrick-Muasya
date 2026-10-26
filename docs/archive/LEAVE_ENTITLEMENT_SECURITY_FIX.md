# Leave Entitlement Security and Validation Fix

## Issue summary

The Leave Entitlement Detail page accepted a `year` value from the URL query string and used it directly to fetch entitlement data. Because the value was not validated against the known financial-year records, a user could tamper with the URL and trigger a page load with an invalid or fake year.

This created a security and correctness problem:

- invalid or non-existent years could be displayed as if they were real
- the code could silently fall back or render empty states for a fake year
- the app did not consistently reject untrusted query input
- if the page were opened with a malicious or malformed `year`, the user could be misled into thinking the year existed

## Root cause

The detail controller previously used this pattern:

- read `$_GET['year']`
- trim and normalize it
- call the entitlement service with it
- render the page

There was no check that the supplied value existed in the database-backed list of financial years before using it.

The validation fix was needed in the controller itself:

- `app/Controllers/LeaveController.php`

The service and model were inspected and used as read-only access points, but they did not require modification for the validation fix. In particular, the underlying entitlement lookup already used a prepared `SELECT` query and did not perform writes during a GET request.

This was therefore a correctness and resource-validation issue rather than a database-write vulnerability.

## What was fixed

The minimal fix keeps the existing ELMIS architecture and does not redesign routing or add a new authorization system.

### 1. Authorization is enforced for Leave Entitlement routes

The routes for the leave-entitlement pages now use the existing `AuthMiddleware` and `RoleMiddleware` pattern already present in the app.

Relevant files:

- `routes/web.php`
- `app/Middleware/AuthMiddleware.php`
- `app/Middleware/RoleMiddleware.php`

The allowed role for these pages is the existing `admin` role stored in session as `user_role`.

### 2. Financial-year validation is required before page rendering

The detail page now does this in order:

1. Authentication check runs first via existing middleware
2. Authorization check runs second via existing `RoleMiddleware`
3. If the user is authenticated and authorized, the controller checks whether the `year` query parameter exists and is non-empty
4. The supplied year is normalized
5. The controller compares it against the known financial-year labels from the app
6. If it is missing, malformed, or does not match a real financial year, the controller uses the existing 404 mechanism
7. Only a valid, existing year is used to read entitlement data

This ensures no silent fallback to the current/latest year when a user explicitly provides an invalid year.

### 3. GET remains read-only

The detail page still performs only read operations:

- `getFinancialYearConfigurationSummary()`
- `getEntitlementsForYear()`

No INSERT, UPDATE, or DELETE queries were introduced for the GET page load.

## Existing error handling used

The fix intentionally uses the already existing ELMIS mechanisms rather than creating a new architecture.

### 403 (unauthorized)

Handled by the existing route middleware:

- `app/Middleware/RoleMiddleware.php`

Behavior:

- checks `Session::get('user_role')`
- if role is not allowed, calls `http_response_code(403)` and exits with the app's current access-denied message

### 404 (missing, malformed, or non-existent year)

Handled by the existing controller error flow:

- `app/Controllers/ErrorController.php`
- `app/Views/errors/404.php`

Behavior:

- `notFound()` sets `http_response_code(404)` and renders the existing 404 page

### 500

Kept as the existing server-side exception path:

- `app/Core/ErrorHandler.php`
- `app/Views/errors/500.php`

No change was made to the global 500 handler.

## Resulting behavior

When a user is authenticated and allowed:

- valid year -> `200`
- missing year -> `404`
- malformed year -> `404`
- non-existent year -> `404`

When a user is authenticated but not allowed:

- any request to this page -> `403`

When a user is unauthenticated:

- existing login redirect is used

## Files touched

- `routes/web.php`
- `app/Controllers/LeaveController.php`

## Verification

The PHP syntax of the changed controller file was checked with:

```bash
php -l "c:\Users\Administrator\Documents\ELMIS---Fredrick-Muasya\app\Controllers\LeaveController.php"
```

Result:

- No syntax errors detected

No browser or HTTP integration test was executed from this environment, so no live runtime success claim is made beyond the syntax validation above.
