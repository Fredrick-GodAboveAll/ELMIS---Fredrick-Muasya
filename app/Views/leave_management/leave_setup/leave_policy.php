<?php $currentPage = 'leave_policy'; ?>
<?php $csrf = \App\Core\Csrf::generate(); ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item active" aria-current="page">leave policy</li>
  </ol>
</nav>

<?php if ($error = \App\Core\Session::flash('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if ($success = \App\Core\Session::flash('success')): ?>
  <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row g-3 mb-3 align-items-center">
  <div class="col-lg-8">
    <h4 class="mb-1"><i data-feather="shield" class="me-2" width="22" height="22"></i>Leave Policies</h4>
    <p class="mb-0 text-600">Reusable templates that define what leave each group of employees is allocated per Financial Year.</p>
  </div>
  <div class="col-lg-4 text-lg-end">
    <button class="btn btn-falcon-default" type="button" data-bs-toggle="offcanvas" data-bs-target="#addPolicyOffcanvas" aria-controls="addPolicyOffcanvas">
      <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add policy
    </button>
  </div>
</div>

<!-- Stat cards -->
<div class="row g-3 mb-3">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center p-3 me-3">
            <i data-feather="layers" width="20" height="20"></i>
          </div>
          <div>
            <p class="text-500 fs-10 mb-1">Total Policies</p>
            <h4 class="mb-0">5</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center p-3 me-3">
            <i data-feather="check-circle" width="20" height="20"></i>
          </div>
          <div>
            <p class="text-500 fs-10 mb-1">Active</p>
            <h4 class="mb-0">3</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center p-3 me-3">
            <i data-feather="archive" width="20" height="20"></i>
          </div>
          <div>
            <p class="text-500 fs-10 mb-1">Inactive</p>
            <h4 class="mb-0">2</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Search + filter toolbar -->
<div class="row g-3 align-items-center mb-3">
  <div class="col-lg-5">
    <input class="form-control shadow-sm" id="policySearch" type="search" placeholder="Search policies by name or description">
  </div>
  <div class="col-lg-3">
    <select class="form-select js-choice shadow-sm" id="policyStatus">
      <option value="">All statuses</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
  </div>
  <div class="col-lg-4 text-lg-end">
    <span class="d-inline-block bg-white shadow-sm rounded-3 px-3 py-2 text-600 fs-10">
      <span class="fw-bold text-900">4</span> policies
    </span>
  </div>
</div>

<div class="row g-3">
  <div class="col-12">
    <?php if (empty($policies)): ?>
      <div class="card">
        <div class="card-body text-center py-5">
          <p class="text-700 mb-0">No policies found. Create the first reusable policy to get started.</p>
        </div>
      </div>
    <?php else: ?>
      <div class="row g-3" id="policyList">
        <?php foreach ($policies as $policy): ?>
          <?php $isActive = !empty($policy->is_active); ?>
          <div class="col-lg-6 js-policy-item"
               data-policy-name="<?= htmlspecialchars((string) ($policy->name ?? ''), ENT_QUOTES, 'UTF-8') ?>"
               data-policy-description="<?= htmlspecialchars((string) ($policy->description ?? ''), ENT_QUOTES, 'UTF-8') ?>"
               data-policy-status="<?= $isActive ? 'active' : 'inactive' ?>">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">

                <div class="d-flex justify-content-between align-items-start mb-2">
                  <div class="d-flex align-items-center">
                    <div class="bg-<?= $isActive ? 'primary' : 'secondary' ?>-subtle text-<?= $isActive ? 'primary' : 'secondary' ?> rounded-3 d-flex align-items-center justify-content-center p-2 me-2">
                      <i data-feather="file-text" width="16" height="16"></i>
                    </div>
                    <div>
                      <h6 class="mb-0"><?= htmlspecialchars((string) ($policy->name ?? 'Unnamed policy')) ?></h6>
                      <div class="d-flex align-items-center mt-1">
                        <span class="bg-<?= $isActive ? 'success' : 'secondary' ?> rounded-circle d-inline-block" style="width:6px;height:6px;"></span>
                        <span class="text-<?= $isActive ? 'success' : 'secondary' ?> fs-11 fw-semi-bold ms-1">
                          <?= $isActive ? 'Active' : 'Inactive' ?>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="dropdown font-sans-serif position-static d-inline-block">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none" type="button"
                            data-bs-toggle="dropdown" data-boundary="viewport"
                            aria-haspopup="true" aria-expanded="false"
                            aria-label="Policy actions">
                      <span class="fas fa-ellipsis-h fs-11"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end border py-2">
                      <button class="dropdown-item" type="button"
                              data-bs-toggle="modal"
                              data-bs-target="#policyDetailsModal">
                        <span class="fas fa-eye me-2 text-600" data-fa-transform="shrink-3"></span>View
                      </button>
                      <a class="dropdown-item" href="/leave-policy-detail">
                        <span class="fas fa-edit me-2 text-600" data-fa-transform="shrink-3"></span>Edit
                      </a>
                      <div class="dropdown-divider"></div>
                      <?php if ($isActive): ?>
                        <a class="dropdown-item text-warning" href="#!">
                          <span class="fas fa-ban me-2" data-fa-transform="shrink-3"></span>Deactivate
                        </a>
                      <?php else: ?>
                        <a class="dropdown-item text-success" href="#!">
                          <span class="fas fa-check-circle me-2" data-fa-transform="shrink-3"></span>Activate
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <p class="text-600 fs-10 mb-3">
                  <?= !empty($policy->description) ? htmlspecialchars((string) $policy->description) : 'No description provided.' ?>
                </p>

                <div class="mt-auto border-top pt-2 d-flex justify-content-between align-items-center">
                  <p class="text-500 fs-11 mb-0">Configured <span class="text-900 fw-semi-bold">5</span> of 10</p>
                  <a class="text-primary fs-11 fw-semi-bold text-decoration-none" href="/leave-policy-detail">
                    Open policy
                    <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-4"></span>
                  </a>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="card d-none mt-3" id="policyNoResults">
        <div class="card-body text-center py-5">
          <i data-feather="search" width="28" height="28" class="text-400 mb-2"></i>
          <p class="text-700 mb-0">No policies match your search or filter.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- ==========================================================
     POLICY DETAILS MODAL
     ========================================================== -->
<div class="modal fade" id="policyDetailsModal" tabindex="-1" aria-labelledby="policyDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="policyDetailsModalLabel">
          <i data-feather="file-text" width="16" height="16" class="me-2 text-muted"></i>
          Policy Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">

        <!-- Hero -->
        <div class="bg-primary-subtle rounded-3 p-4 mb-4">
          <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
              <h3 class="mb-1">Executive Leave Policy</h3>
              <p class="text-600 mb-0">Special policy for senior staff with enhanced annual leave.</p>
            </div>
            <div class="d-flex align-items-center">
              <span class="bg-success rounded-circle d-inline-block me-2" style="width:8px;height:8px;"></span>
              <span class="text-success fw-semi-bold">Active</span>
            </div>
          </div>
        </div>

        <!-- Stat tiles -->
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <div class="bg-body-tertiary border rounded-3 p-3 h-100">
              <p class="text-500 fs-11 mb-1">Leave Types Configured</p>
              <h4 class="mb-0">5 <span class="text-600 fs-11 fw-normal">of 10</span></h4>
            </div>
          </div>
          <div class="col-md-4">
            <div class="bg-body-tertiary border rounded-3 p-3 h-100">
              <p class="text-500 fs-11 mb-1">Financial Years</p>
              <h4 class="mb-0">3 <span class="text-600 fs-11 fw-normal">covered</span></h4>
            </div>
          </div>
          <div class="col-md-4">
            <div class="bg-body-tertiary border rounded-3 p-3 h-100">
              <p class="text-500 fs-11 mb-1">Employees Assigned</p>
              <h4 class="mb-0">8 <span class="text-600 fs-11 fw-normal">staff</span></h4>
            </div>
          </div>
        </div>

        <!-- Allocations table -->
        <h6 class="mb-2">Leave Allocations</h6>
        <div class="border rounded-3 overflow-hidden">
          <div class="table-responsive">
            <table class="table table-sm fs-10 mb-0">
              <thead class="bg-200">
                <tr>
                  <th class="text-900 ps-3 text-nowrap">Leave Type</th>
                  <th class="text-900 text-end text-nowrap">Base</th>
                  <th class="text-900 text-end text-nowrap">Allocation</th>
                  <th class="text-900 pe-3 text-nowrap">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="ps-3 py-3 fw-semi-bold text-nowrap">Annual Leave</td>
                  <td class="text-end py-3 text-nowrap">30 <span class="text-600">days</span></td>
                  <td class="text-end py-3 fw-semi-bold text-nowrap">35 <span class="text-600 fw-normal">days</span></td>
                  <td class="pe-3 py-3 text-nowrap">
                    <span class="badge rounded-pill badge-subtle-success">Configured</span>
                  </td>
                </tr>
                <tr>
                  <td class="ps-3 py-3 fw-semi-bold text-nowrap">Sick Leave</td>
                  <td class="text-end py-3 text-nowrap">10 <span class="text-600">days</span></td>
                  <td class="text-end py-3 fw-semi-bold text-nowrap">15 <span class="text-600 fw-normal">days</span></td>
                  <td class="pe-3 py-3 text-nowrap">
                    <span class="badge rounded-pill badge-subtle-success">Configured</span>
                  </td>
                </tr>
                <tr>
                  <td class="ps-3 py-3 fw-semi-bold text-nowrap">Maternity Leave</td>
                  <td class="text-end py-3 text-nowrap">90 <span class="text-600">days</span></td>
                  <td class="text-end py-3 fw-semi-bold text-nowrap">90 <span class="text-600 fw-normal">days</span></td>
                  <td class="pe-3 py-3 text-nowrap">
                    <span class="badge rounded-pill badge-subtle-success">Configured</span>
                  </td>
                </tr>
                <tr>
                  <td class="ps-3 py-3 fw-semi-bold text-nowrap">Paternity Leave</td>
                  <td class="text-end py-3 text-nowrap">10 <span class="text-600">days</span></td>
                  <td class="text-end py-3 fw-semi-bold text-nowrap">10 <span class="text-600 fw-normal">days</span></td>
                  <td class="pe-3 py-3 text-nowrap">
                    <span class="badge rounded-pill badge-subtle-success">Configured</span>
                  </td>
                </tr>
                <tr>
                  <td class="ps-3 py-3 fw-semi-bold text-nowrap">Study Leave</td>
                  <td class="text-end py-3 text-nowrap">5 <span class="text-600">days</span></td>
                  <td class="text-end py-3 fw-semi-bold text-nowrap">10 <span class="text-600 fw-normal">days</span></td>
                  <td class="pe-3 py-3 text-nowrap">
                    <span class="badge rounded-pill badge-subtle-success">Configured</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Timeline -->
        <div class="row g-3 mt-4">
          <div class="col-md-6">
            <div class="bg-body-tertiary border rounded-3 p-3">
              <p class="text-500 fs-11 mb-1">Created</p>
              <p class="mb-0 fw-semi-bold">01 Jul 2024</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="bg-body-tertiary border rounded-3 p-3">
              <p class="text-500 fs-11 mb-1">Last Updated</p>
              <p class="mb-0 fw-semi-bold">12 Aug 2026</p>
            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer border-top bg-body-tertiary">
        <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">Close</button>
        <a href="/leave-policy-detail?id=2" class="btn btn-primary">
          <i data-feather="edit-2" width="14" height="14" class="me-1"></i>
          Edit policy
        </a>
      </div>

    </div>
  </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="addPolicyOffcanvas" aria-labelledby="addPolicyOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="addPolicyOffcanvasLabel"><i data-feather="shield" class="me-2" width="18" height="18"></i>Add leave policy</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0">
    <form method="POST" action="/leave-policies" id="createPolicyForm">
      <div class="p-3">
        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="policyName">Policy name <span class="text-danger">*</span></label>
          <input class="form-control" id="policyName" name="name" type="text" placeholder="e.g. Standard Staff Leave Policy" required>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="policyDescription">Description</label>
          <textarea class="form-control" id="policyDescription" name="description" rows="3" placeholder="Who does this policy apply to?"></textarea>
        </div>

        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="policyActive" name="is_active" value="1" checked>
          <label class="form-check-label" for="policyActive">Active policy</label>
        </div>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />
      </div>
    </form>
  </div>

  <div class="border-top p-3">
    <div class="d-flex justify-content-end align-items-center gap-2">
      <button type="button" class="btn btn-falcon-default" data-bs-dismiss="offcanvas">Cancel</button>
      <button type="submit" form="createPolicyForm" class="btn btn-primary">Save policy</button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('policySearch');
    var statusSelect = document.getElementById('policyStatus');
    var items = document.querySelectorAll('.js-policy-item');
    var noResults = document.getElementById('policyNoResults');

    function filterPolicies() {
      var query = (searchInput ? searchInput.value : '').trim().toLowerCase();
      var status = statusSelect ? statusSelect.value : '';
      var visible = 0;

      items.forEach(function (item) {
        var name = (item.dataset.policyName || '').toLowerCase();
        var desc = (item.dataset.policyDescription || '').toLowerCase();
        var itemStatus = item.dataset.policyStatus || '';

        var matchSearch = !query || name.indexOf(query) !== -1 || desc.indexOf(query) !== -1;
        var matchStatus = !status || itemStatus === status;

        if (matchSearch && matchStatus) {
          item.classList.remove('d-none');
          visible++;
        } else {
          item.classList.add('d-none');
        }
      });

      if (noResults) {
        if (visible === 0 && items.length > 0) {
          noResults.classList.remove('d-none');
        } else {
          noResults.classList.add('d-none');
        }
      }
    }

    if (searchInput) {
      searchInput.addEventListener('input', filterPolicies);
      searchInput.addEventListener('change', filterPolicies);
    }
    if (statusSelect) {
      statusSelect.addEventListener('change', filterPolicies);
    }
  });
</script>