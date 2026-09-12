<?php $currentPage = 'leave_entitlement'; ?>
<?php $selectedYear = $_GET['year'] ?? '2026 / 2027'; ?>
<?php $csrf = \App\Core\Csrf::generate(); ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/leave-entitlements">Leave Entitlement</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($selectedYear) ?></li>
  </ol>
</nav>

<div class="row align-items-end justify-content-between g-3 mb-3">
  <div class="col-md-8">
    <div>
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="badge badge-subtle-primary fs-10">Leave Setup</span>
      </div>
      <h2 class="mb-1"><?= htmlspecialchars($selectedYear) ?></h2>
      <p class="text-600 mb-0">Leave entitlement configuration for the selected financial year.</p>
    </div>
  </div>
</div>

<div class="card border-0 shadow-none">
  <div class="card-body py-5">
    <div class="text-center" id="detailEmptyState">
      <i class="fas fa-clipboard-list fa-3x text-500 mb-3"></i>
      <p class="text-700 mb-3">No entitlements configured yet for this financial year. Add the first one to get started.</p>
      <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#entitlementForm" type="button">
        <span class="fas fa-plus me-2"></span>Add First Entitlement
      </button>
    </div>
  </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="entitlementForm" aria-labelledby="entitlementFormLabel" style="width:460px;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="entitlementFormLabel">Add Entitlement</h5>
    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body p-0">
    <form method="post" action="#" id="entitlementFormSubmit">
      <div class="p-3">
        <input type="hidden" name="edit_id" value="" />
        <input type="hidden" name="year" value="<?= htmlspecialchars($selectedYear) ?>" />
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />

        <div class="mb-3">
          <label class="form-label fs--1 mb-1">Financial Year</label>
          <div class="border rounded-3 bg-body-tertiary p-3 text-700">
            Managing <?= htmlspecialchars($selectedYear) ?>.
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="entitlementLeaveType">Leave Type</label>
          <select class="form-select" id="entitlementLeaveType" name="leave_type">
            <option value="">Select a leave type…</option>
            <option value="Annual Leave">Annual Leave</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Maternity Leave">Maternity Leave</option>
            <option value="Paternity Leave">Paternity Leave</option>
            <option value="Study Leave">Study Leave</option>
            <option value="Leave Without Pay">Leave Without Pay</option>
          </select>
          <div class="form-text">Only leave types without an entitlement for this year are listed.</div>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="entitlementDays">Entitlement</label>
          <div class="input-group">
            <input class="form-control" id="entitlementDays" name="entitlement_days" type="number" min="0" step="1" placeholder="e.g. 30" />
            <span class="input-group-text">Days</span>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1">Calculation Method</label>
          <div class="border rounded-3 bg-body-tertiary p-2 text-600">
            Set automatically from the leave type
          </div>
          <div class="form-text">Defined on the leave type itself, so it cannot drift between screens.</div>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1">Carry Forward</label>
          <div class="d-flex gap-2 flex-wrap">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="carry_forward" id="carryForwardNo" value="No" checked>
              <label class="form-check-label" for="carryForwardNo">No</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="carry_forward" id="carryForwardYes" value="Yes">
              <label class="form-check-label" for="carryForwardYes">Yes</label>
            </div>
          </div>
        </div>

        <div class="mb-3 d-none" id="cfLimitWrap">
          <label class="form-label fs--1 mb-1" for="cfLimit">Maximum Carry Forward</label>
          <div class="input-group">
            <input class="form-control" id="cfLimit" name="carry_forward_limit" type="number" min="0" step="1" placeholder="e.g. 15" />
            <span class="input-group-text">Days</span>
          </div>
        </div>

        <div class="mb-1 d-flex align-items-center justify-content-between">
          <label class="form-label fs--1 mb-0">Status</label>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="entitlementStatus" name="status" checked>
          </div>
        </div>
        <div class="form-text">New entitlements are active by default. Deactivate later from the table if needed.</div>
      </div>
    </form>
  </div>

  <div class="border-top p-3">
    <div class="d-flex justify-content-end align-items-center gap-2">
      <button type="button" class="btn btn-falcon-default" data-bs-dismiss="offcanvas">Cancel</button>
      <button type="submit" form="entitlementFormSubmit" class="btn btn-primary">Save Entitlement</button>
    </div>
  </div>
</div>
