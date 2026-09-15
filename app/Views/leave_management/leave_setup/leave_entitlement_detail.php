<?php $currentPage = 'leave_entitlement'; ?>
<?php $csrf = \App\Core\Csrf::generate(); ?>

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
<!--
  View variables (provided by the controller/service before rendering):
  - $selectedYear: string label of the financial year (e.g. "2026/2027").
  - $entitlements: array/list of entitlement objects for the selected year.
  - $eligibleLeaveTypes: list of leave types that do NOT yet have an entitlement
    for this year (used to populate the Add Entitlement dropdown).
  - $csrf: CSRF token string to protect the POST form.

  NOTE: The server (controller/service) must validate all submitted values
  (year, leave_type, entitlement_days, carry_forward, carry_forward_limit).
  JavaScript on this page only controls presentation and helps the user.
-->

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/leave-entitlements">Leave Entitlement</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($selectedYear) ?></li>
  </ol>
</nav>

  <!-- Page header: badge, title and short description -->
  <div class="row align-items-end justify-content-between g-3 mb-3">
  <div class="col-md-8">
    <div>
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="badge badge-subtle-primary fs-10">Leave Setup</span>
      </div>
      <!-- Financial year shown prominently so the user knows which year they're managing -->
      <h2 class="mb-1"><?php echo htmlspecialchars($selectedYear); ?></h2>
      <p class="text-600 mb-0">Leave entitlement configuration for the selected financial year.</p>
    </div>
  </div>
</div>

  <script>
    // Wait until the DOM is ready so all form controls exist when we query them.
    // Reason: this view places the form (offcanvas) later in the document, so
    // running the script immediately may find `null` elements and fail to
    // wire up event listeners. Wrapping in DOMContentLoaded preserves the
    // existing layout and only changes when the script runs.
    //
    // Notes on the DOM APIs used here (beginner-friendly):
    // - `document.getElementById('id')` returns a single element with that ID
    //    or `null` if not present. We use it because IDs are unique and already
    //    present in the HTML (`entitlementLeaveType`, `carryForwardYes`, etc.).
    // - Alternatively `document.querySelector('selector')` can be used to find
    //    elements by CSS selector, but we stick to `getElementById` since the
    //    view already assigns stable IDs.
    // - `element.addEventListener('change', fn)` registers a listener that
    //    triggers when the control's value changes (works for select and radio).
    // - `element.classList.add('d-none')` / `element.classList.remove('d-none')`
    //    toggle a Bootstrap utility class which hides or shows the element.
    //
    // Important: this JavaScript controls presentation only. The server must
    // still validate every submitted value (carry_forward, carry_forward_limit,
    // entitlement_days, leave_type, year, and CSRF token).
    document.addEventListener('DOMContentLoaded', function () {
      // Get the important elements by their existing IDs (do not change IDs).
      // `entitlementLeaveType`: the Leave Type dropdown in the Add Entitlement form
      const leaveTypeSelect = document.getElementById('entitlementLeaveType');
      // `calculationMethodDisplay`: read-only box showing how entitlement is calculated
      const calcDisplay = document.getElementById('calculationMethodDisplay');
      // Carry Forward radio inputs (same `name="carry_forward"` in the form)
      const cfNo = document.getElementById('carryForwardNo');
      const cfYes = document.getElementById('carryForwardYes');
      // The wrapper for the Maximum Carry Forward field; shown/hidden by JS
      const cfWrap = document.getElementById('cfLimitWrap');

      // Update the calculation-method display when the selected leave type changes.
      // This only controls presentation: it reads the `data-calculation` attribute
      // from the selected `<option>` and updates the UI. The server still owns
      // validation and authoritative values.
      function updateCalculation() {
        if (!leaveTypeSelect || !calcDisplay) return;
        const opt = leaveTypeSelect.selectedOptions && leaveTypeSelect.selectedOptions[0];
        const method = opt ? opt.getAttribute('data-calculation') : null;
        if (!method) {
          calcDisplay.textContent = 'Set automatically from the leave type';
        } else {
          calcDisplay.textContent = method === 'calendar_days' ? 'Calendar Days' : 'Working Days';
        }
      }

      // Show or hide the Maximum Carry Forward wrapper based on the selected radio.
      // IMPORTANT: Carry Forward is an actual form field (`name="carry_forward"`).
      // JavaScript only detects which radio is selected and shows/hides the
      // `#cfLimitWrap` presentation. The backend must still validate the value.
      function updateCfWrap() {
        if (!cfWrap) return;
        if (cfYes && cfYes.checked) {
          cfWrap.classList.remove('d-none'); // show
        } else {
          cfWrap.classList.add('d-none'); // hide
        }
      }

      // Wire up events using existing elements. Use 'change' so keyboard and
      // mouse interactions both trigger the updates.
      if (leaveTypeSelect) leaveTypeSelect.addEventListener('change', updateCalculation);
      if (cfNo) cfNo.addEventListener('change', updateCfWrap);
      if (cfYes) cfYes.addEventListener('change', updateCfWrap);

      // Initialize UI to match current form values on first render.
      updateCalculation();
      updateCfWrap();
    });
  </script>
<!-- Empty state: shown when there are no entitlements for this financial year -->
<?php if (empty($entitlements)): ?>
  <div class="card border-0 shadow-none">
    <div class="card-body py-5">
      <div class="text-center" id="detailEmptyState">
        <i class="fas fa-clipboard-list fa-3x text-500 mb-3"></i>
        <p class="text-700 mb-3">No entitlements configured yet for this financial year.</p>
        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#entitlementForm" type="button">
          <span class="fas fa-plus me-2"></span>Add First Entitlement
        </button>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="card">
    <div class="card-header">
      <div class="row flex-between-center">
        <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
          <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Entitlement Rules</h5>
        </div>
        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
          <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#entitlementForm">
            <span class="fas fa-plus me-2"></span>Add Entitlement
          </button>
        </div>
      </div>
    </div>

    <div class="card-body px-0 pt-0">
      <!-- Entitlements table: read-only list of configured entitlements for the year -->
      <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
        <thead class="bg-200">
          <tr>
            <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
              <div class="form-check mb-0 d-flex align-items-center">
                <input class="form-check-input" id="checkbox-bulk-item-select-detail" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body-detail","actions":"table-simple-pagination-actions-detail","replacedElement":"table-simple-pagination-replace-element-detail"}' />
              </div>
            </th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap">Leave Type</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap">Calculation</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Entitlement</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Carry Forward</th>
            <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Max Carry</th>
            <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
          </tr>
        </thead>
        <tbody class="list" id="table-simple-pagination-body-detail">
          <?php foreach ($entitlements as $index => $entitlement): ?>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="simple-pagination-item-detail-<?= (int) $index; ?>" data-bulk-select-row="data-bulk-select-row" />
                </div>
              </td>
              <!-- Leave type name -->
              <td class="align-middle fw-semi-bold white-space-nowrap name"><?= htmlspecialchars((string) ($entitlement->leave_type_name ?? 'N/A')) ?></td>
              <!-- Calculation method: displayed as human readable text -->
              <td class="align-middle white-space-nowrap"><?= htmlspecialchars((string) ($entitlement->calculation_method ?? 'working_days')) === 'calendar_days' ? 'Calendar Days' : 'Working Days'; ?></td>
              <!-- Entitlement days formatted to 2 decimals -->
              <td class="align-middle text-end white-space-nowrap"><?= htmlspecialchars((int) ($entitlement->entitlement ?? 0)) ?> days</td>
              <!-- Carry Forward shown as Yes/No based on truthiness of carry_forward -->
              <td class="align-middle text-center white-space-nowrap"><?= !empty($entitlement->carry_forward) ? 'Yes' : 'No' ?></td>
              <!-- Maximum carry forward (numeric) -->
              <td class="align-middle text-end white-space-nowrap"><?= htmlspecialchars((int) ($entitlement->carry_forward_limit ?? 0)) ?></td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-detail-table-item-<?= (int) $index; ?>" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-detail-table-item-<?= (int) $index; ?>">
                    <?php if (!empty($entitlement->entitlement_id)): ?>
                      <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#entitlementDetailsModal-<?= (int) $entitlement->entitlement_id; ?>">View</button>
                    <?php else: ?>
                      <button class="dropdown-item disabled" type="button" disabled>View</button>
                    <?php endif; ?>
                    <a class="dropdown-item" href="#!">Edit</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<?php foreach ($entitlements as $entitlement): ?>
  <?php if (empty($entitlement->entitlement_id)) continue; ?>
  <div class="modal fade" id="entitlementDetailsModal-<?= (int) $entitlement->entitlement_id; ?>" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="entitlementDetailsModalLabel-<?= (int) $entitlement->entitlement_id; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
          <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
            <h4 class="mb-1" id="entitlementDetailsModalLabel-<?= (int) ($entitlement->entitlement_id ?? 0); ?>"><?= htmlspecialchars((string) ($entitlement->leave_type_name ?? 'Entitlement')) ?></h4>
          </div>

          <div class="p-4">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="d-flex align-items-center border rounded-3 p-3 h-100">
                  <div>
                    <p class="text-500 fs-10 mb-1">Financial Year</p>
                    <h5 class="mb-0"><?= htmlspecialchars((string) $selectedYear) ?></h5>
                  </div>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="d-flex align-items-center border rounded-3 p-3 h-100 mt-3">
                  <div>
                    <p class="text-500 fs-10 mb-1">Calculation Method</p>
                    <h5 class="mb-0"><?= htmlspecialchars($entitlement->calculation_method === 'calendar_days' ? 'Calendar Days' : 'Working Days') ?></h5>
                  </div>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="d-flex align-items-center border rounded-3 p-3 h-100 mt-3">
                  <div>
                    <p class="text-500 fs-10 mb-1">Entitlement</p>
                        <h5 class="mb-0"><?= htmlspecialchars((int) ($entitlement->entitlement ?? 0)) ?> days</h5>
                  </div>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="d-flex align-items-center border rounded-3 p-3 h-100 mt-3">
                  <div>
                    <p class="text-500 fs-10 mb-1">Carry Forward</p>
                    <!-- Carry Forward and Maximum Carry Forward displayed in the View modal -->
                    <h5 class="mb-0"><?= !empty($entitlement->carry_forward) ? 'Yes' : 'No' ?></h5>
                    <p class="text-500 fs-10 mb-1 mt-2">Maximum Carry Forward</p>
                    <h5 class="mb-0"><?= htmlspecialchars((int) ($entitlement->carry_forward_limit ?? 0)) ?> days</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="border-top p-3 d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="entitlementForm" aria-labelledby="entitlementFormLabel" style="width:460px;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="entitlementFormLabel">Add Entitlement</h5>
    <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body p-0">
    <?php if (!empty($eligibleLeaveTypes)): ?>
    <form method="post" action="/leave-entitlements" id="entitlementFormSubmit">
      <div class="p-3">
        <!-- Hidden form fields:
             - edit_id: used when editing existing entitlement (empty for add)
             - year: the financial year label being managed (trusted only after backend validation)
             - csrf_token: anti-CSRF token; must be validated server-side
        -->
        <input type="hidden" name="edit_id" value="" />
        <input type="hidden" name="year" value="<?= htmlspecialchars($selectedYear) ?>" />
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />

        <div class="mb-3">
          <label class="form-label fs--1 mb-1">Financial Year</label>
          <div class="border rounded-3 bg-body-tertiary p-3 text-700">
            Managing <?= htmlspecialchars($selectedYear) ?>.
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="entitlementLeaveType">Leave Type</label>
          <select class="form-select" id="entitlementLeaveType" name="leave_type" required>
            <!--
              The dropdown is populated from `$eligibleLeaveTypes` provided by the
              controller/service. When `$eligibleLeaveTypes` is non-empty we show
              a placeholder option followed by the eligible leave types. When no
              eligible types exist we show a single informational option with
              empty value so the browser cannot submit a valid leave type.
            -->
            <?php if (!empty($eligibleLeaveTypes)): ?>
              <option value="">Select a leave type…</option>
              <?php foreach ($eligibleLeaveTypes as $lt): ?>
                <option value="<?= (int) $lt->id; ?>" data-calculation="<?= htmlspecialchars($lt->calculation_method); ?>"><?= htmlspecialchars((string) $lt->name); ?></option>
              <?php endforeach; ?>
            <?php else: ?>
              <option value="" selected>Financial year fully configured — no leave types available</option>
            <?php endif; ?>
          </select>
          <div class="form-text">Only leave types without an entitlement for this year are listed.</div>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1" for="entitlementDays">Entitlement</label>
          <div class="input-group">
            <input class="form-control" id="entitlementDays" name="entitlement_days" type="number" min="0" step="1" placeholder="e.g. 30" required />
            <span class="input-group-text">Days</span>
          </div>
          <!-- Entitlement: numeric input in days. Backend must validate that the
               submitted value is numeric and within business rules. -->
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1">Calculation Method</label>
          <div class="border rounded-3 bg-body-tertiary p-2 text-600" id="calculationMethodDisplay">
            Set automatically from the leave type
          </div>
          <!-- Calculation method: read-only presentation that reflects the
               `data-calculation` attribute of the selected leave type. This is
               a convenience for the user; the server remains authoritative. -->
          <div class="form-text">Defined on the leave type itself, so it cannot drift between screens.</div>
        </div>

        <div class="mb-3">
          <label class="form-label fs--1 mb-1">Carry Forward</label>
          <div class="d-flex gap-2 flex-wrap">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="carry_forward" id="carryForwardNo" value="No" checked required>
              <label class="form-check-label" for="carryForwardNo">No</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="carry_forward" id="carryForwardYes" value="Yes">
              <label class="form-check-label" for="carryForwardYes">Yes</label>
            </div>
          </div>
          <!--
            Carry Forward radios: these are real form controls (`name="carry_forward"`).
            JavaScript will listen for changes to these radios and show/hide the
            Maximum Carry Forward field (`#cfLimitWrap`). The chosen value is
            submitted to the server and must be validated there (Yes/No).
          -->
        </div>

        <!-- Maximum Carry Forward wrapper. Hidden by default using `d-none`.
             The JS on this page toggles this wrapper's visibility by adding
             or removing the `d-none` class. The input inside remains a normal
             form field (`name="carry_forward_limit"`) and must be validated
             server-side. -->
        <div class="mb-3 d-none" id="cfLimitWrap">
          <label class="form-label fs--1 mb-1" for="cfLimit">Maximum Carry Forward</label>
          <div class="input-group">
            <input class="form-control" id="cfLimit" name="carry_forward_limit" type="number" min="0" step="1" placeholder="e.g. 15" />
            <span class="input-group-text">Days</span>
          </div>
        </div>

        
        </div>
    </form>
    <?php else: ?>
      <div class="p-5 text-center">
        <div class="mb-3">
          <i class="fas fa-check-circle fa-3x text-success"></i>
        </div>
        <h5 class="mb-2">Fully Configured</h5>
        <p class="text-700">All active leave types already have entitlement rules configured for FY <?= htmlspecialchars($selectedYear) ?>.<br/>No additional configuration is required.</p>
      </div>
    <?php endif; ?>
  </div>

  <div class="border-top p-3">
    <div class="d-flex justify-content-end align-items-center gap-2">
      <?php if (!empty($eligibleLeaveTypes)): ?>
        <button type="button" class="btn btn-falcon-default" data-bs-dismiss="offcanvas">Cancel</button>
        <button type="submit" form="entitlementFormSubmit" class="btn btn-primary">Save Entitlement</button>
      <?php else: ?>
        <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas">Close</button>
      <?php endif; ?>
    </div>
  </div>
</div>
