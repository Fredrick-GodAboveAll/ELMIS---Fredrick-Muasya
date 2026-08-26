<?php $currentPage = 'departments'; ?>
<?php $csrf = \App\Core\Csrf::generate(); ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item active" aria-current="page">Departments</li>
  </ol>
</nav>

<?php
// Render Falcon-style alerts for different flash levels
$flashMap = [
  'flash_success' => ['class' => 'success', 'icon' => 'check-circle', 'bg' => 'bg-success'],
  'flash_info' => ['class' => 'info', 'icon' => 'info-circle', 'bg' => 'bg-info'],
  'flash_warning' => ['class' => 'warning', 'icon' => 'exclamation-circle', 'bg' => 'bg-warning'],
  'flash_error' => ['class' => 'danger', 'icon' => 'times-circle', 'bg' => 'bg-danger'],
];

foreach ($flashMap as $key => $meta) {
  if (!empty($_SESSION[$key])) {
    $msg = htmlspecialchars((string) $_SESSION[$key], ENT_QUOTES, 'UTF-8');
    ?>
    <div class="alert alert-<?= $meta['class']; ?> alert-dismissible border-0 d-flex align-items-center fade show" role="alert">
      <div class="<?= $meta['bg']; ?> me-3 icon-item"><span class="fas fa-<?= $meta['icon']; ?> text-white fs-6"></span></div>
      <p class="mb-0 flex-1"><?= $msg; ?></p>
      <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION[$key]);
  }
}
?>

<div class="row mb-2 justify-content-end align-items-center">
  <div class="col-auto">
    <button class="btn btn-falcon-default btn-sm" data-bs-toggle="offcanvas" data-bs-target="#historyEmployees" type="button">
      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
      <span class="d-none d-sm-inline-block ms-1">Add Department</span>
    </button>

    <a href="/departments/deployment" class="btn btn-outline-secondary btn-sm ms-2">
      <span class="fas fa-rocket" aria-hidden="true"></span>
      <span class="d-none d-sm-inline-block ms-1">Deployment</span>
    </a>

  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Departments</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div class="d-none" id="table-simple-pagination-actions">
              <div class="d-flex">
                <select class="form-select form-select-sm" aria-label="Bulk actions">
                  <option selected="">Bulk actions</option>
                  <option value="Edit">Edit</option>
                  <option value="Archive">Archive</option>
                  <option value="Delete">Delete</option>
                </select>
                <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
              </div>
            </div>
            <div id="table-simple-pagination-replace-element">
              
              <button class="btn btn-falcon-default btn-sm mx-2" type="button">
                <span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span>
                <span class="d-none d-sm-inline-block ms-1">Filter</span>
              </button>
              <button class="btn btn-falcon-default btn-sm" type="button">
                <span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span>
                <span class="d-none d-sm-inline-block ms-1">Export</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body px-0 pt-0">
        <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
          <thead class="bg-200">
            <tr>
              <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                <div class="form-check mb-0 d-flex align-items-center">
                  <input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body","actions":"table-simple-pagination-actions","replacedElement":"table-simple-pagination-replace-element"}' />
                </div>
              </th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Department Name</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">Employees</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Department Code</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Head of Department</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
            </tr>
          </thead>
          <tbody class="list" id="table-simple-pagination-body">
            <?php if (!empty($departments)): ?>
              <?php foreach ($departments as $department): ?>
                <tr class="btn-reveal-trigger">
                  <td class="align-middle" style="width: 28px;">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" id="simple-pagination-item-<?= (int) ($department->id ?? 0); ?>" data-bulk-select-row="data-bulk-select-row" />
                    </div>
                  </td>

                  <td class="align-middle white-space-nowrap fw-semi-bold name">
                    <a href="#"><?= htmlspecialchars((string) ($department->name ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></a>
                  </td>
                  <td class="align-middle amount text-start"><?= htmlspecialchars((string) ($department->employee_count ?? 0), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="align-middle amount"><?= htmlspecialchars((string) ($department->code ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="align-middle white-space-nowrap email"><?= htmlspecialchars((string) ($department->hod_name ?? 'Not assigned'), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="align-middle white-space-nowrap text-end">
                    <div class="dropstart font-sans-serif position-static d-inline-block">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-<?= (int) ($department->id ?? 0); ?>" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                        <span class="fas fa-ellipsis-h fs-10"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-<?= (int) ($department->id ?? 0); ?>">
                        <a class="dropdown-item" href="#!">View</a>
                        <a class="dropdown-item" href="#!">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-warning" href="#!">Archive</a>
                        <form method="POST" action="/departments/delete" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this department?');">
                          <input type="hidden" name="id" value="<?= (int) ($department->id ?? 0); ?>" />
                          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />
                          <button type="submit" class="dropdown-item text-danger">Delete</button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4">No departments found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<div class="offcanvas offcanvas-end" tabindex="-1" id="historyEmployees" aria-labelledby="historyEmployeesLabel" style="width:460px;">

  <!-- Header -->
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="historyEmployeesLabel">
      New department
    </h5>

    <button class="btn-close text-reset"
            type="button"
            data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
  </div>


  <!-- Body -->
  <div class="offcanvas-body p-0">
    <form method="POST" action="/departments" id="createDepartmentForm">

      <ul class="nav nav-tabs px-3" id="departmentTabs" role="tablist">

        <li class="nav-item">
          <a class="nav-link active" id="general-details-tab" data-bs-toggle="tab" href="#tab-general-details" role="tab" aria-controls="tab-general-details" aria-selected="true">General details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" id="limits-tab" data-bs-toggle="tab" href="#tab-limits" role="tab" aria-controls="tab-limits" aria-selected="false">Limits</a>
        </li>

      </ul>

      <div class="tab-content p-3" id="departmentTabsContent">

        <div class="tab-pane fade show active" id="tab-general-details" role="tabpanel" aria-labelledby="general-details-tab">

          <div class="mb-3">
            <label class="form-label fs--1 mb-1" for="departmentName">Department name <span class="text-danger">*</span></label>
            <input class="form-control" id="departmentName" name="department_name" type="text" placeholder="Enter department name" required>
          </div>

          <div class="mb-3">
            <label class="form-label fs--1 mb-1" for="departmentCode">Department code</label>
            <input class="form-control" id="departmentCode" name="department_code" type="text" readonly placeholder="Auto-generated">
          </div>

          <div class="mb-3">
            <label class="form-label fs--1 mb-1" for="headOfDepartment">Head of Department</label>
            <select class="form-select js-choice" id="headOfDepartment" name="head_of_department" size="1" data-options='{"removeItemButton": true, "placeholder": true, "searchEnabled": true, "duplicateItemsAllowed": false}'>
              <option value="">Select head of department...</option>
              <?php if (!empty($employees)): ?>
                <?php foreach ($employees as $empOpt): ?>
                  <option value="<?= htmlspecialchars((string) ($empOpt->payroll_number ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) ($empOpt->full_name ?? $empOpt->payroll_number), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />

          <p class="text-600 mb-0">Add the basic information for the department and select the employee responsible for leading the department.</p>

        </div>

        <div class="tab-pane fade" id="tab-limits" role="tabpanel" aria-labelledby="limits-tab">

          <div class="d-flex flex-column gap-3">

            <div class="d-flex justify-content-between align-items-center">

              <button type="button" class="btn btn-link text-primary p-0">
                <span class="fas fa-plus me-2"></span>
                Add limit
              </button>

            </div>

            <div class="text-center py-5">

              <div class="mb-3">
                <span class="fas fa-calendar-alt fs-5 text-info"></span>
              </div>

              <h5 class="mb-2">No limits have been added yet</h5>

              <p class="text-600 mb-0">Limit how many employees in this department are allowed to take leave in a specific date range.</p>

            </div>

          </div>

        </div>

      </div>

    </form>

  </div>

<script>
  (function(){
    const nameInput = document.getElementById('departmentName');
    const codeInput = document.getElementById('departmentCode');

    function genCode(name){
      const first = (name || '').trim().charAt(0).toUpperCase() || 'D';
      const rand = Math.floor(100 + Math.random() * 900); // 100-999
      return first + rand;
    }

    if(nameInput && codeInput){
      nameInput.addEventListener('input', function(e){
        codeInput.value = genCode(e.target.value);
      });
      // initialize when form is shown
      codeInput.value = genCode(nameInput.value || '');
      // also regenerate when offcanvas opens (in case user reopened)
      var offcanvasEl = document.getElementById('historyEmployees');
      if(window.bootstrap && offcanvasEl){
        offcanvasEl.addEventListener('show.bs.offcanvas', function(){
          codeInput.value = genCode(nameInput.value || '');
        });
      }
    }
  })();
</script>


  <!-- Footer -->
  <div class="border-top p-3">
    <div class="d-flex justify-content-end align-items-center gap-2">

      <button type="button"
              class="btn btn-falcon-default"
              data-bs-dismiss="offcanvas">
        Cancel
      </button>

      <button type="submit"
              form="createDepartmentForm"
              class="btn btn-primary">
        <span class="fas fa-building me-2"></span>
        Add department
      </button>

    </div>
  </div>

</div>

<!-- Department code is generated server-side as first letter + random number; no client auto-generation. -->
