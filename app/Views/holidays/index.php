<?php $currentPage = 'holidays'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Holiday List</li>
  </ol>
</nav>

<!-- HOLIDAY  -->

<div class="row mb-3 justify-content-end align-items-center">
  <div class="col-auto">
    <a class="btn btn-falcon-default btn-sm" href="/holidays/new" type="button">
      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
      <span class="d-none d-sm-inline-block ms-1">Add Holiday</span>
    </a>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0"> Holidays List </h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div class="d-none" id="table-simple-pagination-actions">
              <div class="d-flex"><select class="form-select form-select-sm" aria-label="Bulk actions">
                  <option selected="">Bulk actions</option>
                  <option value="Delete">Delete</option>
                  <option value="Archive">Archive</option>
                </select><button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button></div>
            </div>
            <div id="table-simple-pagination-replace-element">
             
              <button class="btn btn-falcon-default btn-sm mx-2" type="button">
                <span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span>
                <span class="d-none d-sm-inline-block ms-1">Filter</span>
              </button>
              <div class="btn-group" role="group">
                <button id="export-excel" class="btn btn-falcon-default btn-sm" type="button" title="Export to Excel">
                  <span class="fas fa-file-excel" data-fa-transform="shrink-3 down-2"></span>
                  <span class="d-none d-sm-inline-block ms-1">Excel</span>
                </button>
                <button id="export-csv" class="btn btn-falcon-default btn-sm" type="button" title="Export to CSV">
                  <span class="fas fa-file-csv" data-fa-transform="shrink-3 down-2"></span>
                  <span class="d-none d-sm-inline-block ms-1">CSV</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body px-0 pt-0">
        <table id="holidays-table" class="table table-sm mb-0 overflow-hidden data-table fs-10">

          <thead class="bg-200">

            <tr>
              <th class="no-export text-900 no-sort white-space-nowrap" data-orderable="false">
                <div class="form-check mb-0 d-flex align-items-center"><input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body","actions":"table-simple-pagination-actions","replacedElement":"table-simple-pagination-replace-element"}' /></div>
              </th>

              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">No.</th>

              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">Financial Year</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">From Date</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">To Date</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap"> Total Holidays</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-start">Status</th>
              <th class="no-export text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false">Actions</th>

            </tr>

          </thead>



          <tbody class="list" id="table-simple-pagination-body">

            <tr class="btn-reveal-trigger">
              <td class="no-export align-middle" style="width:28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-0" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              
              <td class="align-middle white-space-nowrap email text-start">1</td>

              <td class="align-middle white-space-nowrap fw-semi-bold name">
                <a href="../../app/e-commerce/customer-details.html">2026/2026</a>
              </td>
              
              <td class="align-middle white-space-nowrap product">01-07-2026</td>
              <td class="align-middle white-space-nowrap product">30-06-2027</td>

              <td class="align-middle white-space-nowrap product">10</td>

              <td class="align-middle text-start fs-9 white-space-nowrap payment">
                <span class="badge badge rounded-pill badge-subtle-success">Success
                  <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                </span>
              </td>

              <td class="no-export align-middle white-space-nowrap text-start">

                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-0" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                  </button>

                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-0">
                    <a class="dropdown-item" href="#!">View</a>
                    <a class="dropdown-item" href="#!">Edit</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-warning" href="#!">Archive</a>
                    <a class="dropdown-item text-danger" href="#!">Delete</a>
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

<script>
  // Set the DataTables config on the table from a plain JS object instead of
  // hand-writing JSON inside the HTML attribute. This script is intentionally
  // NOT wrapped in a DOMContentLoaded listener — it runs synchronously as the
  // page is parsed, right here, which guarantees it finishes BEFORE Falcon's
  // own theme.js scans the page (on DOMContentLoaded) for elements carrying
  // data-datatables. That's what keeps us on Falcon's correctly-aligned init
  // path instead of falling back to plain DataTables' default layout.
  (function() {
    var holidaysTableOptions = {
      responsive: false,
      pagingType: 'simple',
      lengthChange: true,
      pageLength: 10,
      searching: true,
      deferRender: true,
      serverSide: false,
      language: {
        info: '_START_ to _END_ Items of _TOTAL_'
      }
    };

    document
      .getElementById('holidays-table')
      .setAttribute('data-datatables', JSON.stringify(holidaysTableOptions));
  })();
</script>


