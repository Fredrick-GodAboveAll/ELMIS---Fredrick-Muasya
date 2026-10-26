# Leave Management Project Reference

This document is a working reference for the leave management module in this project. It captures what already exists, the rules already being enforced, the architecture pattern being followed, and the recommended direction for the future leave application workflow.

It is meant to help the team brainstorm and align around a final design before implementation.

---

## 0. Project status and pitch

### What is already there
The project already has a solid foundation for leave management. The current codebase contains:

- employee and department records
- financial year and leave period management
- leave types and calculation methods
- leave entitlement setup by financial year
- leave policies and assignments
- holiday lists and holiday entries
- controller, service, and model patterns for business logic
- a functioning leave calculator that already validates dates and working-day logic

This means the system is not starting from zero. The core HR and leave framework is already in place.

### What is being built now
The next phase is the actual leave application experience itself:

- a leave application form
- employee lookup before the form appears
- calculation of leave duration from start date + number of days
- preview of calculated end date and return-to-work date
- validation against leave balance, weekends, and holidays
- secure server-side revalidation before saving

This is the stage where the project moves from configuration and setup into actual employee-facing leave transactions.

### My opinion as the current project reviewer
From what the code already shows, the right direction is to build the leave application around a modern, lookup-first experience and keep the mathematical rules in PHP. The project already has a strong HR architecture and the `LeaveCalculator` is the correct central place for the real business logic.

The best UX is not to make employees manually pick end dates or scroll through giant lists of names. The better flow is:

1. search for the employee
2. confirm the person
3. enter leave type and start date
4. enter the number of days
5. let the backend calculate the end date and projected balance
6. submit only after final server-side validation

This approach matches how HR teams think and keeps the system precise and secure.

### Option A vs Option B

#### Option A: Traditional PHP page reload
How it works:

1. User types employee ID or name
2. Form submits to server
3. PHP validates the employee and re-renders the page with the leave form
4. The whole page reloads

Pros:

- zero JavaScript required
- simpler PHP-only flow
- easy to implement quickly

Cons:

- slower and clunky
- page flashes on reload
- more interruption for the user
- not as polished for an HR dashboard

#### Option B: Simple JavaScript lookup with AJAX
How it works:

1. User types employee ID or name
2. JavaScript sends a request to PHP in the background
3. PHP checks the database and returns JSON
4. JavaScript reveals the leave form without reloading the page

Pros:

- smooth and modern user experience
- better for employee and HR workflows
- keeps the user on the same screen
- works well with a real-time leave calculator

Cons:

- needs a small JavaScript fetch flow
- requires a lightweight JSON endpoint in PHP

### Recommendation
For this project, the stronger and more professional choice is Option B: the simple AJAX lookup pattern, combined with the project’s existing `LeaveCalculator` rules.

This gives the best balance of:

- modern enterprise UX
- low front-end complexity
- secure server-side validation
- compatibility with the existing financial-year, entitlement, and holiday logic

This is the direction I would pitch to a friend or project teammate: build a lightweight employee lookup first, then reveal the leave form, and let the PHP calculator handle the real business rules.

---

## 1. Project snapshot

This project is a PHP MVC HR and leave administration system. The structure already includes:

- Employees and departments
- Financial years and leave periods
- Leave types
- Leave entitlements
- Leave policies and policy assignments
- Holiday lists
- Leave applications workflow
- Dashboard and admin layout

The leave subsystem is not fully finished yet, but the project already has the foundation for a strong HR leave engine.

The main architectural pattern is:

- Models handle database access
- Services hold business rules and validation
- Controllers prepare data and render views
- Views are Blade-like PHP templates styled with the Falcon admin UI
- Routes connect URL endpoints to controller actions

---

## 2. What the project already has

### Employee and HR baseline
The project already contains the core HR structure needed for leave logic:

- `employees` table and model
- `departments` model and management screens
- `financial_years` model and logic
- `leave_types` model and service

This is important because leave rules are tied to employees, financial years, and leave categories.

### Leave-related modules already implemented
From the existing code and docs, the project already includes or partially includes:

- `LeaveType` creation and validation
- `LeaveTypeService` for name and calculation method validation
- `LeaveCalculator` for date arithmetic
- `LeaveEntitlement` configuration per financial year
- `LeavePolicy` logic and assignment UI
- `HolidayList` and holiday management
- `LeaveController` endpoints for leaves, entitlements, periods, and policies

The system is already moving toward a policy-based leave model rather than hard-coded leave rules.

---

## 3. Core business rules already in the code

### A. Leave types have calculation methods
Defined in `LeaveTypeService`:

- `working_days`
- `calendar_days`

This means the system already recognizes that some leave types may be counted differently.

### B. Leave cannot start on a weekend
This is enforced directly in `LeaveCalculator`:

- If start date is Saturday or Sunday, the calculator throws an error.

This is a strong business rule and should remain central to the final design.

### C. Date validation is strict
The calculator checks:

- start date required
- end date required
- valid date format
- start date cannot be after end date
- invalid calculation method rejected

This protects the leave workflow from invalid submissions.

### D. Entitlements are stored per financial year and leave type
`LeaveEntitlementService` creates entitlement records for:

- a financial year
- a leave type
- a numeric entitlement value

This indicates the platform already intends each leave type to have an annual allocation or entitlement by year.

### E. Policies and assignments are part of the design
`LeavePolicyService` includes logic for:

- policy creation
- policy details
- allocation values
- carry forward support
- assignment to employees

This means the project is not simply a leave form. It is aiming for a more complete HR leave policy system.

---

## 4. Current leave architecture in practice

### Existing layers
The current model is consistent with a clean architecture:

- `app/Models/` — database entities and direct repository logic
- `app/Services/` — business logic and rule enforcement
- `app/Controllers/` — HTTP entry points
- `app/Views/leave_management/` — leave UI screens
- `routes/web.php` — route registration

### Leave flow being prepared
The documentation and code show the intended end-state flow is roughly:

1. Define leave types
2. Configure financial year entitlements
3. Create leave policies
4. Assign policies to employees or groups
5. Employees apply for leave
6. System validates rules and balances
7. Approvals and reporting happen on top of recorded leave applications

This is exactly the kind of structured HR leave system that scales well.

---

## 5. The leave calculator is the core engine

The main logic sits in [app/Services/LeaveCalculator.php](app/Services/LeaveCalculator.php).

It currently supports:

- `calculate(startDate, endDate, calculationMethod)`
- `calculateEndDate(startDate, days, calculationMethod)`
- `calculateReturnDate(endDate)`

### Working day logic
For `working_days`, the calculator counts only Monday to Friday.

### Calendar day logic
For `calendar_days`, it counts every day in the range, including the start and end dates.

### Important rule
The global rule is: leave cannot begin on a weekend.

This is a crucial rule because it prevents weird cases such as employees starting leave on Saturday and then thinking it is valid.

---

## 6. The important design direction: start date + number of days

The best direction for the final leave application UX is to let users enter:

- Employee
- Leave type
- Start date
- Number of days

Instead of forcing them to choose a full end date manually.

This matches the way HR and employees think in real life:

> “I need 3 days off starting on Friday.”

This is much more natural than asking the user to calculate their own end date and then manually validate it.

### Why this is better
- Easier for the user
- Less chance of wrong end-date input
- The system calculates the actual end date using the same business rules
- It matches the project’s existing `calculateEndDate()` method
- It reduces front-end complexity and input errors
- It makes the leave preview card clearer and more useful

---

## 7. Suggested real-time leave flow

### Form inputs
The final form should ask for:

- Employee
- Leave Type
- Start Date
- Number of Days

### Real-time behavior
When the user fills in the first three values, the system should calculate the remaining values instantly.

The backend should re-run the same rules in real time or on change events:

- calculate end date from start date + days
- validate against weekends
- check public holidays
- validate employee balance
- show projected remaining balance

### Example flow
A user enters:

- Employee: Ava Patel
- Leave Type: Annual Leave
- Start Date: Friday, Oct 23
- Number of Days: 3

The system computes:

- End date: Tuesday, Oct 27
- Return to work: Wednesday, Oct 28
- Projected balance: e.g. 13 days remaining

This gives a clear and useful preview before final submission.

---

## 8. Idea 2: Lookup-and-apply workflow

This is a second strong UX option and it improves the application flow from a static form to a lookup-first pattern.

### Concept
Instead of showing a large dropdown of employees immediately, the interface uses a two-step flow:

1. Search or identify the employee
2. Reveal the leave form only after the employee has been confirmed

This creates a cleaner, more modern HR experience and fits enterprise workflows well.

### User flow

#### Step 1: Lookup
The user types an employee number or name such as:

- `EMP-1018`
- `Ava Patel`

and clicks Search or presses Enter.

The system checks whether the employee exists and is active.

#### Step 2: Reveal the leave form
If the employee is found, the system displays the leave form and employee profile card. If not found, it shows an error message and keeps the user on the lookup state.

### Secure implementation approach
JavaScript alone is not enough for a secure validation check. It can only validate whether a field is empty. It cannot confirm the employee actually exists in the database without sending a request.

The recommended pattern is:

- JavaScript sends the employee lookup to a PHP endpoint such as `/api/lookup-employee`
- PHP validates the employee record in the database
- PHP returns JSON such as:
  - found
  - employee name
  - current leave balance
  - status flag
- JavaScript reveals the leave form only if the lookup succeeds

This gives a modern app feel while still keeping server-side validation authoritative.

### Recommended flow with real-time values
Once the employee is confirmed, the form behaves like the calculator-driven flow already discussed:

- Select leave type
- Pick start date
- Enter number of days
- PHP calculates end date and return date
- UI updates projected balance and warnings

### Exact data flow from the database
This is the clearest way to explain the architecture to a teammate or friend. There are three separate phases, and each phase uses a different source of data.

#### Phase 1: Static page load (standard PHP)
When the page first opens, the user does not need AJAX. These values are loaded once and are not employee-specific.

| Data | Source table | Purpose |
|---|---|---|
| Leave types | `leave_types` | Build the leave type dropdown |
| Financial year | `financial_years` | Show the current FY context |

This is the initial page state, and it is handled in normal PHP view rendering.

#### Phase 2: Employee lookup (AJAX trigger)
When the user searches for an employee number or name, the system fetches only that employee's data.

| Data | Source table | Purpose |
|---|---|---|
| Employee profile | `employees` | Show employee name, designation, department |
| Leave balances | `leave_allocations`, joined with `leave_types` and policy data | Show available balances like annual leave or sick leave |

This is where AJAX matters: you do not fetch all employees and all balances on page load. You only request the searched employee's record.

#### Phase 3: Real-time preview (AJAX trigger)
After the form is revealed and the user selects the leave type and input values, the system calculates the actual leave outcome.

| Data | Source table / logic | Purpose |
|---|---|---|
| Holiday-aware day calculation | `holidays` + `LeaveCalculator` | Calculate correct end date, skipping weekends and official holidays |
| Projected balance | `leave_allocations` balance minus requested days | Show remaining leave after the request |

This step is where the `LeaveCalculator` becomes central to the process.

### Backend API split
For implementation, the clean structure is:

1. `GET` or `POST /api/lookup-employee`
   - input: employee ID or payroll number
   - returns: employee profile + available balances

2. `POST /api/preview-leave`
   - input: employee ID, leave type, start date, days requested
   - returns: end date, return date, projected balance, validation status

3. Final submit: standard form POST to `/leave-applications/store`
   - PHP recalculates everything again
   - inserts the application into `leave_applications`
   - inserts a ledger entry into `leave_ledger`

### Why this is the right split
This keeps the architecture clean and avoids overloading a single page with unnecessary queries:

- static page data loads once
- employee-specific data loads only when needed
- leave calculation runs only when the user provides a valid request
- final submit stays as the secure server-side confirmation step

### Why this is useful for the project
This approach is strong for a system with many employees because:

- typing an employee number is faster than scrolling through a dropdown
- the interface is cleaner and more focused
- the user only sees the full form after a valid employee is confirmed
- it reduces accidental selection and invalid submissions
- it is closer to a premium enterprise workflow pattern
- it keeps the database queries efficient by only loading what is needed for the selected employee

### Best implementation style
For this project, the best middle ground is the simple AJAX lookup approach:

- Search box + Search button
- minimal JavaScript to call a PHP lookup endpoint
- the form remains hidden until validation succeeds
- the final save still uses secure server-side validation before database insertion

This gives a better user experience without building a large front-end validation layer.

---

## 9. Suggested business logic for the new flow

### Leave calculation logic
The application should follow this pattern:

1. User submits start date and number of days
2. PHP receives the data
3. PHP runs `calculateEndDate(startDate, days, leaveTypeMethod)`
4. PHP checks the leave type calculation method
5. PHP checks weekends and public holidays
6. PHP validates employee entitlement or available balance
7. PHP saves the result as:
   - start date
   - end date
   - number of days
   - leave type
   - employee
   - status

### Security rule
Even if the frontend computes the preview, the backend must calculate again from scratch before saving.

This ensures the final decision is based on server-side logic and not client-side tampering.

---

## 10. Recommended preview card UX

The project already uses a card-based admin UI. The leave application card should show a live summary such as:

- Start date
- Days requested
- Calculated end date
- Return to work
- Projected leave balance

### Example layout
| Field | Example |
|---|---|
| Start Date | Fri, Oct 23 |
| Days Requested | 3 |
| Calculated End Date | Tue, Oct 27 |
| Return to Work | Wed, Oct 28 |
| Projected Balance | 13 days left |

If the projected balance is negative, the card should clearly show a warning state.

---

## 11. Suggested final design principle

The system should use this principle:

> The user enters when they want to start and how many days they want; the system calculates the exact end date and return date from the project rules.

This is simpler, more natural, and far more aligned with the way employees actually request leave.

---

## 12. Summary of the whole direction

This project is already structured toward a proper HR leave engine:

- leave types are defined
- entitlements are configured by year
- policies and assignments are modeled
- holiday logic is present
- the calculator already enforces critical rules

The missing piece is not a totally different architecture; it is refining the leave application UX so it uses the system’s existing logic properly.

The best proposal is:

- Start date + number of days
- Real-time backend calculation
- Live preview card
- Secure server-side revalidation before save
- Balance warnings and holiday-aware calculations

This is consistent with the codebase and the business logic already being built.

---

## 13. Suggested wording for the brainstorming note

> This is actually much better. It aligns perfectly with how HR and employees think: “I need 3 days off starting on Friday.” It simplifies the frontend significantly.
>
> Since the project already has `calculateEndDate($startDate, $days)` in the PHP `LeaveCalculator`, this fits the architecture perfectly.
>
> The user enters the start date and number of days, the backend calculates the actual end date and return-to-work date, the UI shows the preview instantly, and the backend re-checks everything before saving.
>
> This approach is more natural, more secure, and easier to validate against holidays, weekends, and balances.

---

## 14. Recommended next implementation focus

The next implementation should focus on:

1. Finalizing the leave application form UX
2. Using `Start Date + Number of Days` as the primary input model
3. Reusing the existing calculator for the preview and the final save
4. Integrating employee entitlement balance checks
5. Applying holiday and weekend logic consistently
6. Creating a preview card with projected end date and remaining balance
7. Saving the action only after a final server-side validation pass

This is the cleanest design for moving from the current foundation into a production-ready leave application workflow.
