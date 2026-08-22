<?php $currentPage = 'departments'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item active" aria-current="page">Departments</li>
  </ol>
</nav>

<div class="row mb-2 justify-content-end align-items-center">
  <div class="col-auto">
    <button class="btn btn-falcon-default btn-sm" type="button">
      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
      <span class="d-none d-sm-inline-block ms-1">Add Department</span>
    </button>
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
              <button class="btn btn-falcon-default btn-sm" type="button">
                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                <span class="d-none d-sm-inline-block ms-1">New</span>
              </button>
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
                        <a class="dropdown-item text-danger" href="#!">Delete</a>
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
