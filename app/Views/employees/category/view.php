<?php
/** @var string $currentPage */
/** @var array $selected */
/** @var int $count */
/** @var array $rows */
$currentPage = 'employee_category_view';
$selectedTitle = $selected['title'] ?? 'Employee Category';
?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/employees/category">Employee Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($selectedTitle) ?></li>
  </ol>
</nav>

<!-- Compact Header Card -->
<div class="card mb-3 border-0 shadow">
  <div class="card-body">
    <div class="row justify-content-between align-items-center">
      
      <!-- Left Side: Icon & Text -->
      <div class="col-md">
        <div class="d-flex align-items-center">
          <span class="fa-stack me-3 ms-n1">
            <i class="fas fa-circle fa-stack-2x text-300"></i>
            <i class="fas fa-folder-open fa-stack-1x fa-inverse text-primary" data-fa-transform="shrink-2"></i>
          </span>
          <div>
            <h5 class="mb-1"><?= htmlspecialchars($selectedTitle) ?></h5>
            <p class="text-600 mb-0 fs--1">
              <?= (int) $count ?> records
            </p>
          </div>
        </div>
      </div>
      
      <!-- Right Side: Buttons -->
      <div class="col-auto mt-3 mt-md-0">
        <a href="/employees/category" class="btn btn-falcon-default btn-sm me-2">
          <span class="fas fa-arrow-left me-1"></span>Back
        </a>
        <button class="btn btn-primary btn-sm">
          <span class="fas fa-plus me-1"></span>Add value
        </button>
      </div>

    </div>
  </div>
</div>

<!-- The Perfect Table Shell -->
<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card shadow border-0">
      
      <div class="card-header bg-transparent">
        <div class="row flex-between-center">
          <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Current values</h5>
          </div>
          <!-- Empty right side to maintain the flex-between layout -->
          <div class="col-6 col-sm-auto ms-auto text-end ps-0"></div>
        </div>
      </div>
      
      <div class="card-body px-0 pt-0">
        <?php if (empty($rows)): ?>
          <div class="p-4 text-center text-600">
            No records have been added for this category yet.
          </div>
        <?php else: ?>
          <?php
            $firstRow = $rows[0];
            $firstRowData = is_object($firstRow) ? get_object_vars($firstRow) : (array) $firstRow;
          ?>
          
          <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
            <thead class="bg-200">
              <tr>
                <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                  <div class="form-check mb-0 d-flex align-items-center">
                    <input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body"}' />
                  </div>
                </th>
                
                <!-- Dynamic Columns -->
                <?php foreach ($firstRowData as $key => $value): ?>
                  <?php if ($key === 'created_at' || $key === 'updated_at' || $key === 'code') continue; ?>
                  
                  <?php if ($key === 'is_active'): ?>
                    <th class="text-900 sort pe-1 align-middle white-space-nowrap">Status</th>
                  <?php elseif ($key === 'employee_names'): ?>
                    <th class="text-900 sort pe-1 align-middle white-space-nowrap">Employees</th>
                  <?php elseif ($key === 'id'): ?>
                    <th class="text-900 sort pe-1 align-middle white-space-nowrap">ID</th>
                  <?php else: ?>
                    <th class="text-900 sort pe-1 align-middle white-space-nowrap"><?= htmlspecialchars(str_replace('_', ' ', ucfirst((string) $key))) ?></th>
                  <?php endif; ?>
                <?php endforeach; ?>
                
                <!-- Actions Column -->
                <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
              </tr>
            </thead>
            <tbody class="list" id="table-simple-pagination-body">
              <?php foreach ($rows as $row): ?>
                <?php $rowData = is_object($row) ? get_object_vars($row) : (array) $row; ?>
                <tr>
                  <!-- Checkbox -->
                  <td class="align-middle">
                    <div class="form-check mb-0 d-flex align-items-center">
                      <input class="form-check-input" type="checkbox" id="checkbox-<?= htmlspecialchars((string)($rowData['id'] ?? '')) ?>" />
                    </div>
                  </td>
                  
                  <!-- Dynamic Data -->
                  <?php foreach ($rowData as $key => $value): ?>
                    <?php if (in_array($key, ['created_at', 'updated_at', 'code'], true)) continue; ?>
                    
                    <?php if ($key === 'is_active'): ?>
                      <?php
                        $status = !empty($value) ? 'Active' : 'Inactive';
                        $badgeClass = !empty($value) ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary';
                      ?>
                      <td class="align-middle pe-1">
                        <span class="badge rounded-pill <?= $badgeClass ?>"><?= $status ?></span>
                      </td>
                      
                    <?php elseif ($key === 'employee_names'): ?>
                      <td class="align-middle pe-1">
                        <?= htmlspecialchars(trim((string)($value ?? '')) ?: '—') ?>
                      </td>
                      
                    <?php else: ?>
                      <td class="align-middle pe-1"><?= htmlspecialchars((string) ($value ?? '')) ?></td>
                    <?php endif; ?>
                  <?php endforeach; ?>
                  
                  <!-- Actions Dropdown -->
                  <td class="align-middle text-end pe-1">
                    <div class="dropdown font-sans-serif btn-reveal-trigger">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-ellipsis-h fs-11"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end border py-2">
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
          
        <?php endif; ?>
      </div>
      
    </div>
  </div>
</div>