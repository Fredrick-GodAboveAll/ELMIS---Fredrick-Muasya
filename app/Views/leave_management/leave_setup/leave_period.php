<?php $currentPage = 'leave_period'; $csrfToken = \App\Core\Csrf::generate(); ?>

    <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
        <li class="breadcrumb-item"><a href="/leaves">Leave</a></li>
        <li class="breadcrumb-item active" aria-current="page">leave period</li>
    </ol>
    </nav>

<!-- content  -->

    <div class="row mb-3 justify-content-end align-items-center">
      <div class="col-auto">
        <a class="btn btn-falcon-default btn-sm" href="/new-leave-period" type="button">
          <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
          <span class="d-none d-sm-inline-block ms-1">Add Leave Period</span>
        </a>
      </div>
    </div>


    <div class="row g-3 mb-3">
      <div class="col-xxl-12 col-xl-12">
        <div class="card">
          <div class="card-header">
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
            <div class="row flex-between-center">
              <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Leave Period</h5>
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
                </button><button class="btn btn-falcon-default btn-sm" type="button">
                  <span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span>
                  <span class="d-none d-sm-inline-block ms-1">Export</span></button></div>
              </div>
            </div>
          </div>
          
          <div class="card-body px-0 pt-0">
            <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
              <thead class="bg-200">
                <tr>
                  <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                    <div class="form-check mb-0 d-flex align-items-center"><input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" data-bulk-select='{"body":"table-simple-pagination-body","actions":"table-simple-pagination-actions","replacedElement":"table-simple-pagination-replace-element"}' /></div>
                  </th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap">Leave Period Name</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap">Start Date</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap">End Date</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Status</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Current</th>
                  <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
                </tr>
              </thead>
              <tbody class="list" id="table-simple-pagination-body">

                <?php if (!empty($periods)): ?>
                  <?php foreach ($periods as $period): ?>
                    <tr class="btn-reveal-trigger">
                      <td class="align-middle" style="width: 28px;">
                        <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-<?= (int) $period->id; ?>" data-bulk-select-row="data-bulk-select-row" /></div>
                      </td>
                      <td class="align-middle white-space-nowrap fw-semi-bold name">
                        <a href="#"><?= htmlspecialchars($period->label ?? 'Unnamed Period') ?></a>
                      </td>
                      <td class="align-middle white-space-nowrap email">
                        <?= htmlspecialchars(date('d M Y', strtotime($period->start_date))) ?>
                      </td>
                      <td class="align-middle white-space-nowrap product">
                        <?= htmlspecialchars(date('d M Y', strtotime($period->end_date))) ?>
                      </td>
                      <td class="align-middle text-center fs-9 white-space-nowrap payment">
                        <?php if (!empty($period->is_current)): ?>
                          <span class="badge badge rounded-pill badge-subtle-success">Current<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span>
                        <?php else: ?>
                          <span class="badge badge rounded-pill badge-subtle-secondary">Inactive</span>
                        <?php endif; ?>
                      </td>
                      <td class="align-middle text-end amount">
                        <?= !empty($period->is_current) ? 'Active' : 'Standby' ?>
                      </td>
                      <td class="align-middle white-space-nowrap text-end">
                        <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-<?= (int) $period->id; ?>" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-<?= (int) $period->id; ?>">
                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editLeavePeriodModal-<?= (int) $period->id; ?>">Edit</button>
                            <div class="dropdown-divider"></div>
                            <button type="button" class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#editLeavePeriodModal-<?= (int) $period->id; ?>">Set current</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>

           
          </div>
        </div>
      </div>
    </div>


    <?php if (!empty($periods)): ?>
      <?php foreach ($periods as $period): ?>
        <div class="modal fade" id="editLeavePeriodModal-<?= (int) $period->id; ?>" tabindex="-1" aria-labelledby="editLeavePeriodModalLabel-<?= (int) $period->id; ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form id="updateLeavePeriodForm-<?= (int) $period->id; ?>" method="POST" action="/leave-periods/update">
                <div class="modal-header">
                  <h5 class="modal-title" id="editLeavePeriodModalLabel-<?= (int) $period->id; ?>">Edit Leave Period</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                  <input type="hidden" name="id" value="<?= (int) $period->id; ?>">
                  <input type="hidden" name="is_current" value="0">

                  <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="is_current_<?= (int) $period->id; ?>" name="is_current" value="1" <?= !empty($period->is_current) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="is_current_<?= (int) $period->id; ?>">Active</label>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="submit" form="deleteLeavePeriodForm-<?= (int) $period->id; ?>" class="btn btn-outline-danger btn-sm">Delete</button>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="updateLeavePeriodForm-<?= (int) $period->id; ?>" class="btn btn-primary btn-sm">Update</button>
                  </div>
                </div>
              </form>

              <form id="deleteLeavePeriodForm-<?= (int) $period->id; ?>" method="POST" action="/leave-periods/delete" onsubmit="return confirm('Are you sure you want to delete this leave period?');" style="display:none;">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="id" value="<?= (int) $period->id; ?>">
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

