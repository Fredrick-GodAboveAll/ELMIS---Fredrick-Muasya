<?php $currentPage = 'departments'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/departments">Departments</a></li>
    <li class="breadcrumb-item active" aria-current="page">Deployment</li>
  </ol>
</nav>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Department Deployment</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div id="table-simple-pagination-replace-element">
              <a href="/departments" class="btn btn-falcon-default btn-sm">Back</a>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body px-0 pt-0">
        <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
          <thead class="bg-200">
            <tr>
              <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                <div class="form-check mb-0 d-flex align-items-center"><input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" /></div>
              </th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Payroll #</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Full Name</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">ID Number</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Designation</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Department Status</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
            </tr>
          </thead>
          <tbody class="list" id="table-simple-pagination-body">
            <?php if (!empty($employees)): ?>
              <?php $i = 0; foreach ($employees as $emp): ?>
                <tr class="btn-reveal-trigger">
                  <td class="align-middle" style="width: 28px;">
                    <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-<?= (int) $i; ?>" data-bulk-select-row="data-bulk-select-row" /></div>
                  </td>

                  <td class="align-middle white-space-nowrap fw-semi-bold name"><?= htmlspecialchars((string) ($emp->payroll_number ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="align-middle white-space-nowrap"><?= htmlspecialchars((string) ($emp->full_name ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="align-middle white-space-nowrap"><?= htmlspecialchars((string) ($emp->id_number ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="align-middle white-space-nowrap"><?= htmlspecialchars((string) ($emp->designation ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="align-middle text-center white-space-nowrap">
                    <?php if (!empty($emp->department_name)): ?>
                      <span class="badge badge rounded-pill badge-subtle-success">Assigned</span>
                      <div class="fs--2 text-600"><?= htmlspecialchars((string) $emp->department_name, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php else: ?>
                      <span class="badge badge rounded-pill badge-subtle-secondary">Unassigned</span>
                    <?php endif; ?>
                  </td>
                  <td class="align-middle white-space-nowrap text-end">
                    <div class="dropstart font-sans-serif position-static d-inline-block">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" data-bs-toggle="dropdown" data-boundary="window">
                        <span class="fas fa-ellipsis-h fs-10"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end border py-2"><a class="dropdown-item" href="#">View</a><a class="dropdown-item" href="#">Assign to Department</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#">Remove</a>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php $i++; endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-4">No employees found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
