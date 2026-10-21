<?php
$currentPage = 'policy_assignments_create';
$csrf = \App\Core\Csrf::generate();
$policies = $policies ?? [];
$departments = $departments ?? [];
$employees = $employees ?? [];
$financialYears = $financialYears ?? [];
?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/leave-policies">Leave Policies</a></li>
    <li class="breadcrumb-item"><a href="/policy-assignments">Policy Assignments</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Assignment</li>
  </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="fw-bold mb-1">Create policy assignment</h3>
    <div class="text-600">Assign an employee or department to a leave policy.</div>
  </div>
  <a href="/policy-assignments" class="btn btn-falcon-default btn-sm">
    <span class="fas fa-arrow-left me-1"></span>Back
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="/policy-assignments">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8'); ?>" />

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="policy_id">Policy</label>
          <select class="form-select" id="policy_id" name="policy_id" required>
            <option value="">Select a policy</option>
            <?php foreach ($policies as $policy): ?>
              <option value="<?= (int) ($policy->id ?? 0) ?>"><?= htmlspecialchars((string) ($policy->name ?? 'Policy')) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="scope_type">Assignment scope</label>
          <select class="form-select" id="scope_type" name="scope_type" required>
            <option value="">Select scope</option>
            <option value="department">Department</option>
            <option value="employee">Employee</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="scope_id">Department or employee</label>
          <select class="form-select" id="scope_id" name="scope_id" required>
            <option value="">Choose target</option>
            <?php foreach ($departments as $department): ?>
              <option value="<?= (int) ($department->id ?? 0) ?>">Department: <?= htmlspecialchars((string) ($department->name ?? '')) ?></option>
            <?php endforeach; ?>
            <?php foreach ($employees as $employee): ?>
              <option value="<?= (int) ($employee->id ?? 0) ?>">Employee: <?= htmlspecialchars((string) (($employee->first_name ?? '') . ' ' . ($employee->last_name ?? ''))) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="financial_year_id">Financial year</label>
          <select class="form-select" id="financial_year_id" name="financial_year_id">
            <option value="">Select year</option>
            <?php foreach ($financialYears as $year): ?>
              <option value="<?= (int) ($year->id ?? 0) ?>"><?= htmlspecialchars((string) ($year->label ?? '')) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="mt-4 d-flex justify-content-end gap-2">
        <a href="/policy-assignments" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save assignment</button>
      </div>
    </form>
  </div>
</div>
