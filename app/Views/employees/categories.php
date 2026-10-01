<?php $currentPage = 'employee_categories'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/employees">Employees</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
  </ol>
</nav>

<div class="row mb-2 justify-content-end align-items-center">
  <div class="col-auto">
    <button class="btn btn-falcon-default btn-sm" type="button">
      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
      <span class="d-none d-sm-inline-block ms-1">Add category</span>
    </button>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card shadow-none border">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0"># Employee categories</h5>
        </div>
        <span class="badge badge-soft-primary rounded-pill">HR setup</span>
      </div>

      <div class="card-body">
        <p class="text-700 mb-4">
          Employee categories help classify staff by employment status, work arrangement, and organizational grouping.
          This section is designed to keep workforce management clear, consistent, and easier to report on.
        </p>

        <div class="row g-3">
          <div class="col-md-6 col-xl-3">
            <div class="border rounded-3 h-100 p-3 bg-light-subtle">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge rounded-pill bg-primary-subtle text-primary">Core</span>
                <span class="fas fa-user-tie text-primary"></span>
              </div>
              <h6 class="mb-1">Permanent Staff</h6>
              <p class="text-600 fs--1 mb-0">Full-time employees in ongoing roles with standard benefit coverage and long-term workforce planning.</p>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <div class="border rounded-3 h-100 p-3 bg-light-subtle">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge rounded-pill bg-success-subtle text-success">Flexible</span>
                <span class="fas fa-briefcase text-success"></span>
              </div>
              <h6 class="mb-1">Contract Staff</h6>
              <p class="text-600 fs--1 mb-0">Employees engaged for defined assignment periods, project-based work, or temporary business needs.</p>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <div class="border rounded-3 h-100 p-3 bg-light-subtle">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge rounded-pill bg-warning-subtle text-warning">Learning</span>
                <span class="fas fa-graduation-cap text-warning"></span>
              </div>
              <h6 class="mb-1">Interns</h6>
              <p class="text-600 fs--1 mb-0">Trainees and learners who support operational delivery while building practical experience and new skills.</p>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <div class="border rounded-3 h-100 p-3 bg-light-subtle">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge rounded-pill bg-info-subtle text-info">Support</span>
                <span class="fas fa-clock text-info"></span>
              </div>
              <h6 class="mb-1">Part-Time Staff</h6>
              <p class="text-600 fs--1 mb-0">Employees with reduced schedules that provide flexibility while maintaining operational coverage.</p>
            </div>
          </div>
        </div>

        <div class="row mt-4 g-3">
          <div class="col-lg-7">
            <div class="card border h-100">
              <div class="card-header bg-light">
                <h6 class="mb-0">Category overview</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm mb-0 align-middle">
                    <thead>
                      <tr>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Notes</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Permanent Staff</td>
                        <td><span class="badge rounded-pill bg-success-subtle text-success">Active</span></td>
                        <td>Standard HR and payroll setup.</td>
                      </tr>
                      <tr>
                        <td>Contract Staff</td>
                        <td><span class="badge rounded-pill bg-info-subtle text-info">Managed</span></td>
                        <td>Role-based and assignment-specific.</td>
                      </tr>
                      <tr>
                        <td>Interns</td>
                        <td><span class="badge rounded-pill bg-warning-subtle text-warning">Review</span></td>
                        <td>Temporary learning placement support.</td>
                      </tr>
                      <tr>
                        <td>Part-Time Staff</td>
                        <td><span class="badge rounded-pill bg-secondary-subtle text-secondary">Scheduled</span></td>
                        <td>Flexible work arrangements.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="card border h-100">
              <div class="card-header bg-light">
                <h6 class="mb-0">Category purpose</h6>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="d-flex align-items-start mb-3">
                    <span class="fas fa-check-circle text-success mt-1 me-2"></span>
                    <span>Keep workforce groups organized for payroll, leave, and policy assignment.</span>
                  </li>
                  <li class="d-flex align-items-start mb-3">
                    <span class="fas fa-check-circle text-success mt-1 me-2"></span>
                    <span>Support reporting across full-time, contract, and temporary employee groups.</span>
                  </li>
                  <li class="d-flex align-items-start">
                    <span class="fas fa-check-circle text-success mt-1 me-2"></span>
                    <span>Make onboarding and headcount planning easier for management teams.</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
