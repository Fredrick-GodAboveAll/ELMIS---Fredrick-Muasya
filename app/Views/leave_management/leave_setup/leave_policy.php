<?php
$currentPage = 'leave_policy';
$csrf = \App\Core\Csrf::generate();

// Old input: not currently provided by this flow; created locally for Leave Policies only.
$old = $old ?? [];
$oldIsActive = isset($old['is_active']) ? (string) $old['is_active'] : '1';
$policyActiveChecked = ($oldIsActive === '1' || (int) $oldIsActive === 1) ? 'checked' : '';

$policies = $policies ?? [];
$totalPolicies = $totalPolicies ?? (is_array($policies) ? count($policies) : 0);
$activePolicies = $activePolicies ?? (is_array($policies) ? count(array_filter($policies, fn($p) => !empty($p->is_active))) : 0);
$inactivePolicies = $inactivePolicies ?? ($totalPolicies - $activePolicies);
?>

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
            <h4 class="mb-0"><?= (int) $totalPolicies; ?></h4>
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
            <h4 class="mb-0"><?= (int) $activePolicies; ?></h4>
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
            <h4 class="mb-0"><?= (int) $inactivePolicies; ?></h4>
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
      <span class="fw-bold text-900"><?= (int) $totalPolicies; ?></span> policies
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
          <?php
            $isActive = !empty($policy->is_active);
            $pid = (int) ($policy->id ?? 0);
          ?>
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
                              data-bs-target="#viewPolicyModal-<?= $pid ?>">
                        View
                      </button>
                      <a class="dropdown-item" href="/leave-policy-detail?id=<?= urlencode((string) $pid) ?>">
                        Edit
                      </a>
                      <div class="dropdown-divider"></div>
                      <?php if ($isActive): ?>
                        <form method="POST" action="/leave-policies/toggle-active" class="m-0">
                          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />
                          <input type="hidden" name="id" value="<?= (int) $pid ?>" />
                          <input type="hidden" name="action" value="deactivate" />
                          <button type="submit" class="dropdown-item text-warning">
                            Deactivate
                          </button>
                        </form>
                      <?php else: ?>
                        <form method="POST" action="/leave-policies/toggle-active" class="m-0">
                          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />
                          <input type="hidden" name="id" value="<?= (int) $pid ?>" />
                          <input type="hidden" name="action" value="activate" />
                          <button type="submit" class="dropdown-item text-success">
                            Activate
                          </button>
                        </form>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <p class="text-600 fs-10 mb-3">
                  <?= !empty($policy->description) ? htmlspecialchars((string) $policy->description) : 'No description provided.' ?>
                </p>

                <div class="mt-auto border-top pt-2 d-flex justify-content-between align-items-center">
                  <p class="text-500 fs-11 mb-0">Configured <span class="text-900 fw-semi-bold"><?= (int) ($policy->card->configured_count ?? 0) ?></span> of <?= (int) ($policy->card->total_entitlements ?? 0) ?></p>
                  <a class="text-primary fs-11 fw-semi-bold text-decoration-none" href="/leave-policy-detail?id=<?= urlencode((string) $pid) ?>">
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

<!-- ============================================================
     ONE VIEW MODAL PER POLICY — rendered by PHP, no JS
     Generic/demo data — Copilot will wire real data
     ============================================================ -->
<?php foreach ($policies as $policy): ?>
  <?php
    $isActive = !empty($policy->is_active);
    $pid = (int) ($policy->id ?? 0);
  ?>
  <div class="modal fade" id="viewPolicyModal-<?= $pid ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">
            <i data-feather="file-text" width="16" height="16" class="me-2 text-500"></i>
            Policy Details
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body p-4">

          <!-- Hero -->
          <div class="bg-primary-subtle rounded-3 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
              <div>
                <h3 class="mb-1 fw-semi-bold"><?= htmlspecialchars((string) ($policy->name ?? 'Policy')) ?></h3>
                <p class="text-600 mb-0">
                  <?= !empty($policy->description) ? htmlspecialchars((string) $policy->description) : 'No description provided.' ?>
                </p>
              </div>
              <span class="badge rounded-pill badge-subtle-<?= $isActive ? 'success' : 'secondary' ?>">
                <?= $isActive ? 'Active' : 'Inactive' ?>
              </span>
            </div>
          </div>

          <div class="text-500 fs-11 mb-3">
            Showing allocations for
            <span class="fw-semi-bold text-900">FY <?= htmlspecialchars($currentFyLabel ?? '—') ?></span>
          </div>

          <!-- Stat tiles -->
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <div class="bg-body-tertiary border rounded-3 p-3 h-100">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-2" style="letter-spacing:.05em;">
                  Leave Types Configured
                </div>
                <div class="d-flex align-items-baseline">
                  <span class="fw-semi-bold"><?= (int) ($policy->card->configured_count ?? 0) ?></span>
                  <span class="text-500 fs-11 ms-1">of <?= (int) ($policy->card->total_entitlements ?? 0) ?></span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="bg-body-tertiary border rounded-3 p-3 h-100">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-2" style="letter-spacing:.05em;">
                  Financial Years
                </div>
                <div class="d-flex align-items-baseline">
                  <span class="fw-semi-bold"><?= (int) ($policy->card->financial_years_count ?? 0) ?></span>
                  <span class="text-500 fs-11 ms-1">covered</span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="bg-body-tertiary border rounded-3 p-3 h-100">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-2" style="letter-spacing:.05em;">
                  Employees Assigned
                </div>
                <div class="d-flex align-items-baseline">
                  <span class="fw-semi-bold"><?= (int) ($policy->card->employees_assigned ?? 0) ?></span>
                  <span class="text-500 fs-11 ms-1">staff</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Allocations table -->
          <h6 class="mb-2 fs-10 text-uppercase text-500 fw-semi-bold" style="letter-spacing:.05em;">
            Leave Allocations
          </h6>
          <div class="border rounded-3 overflow-hidden mb-4">
            <div class="table-responsive">
              <table class="table table-sm fs-10 mb-0">
                <thead class="bg-200">
                  <tr>
                    <th class="text-900 ps-3">Leave Type</th>
                    <th class="text-900 text-end">Base</th>
                    <th class="text-900 text-end">Allocation</th>
                    <th class="text-900 pe-3">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($policy->card->allocations as $alloc): ?>
                    <tr>
                      <td class="ps-3 fw-semi-bold"><?= htmlspecialchars($alloc->leave_type_name) ?></td>
                      <td class="text-end"><?= (int) $alloc->base_entitlement ?> <span class="text-600">days</span></td>
                      <td class="text-end fw-semi-bold">
                        <?php if ($alloc->allocation !== null): ?>
                          <?= (float) $alloc->allocation ?> <span class="text-600 fw-normal">days</span>
                        <?php else: ?>
                          <span class="text-600 fst-italic">Not set</span>
                        <?php endif; ?>
                      </td>
                      <td class="pe-3">
                        <?php if ($alloc->status === 'configured'): ?>
                          <span class="badge rounded-pill badge-subtle-success">Configured</span>
                        <?php else: ?>
                          <span class="badge rounded-pill badge-subtle-secondary">Not configured</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Meta -->
          <div class="row g-3">
            <div class="col-md-6">
              <div class="bg-body-tertiary border rounded-3 p-3">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-1" style="letter-spacing:.05em;">Created</div>
                <div class="fw-semi-bold fs-11"><?= htmlspecialchars($policy->card->created_at ?? '—') ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="bg-body-tertiary border rounded-3 p-3">
                <div class="text-500 fs-10 text-uppercase fw-semi-bold mb-1" style="letter-spacing:.05em;">Last Updated</div>
                <div class="fw-semi-bold fs-11"><?= htmlspecialchars($policy->card->updated_at ?? '—') ?></div>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">Close</button>
          <a href="/leave-policy-detail?id=<?= urlencode((string) $pid) ?>" class="btn btn-primary">
            <i data-feather="edit-2" width="14" height="14" class="me-1"></i>
            Open policy
          </a>
        </div>

      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- ============================================================
     ADD POLICY OFFCANVAS
     ============================================================ -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addPolicyOffcanvas" aria-labelledby="addPolicyOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="addPolicyOffcanvasLabel">
      <i data-feather="shield" class="me-2" width="18" height="18"></i>Add leave policy
    </h5>
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
          <input type="hidden" name="is_active" value="0" />
          <input class="form-check-input" type="checkbox" id="policyActive" name="is_active" value="1" <?= $policyActiveChecked ?>>
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