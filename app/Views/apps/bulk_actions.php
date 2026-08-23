<?php
$currentPage = 'bulk_import';
$csrfToken = \App\Core\Csrf::generate();
?>

<?php if ($error = \App\Core\Session::flash('error')): ?>
  <div class="alert alert-danger rounded-3 border-0 mb-3"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success = \App\Core\Session::flash('success')): ?>
  <div class="alert alert-success rounded-3 border-0 mb-3"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="row g-3 mb-3">
  <div class="col-12">
    <h5 class="mb-0">Data import</h5>
    <p class="text-600 mb-0">If you are managing many employees, you can bulk upload their data here.</p>
  </div>
</div>

<!-- Employees -->
<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0">Employees</h6>
        <button type="button" class="btn btn-falcon-default btn-sm rounded-pill" data-bs-toggle="offcanvas" data-bs-target="#historyEmployees" aria-controls="historyEmployees">
          <span class="fas fa-hourglass-half me-1" data-fa-transform="shrink-3"></span>See import history
        </button>
      </div>
      <div class="card-body">
        <p class="text-600 mb-3">Import multiple employees using an Excel (.xlsx) or CSV (.csv) template.</p>
        <form action="/bulk-import/employees" method="post" enctype="multipart/form-data" class="d-flex align-items-center flex-wrap gap-2 mb-0 employee-upload-form">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <a href="#!" class="fw-semibold" data-bs-toggle="modal" data-bs-target="#templateEmployees">
            <span class="fas fa-download me-1" data-fa-transform="shrink-3"></span>Download template
          </a>
          <span class="text-600">and fill it, then</span>
          <label class="btn btn-primary btn-sm rounded-pill mb-0 employee-upload-label" for="employeesFile">
            <span class="fas fa-upload me-1" data-fa-transform="shrink-3"></span>Upload filled template
          </label>
          <button type="button" class="btn btn-primary btn-sm rounded-pill mb-0 employee-upload-loading d-none" disabled>
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Uploading...
          </button>
          <input type="file" id="employeesFile" name="import_file" accept=".xlsx,.csv" class="d-none employee-file-input">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Leave -->
<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0">Leave</h6>
        <button type="button" class="btn btn-falcon-default btn-sm rounded-pill" data-bs-toggle="offcanvas" data-bs-target="#historyLeave" aria-controls="historyLeave">
          <span class="fas fa-hourglass-half me-1" data-fa-transform="shrink-3"></span>See import history
        </button>
      </div>
      <div class="card-body">
        <p class="text-600 mb-3">Import multiple leave records using an Excel (.xlsx) or CSV (.csv) template.</p>
        <form action="/bulk-import/leave" method="post" enctype="multipart/form-data" class="d-flex align-items-center flex-wrap gap-2 mb-0 leave-upload-form">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <a href="#!" class="fw-semibold" data-bs-toggle="modal" data-bs-target="#templateLeave">
            <span class="fas fa-download me-1" data-fa-transform="shrink-3"></span>Download template
          </a>
          <span class="text-600">and fill it, then</span>
          <label class="btn btn-primary btn-sm rounded-pill mb-0 leave-upload-label" for="leaveFile">
            <span class="fas fa-upload me-1" data-fa-transform="shrink-3"></span>Upload filled template
          </label>
          <button type="button" class="btn btn-primary btn-sm rounded-pill mb-0 leave-upload-loading d-none" disabled>
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Uploading...
          </button>
          <input type="file" id="leaveFile" name="import_file" accept=".xlsx,.csv" class="d-none leave-file-input">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Allowances -->
<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0">Allowances</h6>
        <button type="button" class="btn btn-falcon-default btn-sm rounded-pill" data-bs-toggle="offcanvas" data-bs-target="#historyAllowances" aria-controls="historyAllowances">
          <span class="fas fa-hourglass-half me-1" data-fa-transform="shrink-3"></span>See import history
        </button>
      </div>
      <div class="card-body">
        <p class="text-600 mb-3">Import multiple allowances using an Excel (.xlsx) or CSV (.csv) template.</p>
        <form action="/bulk-import/allowances" method="post" enctype="multipart/form-data" class="d-flex align-items-center flex-wrap gap-2 mb-0 allowance-upload-form">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <a href="#!" class="fw-semibold" data-bs-toggle="modal" data-bs-target="#templateAllowances">
            <span class="fas fa-download me-1" data-fa-transform="shrink-3"></span>Download template
          </a>
          <span class="text-600">and fill it, then</span>
          <label class="btn btn-primary btn-sm rounded-pill mb-0 allowance-upload-label" for="allowancesFile">
            <span class="fas fa-upload me-1" data-fa-transform="shrink-3"></span>Upload filled template
          </label>
          <button type="button" class="btn btn-primary btn-sm rounded-pill mb-0 allowance-upload-loading d-none" disabled>
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Uploading...
          </button>
          <input type="file" id="allowancesFile" name="import_file" accept=".xlsx,.csv" class="d-none allowance-file-input">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ============ Template preview modals ============ -->

<!-- Employees template modal -->
<div class="modal fade" id="templateEmployees" tabindex="-1" aria-labelledby="templateEmployeesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg mt-6" role="document">
    <div class="modal-content border-0">
      <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
          <h4 class="mb-1" id="templateEmployeesLabel">Employees import template</h4>
          <p class="fs-11 mb-0">Excel (.xlsx) / CSV (.csv) &middot; last updated <span class="fw-semibold">12 Aug 2026</span></p>
        </div>
        <div class="p-4">
          <div class="row">
            <div class="col-lg-9">
              <div class="d-flex">
                <span class="fa-stack ms-n1 me-3">
                  <i class="fas fa-circle fa-stack-2x text-200"></i>
                  <i class="fa-inverse fa-stack-1x text-primary fas fa-table" data-fa-transform="shrink-2"></i>
                </span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Columns required</h5>
                  <div class="d-flex flex-wrap gap-1">
                    <span class="badge py-2 badge-subtle-primary">Employee No.</span>
                    <span class="badge py-2 badge-subtle-primary">Full Name</span>
                    <span class="badge py-2 badge-subtle-primary">National ID</span>
                    <span class="badge py-2 badge-subtle-primary">Job Group</span>
                    <span class="badge py-2 badge-subtle-primary">Station</span>
                    <span class="badge py-2 badge-subtle-primary">Date of Employment</span>
                  </div>
                  <hr class="my-4" />
                </div>
              </div>
              <div class="d-flex">
                <span class="fa-stack ms-n1 me-3">
                  <i class="fas fa-circle fa-stack-2x text-200"></i>
                  <i class="fa-inverse fa-stack-1x text-primary fas fa-align-left" data-fa-transform="shrink-2"></i>
                </span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Notes</h5>
                  <p class="text-break fs-10">Keep one row per employee and don't rename the header row — the importer matches columns by name.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <h6 class="mt-5 mt-lg-0">Actions</h6>
              <a href="/bulk-import/employees/template" class="btn btn-primary btn-sm rounded-pill w-100 mb-2">
                <span class="fas fa-download me-1" data-fa-transform="shrink-3"></span>Download
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Leave template modal -->
<div class="modal fade" id="templateLeave" tabindex="-1" aria-labelledby="templateLeaveLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg mt-6" role="document">
    <div class="modal-content border-0">
      <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
          <h4 class="mb-1" id="templateLeaveLabel">Leave import template</h4>
          <p class="fs-11 mb-0">Excel (.xlsx) &middot; last updated <span class="fw-semibold">12 Aug 2026</span></p>
        </div>
        <div class="p-4">
          <div class="row">
            <div class="col-lg-9">
              <div class="d-flex">
                <span class="fa-stack ms-n1 me-3">
                  <i class="fas fa-circle fa-stack-2x text-200"></i>
                  <i class="fa-inverse fa-stack-1x text-primary fas fa-table" data-fa-transform="shrink-2"></i>
                </span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Columns required</h5>
                  <div class="d-flex flex-wrap gap-1">
                    <span class="badge py-2 badge-subtle-primary">Employee No.</span>
                    <span class="badge py-2 badge-subtle-primary">Leave Type</span>
                    <span class="badge py-2 badge-subtle-primary">Start Date</span>
                    <span class="badge py-2 badge-subtle-primary">End Date</span>
                    <span class="badge py-2 badge-subtle-primary">Days</span>
                  </div>
                  <hr class="my-4" />
                </div>
              </div>
              <div class="d-flex">
                <span class="fa-stack ms-n1 me-3">
                  <i class="fas fa-circle fa-stack-2x text-200"></i>
                  <i class="fa-inverse fa-stack-1x text-primary fas fa-align-left" data-fa-transform="shrink-2"></i>
                </span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Notes</h5>
                  <p class="text-break fs-10">Dates must be DD/MM/YYYY. Leave type must match an existing leave type name exactly.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <h6 class="mt-5 mt-lg-0">Actions</h6>
              <a href="/bulk-import/leave/template" class="btn btn-primary btn-sm rounded-pill w-100 mb-2">
                <span class="fas fa-download me-1" data-fa-transform="shrink-3"></span>Download
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Allowances template modal -->
<div class="modal fade" id="templateAllowances" tabindex="-1" aria-labelledby="templateAllowancesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg mt-6" role="document">
    <div class="modal-content border-0">
      <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
          <h4 class="mb-1" id="templateAllowancesLabel">Allowances import template</h4>
          <p class="fs-11 mb-0">Excel (.xlsx) &middot; last updated <span class="fw-semibold">12 Aug 2026</span></p>
        </div>
        <div class="p-4">
          <div class="row">
            <div class="col-lg-9">
              <div class="d-flex">
                <span class="fa-stack ms-n1 me-3">
                  <i class="fas fa-circle fa-stack-2x text-200"></i>
                  <i class="fa-inverse fa-stack-1x text-primary fas fa-table" data-fa-transform="shrink-2"></i>
                </span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Columns required</h5>
                  <div class="d-flex flex-wrap gap-1">
                    <span class="badge py-2 badge-subtle-primary">Employee No.</span>
                    <span class="badge py-2 badge-subtle-primary">Allowance Type</span>
                    <span class="badge py-2 badge-subtle-primary">Amount</span>
                    <span class="badge py-2 badge-subtle-primary">Effective Date</span>
                  </div>
                  <hr class="my-4" />
                </div>
              </div>
              <div class="d-flex">
                <span class="fa-stack ms-n1 me-3">
                  <i class="fas fa-circle fa-stack-2x text-200"></i>
                  <i class="fa-inverse fa-stack-1x text-primary fas fa-align-left" data-fa-transform="shrink-2"></i>
                </span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Notes</h5>
                  <p class="text-break fs-10">Amount is in KES, numbers only — no commas or currency symbols.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <h6 class="mt-5 mt-lg-0">Actions</h6>
              <a href="/bulk-import/allowances/template" class="btn btn-primary btn-sm rounded-pill w-100 mb-2">
                <span class="fas fa-download me-1" data-fa-transform="shrink-3"></span>Download
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ============ Import history offcanvases ============ -->

<!-- Employees history -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="historyEmployees" aria-labelledby="historyEmployeesLabel" style="width:460px;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="historyEmployeesLabel">Employees &mdash; import history</h5>
    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="alert alert-primary py-2 px-3 mb-3" role="alert">
      <div class="d-flex align-items-center justify-content-between gap-3">
        <div>
          <div class="fw-semibold">Latest import</div>
          <div class="small text-600">23 Aug 2026 · 09:14</div>
        </div>
        <span class="badge badge-subtle-success">Success</span>
      </div>
    </div>

    <div class="small text-600 mb-2">Recent activity</div>

    <div class="list-group list-group-flush">
      <div class="list-group-item px-0 py-3 border-0 border-bottom">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="fw-semibold">employees_aug_23.csv</div>
            <div class="small text-600">Uploaded 23 Aug 2026 · 09:14</div>
          </div>
          <span class="badge badge-subtle-success">Success</span>
        </div>
        <div class="mt-2 small text-600">7 employees processed</div>
      </div>

      <div class="list-group-item px-0 py-3 border-0 border-bottom">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="fw-semibold">employees_march.xlsx</div>
            <div class="small text-600">Uploaded 12 Aug 2026 · 10:36</div>
          </div>
          <span class="badge badge-subtle-success">Success</span>
        </div>
        <div class="mt-2 small text-600">84 employees processed</div>
      </div>

      <div class="list-group-item px-0 py-3 border-0">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="fw-semibold">employees_jan.xlsx</div>
            <div class="small text-600">Uploaded 15 Jan 2026 · 13:45</div>
          </div>
          <span class="badge badge-subtle-danger">Failed</span>
        </div>
        <div class="mt-2 small text-600">3 rows invalid</div>
      </div>
    </div>
  </div>
</div>

<!-- Leave history -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="historyLeave" aria-labelledby="historyLeaveLabel" style="width:460px;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="historyLeaveLabel">Leave &mdash; import history</h5>
    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <table class="table table-sm align-middle">
      <thead class="table-light">
        <tr><th>File</th><th>Uploaded</th><th>Records</th><th>Status</th></tr>
      </thead>
      <tbody>
        <tr><td>leave_q2.xlsx</td><td>05 Jul 2026</td><td>146</td><td><span class="badge badge-subtle-success">Success</span></td></tr>
        <tr><td>leave_q1.xlsx</td><td>02 Apr 2026</td><td>131</td><td><span class="badge badge-subtle-success">Success</span></td></tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Allowances history -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="historyAllowances" aria-labelledby="historyAllowancesLabel" style="width:460px;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="historyAllowancesLabel">Allowances &mdash; import history</h5>
    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <table class="table table-sm align-middle">
      <thead class="table-light">
        <tr><th>File</th><th>Uploaded</th><th>Records</th><th>Status</th></tr>
      </thead>
      <tbody>
        <tr><td>allowances_july.xlsx</td><td>01 Aug 2026</td><td>212</td><td><span class="badge badge-subtle-success">Success</span></td></tr>
        <tr><td>allowances_june.xlsx</td><td>01 Jul 2026</td><td>209</td><td><span class="badge badge-subtle-danger">Failed &mdash; duplicate rows</span></td></tr>
      </tbody>
    </table>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.employee-upload-form, .leave-upload-form, .allowance-upload-form');

    forms.forEach(function (form) {
      const input = form.querySelector('input[type="file"]');
      const label = form.querySelector('.employee-upload-label, .leave-upload-label, .allowance-upload-label');
      const loading = form.querySelector('.employee-upload-loading, .leave-upload-loading, .allowance-upload-loading');

      if (!input || !label || !loading) return;

      input.addEventListener('change', function () {
        if (!input.files || !input.files.length) return;

        label.classList.add('d-none');
        loading.classList.remove('d-none');

        setTimeout(function () {
          form.submit();
        }, 500);
      });
    });
  });
</script>