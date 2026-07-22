<?php $currentPage = 'holidays'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="/holidays">Holiday List</a></li>
    <li class="breadcrumb-item active" aria-current="page">New Holiday List</li>
  </ol>
</nav>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">

    <div class="card">

      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-auto">
            <h5 class="fs-9 mb-0">New Holiday List</h5>
          </div>
          <div class="col-auto">
            <button class="btn btn-primary btn-sm" type="submit" form="holidayListForm">Save</button>
          </div>
        </div>
      </div>

      <div class="card-body">

        <form id="holidayListForm" method="POST" action="#">

          <?php /* TODO: output CSRF token field here using App\Core\Csrf, e.g. App\Core\Csrf::field() */ ?>

          <div class="row g-3 mb-4">

            <div class="col-md-8">
              <label class="form-label" for="holidayListName">Holiday List Name <span class="text-danger">*</span></label>
              <input class="form-control" id="holidayListName" name="holiday_list_name" type="text" required="required" />
            </div>

            <div class="col-md-4">
              <label class="form-label" for="totalHolidays">Total Holidays</label>
              <input class="form-control" id="totalHolidays" name="total_holidays" type="text" readonly="readonly" value="0" />
            </div>

            <div class="col-md-6">
              <label class="form-label" for="fromDate">From Date <span class="text-danger">*</span></label>
              <input class="form-control datetimepicker" id="fromDate" name="from_date" type="text" placeholder="dd/mm/yy" data-options='{"disableMobile":true}' required="required" />
            </div>

            <div class="col-md-6">
              <label class="form-label" for="toDate">To Date <span class="text-danger">*</span></label>
              <input class="form-control datetimepicker" id="toDate" name="to_date" type="text" placeholder="dd/mm/yy" data-options='{"disableMobile":true}' required="required" />
            </div>

          </div>

          <hr class="my-4" />

          <div class="row justify-content-between align-items-center mb-2">
            <div class="col-auto">
              <h5 class="mb-0">Holidays</h5>
            </div>
          </div>

          <div class="table-responsive mb-3">
            <table class="table table-sm mb-0" id="holidaysTable">
              <thead class="bg-200">
                <tr>
                  <th class="white-space-nowrap" style="width:60px;">No.</th>
                  <th class="white-space-nowrap">Date <span class="text-danger">*</span></th>
                  <th class="white-space-nowrap">Description <span class="text-danger">*</span></th>
                  <th class="white-space-nowrap text-center" style="width:110px;">Is Half Day</th>
                  <th class="white-space-nowrap text-end" style="width:60px;"></th>
                </tr>
              </thead>
              <tbody id="holidaysTableBody">
                <tr id="noHolidaysRow">
                  <td class="text-center text-500" colspan="5">No rows</td>
                </tr>
              </tbody>
            </table>
          </div>

          <button class="btn btn-falcon-default btn-sm me-1" id="addHolidayRowBtn" type="button">
            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
            <span class="d-none d-sm-inline-block ms-1">Add Row</span>
          </button>

          <button class="btn btn-falcon-default btn-sm" id="clearHolidaysTableBtn" type="button">
            <span class="fas fa-trash-alt" data-fa-transform="shrink-3 down-2"></span>
            <span class="d-none d-sm-inline-block ms-1">Clear Table</span>
          </button>

          <hr class="my-4" />

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label" for="holidayListColor">Color</label>
              <input class="form-control form-control-color" id="holidayListColor" name="color" type="color" value="#2c7be5" title="Choose a color" />
            </div>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

<script>
  // Wires up the Holidays sub-table: Add Row / Clear Table / row removal,
  // keeps the No. column numbered, keeps Total Holidays in sync, and
  // manually fires flatpickr on rows added after page load (Falcon's
  // theme.js only auto-inits datetimepicker fields that exist at
  // DOMContentLoaded, so anything added later needs its own init call).
  (function () {
    var tbody = document.getElementById('holidaysTableBody');
    var noRowsRow = document.getElementById('noHolidaysRow');
    var totalHolidaysInput = document.getElementById('totalHolidays');
    var addBtn = document.getElementById('addHolidayRowBtn');
    var clearBtn = document.getElementById('clearHolidaysTableBtn');
    var rowIndex = 0;

    function renumberRows() {
      var rows = tbody.querySelectorAll('tr.holiday-row');
      rows.forEach(function (row, i) {
        row.querySelector('.holiday-row-no').textContent = i + 1;
      });
    }

    function recalcTotalHolidays() {
      var rows = tbody.querySelectorAll('tr.holiday-row');
      var total = 0;
      rows.forEach(function (row) {
        var isHalf = row.querySelector('.holiday-row-half').checked;
        total += isHalf ? 0.5 : 1;
      });
      totalHolidaysInput.value = total;
    }

    function toggleNoRows() {
      var hasRows = tbody.querySelectorAll('tr.holiday-row').length > 0;
      noRowsRow.style.display = hasRows ? 'none' : '';
    }

    function addRow() {
      rowIndex++;

      var tr = document.createElement('tr');
      tr.className = 'holiday-row';
      tr.innerHTML =
        '<td class="align-middle holiday-row-no"></td>' +
        '<td class="align-middle">' +
          '<input class="form-control form-control-sm datetimepicker" type="text" name="holidays[' + rowIndex + '][date]" placeholder="dd/mm/yy" data-options=\'{"disableMobile":true}\' required="required" />' +
        '</td>' +
        '<td class="align-middle">' +
          '<input class="form-control form-control-sm" type="text" name="holidays[' + rowIndex + '][description]" required="required" />' +
        '</td>' +
        '<td class="align-middle text-center">' +
          '<div class="form-check mb-0 d-flex justify-content-center"><input class="form-check-input holiday-row-half" type="checkbox" name="holidays[' + rowIndex + '][is_half_day]" value="1" /></div>' +
        '</td>' +
        '<td class="align-middle text-end">' +
          '<button class="btn btn-link text-danger btn-sm p-0 remove-holiday-row" type="button" title="Remove"><span class="fas fa-trash-alt"></span></button>' +
        '</td>';

      tbody.appendChild(tr);

      var dateInput = tr.querySelector('.datetimepicker');
      if (window.flatpickr) {
        window.flatpickr(dateInput, { disableMobile: true });
      }

      renumberRows();
      toggleNoRows();
      recalcTotalHolidays();
    }

    addBtn.addEventListener('click', addRow);

    clearBtn.addEventListener('click', function () {
      tbody.querySelectorAll('tr.holiday-row').forEach(function (row) {
        row.remove();
      });
      rowIndex = 0;
      toggleNoRows();
      recalcTotalHolidays();
    });

    tbody.addEventListener('click', function (e) {
      var removeBtn = e.target.closest('.remove-holiday-row');
      if (!removeBtn) return;
      removeBtn.closest('tr').remove();
      renumberRows();
      toggleNoRows();
      recalcTotalHolidays();
    });

    tbody.addEventListener('change', function (e) {
      if (e.target.classList.contains('holiday-row-half')) {
        recalcTotalHolidays();
      }
    });
  })();
</script>

