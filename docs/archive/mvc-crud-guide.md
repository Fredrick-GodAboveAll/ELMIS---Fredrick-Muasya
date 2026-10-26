# MVC CRUD guide for this codebase

This project uses a simple PHP MVC structure. When you add a new create, edit, or delete action, the request usually moves through the same layers in the same order: View → Route → Controller → Service → Model → Redirect.

## 1. The six-layer model

Every CRUD action in this project follows the same idea: the browser sends a form submission, the route decides which controller method handles it, the controller validates the input, the service or model performs the database work, and the controller redirects back to a page with a flash message.

| Layer | File/area in this project | Responsibility |
| --- | --- | --- |
| View | app/Views/... | Renders the page, builds the POST form, includes hidden CSRF and ID fields, and shows flash alerts |
| Route | routes/web.php | Maps a URL to a controller method and applies middleware |
| Controller | app/Controllers/*.php | Validates the request, reads POST data, calls the model/service, and redirects |
| Service | app/Services/*.php | Encapsulates business logic when work spans multiple models or rules |
| Model | app/Models/*.php | Runs prepared SQL against the database |
| Redirect | Controller method | Uses header('Location: ...') and exit; returns the browser to the list page |

A real example in this project is the holiday list flow:

- The page is rendered by app/Views/leave_management/leave_setup/holiday_list.php
- The route is registered in routes/web.php
- The action is handled in LeaveController
- The database logic lives in HolidayListModel
- The result is returned to the browser through a redirect with Session::flash(...) messages

## 2. Layer-by-layer guide

### View

The view is responsible for the form markup and all user-facing feedback.

For a delete or update action, the view should use a form with method="POST" and include a CSRF token field hidden from the user. The ID should be passed as a hidden field instead of being read from the URL. Destructive actions should use an onsubmit confirmation before submitting. If the form sits inside a Bootstrap dropdown, use class="m-0" so it does not add unwanted spacing.

This project uses the same pattern in several places, including the holiday list page. Example from app/Views/leave_management/leave_setup/holiday_list.php:

```php
<form method="POST" action="/holiday-lists/delete" class="m-0"
      onsubmit="return confirm('Delete this holiday list? All holidays in it will also be removed. This cannot be undone.');">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8') ?>">
  <input type="hidden" name="id" value="<?= (int) $holidayList->id ?>">
  <button type="submit" class="dropdown-item text-danger">
    Delete
  </button>
</form>
```

The view also renders flash messages with Session::flash('success') and Session::flash('error') so the user sees the result of the redirect.

### Route

Routes are declared in routes/web.php. For an action that mutates data, use a POST route and mirror the same middleware as the GET sibling page.

Example:

```php
$router->post('/holiday-lists/delete', 'LeaveController@deleteHolidayList', [
    AuthMiddleware::class,
    [RoleMiddleware::class, 'admin']
]);
```

This matches the rest of the app: the page is protected by AuthMiddleware and the admin-only action also uses RoleMiddleware.

### Controller

The controller owns the request flow. The pattern is consistent across the project:

1. Check the request method.
2. Validate the CSRF token.
3. Read and validate input.
4. Call the model or service.
5. Redirect with Session::flash and exit.

Example structure:

```php
public function deleteHolidayList()
{
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Session::flash('error', 'Invalid request method.');
            header('Location: /holiday-list');
            exit;
        }

        Csrf::validate($_POST['csrf_token'] ?? '');

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            throw new InvalidArgumentException('A valid holiday list is required.');
        }

        $holidayListModel = new \App\Models\HolidayListModel();
        $holidayList = $holidayListModel->find($id);
        if (!$holidayList) {
            throw new InvalidArgumentException('Holiday list not found.');
        }

        $holidayListModel->deleteWithChildren($id);

        Session::flash('success', 'Holiday list deleted successfully.');
        header('Location: /holiday-list');
        exit;
    } catch (InvalidArgumentException $e) {
        Session::flash('error', $e->getMessage());
        header('Location: /holiday-list');
        exit;
    } catch (\Throwable $e) {
        Session::flash('error', 'Unable to delete holiday list. Please try again.');
        header('Location: /holiday-list');
        exit;
    }
}
```

The separate catch blocks matter:

- InvalidArgumentException is for validation and missing-resource problems. These errors are user-facing and should show the specific message.
- \Throwable is for unexpected database, PDO, or runtime failures. These should not reveal internals and should show a generic message instead.

That separation is used in LeaveController for other actions as well, including togglePolicyActive() and storeHolidayList(). It keeps user messaging clean and avoids exposing raw exception details.

### Service

A service exists when there is business logic that sits above the raw database access, especially when multiple models are involved or the action is part of a broader leave-management workflow.

Examples in this project include LeavePolicyService, LeaveTypeService, and HolidayService.

When the action is a single-table operation, a model is enough. For example, the holiday list delete is still a direct data operation on the holiday_lists table, but the model handles the child cleanup because the schema requires it. When the logic is only one table and a simple CRUD action, the controller can call the model directly without a custom service.

### Model

Models contain the prepared SQL and database interaction. Always use prepared statements. Never concatenate user input into SQL strings. Return types should be explicit and consistent with the project.

This project uses patterns like:

- find($id)
- deleteWithChildren(int $id): void
- create(array $data): int
- setActive(int $id, int $isActive): void

The holiday list model is a strong example. It uses prepared statements and returns null for missing rows instead of throwing. When fetching a single row, use fetch(PDO::FETCH_OBJ) instead of fetchAll. In practice, this project keeps the parent model method signature compatible with Model::find($id), while the concrete holiday-list logic still validates and normalizes the ID before use.

Transactions are required when multiple tables must change together. In this project, deleteWithChildren() checks whether the legacy bridge table still exists before deleting from it, because the current schema keeps the financial year directly on holiday_lists rather than through financial_year_holiday_lists. The method does this in a transaction:

```php
$this->db->beginTransaction();

$pivotTable = 'financial_year_holiday_lists';
$pivotExists = $this->db->query(
    "SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '{$pivotTable}' LIMIT 1"
)->fetchColumn();

if ($pivotExists) {
    $pivotSql = "DELETE FROM {$pivotTable} WHERE holiday_list_id = :id";
    $pivotStmt = $this->db->prepare($pivotSql);
    $pivotStmt->execute([':id' => $id]);
}

$holidayListSql = "DELETE FROM {$this->table} WHERE id = :id";
$holidayListStmt = $this->db->prepare($holidayListSql);
$holidayListStmt->execute([':id' => $id]);

$this->db->commit();
```

If anything fails, the model rolls back and rethrows the exception, so the database remains consistent.

### Redirect

After a successful POST, do not render the page directly. Redirect the browser using header('Location: ...') and exit immediately.

This is the Post/Redirect/Get pattern and it is required in this project. It avoids resubmissions and ensures the next page load shows the flash message that was set on the session.

Example:

```php
Session::flash('success', 'Holiday list deleted successfully.');
header('Location: /holiday-list');
exit;
```

## 3. The FK gotcha: check the schema before deleting

This project has a real foreign-key trap that affects delete operations, and the correct behavior depends on the actual schema version you are running.

The current app schema now stores the financial year directly on holiday_lists with a `financial_year_id` column. The older bridge-table pattern (`financial_year_holiday_lists`) was migrated away in [database/migrations/2026_09_26_holiday_lists_direct_financial_year.sql](database/migrations/2026_09_26_holiday_lists_direct_financial_year.sql), which drops the legacy bridge table and adds `holiday_lists.financial_year_id` instead.

That means the delete logic must check the actual database state before trying to clean up child rows:

- If the old bridge table still exists, delete its rows first.
- If it does not exist, skip that cleanup and delete the holiday list directly.
- For holidays, the child rows are still tied to `holiday_list_id` and should be handled with the correct cascade logic in the schema.

This is why HolidayListModel::deleteWithChildren() checks `information_schema.tables` before attempting to remove rows from `financial_year_holiday_lists`, then deletes the parent row in the same transaction. It avoids blindly deleting from a table that no longer exists while still remaining safe for older data.

## 4. Full walkthrough of the delete flow using the holiday list example

This is the worked flow for the holiday list delete action.

1. The user clicks the three-dot menu on a row in app/Views/leave_management/leave_setup/holiday_list.php.
2. The view shows a form with POST, a hidden CSRF token, and a hidden id field. It also uses a browser confirmation before submission.
3. The browser submits to /holiday-lists/delete.
4. The route in routes/web.php maps that request to LeaveController@deleteHolidayList.
5. The controller checks that the request method is POST. If not, it flashes an error and redirects to /holiday-list.
6. The controller calls Csrf::validate($_POST['csrf_token'] ?? ''). If the token is invalid, it flashes an error and redirects.
7. The controller reads $id = (int) ($_POST['id'] ?? 0); if it is not greater than zero, it throws InvalidArgumentException.
8. The controller calls HolidayListModel::find($id) to confirm the record really exists.
9. If the record does not exist, it throws InvalidArgumentException and redirects with the error.
10. The controller calls HolidayListModel::deleteWithChildren($id).
11. The model begins a transaction and checks whether the legacy bridge table still exists.
12. If the table exists, it deletes the corresponding rows from financial_year_holiday_lists before deleting the holiday list row.
13. If the table does not exist, it skips that cleanup and deletes the holiday list directly.
14. If anything fails, the model rolls back and rethrows the exception.
15. The controller catches InvalidArgumentException for user errors and \Throwable for unexpected failures.
16. On success, it sets a success flash message and performs a redirect to /holiday-list.
17. The page reloads and the deleted row is no longer shown.

This is the exact pattern the project expects for any delete action.

## 5. Checklist before committing a new CRUD action

Before merging any new create, edit, or delete feature, tick these items:

1. Route exists in routes/web.php and uses the correct HTTP method.
2. Middleware matches the page access rules.
3. View includes the CSRF hidden input.
4. View uses POST, not a GET link, for destructive actions.
5. ID is sent as a hidden field instead of in the URL.
6. The form includes class="m-0" if it is inside a dropdown.
7. The form uses onsubmit confirm for delete actions.
8. Controller checks the request method before touching data.
9. Controller validates CSRF.
10. Controller reads and validates the input ID.
11. Controller checks whether the target record exists before deleting or updating.
12. Controller uses the correct PRG flow: flash → redirect → exit.
13. Controller has separate InvalidArgumentException and \Throwable catch blocks.
14. No raw exception message is exposed to the user in the generic catch.
15. The model uses prepared statements only.
16. The model returns explicit types like ?object, int, or void.
17. Multi-table deletes or writes use a transaction.
18. Child rows are cleaned up before parent deletion when the schema uses RESTRICT.
19. header('Location: ...') is followed by exit.
20. The list page or detail page re-renders the correct result after the redirect.
21. Flash messages are displayed in the view.
22. The route and controller names match the real class and method names exactly.
23. No migration or schema changes were made unless explicitly requested.
24. The action is tested against the real database behavior and not only the UI mock.

## 6. Common mistakes and fixes

| Common mistake | Why it breaks | Fix |
| --- | --- | --- |
| Using a link instead of a form | Links trigger GET requests and bypass CSRF | Use a POST form with a submit button |
| Missing CSRF token | The request is rejected by Csrf::validate() | Add hidden input name="csrf_token" |
| ID in URL instead of hidden field | It is easy to tamper with and not consistent with this project | Use a hidden input name="id" |
| Using GET for a delete route | GET should not mutate data | Use $router->post(...)
| No method check in the controller | Invalid requests can hit the action | Add if ($_SERVER['REQUEST_METHOD'] !== 'POST') |
| header without exit | Execution continues and may render after redirect | Always add exit immediately after header() |
| Rendering after POST | The page may re-submit and show stale state | Use PRG: flash + redirect + exit |
| Showing raw exception text | It exposes unsafe internals | Catch InvalidArgumentException separately and use a safe generic message in \Throwable |
| Deleting the parent row without removing RESTRICT child rows | Database constraint failure | Remove rows from the pivot table first when it exists, then wrap the delete in a transaction |
| Assuming the old bridge table is always present | Delete fails on the newer schema where the bridge table is gone | Check information_schema.tables before deleting from financial_year_holiday_lists |
| String-concatenated SQL | Creates injection risk and breaks project conventions | Use prepared statements with placeholders |
| Writing multi-table updates without a transaction | Partial writes can leave data inconsistent | Begin transaction, commit after all statements, rollback on error |
| Not checking whether the record exists first | You can attempt to delete a missing row | Use find() before deletion |
| Not redirecting after success | The user may stay on a stale POST page | Use Session::flash() plus header('Location: ...') and exit |
| Using fetchAll for a single row | It is the wrong data shape for one row | Use fetch(PDO::FETCH_OBJ) and return ?: null |
| Not using the app's actual names | You can create mismatched route/controller pairs | Use real names like LeaveController, HolidayListModel, Csrf, Session |

## Summary

The project’s CRUD pattern is intentionally simple and consistent. Use the real conventions already in this codebase:

- View with POST form and CSRF
- Route with middleware and POST
- Controller with method check, CSRF validation, validation, model call, PRG redirect
- Model with prepared statements and transactions when multiple tables are involved
- Redirect with Session::flash and exit

The holiday list delete example follows that pattern exactly and should be treated as the reference for new delete actions in this app.
