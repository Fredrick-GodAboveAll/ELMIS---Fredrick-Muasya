<?php $currentPage = 'policy_assignments'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/leave-policies">Leave Policies</a></li>
    <li class="breadcrumb-item active" aria-current="page">Policy Assignments</li>
  </ol>
</nav>

<div class="mb-2">
  <h3 class="fw-bold mb-1">Policy Assignments</h3>
  <div class="text-600">Leave policy coverage for financial year 2026/27</div>
</div>

<div class="alert alert-warning border-0 d-flex align-items-center fs-10 py-2 mb-3" role="alert">
  <div class="bg-warning me-3 icon-item">
    <span class="text-white" data-feather="alert-triangle" width="16" height="16"></span>
  </div>
  <p class="mb-0 flex-1"><strong>24 employees have no leave policy.</strong></p>
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="row g-3 mb-3">

  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Employees</span>
          <span class="text-primary" data-feather="users"></span>
        </div>
        <h4 class="mb-0 mt-2">60</h4>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Assigned</span>
          <span class="text-success" data-feather="check-circle"></span>
        </div>
        <h4 class="mb-0 mt-2">36</h4>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Not assigned</span>
          <span class="text-warning" data-feather="clock"></span>
        </div>
        <h4 class="mb-0 mt-2">24</h4>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="fs-10 fw-semi-bold text-600">Coverage</span>
          <span class="text-info" data-feather="pie-chart"></span>
        </div>
        <h4 class="mb-0 mt-2">60%</h4>
      </div>
    </div>
  </div>

</div>

<div class="row g-3 mb-3">

  <div class="col-lg-6 col-xxl-7">
    <div class="card h-100">
      <div class="card-header bg-body-tertiary d-flex flex-between-center py-2">
        <h6 class="mb-0">Employees by policy</h6>
        <div class="dropdown font-sans-serif btn-reveal-trigger">
          <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="lms-employees-by-policy" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-ellipsis-h fs-11"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="lms-employees-by-policy">
            <a class="dropdown-item" href="#!">View</a>
            <a class="dropdown-item" href="#!">Export</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="#!">Remove</a>
          </div>
        </div>
      </div>
      <div class="card-body">

        <div class="mb-3">
          <div class="d-flex justify-content-between fs-10">
            <span>General staff policy</span>
            <span class="fw-semi-bold text-900">20</span>
          </div>
          <div class="progress mt-2" style="height: 8px;">
            <div class="progress-bar bg-primary" style="width: 33.3333%;"></div>
          </div>
        </div>

        <div class="mb-3">
          <div class="d-flex justify-content-between fs-10">
            <span>Intern policy</span>
            <span class="fw-semi-bold text-900">4</span>
          </div>
          <div class="progress mt-2" style="height: 8px;">
            <div class="progress-bar bg-primary" style="width: 6.66667%;"></div>
          </div>
        </div>

        <div class="mb-0">
          <div class="d-flex justify-content-between fs-10">
            <span>Contract staff policy</span>
            <span class="fw-semi-bold text-900">12</span>
          </div>
          <div class="progress mt-2" style="height: 8px;">
            <div class="progress-bar bg-primary" style="width: 20%;"></div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-6 col-xxl-5">
    <div class="card h-100">
      <div class="card-header bg-body-tertiary d-flex flex-between-center py-2">
        <h6 class="mb-0">Assignment Overview</h6>
        <div class="dropdown font-sans-serif btn-reveal-trigger">
          <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="lms-policy-overview" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-ellipsis-h fs-11"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="lms-policy-overview">
            <a class="dropdown-item" href="#!">View</a>
            <a class="dropdown-item" href="#!">Export</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="#!">Remove</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row align-items-center">

          <div class="col-sm-4">
            <div class="pb-3 mb-3 border-bottom border-200">
              <div class="position-relative ps-3">
                <div class="position-absolute h-100 start-0 rounded bg-info" style="width: 4px;"></div>
                <h6 class="fs-11 text-600 mb-1">Coverage</h6>
                <div class="d-flex align-items-center">
                  <h5 class="fs-7 text-700 mb-0 me-2">60%</h5>
                  <span class="badge rounded-pill fs-11 fw-medium badge-subtle-info">
                    <span class="me-1" data-feather="check" width="10" height="10"></span>On par
                  </span>
                </div>
              </div>
            </div>

            <div class="pb-3 mb-3 border-bottom border-200">
              <div class="position-relative ps-3">
                <div class="position-absolute h-100 start-0 rounded bg-primary" style="width: 4px;"></div>
                <h6 class="fs-11 text-600 mb-1">Assigned</h6>
                <div class="d-flex align-items-center">
                  <h5 class="fs-7 text-700 mb-0 me-2">36</h5>
                  <span class="badge rounded-pill fs-11 fw-medium badge-subtle-primary">
                    <span class="me-1" data-feather="arrow-up" width="10" height="10"></span>Ahead
                  </span>
                </div>
              </div>
            </div>

            <div>
              <div class="position-relative ps-3">
                <div class="position-absolute h-100 start-0 rounded bg-success" style="width: 4px;"></div>
                <h6 class="fs-11 text-600 mb-1">Unassigned</h6>
                <div class="d-flex align-items-center">
                  <h5 class="fs-7 text-700 mb-0 me-2">24</h5>
                  <span class="badge rounded-pill fs-11 fw-medium badge-subtle-danger">
                    <span class="me-1" data-feather="arrow-down" width="10" height="10"></span>Behind
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-8 h-100">
            <!-- Chart container – swap with your own ECharts instance or policy chart config -->
            <div class="echart-weekly-goals-lms" data-echart-responsive="true" style="min-height: 250px;"></div>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>

<div class="row g-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Recent activity</h6>
      </div>
      <div class="card-body pt-2">
        <div class="overflow-auto" style="max-height: 250px;">

          <div class="border-bottom py-2">
            <div>Assigned Contract staff policy to 12 employees (Contract staff)</div>
            <div class="fs-11 text-600">28 Sept 2026, 19:50</div>
          </div>

          <div class="border-bottom py-2">
            <div>Assigned General staff policy to 5 employees (General staff)</div>
            <div class="fs-11 text-600">27 Sept 2026, 14:20</div>
          </div>

          <div class="border-bottom py-2">
            <div>Removed Intern policy from 2 employees (Interns)</div>
            <div class="fs-11 text-600">26 Sept 2026, 09:10</div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>