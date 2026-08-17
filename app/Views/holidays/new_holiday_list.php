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

          <!-- Basic Info: dense grid, small inputs -->
          <div class="row g-2 mb-2">

            <div class="col-md-5">
              <label class="form-label fs--1 mb-1" for="holidayListName">Holiday List Name <span class="text-danger">*</span></label>
              <input class="form-control form-control-sm" id="holidayListName" name="holiday_list_name" type="text" required="required" />
            </div>

            <div class="col-md-4">
              <label class="form-label fs--1 mb-1" for="organizerSingle">Organizer</label>
              <select
                class="form-select form-select-sm js-choice"
                id="organizerSingle"
                name="organizerSingle"
                size="1"
                data-options='{
                  "removeItemButton": true,
                  "placeholder": true,
                  "addItems": true,
                  "addChoices": true,
                  "duplicateItemsAllowed": false
                }'>

                <option value="">Select organizer...</option>
                <option value="Massachusetts Institute of Technology">Massachusetts Institute of Technology</option>
                <option value="University of Chicago">University of Chicago</option>
                <option value="GSAS Open Labs At Harvard">GSAS Open Labs At Harvard</option>
                <option value="California Institute of Technology">California Institute of Technology</option>

              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label fs--1 mb-1" for="totalHolidays">Total Holidays</label>
              <input class="form-control form-control-sm text-center fw-semibold" id="totalHolidays" name="total_holidays" type="text" readonly="readonly" value="0" />
            </div>

          </div>

          <div class="row g-2 mb-3">

            <div class="col-md-3">
              <label class="form-label fs--1 mb-1" for="fromDate">From Date <span class="text-danger">*</span></label>
              <input class="form-control form-control-sm datetimepicker" id="fromDate" name="from_date" type="text" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required="required" />
            </div>

            <div class="col-md-3">
              <label class="form-label fs--1 mb-1" for="toDate">To Date <span class="text-danger">*</span></label>
              <input class="form-control form-control-sm datetimepicker" id="toDate" name="to_date" type="text" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required="required" />
            </div>

            <div class="col-md-2">
              <label class="form-label fs--1 mb-1" for="holidayListColor">Color</label>
              <input class="form-control form-control-sm form-control-color" id="holidayListColor" name="color" type="color" value="#2c7be5" title="Choose a color" />
            </div>

          </div>

          <hr class="my-3" />

          <!-- Quick add: Weekly Holidays -->
          <div class="row g-2 align-items-end mb-2">
            <div class="col-auto">
              <label class="form-label fs--1 mb-1" for="weeklyHolidayDay">Add Weekly Holidays</label>
              <select class="form-select form-select-sm" id="weeklyHolidayDay" style="min-width:140px;">
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                <option value="0">Sunday</option>
              </select>
            </div>
            <div class="col-auto">
              <button class="btn btn-falcon-default btn-sm" id="addWeeklyHolidaysBtn" type="button">
                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                <span class="ms-1">Add to Holidays</span>
              </button>
            </div>
            <div class="col-auto">
              <span class="fs--1 text-500">Fills every matching weekday between From Date and To Date.</span>
            </div>
          </div>

          <!-- Quick add: Local Holidays -->
          <div class="row g-2 align-items-end mb-3">
            <div class="col-auto">
              <label class="form-label fs--1 mb-1" for="localHolidayCountry">Add Local Holidays</label>
              <select class="form-select form-select-sm" id="localHolidayCountry" style="min-width:140px;">
                <option value="KE">Kenya</option>
              </select>
            </div>
            <div class="col-auto">
              <button class="btn btn-falcon-default btn-sm" id="addLocalHolidaysBtn" type="button">
                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                <span class="ms-1">Add to Holidays</span>
              </button>
            </div>
            <div class="col-auto">
              <span class="fs--1 text-500">Not wired to a data source yet — add rows manually below for now.</span>
            </div>
          </div>

          <hr class="my-3" />

          <div class="row justify-content-between align-items-center mb-2">
            <div class="col-auto">
              <h5 class="mb-0 fs-9">Holidays</h5>
            </div>
          </div>

          <div class="table-responsive mb-3">
            <table class="table table-sm mb-0" id="holidaysTable">
              <thead class="bg-200">
                <tr>
                  <th class="white-space-nowrap" style="width:50px;">No.</th>
                  <th class="white-space-nowrap" style="width:140px;">Date <span class="text-danger">*</span></th>
                  <th class="white-space-nowrap">Description <span class="text-danger">*</span></th>
                  <th class="white-space-nowrap text-center" style="width:100px;">Is Half Day</th>
                  <th class="white-space-nowrap text-end" style="width:50px;"></th>
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

        </form>

      </div>
    </div>

  </div>
</div>

<script>
  // Wires up the Holidays sub-table: Add Row / Clear Table / row removal,
  // keeps the No. column numbered, keeps Total Holidays in sync, manually
  // fires flatpickr on rows added after page load (Falcon's theme.js only
  // auto-inits datetimepicker fields present at DOMContentLoaded), and
  // supports pre-filled rows from the Weekly Holidays quick-add.
  (function () {
    var tbody = document.getElementById('holidaysTableBody');
    var noRowsRow = document.getElementById('noHolidaysRow');
    var totalHolidaysInput = document.getElementById('totalHolidays');
    var addBtn = document.getElementById('addHolidayRowBtn');
    var clearBtn = document.getElementById('clearHolidaysTableBtn');
    var addWeeklyBtn = document.getElementById('addWeeklyHolidaysBtn');
    var addLocalBtn = document.getElementById('addLocalHolidaysBtn');
    var fromDateInput = document.getElementById('fromDate');
    var toDateInput = document.getElementById('toDate');
    var weeklyDaySelect = document.getElementById('weeklyHolidayDay');
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

    // prefillDate must already be in d/m/Y string form (matches the picker's dateFormat)
    function addRow(prefillDate, prefillDescription, prefillHalfDay) {
      rowIndex++;

      var tr = document.createElement('tr');
      tr.className = 'holiday-row';
      tr.innerHTML =
        '<td class="align-middle holiday-row-no"></td>' +
        '<td class="align-middle">' +
          '<input class="form-control form-control-sm datetimepicker" type="text" name="holidays[' + rowIndex + '][date]" placeholder="dd/mm/yyyy" data-options=\'{"disableMobile":true,"dateFormat":"d/m/Y"}\' required="required" />' +
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
      var descInput = tr.querySelector('input[name$="[description]"]');
      var halfCheckbox = tr.querySelector('.holiday-row-half');

      if (window.flatpickr) {
        var fp = window.flatpickr(dateInput, { disableMobile: true, dateFormat: 'd/m/Y' });
        if (prefillDate) fp.setDate(prefillDate, true, 'd/m/Y');
      } else if (prefillDate) {
        dateInput.value = prefillDate;
      }

      if (prefillDescription) descInput.value = prefillDescription;
      if (prefillHalfDay) halfCheckbox.checked = true;

      renumberRows();
      toggleNoRows();
      recalcTotalHolidays();
    }

    function parseDMY(str) {
      if (!str) return null;
      var parts = str.split('/');
      if (parts.length !== 3) return null;
      var d = parseInt(parts[0], 10);
      var m = parseInt(parts[1], 10) - 1;
      var y = parseInt(parts[2], 10);
      var dt = new Date(y, m, d);
      return isNaN(dt.getTime()) ? null : dt;
    }

    function formatDMY(date) {
      var d = String(date.getDate()).padStart(2, '0');
      var m = String(date.getMonth() + 1).padStart(2, '0');
      var y = date.getFullYear();
      return d + '/' + m + '/' + y;
    }

    addBtn.addEventListener('click', function () { addRow(); });

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

    addWeeklyBtn.addEventListener('click', function () {
      var from = parseDMY(fromDateInput.value);
      var to = parseDMY(toDateInput.value);
      if (!from || !to) {
        alert('Select From Date and To Date first.');
        return;
      }
      if (from > to) {
        alert('From Date must be before To Date.');
        return;
      }

      var dayIndex = parseInt(weeklyDaySelect.value, 10);
      var dayLabel = weeklyDaySelect.options[weeklyDaySelect.selectedIndex].text;

      var cursor = new Date(from.getTime());
      while (cursor.getDay() !== dayIndex) {
        cursor.setDate(cursor.getDate() + 1);
      }
      while (cursor <= to) {
        addRow(formatDMY(cursor), dayLabel, false);
        cursor.setDate(cursor.getDate() + 7);
      }
    });

    addLocalBtn.addEventListener('click', function () {
      // TODO: replace with a real fetch() call once a backend endpoint / holidays
      // data source is wired up, e.g. GET /api/holidays?country=KE&year=2026,
      // then loop the response into addRow(date, description, false) calls.
      alert('Local holiday lookup is not wired to a data source yet. Add rows manually below for now.');
    });
  })();
</script>