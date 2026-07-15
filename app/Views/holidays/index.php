<?php $currentPage = 'holidays'; ?>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Recent Purchases</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div class="d-none" id="table-simple-pagination-actions">
              <div class="d-flex"><select class="form-select form-select-sm" aria-label="Bulk actions">
                  <option selected="">Bulk actions</option>
                  <option value="Refund">Refund</option>
                  <option value="Delete">Delete</option>
                  <option value="Archive">Archive</option>
                </select><button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button></div>
            </div>
            <div id="table-simple-pagination-replace-element"><button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">New</span></button><button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filter</span></button><div class="btn-group" role="group"><button id="export-excel" class="btn btn-falcon-default btn-sm" type="button" title="Export to Excel"><span class="fas fa-file-excel" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Excel</span></button><button id="export-csv" class="btn btn-falcon-default btn-sm" type="button" title="Export to CSV"><span class="fas fa-file-csv" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">CSV</span></button></div></div>
          </div>
        </div>
      </div>
      
      <div class="card-body px-0 pt-0">
        <table id="holidays-table" class="table table-sm mb-0 overflow-hidden data-table fs-10">
          <thead class="bg-200">
            <tr>
              <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                <div class="form-check mb-0 d-flex align-items-center"><input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body","actions":"table-simple-pagination-actions","replacedElement":"table-simple-pagination-replace-element"}' /></div>
              </th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Customer</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Email</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Product</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Payment</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Amount</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
            </tr>
          </thead>
          <tbody class="list" id="table-simple-pagination-body">
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-0" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Sylvia Plath</a></td>
              <td class="align-middle white-space-nowrap email">john@gmail.com</td>
              <td class="align-middle white-space-nowrap product">Slick - Drag &amp; Drop Bootstrap Generator</td>
              <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-success">Success<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
              <td class="align-middle text-end amount">$99</td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-0" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-0"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-1" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Homer</a></td>
              <td class="align-middle white-space-nowrap email">sylvia@mail.ru</td>
              <td class="align-middle white-space-nowrap product">Bose SoundSport Wireless Headphones</td>
              <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-success">Success<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
              <td class="align-middle text-end amount">$634</td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-1" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-1"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-2" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Edgar Allan Poe</a></td>
              <td class="align-middle white-space-nowrap email">edgar@yahoo.com</td>
              <td class="align-middle white-space-nowrap product">All-New Fire HD 8 Kids Edition Tablet</td>
              <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-secondary">Blocked<span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span></span></td>
              <td class="align-middle text-end amount">$199</td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-2" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-3" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">William Butler Yeats</a></td>
              <td class="align-middle white-space-nowrap email">william@gmail.com</td>
              <td class="align-middle white-space-nowrap product">Apple iPhone XR (64GB)</td>
              <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-success">Success<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
              <td class="align-middle text-end amount">$798</td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-3" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-3"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-4" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Rabindranath Tagore</a></td>
              <td class="align-middle white-space-nowrap email">tagore@twitter.com</td>
              <td class="align-middle white-space-nowrap product">ASUS Chromebook C202SA-YS02 11.6"</td>
              <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-secondary">Blocked<span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span></span></td>
              <td class="align-middle text-end amount">$318</td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-4" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-4"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-5" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Emily Dickinson</a></td>
              <td class="align-middle white-space-nowrap email">emily@gmail.com</td>
              <td class="align-middle white-space-nowrap product">Mirari OK to Wake! Alarm Clock &amp; Night-Light</td>
              <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-warning">Pending<span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span></span></td>
              <td class="align-middle text-end amount">$11</td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-5" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-5"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.min.js"></script>
<script>
// DataTables Export to Excel and CSV
document.addEventListener('DOMContentLoaded', function() {
  // Initialize DataTables with configuration
  var table = $('#holidays-table').DataTable({
    responsive: false,
    pagingType: 'simple',
    lengthChange: true,
    pageLength: 10,
    searching: true,
    bDeferRender: true,
    serverSide: false,
    language: {
      info: '_START_ to _END_ Items of _TOTAL_'
    }
  });

  // Export to Excel
  document.getElementById('export-excel').addEventListener('click', function() {
    if (typeof XLSX === 'undefined') {
      alert('Excel library is loading. Please try again in a moment.');
      return;
    }
    
    // Get headers - only from columns without no-sort class
    var headers = [];
    var columnsToExport = [];
    $('#holidays-table thead th').each(function(index) {
      if (!$(this).hasClass('no-sort')) {
        headers.push($(this).text().trim());
        columnsToExport.push(index);
      }
    });
    
    // Get visible rows only (respects search filter)
    var data = [];
    table.rows({ search: 'applied' }).every(function() {
      var row = [];
      var $cells = $(this.node()).find('td');
      columnsToExport.forEach(function(colIndex) {
        row.push($cells.eq(colIndex).text().trim());
      });
      data.push(row);
    });
    
    // Create and download Excel file
    var ws = XLSX.utils.aoa_to_sheet([headers, ...data]);
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Holidays');
    XLSX.writeFile(wb, 'holidays_' + new Date().toISOString().split('T')[0] + '.xlsx');
  });

  // Export to CSV
  document.getElementById('export-csv').addEventListener('click', function() {
    // Get headers - only from columns without no-sort class
    var headers = [];
    var columnsToExport = [];
    $('#holidays-table thead th').each(function(index) {
      if (!$(this).hasClass('no-sort')) {
        headers.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
        columnsToExport.push(index);
      }
    });
    
    var csv = [headers.join(',')];
    
    // Get visible rows only (respects search filter)
    table.rows({ search: 'applied' }).every(function() {
      var row = [];
      var $cells = $(this.node()).find('td');
      columnsToExport.forEach(function(colIndex) {
        var text = $cells.eq(colIndex).text().trim();
        row.push('"' + text.replace(/"/g, '""') + '"');
      });
      csv.push(row.join(','));
    });
    
    // Create and download CSV file
    var csvContent = csv.join('\n');
    var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    var link = document.createElement('a');
    var url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'holidays_' + new Date().toISOString().split('T')[0] + '.csv');
    link.click();
  });
});
</script>
