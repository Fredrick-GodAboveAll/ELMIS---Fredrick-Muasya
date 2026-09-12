<?php $currentPage = 'leave_types'; ?>
<?php $csrf = \App\Core\Csrf::generate(); ?>
<?php $leaveTypes = $leaveTypes ?? []; ?>

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
    <li class="breadcrumb-item active" aria-current="page">Leave Types</li>
  </ol>
</nav>

<div class="row mb-2 justify-content-end align-items-center">
  <div class="col-auto">
    <button class="btn btn-falcon-default btn-sm" data-bs-toggle="offcanvas" data-bs-target="#leaveTypeOffcanvas" type="button">
      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
      <span class="d-none d-sm-inline-block ms-1">Add Leave Type</span>
    </button>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Leave Types</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div class="d-none" id="table-simple-pagination-actions">
              <div class="d-flex">
                <select class="form-select form-select-sm" aria-label="Bulk actions">
                  <option selected="">Bulk actions</option>
                  <option value="Refund">Refund</option>
                  <option value="Delete">Delete</option>
                  <option value="Archive">Archive</option>
                </select>
                <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
              </div>
            </div>
            <div id="table-simple-pagination-replace-element">
              <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">New</span></button>
              <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filter</span></button>
              <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Export</span></button>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body px-0 pt-0">
        <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
          <thead class="bg-200">
            <tr>
              <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                <div class="form-check mb-0 d-flex align-items-center"><input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body","actions":"table-simple-pagination-actions","replacedElement":"table-simple-pagination-replace-element"}' /></div>
              </th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Leave Type</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Calculation Method</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Status</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false">Actions</th>
            </tr>
          </thead>
          <tbody class="list" id="table-simple-pagination-body">
            <?php if (!empty($leaveTypes)): ?>
              <?php foreach ($leaveTypes as $leaveType): ?>
                <tr class="btn-reveal-trigger">
                  <td class="align-middle" style="width: 28px;">
                    <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-<?= (int) $leaveType->id; ?>" data-bulk-select-row="data-bulk-select-row" /></div>
                  </td>
                  <td class="align-middle white-space-nowrap fw-semi-bold"><?= htmlspecialchars($leaveType->name) ?></td>
                  <td class="align-middle white-space-nowrap"><?= htmlspecialchars($leaveType->calculation_method === 'calendar_days' ? 'Calendar Days' : 'Working Days') ?></td>
                  <td class="align-middle white-space-nowrap">
                    <span class="badge badge-subtle-<?= !empty($leaveType->is_active) ? 'success' : 'secondary'; ?> ms-2"><?= !empty($leaveType->is_active) ? 'Active' : 'Inactive' ?></span>
                  </td>
                  <td class="align-middle white-space-nowrap text-end">
                    <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs-10"></span></button>
                      <div class="dropdown-menu dropdown-menu-end border py-2">
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#leaveTypeDetailsModal-<?= (int) $leaveType->id; ?>">View</button>
                        <a class="dropdown-item" href="#!">Edit</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center py-4 text-600">No leave types found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php foreach ($leaveTypes as $leaveType): ?>
  <div class="modal fade" id="leaveTypeDetailsModal-<?= (int) $leaveType->id; ?>" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="leaveTypeDetailsModalLabel-<?= (int) $leaveType->id; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
          <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
            <h4 class="mb-1" id="leaveTypeDetailsModalLabel-<?= (int) $leaveType->id; ?>"><?= htmlspecialchars($leaveType->name) ?></h4>
          </div>

          <div class="p-4">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="d-flex align-items-center border rounded-3 p-3 h-100">
                  <span class="fa-stack me-3">
                    <i class="fas fa-circle fa-stack-2x text-200"></i>
                    <i class="fa-inverse fa-stack-1x text-primary fas fa-calendar-day" data-fa-transform="shrink-2"></i>
                  </span>
                  <div>
                    <p class="text-500 fs-10 mb-1">Calculation Method</p>
                    <h5 class="mb-0"><?= htmlspecialchars($leaveType->calculation_method === 'calendar_days' ? 'Calendar Days' : 'Working Days') ?></h5>
                  </div>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="d-flex align-items-center border rounded-3 p-3 h-100">
                  <span class="fa-stack me-3">
                    <i class="fas fa-circle fa-stack-2x text-200"></i>
                    <i class="fa-inverse fa-stack-1x text-primary fas fa-toggle-on" data-fa-transform="shrink-2"></i>
                  </span>
                  <div>
                    <p class="text-500 fs-10 mb-1">Status</p>
                    <h5 class="mb-0"><?= !empty($leaveType->is_active) ? 'Active' : 'Inactive' ?></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="border-top p-3 d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="leaveTypeOffcanvas" aria-labelledby="leaveTypeOffcanvasLabel" style="width:460px;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="leaveTypeOffcanvasLabel">New Leave Type</h5>
    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body p-0">
    <form method="POST" action="/leave-types" id="createLeaveTypeForm">
      <div class="p-3">
        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="leaveName">Leave Type Name <span class="text-danger">*</span></label>
          <input class="form-control" id="leaveName" name="name" type="text" placeholder="e.g. Bereavement Leave" required>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="calculationMethod">Calculation Method <span class="text-danger">*</span></label>
          <select class="form-select" id="calculationMethod" name="calculation_method" required>
            <option value="" selected disabled>Select method</option>
            <option value="working_days">Working Days</option>
            <option value="calendar_days">Calendar Days</option>
          </select>
        </div>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />
      </div>
    </form>
  </div>

  <div class="border-top p-3">
    <div class="d-flex justify-content-end align-items-center gap-2">
      <button type="button" class="btn btn-falcon-default" data-bs-dismiss="offcanvas">Cancel</button>
      <button type="submit" form="createLeaveTypeForm" class="btn btn-primary"><span class="fas fa-calendar-plus me-2"></span>Add Leave Type</button>
    </div>
  </div>
</div>
