<?php $currentPage = 'leave_period'; ?>

    <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
        <li class="breadcrumb-item"><a href="/leave-periods">Leave Period</a></li>
        <li class="breadcrumb-item active" aria-current="page">leave period</li>
    </ol>
    </nav>

<!-- Your page content here -->

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">

    <div class="card">

      <div class="card-header">
        <div class="row flex-between-center">
          <div class="col-auto">
            <h5 class="fs-9 mb-0">New Leave Period</h5>
          </div>
          <div class="col-auto">
            <button class="btn btn-primary btn-sm" type="submit" form="holidayListForm">Save</button>
          </div>
        </div>
      </div>

      <div class="card-body">

        <?php if ($error = \App\Core\Session::flash('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if ($success = \App\Core\Session::flash('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form id="holidayListForm" method="POST" action="/new-leave-period">

          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(\App\Core\Csrf::generate()); ?>">

          <!-- Basic Info: dense grid, small inputs -->
          <div class="row g-2 mb-2">

            <div class="col-md-4">
              <label class="form-label fs--1 mb-1" for="fromDate">From Date <span class="text-danger">*</span></label>
              <input class="form-control form-control-sm datetimepicker" id="fromDate" name="from_date" type="text" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required="required" />
            </div>

            <div class="col-md-4">
              <label class="form-label fs--1 mb-1" for="toDate">To Date <span class="text-danger">*</span></label>
              <input class="form-control form-control-sm datetimepicker" id="toDate" name="to_date" disabled type="text" placeholder="dd/mm/yyyy" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' readonly required="required" />
            </div>

            <div class="col-md-4">
              <label class="form-label fs--1 mb-1" for="organizerSingle">Holiday List (optional) </label>
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

                <option value="">Holiday List... </option>
                <option value="Massachusetts Institute of Technology">H-2026-2027</option>
                <option value="Massachusetts Institute of Technology">H-2025-2026</option>
                
              </select>
            </div>

          </div>

          <div class="row g-2 mb-2">

            <div class="col-md-4">
              <label class="form-label fs--1 mb-1" for="holidayListName">Leave Period Name <span class="text-danger">*</span></label>
              <input class="form-control form-control-sm" id="holidayListName" name="holiday_list_name" type="text" readonly />
            </div>

            <div class="col-md-3 d-flex align-items-end">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1">
                <label class="form-check-label" for="is_active">Is Active</label>
              </div>
            </div>

          </div>

        </form>

      </div>
    </div>

  </div>
</div>

<script>
  (function () {
    const fromDateInput = document.getElementById('fromDate');
    const toDateInput = document.getElementById('toDate');
    const labelInput = document.getElementById('holidayListName');

    function parseDate(value) {
      if (!value) return null;
      const parts = value.trim().split('/');
      if (parts.length !== 3) return null;
      const day = Number(parts[0]);
      const month = Number(parts[1]);
      const year = Number(parts[2]);
      if (!day || !month || !year) return null;
      const date = new Date(year, month - 1, day);
      if (date.getFullYear() !== year || date.getMonth() !== (month - 1) || date.getDate() !== day) {
        return null;
      }
      return date;
    }

    function formatDMY(date) {
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }

    function computeFinancialYear(date) {
      const fiscalYearStart = new Date(date.getFullYear(), 6, 1);
      const actualYear = date.getFullYear();
      const fiscalStartYear = date.getMonth() >= 6 ? actualYear : actualYear - 1;
      const fiscalEndYear = fiscalStartYear + 1;
      const startDate = new Date(fiscalStartYear, 6, 1);
      const endDate = new Date(fiscalEndYear, 5, 30);
      return {
        startDate,
        endDate,
        label: `${fiscalStartYear}/${fiscalEndYear}`
      };
    }

    function updateFinancialYear() {
      const startDate = parseDate(fromDateInput.value);
      if (!startDate) {
        toDateInput.value = '';
        if (!labelInput.value) {
          labelInput.value = '';
        }
        return;
      }

      const fiscal = computeFinancialYear(startDate);
      toDateInput.value = formatDMY(fiscal.endDate);
      if (!labelInput.value || labelInput.dataset.autoFilled === '1') {
        labelInput.value = fiscal.label;
      }
      labelInput.dataset.autoFilled = '1';
    }

    if (fromDateInput) {
      fromDateInput.addEventListener('change', updateFinancialYear);
      fromDateInput.addEventListener('input', updateFinancialYear);
    }

    updateFinancialYear();
  })();
</script>
