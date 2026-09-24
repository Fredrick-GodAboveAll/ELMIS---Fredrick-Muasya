<?php
$currentPage = 'leave-policy-detail';
$csrf = \App\Core\Csrf::generate();

$policy = $policy ?? (object) ['id' => 0, 'name' => 'Policy', 'description' => '', 'is_active' => 0];
$financialYears = $financialYears ?? [];
$currentFyId = (int) ($currentFyId ?? 0);
$currentFy = $currentFy ?? (object) ['label' => ''];
$rows = $rows ?? [];

$isActive = !empty($policy->is_active);
?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/leave-policies">Leave policy</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars((string) ($policy->name ?? 'Policy')) ?></li>
  </ol>
</nav>

<?php if ($error = \App\Core\Session::flash('error')): ?>
  <div class="alert alert-danger border-0 d-flex align-items-center py-2" role="alert">
    <div class="bg-danger me-2 d-flex align-items-center justify-content-center rounded-circle" style="width:28px;height:28px;flex-shrink:0;">
      <span class="fas fa-times-circle text-white fs-11"></span>
    </div>
    <p class="mb-0 flex-1 fs-10"><?= htmlspecialchars($error) ?></p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if ($success = \App\Core\Session::flash('success')): ?>
  <div class="alert alert-success border-0 d-flex align-items-center py-2" role="alert">
    <div class="bg-success me-2 d-flex align-items-center justify-content-center rounded-circle" style="width:28px;height:28px;flex-shrink:0;">
      <span class="fas fa-check-circle text-white fs-11"></span>
    </div>
    <p class="mb-0 flex-1 fs-10"><?= htmlspecialchars($success) ?></p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row g-3 mb-3 align-items-center">
  <div class="col-lg-8">
    <h4 class="mb-1 d-flex align-items-center">
      <?= htmlspecialchars((string) ($policy->name ?? 'Policy')) ?>
      <span class="badge rounded-pill badge-subtle-<?= $isActive ? 'success' : 'secondary' ?> ms-2">
        <?= $isActive ? 'Active' : 'Inactive' ?>
      </span>
    </h4>
    <p class="mb-0 text-600">
      <?= htmlspecialchars((string) ($policy->description ?? 'No description provided.')) ?>
    </p>
  </div>
  <div class="col-lg-4 text-lg-end">
    <a href="/leave-policies" class="btn btn-falcon-default">
      <span class="fas fa-arrow-left me-1" data-fa-transform="shrink-3"></span>
      Back to Policies
    </a>
  </div>
</div>

<div class="alert alert-info border-0 d-flex align-items-center py-2 mb-3" role="alert">
  <div class="bg-info me-2 d-flex align-items-center justify-content-center rounded-circle" style="width:28px;height:28px;flex-shrink:0;">
    <span class="fas fa-info-circle text-white fs-11"></span>
  </div>
  <p class="mb-0 flex-1 fs-10">
    <strong>The rule:</strong> this page shows only the leave types that have an
    <em>entitlement</em> for the selected Financial Year. Nothing else.
  </p>
</div>

<div class="row g-3 align-items-center mb-3">
  <div class="col-lg-3">
    <label for="fySelect" class="form-label">Financial Year Allocation</label>
    <select class="form-select js-choice shadow-sm" id="fySelect"
            onchange="window.location.href='/leave-policy-detail?id=<?= (int) ($policy->id ?? 0) ?>&fy=' + this.value;">
      <?php foreach ($financialYears as $fy): ?>
        <option value="<?= (int) $fy->id ?>" <?= (int) $fy->id === $currentFyId ? 'selected' : '' ?>>
          <?= htmlspecialchars((string) $fy->label) ?><?= !empty($fy->is_current) ? ' — Active' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-lg-9 text-lg-end">
    <span class="text-600 fs-11">
      <strong class="text-900"><?= count($rows) ?></strong> entitlements in this FY →
      <strong class="text-900"><?= count($rows) ?></strong> rows shown
    </span>
  </div>
</div>

<!-- ============================================================
     ALLOCATIONS TABLE
     ============================================================ -->
<?php if (empty($rows)): ?>
  <div class="card mt-3">
    <div class="card-body text-center py-5">
      <i data-feather="inbox" width="32" height="32" class="text-400 mb-2"></i>
      <p class="mb-1 fw-semi-bold text-700">No entitlements for this Financial Year</p>
      <p class="text-600 fs-10 mb-0">Add entitlements first. They will appear here automatically.</p>
    </div>
  </div>
<?php else: ?>
  <div class="row g-3 mb-3">
    <div class="col-xxl-12 col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row flex-between-center">
            <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
              <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Leave Allocations</h5>
            </div>
            <div class="col-6 col-sm-auto ms-auto text-end ps-0">
              <div class="d-none" id="table-simple-pagination-actions">
                <div class="d-flex">
                  <select class="form-select form-select-sm" aria-label="Bulk actions">
                    <option selected="">Bulk actions</option>
                    <option value="Delete">Delete</option>
                    <option value="Archive">Archive</option>
                  </select>
                  <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
                </div>
              </div>
              <div id="table-simple-pagination-replace-element">
                <button class="btn btn-falcon-default btn-sm mx-2" type="button">
                  <span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span>
                  <span class="d-none d-sm-inline-block ms-1">Filter</span>
                </button>
                <div class="btn-group" role="group">
                  <button id="export-excel" class="btn btn-falcon-default btn-sm" type="button" title="Export to Excel">
                    <span class="fas fa-file-excel" data-fa-transform="shrink-3 down-2"></span>
                    <span class="d-none d-sm-inline-block ms-1">Excel</span>
                  </button>
                  <button id="export-csv" class="btn btn-falcon-default btn-sm" type="button" title="Export to CSV">
                    <span class="fas fa-file-csv" data-fa-transform="shrink-3 down-2"></span>
                    <span class="d-none d-sm-inline-block ms-1">CSV</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body px-0 pt-0">
          <table id="allocations-table"
                 class="table table-sm mb-0 overflow-hidden data-table fs-10"
                 data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
            <thead class="bg-200">
              <tr>
                <th class="no-export text-900 no-sort white-space-nowrap" data-orderable="false">
                  <div class="form-check mb-0 d-flex align-items-center">
                    <input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox"
                           data-bulk-select='{"body":"table-simple-pagination-body","actions":"table-simple-pagination-actions","replacedElement":"table-simple-pagination-replace-element"}' />
                  </div>
                </th>
                <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">Leave Type</th>
                <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Base Entitlement</th>
                <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Policy Allocation</th>
                <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">Status</th>
                <th class="no-export text-900 no-sort pe-1 align-middle data-table-row-action text-end" data-orderable="false"></th>
              </tr>
            </thead>

            <tbody class="list" id="table-simple-pagination-body">
              <?php foreach ($rows as $index => $row): ?>
                <?php $entId = (int) ($row->entitlement_id ?? 0); ?>
                <tr class="btn-reveal-trigger">
                  <td class="no-export align-middle" style="width:28px;">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox"
                             id="simple-pagination-item-<?= (int) $index ?>"
                             data-bulk-select-row="data-bulk-select-row" />
                    </div>
                  </td>

                  <td class="align-middle white-space-nowrap fw-semi-bold">
                    <?= htmlspecialchars((string) ($row->leave_type_name ?? '')) ?>
                  </td>

                  <td class="align-middle white-space-nowrap text-end">
                    <?= (int) ($row->base_entitlement ?? 0) ?> <span class="text-600 fs-11">days</span>
                  </td>

                  <td class="align-middle white-space-nowrap text-end">
                    <?php if ($row->allocation !== null): ?>
                      <span class="fw-semi-bold"><?= (float) $row->allocation ?></span>
                      <span class="text-600 fs-11">days</span>
                    <?php else: ?>
                      <span class="text-600 fs-11 fst-italic">Not set</span>
                    <?php endif; ?>
                  </td>

                  <td class="align-middle white-space-nowrap text-start fs-9">
                    <?php if ($row->allocation !== null): ?>
                      <span class="badge rounded-pill badge-subtle-success">Configured</span>
                    <?php else: ?>
                      <span class="badge rounded-pill badge-subtle-secondary">Not configured</span>
                    <?php endif; ?>
                  </td>

                  <td class="no-export align-middle white-space-nowrap text-end">
                    <div class="dropstart font-sans-serif position-static d-inline-block">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                              type="button"
                              id="dropdown-allocation-item-<?= $entId ?>"
                              data-bs-toggle="dropdown"
                              data-boundary="window"
                              aria-haspopup="true"
                              aria-expanded="false"
                              data-bs-reference="parent">
                        <span class="fas fa-ellipsis-h fs-10"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-allocation-item-<?= $entId ?>">
                        <button class="dropdown-item" type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#viewAllocationModal-<?= $entId ?>">
                          View
                        </button>
                        <button class="dropdown-item" type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#editAllocationModal-<?= $entId ?>">
                          Edit
                        </button>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-warning" href="#!">Reset to base</a>
                        <a class="dropdown-item text-danger" href="#!">Clear allocation</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- ============================================================
     ONE VIEW + EDIT MODAL PER ROW — rendered by PHP, no JS
     ============================================================ -->
<?php foreach ($rows as $row): ?>
  <?php
    $entId = (int) ($row->entitlement_id ?? 0);
    $leaveTypeName = (string) ($row->leave_type_name ?? '');
    $base = (float) ($row->base_entitlement ?? 0);
    $allocation = $row->allocation !== null ? (float) $row->allocation : null;
    $configured = $allocation !== null && $allocation > 0;
    $diff = $configured ? ($allocation - $base) : null;
  ?>

  <!-- VIEW modal for this row -->
  <div class="modal fade" id="viewAllocationModal-<?= $entId ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">
            <i data-feather="eye" width="16" height="16" class="me-2 text-500"></i>
            Policy Allocation Details
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">

          <!-- Hero -->
          <div class="bg-primary-subtle rounded-3 p-4 mb-4">
            <div class="text-500 fs-11 text-uppercase fw-semi-bold mb-1" style="letter-spacing:.06em;">
              Leave Type
            </div>
            <h3 class="mb-0 fw-semi-bold"><?= htmlspecialchars($leaveTypeName) ?></h3>
          </div>

          <!-- Stat tiles -->
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <div class="bg-body-tertiary border rounded-3 p-3 h-100">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-2" style="letter-spacing:.05em;">
                  Base Entitlement
                </div>
                <div class="d-flex align-items-baseline">
                  <span class="fw-semi-bold"><?= $base ?></span>
                  <span class="text-500 fs-11 ms-1">days</span>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="bg-primary-subtle border rounded-3 p-3 h-100" style="border-color:#bcd2e6 !important;">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-2" style="letter-spacing:.05em;">
                  Policy Allocation
                </div>
                <div class="d-flex align-items-baseline">
                  <?php if ($configured): ?>
                    <span class="fw-semi-bold text-primary"><?= $allocation ?></span>
                    <span class="text-500 fs-11 ms-1">days</span>
                  <?php else: ?>
                    <span class="fw-semi-bold text-500 fst-italic">Not set</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="bg-body-tertiary border rounded-3 p-3 h-100">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-2" style="letter-spacing:.05em;">
                  Difference
                </div>
                <div class="d-flex align-items-baseline">
                  <?php if ($diff === null): ?>
                    <span class="fw-semi-bold text-500">—</span>
                  <?php elseif ($diff === 0): ?>
                    <span class="fw-semi-bold">0</span>
                    <span class="text-500 fs-11 ms-1">days</span>
                  <?php elseif ($diff > 0): ?>
                    <span class="fw-semi-bold text-warning">+<?= $diff ?></span>
                    <span class="text-500 fs-11 ms-1">days</span>
                  <?php else: ?>
                    <span class="fw-semi-bold text-danger"><?= $diff ?></span>
                    <span class="text-500 fs-11 ms-1">days</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Meta list -->
          <div class="border rounded-3 overflow-hidden">
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
              <span class="text-500 fs-11">Financial Year</span>
              <span class="fw-semi-bold fs-11"><?= htmlspecialchars((string) ($currentFy->label ?? '')) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
              <span class="text-500 fs-11">Status</span>
              <?php if ($configured): ?>
                <span class="badge rounded-pill badge-subtle-success">Configured</span>
              <?php else: ?>
                <span class="badge rounded-pill badge-subtle-secondary">Not configured</span>
              <?php endif; ?>
            </div>
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
              <span class="text-500 fs-11">Carry Forward</span>
              <span class="fw-semi-bold fs-11">
                <?php if (!empty($row->carry_forward)): ?>
                  Yes (up to <?= (float) ($row->carry_forward_limit ?? 0) ?> days)
                <?php else: ?>
                  No
                <?php endif; ?>
              </span>
            </div>
            <div class="d-flex justify-content-between align-items-center px-3 py-3">
              <span class="text-500 fs-11">Policy</span>
              <span class="fw-semi-bold fs-11"><?= htmlspecialchars((string) ($policy->name ?? '')) ?></span>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <!-- EDIT modal for this row -->
  <div class="modal fade" id="editAllocationModal-<?= $entId ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" action="/leave-policy-detail">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
          <input type="hidden" name="policy_id" value="<?= (int) $policy->id ?>">
          <input type="hidden" name="financial_year_id" value="<?= (int) $currentFyId ?>">
          <input type="hidden" name="entitlement_id" value="<?= $entId ?>">

          <div class="modal-header">
            <h5 class="modal-title">
              <i data-feather="edit-2" width="16" height="16" class="me-2 text-500"></i>
              Edit Allocation
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3 p-3 rounded-3" style="background:#f8fafc;">
              <div>
                <div class="fw-semi-bold"><?= htmlspecialchars($leaveTypeName) ?></div>
                <div class="text-500 fs-11"><?= htmlspecialchars((string) ($currentFy->label ?? '')) ?></div>
              </div>
              <span class="badge rounded-pill badge-subtle-primary">FY <?= htmlspecialchars((string) ($currentFy->label ?? '')) ?></span>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-6">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-1" style="letter-spacing:.05em;">Base Entitlement</div>
                <div class="fw-semi-bold"><?= $base ?> days</div>
              </div>
              <div class="col-6">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-1" style="letter-spacing:.05em;">Current Allocation</div>
                <div class="fw-semi-bold">
                  <?= $configured ? $allocation . ' days' : 'Not configured' ?>
                </div>
              </div>
            </div>

            <div class="mb-2">
              <label for="em-input-<?= $entId ?>" class="form-label">New Policy Allocation</label>
              <div class="input-group">
                <input type="number"
                       class="form-control"
                       id="em-input-<?= $entId ?>"
                       name="allocation"
                       value="<?= $configured ? $allocation : '' ?>"
                       min="0" step="1">
                <span class="input-group-text">days</span>
              </div>
              <div class="form-text">
                Leave blank to remove the allocation and set this leave type back to "Not configured".
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" width="14" height="14" class="me-1"></i>
              Save Allocation
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>