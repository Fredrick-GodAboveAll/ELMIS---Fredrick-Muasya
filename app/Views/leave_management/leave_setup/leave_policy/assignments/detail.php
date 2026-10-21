<?php
$currentPage = 'policy_assignment_detail';
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
    <li class="breadcrumb-item active" aria-current="page">Assignment Detail</li>
  </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="fw-bold mb-1">Assignment detail</h3>
    <div class="text-600">Review the selected coverage and effective period.</div>
  </div>
  <a href="/policy-assignments" class="btn btn-falcon-default btn-sm">
    <span class="fas fa-arrow-left me-1"></span>Back
  </a>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="mb-0">General staff policy</h6>
    <span class="badge rounded-pill badge-subtle-success">Active</span>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="small text-600">Policy</div>
        <div class="fw-semi-bold">General staff policy</div>
      </div>
      <div class="col-md-3">
        <div class="small text-600">Scope</div>
        <div class="fw-semi-bold">Department</div>
      </div>
      <div class="col-md-3">
        <div class="small text-600">Target</div>
        <div class="fw-semi-bold">Finance & Admin</div>
      </div>
      <div class="col-md-3">
        <div class="small text-600">Financial year</div>
        <div class="fw-semi-bold">2026/2027</div>
      </div>
    </div>

    <hr class="my-3" />

    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Department</th>
            <th>Policy</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (array_slice($employees, 0, 5) as $employee): ?>
            <tr>
              <td><?= htmlspecialchars((string) (($employee->first_name ?? '') . ' ' . ($employee->last_name ?? ''))) ?></td>
              <td><?= htmlspecialchars((string) ($employee->department_name ?? '—')) ?></td>
              <td>General staff policy</td>
              <td><span class="badge rounded-pill badge-subtle-success">Assigned</span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
