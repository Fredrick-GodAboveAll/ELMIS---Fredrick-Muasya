<?php $currentPage = 'holiday_list'; ?>

<?php
/** @var array $holidayLists */
/** @var array $financialYears */
/** @var string $csrf */
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

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item active" aria-current="page">Holiday Lists</li>
  </ol>
</nav>

<div class="row mb-3">
  <div class="col-12">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
      <div>
        <h4 class="mb-1">Holiday Lists</h4>
        <p class="mb-0 text-600 fs-11">Manage named holiday lists. Each list persists across all financial years — switch FY inside a list to view or edit that year's dates.</p>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-falcon-default btn-sm" type="button"
                data-bs-toggle="modal" data-bs-target="#importHolidayModal">
          <span class="fas fa-file-import me-1" data-fa-transform="shrink-3"></span>
          Import
        </button>
        <button class="btn btn-falcon-primary btn-sm" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#addHolidayOffcanvas"
                aria-controls="addHolidayOffcanvas">
          <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>
          Add Holiday List
        </button>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Holiday Lists</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <button class="btn btn-falcon-default btn-sm" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#addHolidayOffcanvas"
                    aria-controls="addHolidayOffcanvas">
              <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>
              <span class="d-none d-sm-inline-block">New</span>
            </button>
          </div>
        </div>
      </div>

      <div class="card-body px-0 pt-0">
        <table class="table table-sm mb-0 overflow-hidden data-table fs-10"
               data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
          <thead class="bg-200">
            <tr>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">List ID</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">List Name</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Active</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Notes</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
            </tr>
          </thead>
          <tbody class="list" id="table-simple-pagination-body">
            <?php if (!empty($holidayLists)): ?>
              <?php foreach ($holidayLists as $holidayList): ?>
                <?php $isActive = !empty($holidayList->is_active); ?>
                <tr class="btn-reveal-trigger">
                  <td class="align-middle white-space-nowrap">
                    <?= htmlspecialchars((string) ($holidayList->code ?? $holidayList->id ?? ''), ENT_QUOTES, 'UTF-8') ?>
                  </td>
                  <td class="align-middle white-space-nowrap fw-semi-bold name">
                    <a href="/holiday-lists/detail?id=<?= (int) ($holidayList->id ?? 0) ?>">
                      <?= htmlspecialchars((string) ($holidayList->name ?? 'Unnamed list'), ENT_QUOTES, 'UTF-8') ?>
                    </a>
                  </td>
                  <td class="align-middle text-center fs-9 white-space-nowrap">
                    <?php if ($isActive): ?>
                      <span class="badge rounded-pill badge-subtle-success">
                        Yes<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                      </span>
                    <?php else: ?>
                      <span class="badge rounded-pill badge-subtle-secondary">
                        No<span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="align-middle fs-10 text-600">
                    <?= htmlspecialchars((string) ($holidayList->notes ?? 'Persists across all FYs'), ENT_QUOTES, 'UTF-8') ?>
                  </td>
                  <td class="align-middle white-space-nowrap text-end">
                    <div class="dropstart font-sans-serif position-static d-inline-block">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                              type="button" data-bs-toggle="dropdown" data-boundary="window"
                              aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                        <span class="fas fa-ellipsis-h fs-10"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end border py-2">
                        <a class="dropdown-item" href="/holiday-lists/detail?id=<?= (int) ($holidayList->id ?? 0) ?>">View</a>
                        <div class="dropdown-divider"></div>
                        <?php if ($isActive): ?>
                          <form method="POST" action="/holiday-lists/toggle-active" class="m-0">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8'); ?>" />
                            <input type="hidden" name="id" value="<?= (int) ($holidayList->id ?? 0) ?>" />
                            <input type="hidden" name="action" value="deactivate" />
                            <button type="submit" class="dropdown-item text-warning">
                              <span class="fas fa-ban me-2" data-fa-transform="shrink-3"></span>Deactivate
                            </button>
                          </form>
                        <?php else: ?>
                          <form method="POST" action="/holiday-lists/toggle-active" class="m-0">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8'); ?>" />
                            <input type="hidden" name="id" value="<?= (int) ($holidayList->id ?? 0) ?>" />
                            <input type="hidden" name="action" value="activate" />
                            <button type="submit" class="dropdown-item text-success">
                              <span class="fas fa-check-circle me-2" data-fa-transform="shrink-3"></span>Activate
                            </button>
                          </form>
                        <?php endif; ?>
                        <form method="POST" action="/holiday-lists/delete" class="m-0"
                              onsubmit="return confirm('Delete this holiday list? All holidays in it across all financial years will also be removed. This cannot be undone.');">
                          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8') ?>">
                          <input type="hidden" name="id" value="<?= (int) $holidayList->id ?>">
                          <button type="submit" class="dropdown-item text-danger">
                            Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <!-- no empty state message — matches current design -->
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     IMPORT HOLIDAY LIST — MODAL (kept as placeholder)
     ============================================================ -->
<div class="modal fade" id="importHolidayModal" tabindex="-1" aria-labelledby="importHolidayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="importHolidayModalLabel">
          <i data-feather="download" width="16" height="16" class="me-2 text-500"></i>
          Import Holiday List
        </h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">

        <p class="text-600 fs-11 mb-3">
          Fetch public holidays for a financial year from a supported country. The holidays will be added into a named list.
        </p>

        <div class="mb-3">
          <label class="form-label fs-10 fw-semi-bold" for="holidayYear">Financial Year <span class="text-danger">*</span></label>
          <select class="form-select form-select-sm" id="holidayYear">
            <?php foreach ($financialYears as $year): ?>
              <option value="<?= (int) $year->id ?>">
                <?= htmlspecialchars((string) ($year->label ?? ''), ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-2">
          <label class="form-label fs-10 fw-semi-bold" for="holidayCountry">Country <span class="text-danger">*</span></label>
          <select class="form-select form-select-sm" id="holidayCountry">
            <option value="" selected disabled>Select a country…</option>
            <option value="KE">Kenya</option>
            <option value="UG">Uganda</option>
            <option value="TZ">Tanzania</option>
          </select>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-falcon-default btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
        <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-title="Coming soon">
          <button class="btn btn-falcon-primary btn-sm" type="button" disabled>
            <span class="fas fa-file-import me-1" data-fa-transform="shrink-3"></span>
            Import Holidays
          </button>
        </span>
      </div>

    </div>
  </div>
</div>

<!-- ============================================================
     ADD HOLIDAY LIST — OFFCANVAS (simplified: name + active only)
     ============================================================ -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addHolidayOffcanvas"
     aria-labelledby="addHolidayOffcanvasLabel" style="width: 420px;">
  <form method="POST" action="/holiday-lists" id="addHolidayListForm">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrf, ENT_QUOTES, 'UTF-8'); ?>" />

    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title fs-9 mb-0" id="addHolidayOffcanvasLabel">
        Add Holiday List
      </h5>
      <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
      <div class="mb-3">
        <label class="form-label fs-10 fw-semi-bold" for="holidayListName">List Name <span class="text-danger">*</span></label>
        <input class="form-control form-control-sm" id="holidayListName" name="holiday_list_name"
               type="text" placeholder="e.g. Kenya National Holidays" required />
        <div class="form-text fs-11">
          One list per country or purpose. It persists across all financial years.
        </div>
      </div>

      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="holidayListIsActive" name="is_active" value="1" checked>
        <label class="form-check-label fs-11" for="holidayListIsActive">
          <span class="fw-semi-bold">Active</span>
          <div class="text-500 fs-11">Only active lists are used in leave calculations.</div>
        </label>
      </div>
    </div>

    <div class="border-top p-3 d-flex justify-content-end gap-2">
      <button class="btn btn-falcon-default btn-sm" type="button" data-bs-dismiss="offcanvas">Cancel</button>
      <button class="btn btn-falcon-primary btn-sm" type="submit">
        <span class="fas fa-check me-1" data-fa-transform="shrink-3"></span>
        Save List
      </button>
    </div>
  </form>
</div>