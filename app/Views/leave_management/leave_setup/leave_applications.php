<?php $currentPage = 'leave_applications'; ?>
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
    <li class="breadcrumb-item active" aria-current="page">Leave Applications</li>
  </ol>
</nav>

<!-- PAGE HEADER -->
<div class="mb-2">
  <h3 class="fw-bold mb-1">Leave Applications</h3>
  <div class="text-600">Record of approved leave taken by employees for financial year 2026/27</div>
</div>

<!-- UPDATED ALERT: Now refers to pending applications -->
<div class="alert alert-warning border-0 d-flex align-items-center fs-10 py-2 mb-3" role="alert">
  <div class="bg-warning me-3 icon-item">
    <span class="text-white" data-feather="alert-triangle" width="16" height="16"></span>
  </div>
  <p class="mb-0 flex-1"><strong>5 leave applications are currently pending review.</strong> Please process them.</p>
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<!-- UPDATED STATS CARDS -->
<div class="row g-3 mb-3">

  <!-- Total Applications -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Total Applications</span>
          <span class="text-primary" data-feather="file-text"></span>
        </div>
        <h4 class="mb-0 mt-2">24</h4>
      </div>
    </div>
  </div>

  <!-- Pending Review -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Pending Review</span>
          <span class="text-warning" data-feather="clock"></span>
        </div>
        <h4 class="mb-0 mt-2">5</h4>
      </div>
    </div>
  </div>

  <!-- Approved -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Approved</span>
          <span class="text-success" data-feather="check-circle"></span>
        </div>
        <h4 class="mb-0 mt-2">15</h4>
      </div>
    </div>
  </div>

  <!-- Rejected -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Rejected</span>
          <span class="text-danger" data-feather="x-circle"></span>
        </div>
        <h4 class="mb-0 mt-2">4</h4>
      </div>
    </div>
  </div>

</div>


<!-- Leave Applications table -->
<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Recent Applications</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div class="d-none" id="table-simple-pagination-actions">
              <div class="d-flex">
                <select class="form-select form-select-sm" aria-label="Bulk actions">
                  <option selected="">Bulk actions</option>
                  <option value="Delete">Delete</option>
                  <option value="Archive">Archive</option>
                </select>
                <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
              </div>
            </div>

            <div id="table-simple-pagination-replace-element">
              
              <a href="/leave-applications/create" class="btn btn-falcon-default btn-sm" type="button">
                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                <span class="d-none d-sm-inline-block ms-1">New Application</span>
              </a>

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
        <table class="table table-sm mb-0 overflow-hidden data-table fs-10"
          data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>

          <thead class="bg-200">
            <tr>
              <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                <div class="form-check mb-0 d-flex align-items-center">
                  <input class="form-check-input"
                    id="checkbox-bulk-item-select"
                    type="checkbox"
                    data-bulk-select='{"body":"table-simple-pagination-body","actions":"table-simple-pagination-actions","replacedElement":"table-simple-pagination-replace-element"}' />
                </div>
              </th>

              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Staff No.</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Employee</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Designation</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Leave Type</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Application Date</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Start Date</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">End Date</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Duration</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Leave Status</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false">Actions</th>
            </tr>
          </thead>

          <tbody class="list" id="table-simple-pagination-body">

            <!-- SAMPLE RECORD 1 -->
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="simple-pagination-item-0" data-bulk-select-row="data-bulk-select-row" />
                </div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="">20250017180</a></td>
              <td class="align-middle white-space-nowrap fw-semi-bold">John William Doe</td>
              <td class="align-middle white-space-nowrap">Human Resource Management Assistant III</td>
              <td class="align-middle white-space-nowrap">Annual Leave</td>
              <td class="align-middle white-space-nowrap">2026/06/05</td>
              <td class="align-middle white-space-nowrap">2026/06/22</td>
              <td class="align-middle white-space-nowrap">2026/06/26</td>
              <td class="align-middle text-center fw-semi-bold">5 days</td>
              <td class="align-middle white-space-nowrap">
                <span class="badge badge rounded-pill badge-subtle-success">
                  Recorded [ 05/06/2026 ]
                  <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                </span>
              </td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                    type="button" id="dropdown-simple-pagination-table-item-0"
                    data-bs-toggle="dropdown" data-boundary="window"
                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-0">
                    <a class="dropdown-item" href="#">View</a>
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Print</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-warning" href="#">Archive</a>
                    <a class="dropdown-item text-danger" href="#">Delete</a>
                  </div>
                </div>
              </td>
            </tr>

            <!-- SAMPLE RECORD 2 -->
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="simple-pagination-item-1" data-bulk-select-row="data-bulk-select-row" />
                </div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="">20250017181</a></td>
              <td class="align-middle white-space-nowrap fw-semi-bold">Jane Wanjiku</td>
              <td class="align-middle white-space-nowrap">Administrative Assistant</td>
              <td class="align-middle white-space-nowrap">Annual Leave</td>
              <td class="align-middle white-space-nowrap">2026/07/02</td>
              <td class="align-middle white-space-nowrap">2026/07/10</td>
              <td class="align-middle white-space-nowrap">2026/07/14</td>
              <td class="align-middle text-center fw-semi-bold">5 days</td>
              <td class="align-middle white-space-nowrap">
                <span class="badge badge rounded-pill badge-subtle-primary">Received</span>
              </td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                    type="button" id="dropdown-simple-pagination-table-item-1"
                    data-bs-toggle="dropdown" data-boundary="window"
                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-1">
                    <a class="dropdown-item" href="#">View</a>
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Print</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-warning" href="#">Archive</a>
                    <a class="dropdown-item text-danger" href="#">Delete</a>
                  </div>
                </div>
              </td>
            </tr>

            <!-- SAMPLE RECORD 3 -->
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="simple-pagination-item-2" data-bulk-select-row="data-bulk-select-row" />
                </div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="">20250017182</a></td>
              <td class="align-middle white-space-nowrap fw-semi-bold">Peter Njoroge</td>
              <td class="align-middle white-space-nowrap">IT Support Officer</td>
              <td class="align-middle white-space-nowrap">Sick Leave</td>
              <td class="align-middle white-space-nowrap">2026/08/14</td>
              <td class="align-middle white-space-nowrap">2026/08/15</td>
              <td class="align-middle white-space-nowrap">2026/08/18</td>
              <td class="align-middle text-center fw-semi-bold">3 days</td>
              <td class="align-middle white-space-nowrap">
                <span class="badge badge rounded-pill badge-subtle-danger">Rejected</span>
              </td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                    type="button" id="dropdown-simple-pagination-table-item-2"
                    data-bs-toggle="dropdown" data-boundary="window"
                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-2">
                    <a class="dropdown-item" href="#">View</a>
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Print</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-warning" href="#">Archive</a>
                    <a class="dropdown-item text-danger" href="#">Delete</a>
                  </div>
                </div>
              </td>
            </tr>

            <!-- SAMPLE RECORD 4 -->
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="simple-pagination-item-3" data-bulk-select-row="data-bulk-select-row" />
                </div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="">20250017183</a></td>
              <td class="align-middle white-space-nowrap fw-semi-bold">Grace Otieno</td>
              <td class="align-middle white-space-nowrap">Finance Officer</td>
              <td class="align-middle white-space-nowrap">Annual Leave</td>
              <td class="align-middle white-space-nowrap">2026/09/01</td>
              <td class="align-middle white-space-nowrap">2026/09/04</td>
              <td class="align-middle white-space-nowrap">2026/09/08</td>
              <td class="align-middle text-center fw-semi-bold">4 days</td>
              <td class="align-middle white-space-nowrap">
                <span class="badge badge rounded-pill badge-subtle-success">
                  Recorded [ 12/09/2026 ]
                  <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                </span>
              </td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                    type="button" id="dropdown-simple-pagination-table-item-3"
                    data-bs-toggle="dropdown" data-boundary="window"
                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-3">
                    <a class="dropdown-item" href="#">View</a>
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Print</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-warning" href="#">Archive</a>
                    <a class="dropdown-item text-danger" href="#">Delete</a>
                  </div>
                </div>
              </td>
            </tr>

            <!-- SAMPLE RECORD 5 -->
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="simple-pagination-item-4" data-bulk-select-row="data-bulk-select-row" />
                </div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="">20250017184</a></td>
              <td class="align-middle white-space-nowrap fw-semi-bold">Daniel Kibet</td>
              <td class="align-middle white-space-nowrap">Procurement Officer</td>
              <td class="align-middle white-space-nowrap">Maternity Leave</td>
              <td class="align-middle white-space-nowrap">2026/10/06</td>
              <td class="align-middle white-space-nowrap">2026/10/09</td>
              <td class="align-middle white-space-nowrap">2026/10/30</td>
              <td class="align-middle text-center fw-semi-bold">25 days</td>
              <td class="align-middle white-space-nowrap">
                <span class="badge badge rounded-pill badge-subtle-primary">Received</span>
              </td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                    type="button" id="dropdown-simple-pagination-table-item-4"
                    data-bs-toggle="dropdown" data-boundary="window"
                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-4">
                    <a class="dropdown-item" href="#">View</a>
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Print</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-warning" href="#">Archive</a>
                    <a class="dropdown-item text-danger" href="#">Delete</a>
                  </div>
                </div>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- NEW APPLICATION MODAL (NOW LARGE) -->
<div class="modal fade" id="newApplicationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Leave Application</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-5">
        <div class="mb-3 text-400" data-feather="file-plus" style="width:48px;height:48px;"></div>
        <h5 class="text-700 mt-4">Application Form</h5>
        <p class="mb-0 text-600">The detailed leave application form will be available here later.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-falcon-default btn-sm" type="button" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>