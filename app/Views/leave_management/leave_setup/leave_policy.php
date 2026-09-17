<?php $currentPage = 'leave_policy'; ?>

<div class="row g-3 mb-3">
  <div class="col-lg-8">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
      <div>
        <h4 class="mb-1"><i data-feather="shield" class="me-2" width="22" height="22"></i>Leave Policies</h4>
        <p class="mb-0 text-600">Bundle leave entitlements into policies for each financial year.</p>
      </div>
      <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#addPolicyOffcanvas" aria-controls="addPolicyOffcanvas">
        <i data-feather="plus" width="16" height="16"></i>
        <span class="ms-1">Add policy</span>
      </button>
    </div>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row g-3 align-items-end">
          <div class="col-lg-6">
        <label class="form-label" for="policySearch">Search policies</label>
        <div class="input-group">
          <span class="input-group-text"><i data-feather="search" width="16" height="16"></i></span>
          <input class="form-control" id="policySearch" type="search" placeholder="Search by policy name or description">
        </div>
          </div>
          <div class="col-lg-3">
        <label class="form-label" for="policyYear">Financial year</label>
        <select class="form-select js-choice" id="policyYear"><option>2026/2027</option><option>2025/2026</option></select>
          </div>
          <div class="col-lg-3">
        <label class="form-label" for="policyStatus">Status</label>
        <select class="form-select js-choice" id="policyStatus"><option>All statuses</option><option>Active</option><option>Inactive</option></select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-9">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">Policies for FY 2026/2027</h5>
      <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#addPolicyOffcanvas" aria-controls="addPolicyOffcanvas">
        <i data-feather="plus" width="14" height="14"></i>
        <span class="ms-1">Add policy</span>
      </button>
    </div>
    <div class="row g-3">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div><h5 class="mb-1">Standard Staff Leave Policy</h5><span class="text-600 fs-10">FY 2026/2027</span></div>
          <span class="badge rounded-pill badge-subtle-success">Active</span>
        </div>
        <p class="text-700 mb-3">Default leave policy for general staff.</p>
        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="badge rounded-pill badge-subtle-primary">Annual · 30 days</span>
          <span class="badge rounded-pill badge-subtle-info">Sick · 10 days</span>
          <span class="badge rounded-pill badge-subtle-warning">Maternity · 90 days</span>
        </div>
        <div class="d-flex justify-content-between align-items-center border-top pt-3">
          <span class="text-600 fs-10"><i data-feather="users" width="14" height="14"></i> 2 assigned</span>
          <div>
            <button class="btn btn-link btn-sm text-600 p-1" type="button" title="View policy"><i data-feather="eye" width="15" height="15"></i></button>
            <button class="btn btn-link btn-sm text-600 p-1" type="button" title="Edit policy"><i data-feather="edit-2" width="15" height="15"></i></button>
          </div>
        </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div><h5 class="mb-1">Executive Leave Policy</h5><span class="text-600 fs-10">FY 2026/2027</span></div>
          <span class="badge rounded-pill badge-subtle-success">Active</span>
        </div>
        <p class="text-700 mb-3">Special policy for senior staff and heads of department.</p>
        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="badge rounded-pill badge-subtle-primary">Annual · 30 days</span>
          <span class="badge rounded-pill badge-subtle-info">Sick · 10 days</span>
          <span class="badge rounded-pill badge-subtle-secondary">Paternity · 10 days</span>
        </div>
        <div class="d-flex justify-content-between align-items-center border-top pt-3">
          <span class="text-600 fs-10"><i data-feather="users" width="14" height="14"></i> 0 assigned</span>
          <div>
            <button class="btn btn-link btn-sm text-600 p-1" type="button" title="View policy"><i data-feather="eye" width="15" height="15"></i></button>
            <button class="btn btn-link btn-sm text-600 p-1" type="button" title="Edit policy"><i data-feather="edit-2" width="15" height="15"></i></button>
          </div>
        </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="card border-dashed text-center">
      <div class="card-body d-flex flex-column justify-content-center align-items-center py-5">
        <i data-feather="plus-circle" class="text-500 mb-2" width="28" height="28"></i>
        <h5 class="mb-1">Create another policy</h5>
        <p class="text-600 fs-10 mb-3">Set up a policy for a specific staff group.</p>
        <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#addPolicyOffcanvas">Add policy</button>
      </div>
    </div>
  </div>
</div>

<!-- Policy form is UI-only for now; backend saving will be added later. -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addPolicyOffcanvas" aria-labelledby="addPolicyOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="addPolicyOffcanvasLabel"><i data-feather="shield" class="me-2" width="18" height="18"></i>Add leave policy</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form>
      <div class="mb-3"><label class="form-label" for="policyName">Policy name</label><input class="form-control" id="policyName" type="text" placeholder="e.g. Standard Staff Leave Policy"></div>
      <div class="mb-3"><label class="form-label" for="policyDescription">Description</label><textarea class="form-control" id="policyDescription" rows="3" placeholder="Who does this policy apply to?"></textarea></div>
      <div class="mb-3"><label class="form-label" for="policyFormYear">Financial year</label><select class="form-select js-choice" id="policyFormYear"><option>2026/2027</option><option>2025/2026</option></select></div>
      <div class="mb-3">
        <label class="form-label">Included entitlements</label>
        <div class="border rounded p-3">
          <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="annualLeave" checked><label class="form-check-label" for="annualLeave">Annual Leave <span class="text-600">30 days</span></label></div>
          <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="sickLeave" checked><label class="form-check-label" for="sickLeave">Sick Leave <span class="text-600">10 days</span></label></div>
          <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="maternityLeave"><label class="form-check-label" for="maternityLeave">Maternity Leave <span class="text-600">90 days</span></label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="paternityLeave"><label class="form-check-label" for="paternityLeave">Paternity Leave <span class="text-600">10 days</span></label></div>
        </div>
      </div>
      <div class="form-check form-switch mb-4"><input class="form-check-input" type="checkbox" id="policyActive" checked><label class="form-check-label" for="policyActive">Active policy</label></div>
      <button class="btn btn-primary" type="button" disabled><i data-feather="save" width="15" height="15"></i><span class="ms-1">Save policy</span></button>
    </form>
  </div>
</div>

<!-- The previous Recent Purchases table is intentionally commented out until this page is wired to policy data. -->
<!--
<div class="card">
  <div class="card-body px-0 pt-0">
    <table class="table table-sm mb-0 data-table fs-10">
      <thead class="bg-200"><tr><th>Customer</th><th>Email</th><th>Product</th><th>Payment</th><th>Amount</th></tr></thead>
      <tbody id="table-simple-pagination-body"></tbody>
    </table>
  </div>
</div>
-->
