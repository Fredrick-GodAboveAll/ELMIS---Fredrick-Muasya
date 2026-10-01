<?php $currentPage = 'holiday_list_detail'; ?>

<?php
/** @var object $holidayList */
/** @var array  $holidays */
/** @var string $csrf */
/** @var array $financialYears */
/** @var object|null $currentFy */
/** @var int $currentFyId */
/** @var object $sourceHolidayList */
?>

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

<?php
$isActive = !empty($holidayList->is_active);
?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/holiday-list">Holiday Lists</a></li>
    <li class="breadcrumb-item active" aria-current="page">
      <?= htmlspecialchars((string) ($holidayList->name ?? ('FY ' . ($currentFy->label ?? '')))) ?>
    </li>
  </ol>
</nav>

<div class="row g-3 mb-3 align-items-center">
  <div class="col-lg-8">
    <h4 class="mb-1 d-flex align-items-center flex-wrap gap-2">
      <?= htmlspecialchars((string) ($holidayList->name ?? 'No holiday list for this Financial Year')) ?>
      <?php if ($holidayList): ?>
        <span class="badge rounded-pill badge-subtle-<?= $isActive ? 'success' : 'secondary' ?>">
          <?= $isActive ? 'Active' : 'Inactive' ?>
        </span>
      <?php endif; ?>
    </h4>
    <p class="mb-0 text-600 fs-11">
      <?php if ($currentFy): ?>
        Financial Year: <strong class="text-900"><?= htmlspecialchars((string) $currentFy->label) ?></strong>
        · <span class="text-600"><?= count($holidays) ?> <?= count($holidays) === 1 ? 'holiday' : 'holidays' ?></span>
      <?php else: ?>
        Financial Year: <span class="text-600">Not assigned</span>
      <?php endif; ?>
    </p>
  </div>
  <div class="col-lg-4 text-lg-end d-flex justify-content-lg-end gap-2 flex-wrap">
    <a href="/holiday-list" class="btn btn-falcon-default btn-sm">
      <span class="fas fa-arrow-left me-1" data-fa-transform="shrink-3"></span>
      Back to Lists
    </a>
    <?php if ($holidayList): ?>
    <button class="btn btn-falcon-primary btn-sm" type="button"
            data-bs-toggle="modal" data-bs-target="#addHolidayModal">
      <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>
      Add Holiday
    </button>
    <?php endif; ?>
  </div>
</div>

<div class="row g-3 align-items-center mb-3">
  <div class="col-lg-3">
    <label for="fySelect" class="form-label">Financial Year Allocation</label>
    <select class="form-select js-choice shadow-sm" id="fySelect"
            onchange="window.location.href='/holiday-lists/detail?id=<?= (int) $sourceHolidayList->id ?>&fy=' + this.value;">
      <?php foreach ($financialYears as $fy): ?>
        <option value="<?= (int) $fy->id ?>" <?= (int) $fy->id === $currentFyId ? 'selected' : '' ?>>
          <?= htmlspecialchars((string) $fy->label) ?><?= !empty($fy->is_current) ? ' — Active' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<!-- ============================================================
     HOLIDAY LIST OVERVIEW
     ============================================================ -->
<?php if ($holidayList): ?>
<div class="card mb-3">
  <div class="card-header">
    <div class="row flex-between-center">
      <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
        <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Holiday List Overview</h5>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="border rounded p-3 h-100">
          <div class="text-600 fs-10 mb-1">Holiday List</div>
          <div class="fw-semi-bold text-900">
            <?= htmlspecialchars((string) ($holidayList->name ?? 'Holiday List')) ?>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border rounded p-3 h-100">
          <div class="text-600 fs-10 mb-1">Financial Year</div>
          <div class="fw-semi-bold text-900">
            <?= htmlspecialchars((string) ($holidayList->financial_year_label ?? 'Not assigned')) ?>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border rounded p-3 h-100">
          <div class="text-600 fs-10 mb-1">Status</div>
          <div>
            <span class="badge rounded-pill badge-subtle-<?= $isActive ? 'success' : 'secondary' ?>">
              <?= $isActive ? 'Active' : 'Inactive' ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php else: ?>
<div class="card mb-3">
  <div class="card-body text-center py-5">
    <p class="text-700 mb-0">No holiday list has been configured for this Financial Year.</p>
    <button type="button" class="btn btn-falcon-primary btn-sm mt-3"
            data-bs-toggle="modal" data-bs-target="#addHolidayModal">
      <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>
      Add Holiday
    </button>
  </div>
</div>
<?php endif; ?>

<!-- ============================================================
     HOLIDAYS
     ============================================================ -->
<?php if ($holidayList): ?>
<div class="card">
  <div class="card-header">
    <div class="row flex-between-center">
      <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
        <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Holidays</h5>
      </div>
      <div class="col-6 col-sm-auto ms-auto text-end ps-0">
        <button class="btn btn-falcon-default btn-sm" type="button"
                data-bs-toggle="modal" data-bs-target="#addHolidayModal">
          <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>
          <span class="d-none d-sm-inline-block">New</span>
        </button>
      </div>
    </div>
  </div>

  <div class="card-body px-0 pt-0">
    <?php if (empty($holidays)): ?>
      <div class="text-center py-5">
        <i data-feather="calendar" width="28" height="28" class="text-400 mb-2"></i>
        <p class="text-700 mb-0">No holidays yet in this list.</p>
      </div>
    <?php else: ?>
      <table class="table table-sm mb-0 overflow-hidden fs-10">
        <thead class="bg-200">
          <tr>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap">Date</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap">Holiday Name</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Weekly Off</th>
            <th class="text-900 no-sort pe-1 align-middle data-table-row-action text-end" data-orderable="false"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($holidays as $index => $holiday): ?>
            <tr class="btn-reveal-trigger">
              <td class="align-middle white-space-nowrap fw-semi-bold">
                <?= htmlspecialchars((string) ($holiday->holiday_date ?? '')) ?>
              </td>
              <td class="align-middle white-space-nowrap">
                <?= htmlspecialchars((string) ($holiday->name ?? '')) ?>
              </td>
              <td class="align-middle text-center">
                <?= !empty($holiday->is_weekly_off) ? 'Yes' : 'No' ?>
              </td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                          type="button"
                          id="dropdown-holiday-item-<?= (int) $index ?>"
                          data-bs-toggle="dropdown"
                          data-boundary="window"
                          aria-haspopup="true" aria-expanded="false"
                          data-bs-reference="parent">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end border py-2"
                       aria-labelledby="dropdown-holiday-item-<?= (int) $index ?>">
                    <button class="dropdown-item" type="button"
                            data-bs-toggle="modal" data-bs-target="#addHolidayModal"
                            data-holiday-id="<?= (int) ($holiday->id ?? 0) ?>"
                            data-holiday-name="<?= htmlspecialchars((string) ($holiday->name ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                            data-holiday-date="<?= htmlspecialchars((string) ($holiday->holiday_date ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                            data-holiday-weekly-off="<?= !empty($holiday->is_weekly_off) ? '1' : '0' ?>">
                      Edit
                    </button>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="/holiday-lists/delete-holiday" class="m-0"
                          onsubmit="return confirm('Delete this holiday? This cannot be undone.');">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8') ?>">
                      <input type="hidden" name="holiday_list_id" value="<?= (int) $holidayList->id ?>">
                      <input type="hidden" name="financial_year_id" value="<?= (int) $currentFyId ?>">
                      <input type="hidden" name="holiday_id" value="<?= (int) ($holiday->id ?? 0) ?>">
                      <button class="dropdown-item text-danger" type="submit">Remove</button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<!-- ============================================================
     ADD HOLIDAY — MODAL
     ============================================================ -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form method="POST" action="/holiday-lists/add-holiday" id="holidayForm">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="holiday_list_id" value="<?= (int) ($holidayList->id ?? 0) ?>">
        <input type="hidden" name="financial_year_id" value="<?= (int) $currentFyId ?>">
        <input type="hidden" name="source_holiday_list_id" value="<?= (int) $sourceHolidayList->id ?>">
        <input type="hidden" name="holiday_id" id="holidayId" value="">

        <div class="modal-header">
          <h5 class="modal-title" id="addHolidayModalLabel">
            <i data-feather="calendar" width="16" height="16" class="me-2 text-500"></i>
            <span id="holidayModalTitle">Add Holiday</span>
          </h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">

          <div class="mb-3">
            <label class="form-label fs-10 fw-semi-bold" for="holidayName">
              Holiday Name <span class="text-danger">*</span>
            </label>
            <input class="form-control form-control-sm" id="holidayName" name="holiday_name"
                   type="text" placeholder="e.g. New Year's Day" required>
          </div>

          <div class="mb-3">
            <label class="form-label fs-10 fw-semi-bold" for="holidayDate">
              Holiday Date <span class="text-danger">*</span>
            </label>
            <input class="form-control form-control-sm" id="holidayDate" name="holiday_date"
                   type="date" min="<?= htmlspecialchars((string) ($holidayList->start_date ?? $currentFy->start_date ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                   max="<?= htmlspecialchars((string) ($holidayList->end_date ?? $currentFy->end_date ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="holidayWeeklyOff"
                   name="is_weekly_off" value="1">
            <label class="form-check-label fs-11" for="holidayWeeklyOff">
              <span class="fw-semi-bold">Weekly off</span>
              <div class="text-500 fs-11">Marks this as a recurring weekly non-working day.</div>
            </label>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-falcon-default btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-falcon-primary btn-sm" type="submit">
            <span class="fas fa-check me-1" data-fa-transform="shrink-3"></span>
            <span id="holidayModalSubmitText">Save Holiday</span>
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
<script>
  (function () {
    var modal = document.getElementById('addHolidayModal');
    var form = document.getElementById('holidayForm');
    var holidayId = document.getElementById('holidayId');
    var holidayName = document.getElementById('holidayName');
    var holidayDate = document.getElementById('holidayDate');
    var weeklyOff = document.getElementById('holidayWeeklyOff');
    var title = document.getElementById('holidayModalTitle');
    var submitText = document.getElementById('holidayModalSubmitText');

    modal.addEventListener('show.bs.modal', function (event) {
      var trigger = event.relatedTarget;
      var isEdit = trigger && trigger.hasAttribute('data-holiday-id');

      form.action = isEdit ? '/holiday-lists/update-holiday' : '/holiday-lists/add-holiday';
      holidayId.value = isEdit ? trigger.dataset.holidayId : '';
      holidayName.value = isEdit ? trigger.dataset.holidayName : '';
      holidayDate.value = isEdit ? trigger.dataset.holidayDate : '';
      weeklyOff.checked = isEdit && trigger.dataset.holidayWeeklyOff === '1';
      title.textContent = isEdit ? 'Edit Holiday' : 'Add Holiday';
      submitText.textContent = isEdit ? 'Save Changes' : 'Save Holiday';
    });
  })();
</script>