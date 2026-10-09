<?php $currentPage = 'employee_categories'; ?>

<?php
/** @var array  $categories */
/** @var array  $members */
/** @var int    $total */
/** @var string $firstKey */

if (!function_exists('cat_h')) {
  function cat_h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('cat_initials')) {
  function cat_initials(string $name): string {
    $out = '';
    foreach (preg_split('/\s+/', trim($name)) as $p) { if ($p !== '') { $out .= strtoupper($p[0]); } }
    return substr($out, 0, 2);
  }
}
if (!function_exists('cat_dots')) {
  function cat_dots(int $n): string {
    if ($n === 0) return '<span class="text-400">○</span> <span class="text-600 fw-semi-bold">0</span>';
    $dots = str_repeat('●', min($n, 5));
    $more = $n > 5 ? '+' : '';
    return '<span class="text-primary" style="letter-spacing:1px;">' . $dots . $more . '</span> '
         . '<span class="text-900 fw-semi-bold ms-1">' . $n . '</span>';
  }
}

$roleIcons = [
  'Base policy' => 'layers',
  'Impact only' => 'sliders',
  'Filter only' => 'filter',
];
?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/employees">Employees</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
  </ol>
</nav>

<!-- ============================================================
     PAGE HEADER
     ============================================================ -->
<div class="row g-3 align-items-center mb-3">
  <div class="col">
    <h4 class="mb-1">Employee Categories</h4>
    <p class="text-600 fs-9 mb-0">
      Classify staff by employment terms, status, and organisational grouping.
    </p>
  </div>
  <div class="col-auto">
    <div class="d-flex gap-2">
      <button class="btn btn-falcon-default btn-sm" type="button">
        <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>
        Add Category
      </button>
      <button class="btn btn-falcon-default btn-sm" type="button"
              data-bs-toggle="modal" data-bs-target="#exportModal">
        <span class="fas fa-file-export me-1" data-fa-transform="shrink-3"></span>
        Export
      </button>
    </div>
  </div>
</div>

<!-- ============================================================
     MAIN CARD
     ============================================================ -->
<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="card border">

      <div class="card-body bg-body-tertiary">
        <div class="tab-content">

          <ul class="nav nav-tabs" id="catTab" role="tablist">
            <?php foreach ($categories as $key => $cat): ?>
              <li class="nav-item" role="presentation">
                <a class="nav-link fs-9 <?= $key === $firstKey ? 'active' : '' ?>"
                   id="tab-<?= cat_h($key) ?>"
                   data-bs-toggle="tab"
                   href="#pane-<?= cat_h($key) ?>"
                   role="tab"
                   aria-controls="pane-<?= cat_h($key) ?>"
                   aria-selected="<?= $key === $firstKey ? 'true' : 'false' ?>">
                  <span class="me-1" data-feather="<?= cat_h($cat['icon']) ?>" style="width:14px;height:14px;"></span>
                  <?= cat_h($cat['title']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>

          <div class="tab-content border border-top-0 p-3 bg-white" id="catTabContent">
            <?php foreach ($categories as $key => $cat):
              $catTotal = 0; $seen = [];
              foreach ($cat['values'] as $label => $effect) {
                foreach ($members[$key][$label] ?? [] as $e) {
                  if (!isset($seen[$e['id']])) { $seen[$e['id']] = true; $catTotal++; }
                }
              }
            ?>
              <div class="tab-pane fade <?= $key === $firstKey ? 'show active' : '' ?>"
                   id="pane-<?= cat_h($key) ?>"
                   role="tabpanel"
                   aria-labelledby="tab-<?= cat_h($key) ?>">

                <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                  <div>
                    <h5 class="mb-1 d-flex align-items-center">
                      <span class="me-2 text-<?= cat_h($cat['color']) ?>"
                            data-feather="<?= cat_h($cat['icon']) ?>"
                            style="width:18px;height:18px;"></span>
                      <?= cat_h($cat['title']) ?>
                    </h5>
                    <p class="text-600 fs-9 mb-0"><?= cat_h($cat['description']) ?></p>
                  </div>
                  <div class="text-end">
                    <span class="badge badge-subtle-<?= cat_h($cat['color']) ?> rounded-pill px-2 py-2 fs-9">
                      <span class="me-1" data-feather="<?= cat_h($roleIcons[$cat['role']] ?? 'tag') ?>" style="width:11px;height:11px;"></span>
                      <span class="text-uppercase" style="letter-spacing:.08em;">
                        <?= cat_h($cat['role']) ?>
                      </span>
                    </span>
                    <div class="fs-9 text-600 mt-1">
                      <?= count($cat['values']) ?> values · <?= $catTotal ?> employees
                    </div>
                  </div>
                </div>

                <?php if ($cat['layout'] === 'arrow'): ?>
                  <?php foreach ($cat['values'] as $label => $effect): ?>
                    <?php
                      $list = $members[$key][$label] ?? []; $count = count($list);
                      $modalId = 'modal-' . $key . '-' . preg_replace('/[^a-z0-9]+/i', '-', $label);
                    ?>
                    <div class="row align-items-center g-0 py-2">
                      <div class="col-3">
                        <span class="badge badge-subtle-secondary fs-9"><?= cat_h($label) ?></span>
                      </div>
                      <div class="col-1 text-center text-500">
                        <span data-feather="arrow-right" style="width:14px;height:14px;"></span>
                      </div>
                      <div class="col-4 fs-9 text-800">
                        <?= $effect !== '' ? cat_h($effect) : '<span class="text-500">—</span>' ?>
                      </div>
                      <div class="col-3 fs-9">
                        <?= cat_dots($count) ?>
                      </div>
                      <div class="col-1 text-end">
                        <?php if ($count > 0): ?>
                          <button class="btn btn-sm btn-link text-<?= cat_h($cat['color']) ?> p-0"
                                  type="button" data-bs-toggle="modal" data-bs-target="#<?= cat_h($modalId) ?>"
                                  aria-label="View employees">
                            <span data-feather="users" style="width:14px;height:14px;"></span>
                          </button>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>

                <?php elseif ($cat['layout'] === 'impact'): ?>
                  <?php foreach ($cat['values'] as $label => $effect): ?>
                    <?php
                      $list = $members[$key][$label] ?? []; $count = count($list);
                      $modalId = 'modal-' . $key . '-' . preg_replace('/[^a-z0-9]+/i', '-', $label);
                    ?>
                    <div class="row align-items-center g-0 py-2">
                      <div class="col-3">
                        <span class="badge badge-subtle-secondary fs-9"><?= cat_h($label) ?></span>
                      </div>
                      <div class="col-5 fs-9 text-800">
                        <?php if ($effect !== ''): ?>
                          <span class="text-<?= cat_h($cat['color']) ?>">
                            <span data-feather="chevron-right" style="width:12px;height:12px;"></span>
                            <?= cat_h($effect) ?>
                          </span>
                        <?php else: ?>
                          <span class="text-500">No adjustment</span>
                        <?php endif; ?>
                      </div>
                      <div class="col-3 fs-9">
                        <?= cat_dots($count) ?>
                      </div>
                      <div class="col-1 text-end">
                        <?php if ($count > 0): ?>
                          <button class="btn btn-sm btn-link text-<?= cat_h($cat['color']) ?> p-0"
                                  type="button" data-bs-toggle="modal" data-bs-target="#<?= cat_h($modalId) ?>"
                                  aria-label="View employees">
                            <span data-feather="users" style="width:14px;height:14px;"></span>
                          </button>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>

                <?php elseif ($cat['layout'] === 'box'): ?>
                  <div class="row g-3">
                    <?php foreach ($cat['values'] as $label => $effect): ?>
                      <?php
                        $list = $members[$key][$label] ?? []; $count = count($list);
                        $modalId = 'modal-' . $key . '-' . preg_replace('/[^a-z0-9]+/i', '-', $label);
                      ?>
                      <div class="col-sm-6 col-lg-4">
                        <div class="border rounded-3 p-3 h-100 d-flex flex-column">
                          <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge badge-subtle-secondary fs-9"><?= cat_h($label) ?></span>
                            <span class="fs-9"><?= cat_dots($count) ?></span>
                          </div>
                          <?php if ($count > 0): ?>
                            <button class="btn btn-sm btn-link text-<?= cat_h($cat['color']) ?> p-0 mt-auto text-start fs-9 fw-semi-bold"
                                    type="button" data-bs-toggle="modal" data-bs-target="#<?= cat_h($modalId) ?>">
                              View <?= $count ?> <span data-feather="arrow-right" style="width:12px;height:12px;"></span>
                            </button>
                          <?php else: ?>
                            <span class="fs-9 text-500 mt-auto">No employees</span>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>

                <?php elseif ($cat['layout'] === 'table'):
                  $maxCount = 1;
                  foreach ($cat['values'] as $label => $effect) {
                    $maxCount = max($maxCount, count($members[$key][$label] ?? []));
                  } ?>
                  <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0 fs-9">
                      <thead class="bg-200">
                        <tr>
                          <th class="text-900" style="width:120px;">Value</th>
                          <th class="text-900 text-end" style="width:110px;">Employees</th>
                          <th class="text-900" style="width:40%;">Share</th>
                          <th class="text-900 text-end" style="width:60px;">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($cat['values'] as $label => $effect): ?>
                          <?php
                            $list = $members[$key][$label] ?? []; $count = count($list);
                            $pct = $maxCount > 0 ? round($count / $maxCount * 100) : 0;
                            $modalId = 'modal-' . $key . '-' . preg_replace('/[^a-z0-9]+/i', '-', $label);
                          ?>
                          <tr>
                            <td><span class="badge badge-subtle-secondary fs-9"><?= cat_h($label) ?></span></td>
                            <td class="text-end fw-semi-bold"><?= $count ?></td>
                            <td>
                              <div class="progress" style="height:6px;">
                                <div class="progress-bar bg-<?= cat_h($cat['color']) ?>" style="width:<?= $pct ?>%;"></div>
                              </div>
                            </td>
                            <td class="text-end">
                              <?php if ($count > 0): ?>
                                <button class="btn btn-sm btn-falcon-default py-0 px-2"
                                        type="button" data-bs-toggle="modal" data-bs-target="#<?= cat_h($modalId) ?>"
                                        aria-label="View employees">
                                  <span data-feather="users" style="width:12px;height:12px;"></span>
                                </button>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif; ?>

              </div>
            <?php endforeach; ?>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<!-- ============================================================
     EXPORT MODAL — placeholder
     ============================================================ -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Export Categories</h6>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div class="mb-3 text-400" data-feather="download" style="width:28px;height:28px;"></div>
        <p class="mb-0 text-700 fs-9">Export will be available later.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-falcon-default btn-sm" type="button" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     VALUE MODALS — one per value that has employees
     ============================================================ -->
<?php foreach ($categories as $key => $cat): ?>
  <?php foreach ($cat['values'] as $label => $effect): ?>
    <?php
      $list = $members[$key][$label] ?? [];
      if (empty($list)) { continue; }
      $modalId = 'modal-' . $key . '-' . preg_replace('/[^a-z0-9]+/i', '-', $label);
    ?>
    <div class="modal fade" id="<?= cat_h($modalId) ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header align-items-center">
            <div class="d-flex align-items-center gap-2">
              <span class="text-<?= cat_h($cat['color']) ?>" data-feather="<?= cat_h($cat['icon']) ?>" style="width:18px;height:18px;"></span>
              <div>
                <h6 class="modal-title mb-0"><?= cat_h($cat['title']) ?></h6>
                <p class="fs-9 text-600 mb-0"><?= cat_h($label) ?> · <?= count($list) ?> employees</p>
              </div>
            </div>
            <button class="btn-close ms-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3">
            <?php foreach ($list as $e): ?>
              <a class="d-flex align-items-center justify-content-between py-2 text-decoration-none text-body border-bottom"
                 href="/employees/<?= cat_h($e['id']) ?>">
                <div class="d-flex align-items-center min-w-0">
                  <div class="avatar avatar-s me-2">
                    <div class="avatar-name rounded-circle bg-<?= cat_h($cat['color']) ?> text-white fs-9">
                      <?= cat_h(cat_initials($e['full_name'] ?? $e['name'] ?? '')) ?>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2 text-truncate">
                    <span class="fw-semi-bold fs-9"><?= cat_h($e['payroll_number'] ?? $e['id']) ?></span>
                    <span class="text-600 fs-9 text-truncate"><?= cat_h($e['full_name'] ?? $e['name'] ?? '') ?></span>
                  </div>
                </div>
                <span class="text-400 ms-3" data-feather="arrow-right" style="width:12px;height:12px;"></span>
              </a>
            <?php endforeach; ?>
          </div>
          <div class="modal-footer">
            <button class="btn btn-falcon-default btn-sm" type="button" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endforeach; ?>