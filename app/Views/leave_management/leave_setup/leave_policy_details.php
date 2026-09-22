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
          <?= htmlspecialchars((string) $fy->label) ?><?= !empty($fy->is_current) ? ' (Current)' : '' ?>
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

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Leave Allocations</h5>
          </div>
        </div>
      </div>

      <div class="card-body px-0 pt-0">
        <table id="allocations-table" class="table table-sm mb-0 overflow-hidden fs-10">
          <thead class="bg-200">
            <tr>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">Leave Type</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Base Entitlement</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Policy Allocation</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">Status</th>
              <th class="no-export text-900 no-sort pe-1 align-middle data-table-row-action text-end" data-orderable="false">Actions</th>
            </tr>
          </thead>

          <tbody>
            <?php if (empty($rows)): ?>
              <tr>
                <td colspan="5">
                  <div class="text-center py-5">
                    <span class="fas fa-inbox fs-4 text-400 mb-2 d-block"></span>
                    <p class="mb-1 fw-semi-bold text-700">No entitlements for this Financial Year</p>
                    <p class="text-600 fs-10 mb-0">Add entitlements first. They will appear here automatically.</p>
                  </div>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($rows as $row): ?>
                <tr class="btn-reveal-trigger">
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

                  <td class="align-middle white-space-nowrap text-end">
                    <div class="dropstart font-sans-serif position-static d-inline-block">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                              type="button"
                              id="dropdown-allocation-item-<?= (int) ($row->entitlement_id ?? 0) ?>"
                              data-bs-toggle="dropdown"
                              data-boundary="window"
                              aria-haspopup="true"
                              aria-expanded="false"
                              data-bs-reference="parent">
                        <span class="fas fa-ellipsis-h fs-10"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-allocation-item-<?= (int) ($row->entitlement_id ?? 0) ?>">
                        <button class="dropdown-item js-view-allocation" type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#viewAllocationModal"
                                data-leave-type="<?= htmlspecialchars((string) ($row->leave_type_name ?? '')) ?>"
                                data-base="<?= (float) ($row->base_entitlement ?? 0) ?>"
                                data-allocation="<?= $row->allocation !== null ? (float) $row->allocation : '' ?>"
                                data-status="<?= $row->allocation !== null ? 'configured' : 'not_configured' ?>"
                                data-fy="<?= htmlspecialchars((string) ($currentFy->label ?? '')) ?>">
                          <span class="fas fa-eye me-2 text-600" data-fa-transform="shrink-3"></span>View
                        </button>
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

<div class="modal fade" id="viewAllocationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i data-feather="file-text" width="16" height="16" class="me-2 text-500"></i>
          Allocation Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="d-flex align-items-center mb-4 p-3 rounded" style="background:#f8fafc;">
          <div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width:44px;height:44px;">
            <i data-feather="file-text" width="20" height="20"></i>
          </div>
          <div>
            <div class="fw-semi-bold" style="font-size:1rem;" id="vm-leave-type">—</div>
            <div class="text-500 fs-11" id="vm-fy">—</div>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-1">Base Entitlement</div>
            <div class="fs-4 fw-semi-bold" id="vm-base">—</div>
          </div>
          <div class="col-6">
            <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-1">Policy Allocation</div>
            <div class="fs-4 fw-semi-bold" id="vm-allocation">—</div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center border-top pt-3">
          <span class="text-500 fs-11">Status</span>
          <span id="vm-status-badge">—</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('click', function (event) {
    const trigger = event.target.closest('.js-view-allocation');
    if (!trigger) {
      return;
    }

    const leaveType = trigger.dataset.leaveType || '—';
    const fy = trigger.dataset.fy || '—';
    const base = trigger.dataset.base || '';
    const allocation = trigger.dataset.allocation || '';
    const status = trigger.dataset.status || 'not_configured';

    const vmLeaveType = document.getElementById('vm-leave-type');
    const vmFy = document.getElementById('vm-fy');
    const vmBase = document.getElementById('vm-base');
    const vmAllocation = document.getElementById('vm-allocation');
    const vmStatusBadge = document.getElementById('vm-status-badge');

    if (vmLeaveType) vmLeaveType.textContent = leaveType;
    if (vmFy) vmFy.textContent = fy;
    if (vmBase) vmBase.textContent = base ? base + ' days' : '—';

    if (vmAllocation) {
      vmAllocation.textContent = allocation ? allocation + ' days' : 'Not configured';
      vmAllocation.style.fontStyle = allocation ? 'normal' : 'italic';
      vmAllocation.style.color = allocation ? '' : '#6c757d';
    }

    if (vmStatusBadge) {
      vmStatusBadge.className = status === 'configured'
        ? 'badge rounded-pill badge-subtle-success'
        : 'badge rounded-pill badge-subtle-secondary';
      vmStatusBadge.textContent = status === 'configured' ? 'Configured' : 'Not configured';
    }
  });
</script>
