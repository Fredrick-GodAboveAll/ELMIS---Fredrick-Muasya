<?php $currentPage = 'leave_entitlement'; ?>
<?php $financialYears = $financialYears ?? []; ?>
<?php $financialYearCount = $financialYearCount ?? 0; ?>
<?php $activeYearCount = $activeYearCount ?? 0; ?>
<?php $totalEntitlementRules = $totalEntitlementRules ?? 0; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item active" aria-current="page">Leave Entitlement</li>
  </ol>
</nav>

<div class="row align-items-end justify-content-between g-3 mb-3">
  <div class="col-md-8">
    <div>
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="badge badge-subtle-primary fs-10">Leave Setup</span>
      </div>
      <h2 class="mb-1">Leave Entitlement</h2>
      <p class="text-600 mb-0">Manage annual entitlement rules, active financial years, and overall leave configuration.</p>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-4 col-xxl-3">
    <div class="card h-md-100">
      <div class="card-header d-flex flex-between-center pb-0">
        <h6 class="mb-0">Financial years</h6>
        <div class="dropdown font-sans-serif btn-reveal-trigger">
          <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-financial-years" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-ellipsis-h fs-11"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-financial-years">
            <a class="dropdown-item" href="#!">View</a>
            <a class="dropdown-item" href="#!">Export</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#!">Edit</a>
          </div>
        </div>
      </div>

      <div class="card-body pt-2">
        <div class="row g-0 h-100 align-items-center">
          <div class="col">
            <div class="d-flex align-items-center">
              <div>
                <h4 class="mb-2"><?= (int) $financialYearCount; ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-xxl-3">
    <div class="card h-md-100">
      <div class="card-header d-flex flex-between-center pb-0">
        <h6 class="mb-0">Active years</h6>
        <div class="dropdown font-sans-serif btn-reveal-trigger">
          <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-active-years" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-ellipsis-h fs-11"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-active-years">
            <a class="dropdown-item" href="#!">View</a>
            <a class="dropdown-item" href="#!">Export</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#!">Edit</a>
          </div>
        </div>
      </div>

      <div class="card-body pt-2">
        <div class="row g-0 h-100 align-items-center">
          <div class="col">
            <div class="d-flex align-items-center">
              <div>
                <h4 class="mb-2"><?= (int) $activeYearCount; ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-xxl-3">
    <div class="card h-md-100">
      <div class="card-header d-flex flex-between-center pb-0">
        <h6 class="mb-0">Total entitlement rules</h6>
        <div class="dropdown font-sans-serif btn-reveal-trigger">
          <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-entitlement-rules" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-ellipsis-h fs-11"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-entitlement-rules">
            <a class="dropdown-item" href="#!">View</a>
            <a class="dropdown-item" href="#!">Export</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#!">Edit</a>
          </div>
        </div>
      </div>

      <div class="card-body pt-2">
        <div class="row g-0 h-100 align-items-center">
          <div class="col">
            <div class="d-flex align-items-center">
              <div>
                <h4 class="mb-2"><?= (int) $totalEntitlementRules; ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-2 justify-content-end align-items-center">
  <div class="col-auto">
    <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#configureFinancialYearModal">
      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
      <span class="d-none d-sm-inline-block ms-1">Configure Financial Year</span>
    </button>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Financial Years</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div class="d-none" id="table-simple-pagination-actions">
              <div class="d-flex">
                <select class="form-select form-select-sm" aria-label="Bulk actions">
                  <option selected="">Bulk actions</option>
                  <option value="Close">Close</option>
                  <option value="Delete">Delete</option>
                  <option value="Archive">Archive</option>
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
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Financial Year</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Period</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Leave Types</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Status</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Entitlements</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
            </tr>
          </thead>
          <tbody class="list" id="table-simple-pagination-body">
            <?php if (!empty($financialYears)): ?>
              <?php foreach ($financialYears as $index => $year): ?>
                <tr class="btn-reveal-trigger">
                  <td class="align-middle" style="width: 28px;">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" id="simple-pagination-item-<?= (int) $index; ?>" data-bulk-select-row="data-bulk-select-row" />
                    </div>
                  </td>
                  <td class="align-middle white-space-nowrap fw-semi-bold name">
                    <a href="/leave-entitlements/detail?year=<?= urlencode((string) $year->label) ?>"><?= htmlspecialchars((string) $year->label) ?></a>
                  </td>
                  <td class="align-middle white-space-nowrap email"><?= htmlspecialchars(date('d M Y', strtotime((string) $year->start_date))) ?> — <?= htmlspecialchars(date('d M Y', strtotime((string) $year->end_date))) ?></td>
                  <td class="align-middle white-space-nowrap product"><?= (int) ($year->active_leave_type_count ?? 0); ?> Leave Types</td>
                  <td class="align-middle text-center fs-9 white-space-nowrap payment">
                    <?php $statusClass = strtolower((string) $year->status) === 'active' ? 'badge-subtle-primary' : (strtolower((string) $year->status) === 'upcoming' ? 'badge-subtle-warning' : 'badge-subtle-secondary'); ?>
                    <span class="badge badge rounded-pill <?= htmlspecialchars($statusClass) ?>"><?= htmlspecialchars((string) $year->status) ?><span class="ms-1 fas fa-<?= strtolower((string) $year->status) === 'active' ? 'check' : (strtolower((string) $year->status) === 'upcoming' ? 'stream' : 'ban') ?>" data-fa-transform="shrink-2"></span></span>
                  </td>
                  <td class="align-middle text-end amount"><?= (int) ($year->entitlement_rule_count ?? 0); ?> / <?= (int) ($year->active_leave_type_count ?? 0); ?></td>
                  <td class="align-middle white-space-nowrap text-end">
                    <div class="dropstart font-sans-serif position-static d-inline-block">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-<?= (int) $index; ?>" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                      <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-<?= (int) $index; ?>">
                        <a class="dropdown-item" href="/leave-entitlements/detail?year=<?= urlencode((string) $year->label) ?>">View Entitlements</a>
                        <a class="dropdown-item" href="#!">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#!">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-4 text-600">No financial years found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="configureFinancialYearModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-header" style="border-bottom:1px solid var(--falcon-border-color, #e9ecef);">
        <h5 class="modal-title mb-0">Configure Financial Year</h5>
      </div>
      <div class="modal-body">
        <p class="text-600 mb-3" style="font-size:13px;">Choose a year that still needs entitlement rules set up. Fully-configured years already have all six leave types covered.</p>
        <form method="get" action="/leave-entitlements/detail">
          <label class="form-label mb-2" for="configureSelect">Financial year</label>
          <select class="form-select mb-3" id="configureSelect" name="year">
            <option value="2027 / 2028">2027 / 2028 — not started</option>
            <option value="2026 / 2027">2026 / 2027 — 4 of 6 configured</option>
            <option value="2025 / 2026">2025 / 2026 — fully configured</option>
          </select>
          <button class="btn btn-primary w-100" type="submit">Continue</button>
        </form>
      </div>
    </div>
  </div>
</div>