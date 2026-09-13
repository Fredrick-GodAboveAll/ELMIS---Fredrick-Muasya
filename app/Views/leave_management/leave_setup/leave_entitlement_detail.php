<?php $currentPage = 'leave_entitlement'; ?>

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

<?php if (empty($entitlements)): ?>
  <div class="card border-0 shadow-none">
    <div class="card-body py-5">
      <div class="text-center" id="detailEmptyState">
        <i class="fas fa-clipboard-list fa-3x text-500 mb-3"></i>
        <p class="text-700 mb-3">No entitlements configured yet for this financial year.</p>
        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#entitlementForm" type="button">
          <span class="fas fa-plus me-2"></span>Add First Entitlement
        </button>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="card">
    <div class="card-header">
      <div class="row flex-between-center">
        <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
          <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Entitlement Rules</h5>
        </div>
        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
          <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#entitlementForm">
            <span class="fas fa-plus me-2"></span>Add Entitlement
          </button>
        </div>
      </div>
    </div>

    <div class="card-body px-0 pt-0">
      <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
        <thead class="bg-200">
          <tr>
            <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
              <div class="form-check mb-0 d-flex align-items-center">
                <input class="form-check-input" id="checkbox-bulk-item-select-detail" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body-detail","actions":"table-simple-pagination-actions-detail","replacedElement":"table-simple-pagination-replace-element-detail"}' />
              </div>
            </th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap">Leave Type</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap">Calculation</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Entitlement</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Carry Forward</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Max Carry</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Status</th>
            <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
          </tr>
        </thead>
        <tbody class="list" id="table-simple-pagination-body-detail">
          <?php foreach ($entitlements as $index => $entitlement): ?>
            <?php $isActive = !empty($entitlement->entitlement_id) || !empty($entitlement->leave_type_id); ?>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="simple-pagination-item-detail-<?= (int) $index; ?>" data-bulk-select-row="data-bulk-select-row" />
                </div>
              </td>
              <td class="align-middle fw-semi-bold white-space-nowrap name"><?= htmlspecialchars((string) ($entitlement->leave_type_name ?? 'N/A')) ?></td>
              <td class="align-middle white-space-nowrap"><?= htmlspecialchars((string) ($entitlement->calculation_method ?? 'working_days')) === 'calendar_days' ? 'Calendar Days' : 'Working Days'; ?></td>
              <td class="align-middle text-end white-space-nowrap"><?= htmlspecialchars(number_format((float) ($entitlement->entitlement ?? 0), 2)) ?> days</td>
              <td class="align-middle text-center white-space-nowrap"><?= !empty($entitlement->carry_forward) ? 'Yes' : 'No' ?></td>
              <td class="align-middle text-end white-space-nowrap"><?= htmlspecialchars(number_format((float) ($entitlement->carry_forward_limit ?? 0), 2)) ?></td>
              <td class="align-middle text-center white-space-nowrap">
                <span class="badge badge-subtle-<?= $isActive ? 'success' : 'secondary'; ?> rounded-pill">
                  <?= $isActive ? 'Active' : 'Inactive'; ?>
                </span>
              </td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-detail-table-item-<?= (int) $index; ?>" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-detail-table-item-<?= (int) $index; ?>">
                    <a class="dropdown-item" href="#!">View</a>
                    <a class="dropdown-item" href="#!">Edit</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

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
