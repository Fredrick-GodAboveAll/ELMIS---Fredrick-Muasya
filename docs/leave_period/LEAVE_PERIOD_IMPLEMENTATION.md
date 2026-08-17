# Leave Period / Financial Year Implementation

## Current behavior

The Leave Period form follows the LeaveDesk financial-year rule:

- Financial year starts on 1 July
- Financial year ends on 30 June of the following year
- The system automatically calculates the end date from the selected start date
- The end date is read-only in the UI
- The financial-year label is generated automatically, for example `2026/2027`

## Automatic end-date calculation

The user only selects the start date. The UI automatically computes the matching financial-year end date.

Example:

- Start date: `01/07/2026`
- End date: `30/06/2027`
- Label: `2026/2027`

This is handled on the page using JavaScript so the field appears populated immediately and is locked from manual editing.

## UI behavior

The relevant form fields work as follows:

- `from_date` is editable
- `to_date` is automatically populated and marked `readonly`
- `holiday_list_name` is auto-generated from the selected financial year and is effectively system-managed

This keeps the existing Falcon/Bootstrap layout and styling exactly as it is while changing only the behavior of the relevant fields.

## Server-side protection and duplicate checks

The JavaScript is only a convenience layer. The final authority is the backend, which recalculates the financial-year values from the submitted start date and ignores any browser-provided `to_date` or `holiday_list_name` values.

The save process now does the following:

1. Validates the CSRF token.
2. Validates the submitted `from_date`.
3. Recalculates the correct end date using the `1 July -> 30 June` rule.
4. Generates the correct financial-year label such as `2026/2027`.
5. Ignores any browser-supplied label or end date values.
6. Rejects duplicate financial-year ranges or duplicate labels already stored in `financial_years`.
7. Validates the active flag before saving.
8. Saves the generated values to the existing `financial_years` table.
9. Preserves the active/current-year logic already used by the app.

## Financial-year calculation logic

The server calculates the financial year as follows:

- If the selected date is in July or later, the financial year starts in that same calendar year.
- If the selected date is before July, the financial year starts in the previous calendar year.
- The end date is always 30 June of the following year.
- The label is generated directly from those dates, for example `2026/2027`.

This ensures the rule remains consistent even if someone manipulates the browser HTML or submits a malformed request.

## Duplicate and missing-field protection

The controller explicitly rejects invalid submissions such as:

- missing start date
- duplicate financial year range
- duplicate financial-year label
- invalid active checkbox value

It does not rely on trusting the browser to send a correct label or end date because those values are system-generated from the start date.

## Database table used

The implementation continues to use the existing table structure:

```sql
CREATE TABLE financial_years (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(9) NOT NULL UNIQUE,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_current BOOLEAN NOT NULL DEFAULT 0
);
```

## Save flow

The complete updated save flow is:

1. User selects a start date.
2. JavaScript calculates the end date and label for convenience.
3. The UI sets the `to_date` field as read-only.
4. The form is submitted to `/new-leave-period`.
5. `LeaveController@storeLeavePeriod()` validates the request.
6. PHP recalculates the correct financial-year dates and label from the submitted start date.
7. The controller ignores any browser-provided `to_date` or `holiday_list_name` values.
8. Duplicate checks run against the generated values.
9. The final values are saved to `financial_years`.
10. The active flag is applied as before, and the current-year logic remains in place.

## Delete action and current-year logic

The leave-period table now includes a real delete action in the row menu. When a user deletes a leave period, the backend:

1. Validates the CSRF token.
2. Confirms the record ID is valid.
3. Loads the period to confirm it exists.
4. Deletes the record from the `financial_years` table.
5. If the deleted record was the current financial year, it reassigns the current flag to the latest remaining financial year when available.
6. Redirects back to `/leave-periods` with a success or error message.

This keeps the active/current-year behavior consistent even after a record is removed.

## Notes

- No change was made to the existing `financial_years` table structure.
- The UI remains visually unchanged apart from the required read-only behavior.
- The current-year logic remains unchanged and continues to work with the saved records.
- The app now protects against duplicate or malformed financial-year submissions at the server layer, while the client-side JavaScript provides immediate feedback and convenience.
- The leave-period list now supports deleting an existing financial year record through the table actions menu.
