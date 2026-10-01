# Holiday Lists and FY Model

## Business rule

Holiday lists are persistent catalog records. They are not recreated per financial year.

- One list can be reused across multiple FYs.
- The financial year is tracked on each holiday row.
- The same list name can therefore contain different dates in different FYs.
- A holiday is uniquely identified by:
  - holiday_list_id
  - financial_year_id
  - holiday_date

This matches the requirement that a list like `Kenya National Holidays` stays the same across FYs, while the actual holiday dates move with the year.

## Canonical structure

### 1. Financial Years

Financial years are independent period records.

Example:

- FY-2526: 2025/2026
- FY-2627: 2026/2027
- FY-2728: 2027/2028

### 2. Holiday Lists

Holiday lists are persistent named collections.

Example:

- HL-KE: Kenya National Holidays
- HL-UG: Uganda National Holidays
- HL-TZ: Tanzania National Holidays

Rules:

- `holiday_lists` contains only list metadata
- `name` is unique
- `is_active` controls whether the list is available in usage
- `holiday_lists` does not own the financial year

### 3. Holidays

Each holiday row is tied to both the list and the FY.

Example:

- H-001 | HL-KE | FY-2627 | New Year's Day | 2027-01-01
- H-101 | HL-KE | FY-2728 | New Year's Day | 2028-01-01

This means the same list, same holiday name, same human concept, but a different FY and different date when the year changes.

## Why this is correct

The previous model incorrectly treated the list as FY-bound. That made the same list appear to be recreated each year, which breaks the requirement that the list persists and FY acts as a row-level dimension.

The corrected model correctly separates:

- the persistent catalog (`holiday_lists`)
- the time dimension (`financial_years`)
- the holiday event record (`holidays`)

## Database schema

The working schema is:

```sql
CREATE TABLE holiday_lists (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_holiday_list_name (name)
);

CREATE TABLE holidays (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  holiday_list_id INT UNSIGNED NOT NULL,
  financial_year_id INT UNSIGNED NOT NULL,
  holiday_date DATE NOT NULL,
  name VARCHAR(150) NOT NULL,
  is_weekly_off TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_holiday_list_financial_year_date (holiday_list_id, financial_year_id, holiday_date),
  CONSTRAINT fk_holidays_holiday_list
    FOREIGN KEY (holiday_list_id) REFERENCES holiday_lists (id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_holidays_financial_year
    FOREIGN KEY (financial_year_id) REFERENCES financial_years (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
);
```

## Application consequences

### List screen

The list page should show:

- List ID
- List Name
- Active
- Notes
- Number of Holidays

It should not show a per-list financial year column because the list is not FY-bound.

### Detail screen

The detail screen should:

- load one persistent list by ID
- show a FY selector
- filter holidays by `holiday_list_id` and `financial_year_id`
- allow adding/editing/deleting holidays for the selected FY only

### Data pattern example

For `HL-KE`:

- FY 2026/2027 has a set of holiday rows
- FY 2027/2028 has another set of holiday rows
- The list name remains `Kenya National Holidays`

This is the exact behavior the app is now aligned to.

## Migration note

The old migration that tried to make a default holiday list per FY was superseded because it contradicts the business model.

The final model is:

- holiday lists persist across FYs
- holiday rows carry FY
- uniqueness is scoped to `(holiday_list_id, financial_year_id, holiday_date)`

## Implementation status

The app code and schema are aligned to this final model:

- list rows are persistent
- FY selection occurs on the detail page
- holiday queries use both list and FY
- duplicates are prevented per list + FY + date
