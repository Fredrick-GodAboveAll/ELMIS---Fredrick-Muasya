# Bulk Employee Upload Update

## Date
2026-08-23

## Summary
This document captures the bulk employee upload work completed today for the ELMIS HR system.

The implementation was updated so the upload feature behaves like a real employee import, instead of silently updating existing employees.

## What was fixed

### 1. Import no longer behaves like an update
The previous logic used payroll number matching as an upsert. That meant a row with an existing payroll number would update an existing employee record instead of rejecting it.

The current behavior is:
- valid new employee records are inserted
- duplicate payroll numbers are rejected
- invalid rows are rejected
- no silent update is allowed during a bulk new employee upload

### 2. Row validation is strict
A row is accepted only if it includes the required data.

Required values include:
- payroll_number
- full_name
- id_number
- gender
- age
- date_of_birth
- designation
- job_group
- employment_status
- engagement_type
- rod_date

The importer also rejects rows where:
- payroll number is empty or invalid
- gender is not M or F
- age is missing or zero
- date fields are invalid or empty
- required text fields are blank

### 3. Import reporting is clearer
The success message now reports the actual import result:
- record(s) added
- record(s) rejected

Example:

Employees import completed. 1 record(s) added and 1 record(s) rejected.

## Bulk upload page behavior
The bulk upload page is used to import employees through the employee upload form on the bulk actions screen.

This page supports:
- CSV upload
- Excel (.xlsx) upload
- template download
- validation before insert

## Important rule for new employee uploads
If the goal is to import brand-new employees only, the upload file must contain:
- unique payroll numbers
- valid employee data
- no existing payroll numbers already in the database

If any row fails validation, it is skipped and counted as rejected.

## Example valid test file
A valid sample file should look like this:

```csv
payroll_number,full_name,id_number,gender,age,date_of_birth,designation,job_group,employment_status,engagement_type,rod_date,special_need
90001,MS MARY WANGARI,30010001,F,28,1997-05-10,Human Resource Officer,K,permanent,Permanent,2038-07-01,0
90002,MR DAVID KIPTOO,30010002,M,31,1994-09-18,Finance Assistant,H,contract,Permanent,2037-06-30,0
```

## Example invalid row
A row like this should be rejected:

```csv
,MR BAD DATA,30010004,M,,1990-01-01,Officer,J,permanent,Permanent,2030-01-01,0
```

Reasons it is rejected:
- payroll_number is empty
- age is missing

## Files involved
- app/Controllers/BulkImportController.php
- app/Models/Employee.php
- storage/examples/employees_valid.csv
- storage/examples/employees_invalid.csv
- storage/examples/employees_mixed.csv
- storage/examples/employees_one_valid_one_bad.csv

## Notes
This work was done to make the employee bulk upload page behave in a predictable, safe way for HR data imports and to prevent accidental edits of existing employees during a fresh import.
