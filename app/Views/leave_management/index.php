<?php $currentPage = 'leave_management'; ?>


    <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
        <li class="breadcrumb-item active" aria-current="page">Holidays</li>
    </ol>
    </nav>

    <!-- Your page content here -->


    <div class="row g-3 mb-3">

        <div class="col-md-4 col-xxl-3">
            <div class="card h-md-100">
                <div class="card-header d-flex flex-between-center pb-0">
                    <h6 class="mb-0">Employees on leave today</h6>
                    <div class="dropdown font-sans-serif btn-reveal-trigger">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-leave-today" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            <span class="fas fa-ellipsis-h fs-11"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-leave-today">
                            <a class="dropdown-item" href="#!">View</a>
                            <a class="dropdown-item" href="#!">Export</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">Edit</a>
                        </div>
                    </div>
                </div>


                <div class="card-body pt-2">
                    <div class="row g-0 h-100 align-items-center">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="mb-2">20</h4>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xxl-3">
            <div class="card h-md-100">
                <div class="card-header d-flex flex-between-center pb-0">
                    <h6 class="mb-0">Employees on leave this month</h6>
                    <div class="dropdown font-sans-serif btn-reveal-trigger">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-leave-month" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            <span class="fas fa-ellipsis-h fs-11"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-leave-month">
                            <a class="dropdown-item" href="#!">View</a>
                            <a class="dropdown-item" href="#!">Export</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">Edit</a>
                        </div>
                    </div>
                </div>


                <div class="card-body pt-2">
                    <div class="row g-0 h-100 align-items-center">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="mb-2">0</h4>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xxl-3">
            <div class="card h-md-100">
                <div class="card-header d-flex flex-between-center pb-0">
                    <h6 class="mb-0">Holidays this month</h6>
                    <div class="dropdown font-sans-serif btn-reveal-trigger">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-holidays-month" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            <span class="fas fa-ellipsis-h fs-11"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-holidays-month">
                            <a class="dropdown-item" href="#!">View</a>
                            <a class="dropdown-item" href="#!">Export</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">Edit</a>
                        </div>
                    </div>
                </div>


                <div class="card-body pt-2">
                    <div class="row g-0 h-100 align-items-center">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="mb-2">0</h4>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mb-3">

        <div class="col-md-4 col-xxl-3">

            <div class="card h-md-100">
                <div class="card-header d-flex flex-start pb-0">
                    <h6 class="mb-0">Setup</h6>
                    
                </div>


                <div class="card-body pt-2">
                    <div class="row g-0 h-100 ">
                        <div class="col">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <a href="/holiday-list">Holiday Lists</a>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

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
                <div id="table-simple-pagination-replace-element"><button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">New</span></button><button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filter</span></button><button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Export</span></button></div>
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
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap">Customer</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap">Email</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap">Product</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Payment</th>
                  <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Amount</th>
                  <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
                </tr>
              </thead>
              <tbody class="list" id="table-simple-pagination-body">
                
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
