<?php $currentPage = 'leave_policy'; ?>
<?php $csrf = \App\Core\Csrf::generate(); ?>
<?php $policies = $policies ?? []; ?>

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

<div class="row g-3 mb-3">
  <div class="col-lg-8">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
      <div>
        <h4 class="mb-1"><i data-feather="shield" class="me-2" width="22" height="22"></i>Leave Policies</h4>
        <p class="mb-0 text-600">Define reusable leave policies and the leave rules they apply to.</p>
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
          <div class="col-lg-6">
            <label class="form-label" for="policyStatus">Status</label>
            <select class="form-select js-choice" id="policyStatus">
              <option value="">All statuses</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">Policies</h5>
      <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#addPolicyOffcanvas" aria-controls="addPolicyOffcanvas">
        <i data-feather="plus" width="14" height="14"></i>
        <span class="ms-1">Add policy</span>
      </button>
    </div>

    <?php if (empty($policies)): ?>
      <div class="card">
        <div class="card-body text-center py-5">
          <p class="text-700 mb-0">No policies found. Create the first reusable policy to get started.</p>
        </div>
      </div>
    <?php else: ?>
      <div class="row g-3">
        <?php foreach ($policies as $policy): ?>
          <div class="col-lg-6">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    <h5 class="mb-1"><?= htmlspecialchars((string) ($policy->name ?? 'Unnamed policy')) ?></h5>
                  </div>
                  <span class="badge rounded-pill badge-subtle-<?= !empty($policy->is_active) ? 'success' : 'secondary'; ?>"><?= !empty($policy->is_active) ? 'Active' : 'Inactive' ?></span>
                </div>

                <p class="text-700 mb-3"><?= !empty($policy->description) ? htmlspecialchars((string) $policy->description) : 'No description provided.' ?></p>

                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                  <span class="text-600 fs-10">Reusable policy definition</span>
                  <div>
                    <button class="btn btn-link btn-sm text-600 p-1" type="button" title="View policy"><i data-feather="eye" width="15" height="15"></i></button>
                    <button class="btn btn-link btn-sm text-600 p-1" type="button" title="Edit policy"><i data-feather="edit-2" width="15" height="15"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
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
