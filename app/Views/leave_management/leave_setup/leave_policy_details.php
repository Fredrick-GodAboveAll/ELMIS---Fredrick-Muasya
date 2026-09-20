<?php $currentPage = 'leave-policy-detail'; ?>
<?php $csrf = \App\Core\Csrf::generate(); ?>

<?php
// ============================================================
// DEMO DATA — swap for controller data later.
// ============================================================
$policy = [
    'id'          => 2,
    'name'        => 'Executive Leave Policy',
    'description' => 'Special policy for senior staff with enhanced annual leave.',
    'is_active'   => true,
];

$financialYears = [
    ['id' => 3, 'label' => '2026/2027', 'current' => true],
    ['id' => 2, 'label' => '2025/2026', 'current' => false],
    ['id' => 1, 'label' => '2024/2025', 'current' => false],
];

$currentFyId = 3;

$rows = [
    ['leave_type' => 'Annual Leave',    'base' => 30, 'allocation' => 30,   'configured' => true],
    ['leave_type' => 'Sick Leave',      'base' => 10, 'allocation' => null, 'configured' => false],
    ['leave_type' => 'Maternity Leave', 'base' => 90, 'allocation' => 90,   'configured' => true],
    ['leave_type' => 'Paternity Leave', 'base' => 10, 'allocation' => 10,   'configured' => true],
    ['leave_type' => 'Study Leave',     'base' => 5,  'allocation' => null, 'configured' => false],
];

$currentFy = null;
foreach ($financialYears as $fy) {
    if ($fy['id'] === $currentFyId) { $currentFy = $fy; break; }
}
$entitlementCount = count($rows);
$rowCount = count($rows);
$isActive = !empty($policy['is_active']);
?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/leave-policies">Leave policy</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($policy['name']) ?></li>
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

<!-- ============================================================
     POLICY HEADER
     ============================================================ -->
<div class="row g-3 mb-3 align-items-center">
  <div class="col-lg-8">
    <h4 class="mb-1 d-flex align-items-center">
      <?= htmlspecialchars($policy['name']) ?>
      <span class="badge rounded-pill badge-subtle-<?= $isActive ? 'success' : 'secondary' ?> ms-2">
        <?= $isActive ? 'Active' : 'Inactive' ?>
      </span>
    </h4>
    <p class="mb-0 text-600">
      <?= htmlspecialchars($policy['description'] ?: 'No description provided.') ?>
    </p>
  </div>
  <div class="col-lg-4 text-lg-end">
    <a href="/leave-policies" class="btn btn-falcon-default">
      <span class="fas fa-arrow-left me-1" data-fa-transform="shrink-3"></span>
      Back to Policies
    </a>
  </div>
</div>

<!-- ============================================================
     RULE STRIP
     ============================================================ -->
<div class="alert alert-info border-0 d-flex align-items-center py-2 mb-3" role="alert">
  <div class="bg-info me-2 d-flex align-items-center justify-content-center rounded-circle" style="width:28px;height:28px;flex-shrink:0;">
    <span class="fas fa-info-circle text-white fs-11"></span>
  </div>
  <p class="mb-0 flex-1 fs-10">
    <strong>The rule:</strong> this page shows only the leave types that have an
    <em>entitlement</em> for the selected Financial Year. Nothing else.
  </p>
</div>

<!-- ============================================================
     FY SELECTOR + COUNT
     ============================================================ -->
<div class="row g-3 align-items-center mb-3">
  <div class="col-lg-3">
    <label for="fySelect" class="form-label">Financial Year Allocation</label>
    <select class="form-select js-choice shadow-sm" id="fySelect"
            onchange="window.location.href='/leave-policy-detail?id=<?= (int) $policy['id'] ?>&fy=' + this.value;">
      <?php foreach ($financialYears as $fy): ?>
        <option value="<?= (int) $fy['id'] ?>" <?= $fy['id'] === $currentFyId ? 'selected' : '' ?>>
          <?= htmlspecialchars($fy['label']) ?><?= $fy['current'] ? ' (Current)' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-lg-9 text-lg-end">
    <span class="text-600 fs-11">
      <strong class="text-900"><?= (int) $entitlementCount ?></strong> entitlements in this FY →
      <strong class="text-900"><?= (int) $rowCount ?></strong> rows shown
    </span>
  </div>
</div>

<!-- ============================================================
     ALLOCATIONS TABLE
     ============================================================ -->
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
              <button class="btn btn-falcon-default btn-sm mx-2" type="button"
                      data-bs-toggle="offcanvas" data-bs-target="#newAllocationOffcanvas">
                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                <span class="d-none d-sm-inline-block ms-1">New</span>
              </button>
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
              <th class="no-export text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false">Actions</th>
            </tr>
          </thead>

          <tbody class="list" id="table-simple-pagination-body">
            <?php if (empty($rows)): ?>
              <tr>
                <td colspan="6">
                  <div class="text-center py-5">
                    <span class="fas fa-inbox fs-4 text-400 mb-2 d-block"></span>
                    <p class="mb-1 fw-semi-bold text-700">No entitlements for this Financial Year</p>
                    <p class="text-600 fs-10 mb-0">Add entitlements first. They will appear here automatically.</p>
                  </div>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($rows as $index => $row): ?>
                <tr class="btn-reveal-trigger">
                  <td class="no-export align-middle" style="width:28px;">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox"
                             id="simple-pagination-item-<?= (int) $index ?>"
                             data-bulk-select-row="data-bulk-select-row" />
                    </div>
                  </td>

                  <td class="align-middle white-space-nowrap fw-semi-bold">
                    <?= htmlspecialchars($row['leave_type']) ?>
                  </td>

                  <td class="align-middle white-space-nowrap text-end">
                    <?= (int) $row['base'] ?> <span class="text-600 fs-11">days</span>
                  </td>

                  <td class="align-middle white-space-nowrap text-end">
                    <?php if ($row['allocation'] !== null): ?>
                      <span class="fw-semi-bold"><?= (int) $row['allocation'] ?></span>
                      <span class="text-600 fs-11">days</span>
                    <?php else: ?>
                      <span class="text-600 fs-11 fst-italic">Not set</span>
                    <?php endif; ?>
                  </td>

                  <td class="align-middle white-space-nowrap text-start fs-9">
                    <?php if (!empty($row['configured'])): ?>
                      <span class="badge rounded-pill badge-subtle-success">Configured</span>
                    <?php else: ?>
                      <span class="badge rounded-pill badge-subtle-secondary">Not configured</span>
                    <?php endif; ?>
                  </td>

                  <td class="no-export align-middle white-space-nowrap text-start">
                    <div class="dropstart font-sans-serif position-static d-inline-block">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                              type="button"
                              id="dropdown-allocation-item-<?= (int) $index ?>"
                              data-bs-toggle="dropdown"
                              data-boundary="window"
                              aria-haspopup="true"
                              aria-expanded="false"
                              data-bs-reference="parent">
                        <span class="fas fa-ellipsis-h fs-10"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-allocation-item-<?= (int) $index ?>">
                        <a class="dropdown-item" href="#!">View</a>
                        <a class="dropdown-item" href="#!">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-warning" href="#!">Reset to base</a>
                        <a class="dropdown-item text-danger" href="#!">Clear allocation</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     NEW ALLOCATION OFFCANVAS (placeholder)
     ============================================================ -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="newAllocationOffcanvas" aria-labelledby="newAllocationOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="newAllocationOffcanvasLabel">
      <span class="fas fa-plus me-2" data-fa-transform="shrink-3"></span>New Allocation
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <p class="text-600 fs-10 mb-0">Form goes here — pick a leave type that already has an entitlement for this FY, then set the allocation.</p>
  </div>
</div>