<?php
/** @var string $currentPage */
/** @var array $selected */
/** @var int $count */
/** @var array $rows */
$currentPage = 'employee_category_view';
$selectedTitle = $selected['title'] ?? 'Employee Category';
$selectedTable = $selected['table'] ?? '';
?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/employees/category">Employee Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($selectedTitle) ?></li>
  </ol>
</nav>

<div class="card shadow border-0 mb-3">
  <div class="card-body p-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
      <div>
        <p class="text-500 fs-11 mb-1 text-uppercase tracking-wide">Employee category</p>
        <h1 class="h4 fw-bold mb-1"><?= htmlspecialchars($selectedTitle) ?></h1>
        <p class="text-600 fs--1 mb-0"><?= htmlspecialchars($selected['description'] ?? 'Employee category details and values.') ?></p>
      </div>
      <div class="text-md-end">
        <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-11 fw-semi-bold"><?= (int) $count; ?> records</div>
      </div>
    </div>
  </div>
</div>

<div class="card shadow border-0">
  <div class="card-header bg-transparent border-0 px-4 pt-4 pb-0">
    <div class="d-flex align-items-center justify-content-between">
      <h2 class="h6 mb-0">Current values</h2>
      <span class="text-500 fs-11">Table: <?= htmlspecialchars($selectedTable) ?></span>
    </div>
  </div>
  <div class="card-body p-4">
    <?php if (empty($rows)): ?>
      <div class="alert alert-light mb-0">
        No records have been added for this category yet.
      </div>
    <?php else: ?>
      <?php
        $firstRow = $rows[0];
        $firstRowData = is_object($firstRow) ? get_object_vars($firstRow) : (array) $firstRow;
      ?>
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <?php foreach ($firstRowData as $key => $value): ?>
                <?php if ($key === 'id' || $key === 'created_at' || $key === 'updated_at' || $key === 'code') continue; ?>
                <?php if ($key === 'is_active'): ?>
                  <th>Status</th>
                <?php elseif ($key === 'employee_names'): ?>
                  <th>Employees</th>
                <?php else: ?>
                  <th><?= htmlspecialchars(str_replace('_', ' ', ucfirst((string) $key))) ?></th>
                <?php endif; ?>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row): ?>
              <?php $rowData = is_object($row) ? get_object_vars($row) : (array) $row; ?>
              <tr>
                <td><?= htmlspecialchars((string) ($rowData['id'] ?? '')) ?></td>
                <?php foreach ($rowData as $key => $value): ?>
                  <?php if (in_array($key, ['id', 'code', 'created_at', 'updated_at'], true)) continue; ?>
                  <?php if ($key === 'is_active') {
                      $status = !empty($value) ? 'Active' : 'Inactive';
                      $badgeClass = !empty($value) ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary';
                      echo '<td><span class="badge rounded-pill ' . htmlspecialchars($badgeClass, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . '</span></td>';
                      continue;
                  } ?>
                  <?php if ($key === 'employee_names') {
                      $employeeList = trim((string) ($value ?? ''));
                      echo '<td>' . htmlspecialchars($employeeList !== '' ? $employeeList : '—') . '</td>';
                      continue;
                  } ?>
                  <td><?= htmlspecialchars((string) ($value ?? '')) ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
