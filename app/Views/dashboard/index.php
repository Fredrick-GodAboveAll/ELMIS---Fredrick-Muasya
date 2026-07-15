


<?php $currentPage = 'dashboard'; ?>

          <div class="row g-3 mb-3">
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100 ecommerce-card-min-width">
                      <div class="card-header pb-0">
                          <h6 class="mb-0 mt-2 d-flex align-items-center">
                              Leave Records This Week
                              <span class="ms-1 text-400" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of leave records entered this week">
                                  <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                              </span>
                          </h6>
                      </div>
                      <div class="card-body d-flex flex-column justify-content-end">
                          <div class="row">
                              <div class="col">
                                  <p class="font-sans-serif lh-1 mb-1 fs-5">15</p>
                                  <span class="badge badge-subtle-success rounded-pill fs-11">+5%</span>
                              </div>
                              <div class="col-auto ps-0">
                                  <div class="echart-bar-weekly-sales h-100"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100">
                      <div class="card-header pb-0">
                          <h6 class="mb-0 mt-2">Recorded Leave Entries</h6>
                      </div>
                      <div class="card-body d-flex flex-column justify-content-end">
                          <div class="row justify-content-between">
                              <div class="col-auto align-self-end">
                                  <div class="fs-5 fw-normal font-sans-serif text-700 lh-1 mb-1">23</div>
                                  <span class="badge rounded-pill fs-11 bg-200 text-primary">
                                      <span class="fas fa-caret-up me-1"></span>
                                      Manual approvals recorded
                                  </span>
                              </div>
                              <div class="col-auto ps-0 mt-n4">
                                  <div class="echart-default-total-order" data-echarts='{"tooltip":{"trigger":"axis","formatter":"{b0} : {c0}"},"xAxis":{"data":["Week 4","Week 5","Week 6","Week 7"]},"series":[{"type":"line","data":[20,40,100,120],"smooth":true,"lineStyle":{"width":3}}],"grid":{"bottom":"2%","top":"2%","right":"0","left":"10px"}}' data-echart-responsive="true"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100">
                      <div class="card-body">
                          <div class="row h-100 justify-content-between g-0">
                              <div class="col-5 col-sm-6 col-xxl pe-2">
                                  <h6 class="mt-1">Leave Types Distribution</h6>
                                  <div class="fs-11 mt-3">
                                      <div class="d-flex flex-between-center mb-1">
                                          <div class="d-flex align-items-center">
                                              <span class="dot bg-primary"></span>
                                              <span class="fw-semi-bold">Annual Leave</span>
                                          </div>
                                          <div class="d-xxl-none">45%</div>
                                      </div>
                                      <div class="d-flex flex-between-center mb-1">
                                          <div class="d-flex align-items-center">
                                              <span class="dot bg-info"></span>
                                              <span class="fw-semi-bold">Sick Leave</span>
                                          </div>
                                          <div class="d-xxl-none">30%</div>
                                      </div>
                                      <div class="d-flex flex-between-center mb-1">
                                          <div class="d-flex align-items-center">
                                              <span class="dot bg-300"></span>
                                              <span class="fw-semi-bold">Maternity Leave</span>
                                          </div>
                                          <div class="d-xxl-none">15%</div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-auto position-relative">
                                  <div class="echart-market-share"></div>
                                  <div class="position-absolute top-50 start-50 translate-middle text-1100 fs-7">26M</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100">
                      <div class="card-header d-flex flex-between-center pb-0">
                          <h6 class="mb-0">On Leave Today</h6>
                          <div class="dropdown font-sans-serif btn-reveal-trigger">
                              <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-weather-update" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                  <span class="fas fa-ellipsis-h fs-11"></span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-weather-update">
                                  <a class="dropdown-item" href="#!">View</a>
                                  <a class="dropdown-item" href="#!">Export</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#!">Remove</a>
                              </div>
                          </div>
                      </div>
                      <div class="card-body pt-2">
                          <div class="row g-0 h-100 align-items-center">
                              <div class="col">
                                  <div class="d-flex align-items-center">
                                      <img class="me-3" src="assets/img/icons/leave-icon.png" alt="" height="60"/>
                                      <div>
                                          <h6 class="mb-2">Employees on Leave</h6>
                                          <div class="fs-11 fw-semi-bold">
                                              <div class="text-warning">5 Active</div>
                                              Annual: 3, Sick: 2
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-auto text-center ps-2">
                                  <div class="fs-5 fw-normal font-sans-serif text-primary mb-1 lh-1">5</div>
                                  <div class="fs-10 text-800">Total Today</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="row g-3 mb-3">

            <div class="col-xxl-6 col-xl-12">
              <div class="card py-3">
                <div class="card-body py-3">
                  <div class="row g-0">
                    <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                      <h6 class="pb-1 text-700">Total Employees </h6>
                      <p class="font-sans-serif lh-1 mb-1 fs-8"><?= $employeeCount ?? 0 ?> </p>
                      <div class="d-flex align-items-center">
                        <h6 class="fs-11 text-500 mb-0">+2 </h6>
                        <h6 class="fs-11 ps-3 mb-0 text-primary"><span class="me-1 fas fa-caret-up"></span>21.8%</h6>
                      </div>
                    </div>
                    <div class="col-6 col-md-4 border-200 border-bottom border-end-md pb-4 ps-3">
                      <h6 class="pb-1 text-700">Departments </h6>
                      <p class="font-sans-serif lh-1 mb-1 fs-8">8 </p>
                      <div class="d-flex align-items-center">
                        <h6 class="fs-11 text-500 mb-0">+ 1 </h6>
                        <h6 class="fs-11 ps-3 mb-0 text-warning"><span class="me-1 fas fa-caret-up"></span>21.8%</h6>
                      </div>
                    </div>
                    <div class="col-6 col-md-4 border-200 border-bottom border-end border-end-md-0 pb-4 pt-4 pt-md-0 ps-md-3">
                      <h6 class="pb-1 text-700">Total Leave Records </h6>
                      <p class="font-sans-serif lh-1 mb-1 fs-8">78 </p>
                      <div class="d-flex align-items-center">
                        <h6 class="fs-11 text-500 mb-0">+ 40  </h6>
                        <h6 class="fs-11 ps-3 mb-0 text-success"><span class="me-1 fas fa-caret-up"></span>21.8%</h6>
                      </div>
                    </div>
                    <div class="col-6 col-md-4 border-200 border-bottom border-bottom-md-0 border-end-md pt-4 pb-md-0 ps-3 ps-md-0">
                      <h6 class="pb-1 text-700">Upcoming Holidays  </h6>
                      <p class="font-sans-serif lh-1 mb-1 fs-8">12 </p>
                      <div class="d-flex align-items-center">
                        <h6 class="fs-11 text-500 mb-0">This Year 13</h6>
                        <h6 class="fs-11 ps-3 mb-0 text-danger"><span class="me-1 fas fa-caret-up"></span>21.8%</h6>
                      </div>
                    </div>
                    <div class="col-6 col-md-4 border-200 border-bottom-md-0 border-end pt-4 pb-md-0 ps-md-3">
                      <h6 class="pb-1 text-700">Employee's On Leave </h6>
                      <p class="font-sans-serif lh-1 mb-1 fs-8">78 </p>
                      <div class="d-flex align-items-center">
                        <h6 class="fs-11 text-500 mb-0">Incoming 12 </h6>
                        <h6 class="fs-11 ps-3 mb-0 text-success"><span class="me-1 fas fa-caret-up"></span>21.8%</h6>
                      </div>
                    </div>
                    <div class="col-6 col-md-4 pb-0 pt-4 ps-3">
                      <h6 class="pb-1 text-700">Recorded This Month </h6>
                      <p class="font-sans-serif lh-1 mb-1 fs-8">45 </p>
                      <div class="d-flex align-items-center">
                        <h6 class="fs-11 text-500 mb-0">Last Month 38 </h6>
                        <h6 class="fs-11 ps-3 mb-0 text-info"><span class="me-1 fas fa-caret-up"></span>18.4%</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xxl-6 col-xl-12">
              <div class="card overflow-hidden h-100">
                <div class="card-body p-0 management-calendar">
                  <div class="row g-3">
                    <div class="col-md-7">
                      <div class="p-x1">
                        <div class="d-flex justify-content-between">
                          <div class="order-md-1"><button class="btn btn-sm border me-1 shadow-sm" type="button" data-event="prev" data-bs-toggle="tooltip" title="Previous"><span class="fas fa-chevron-left"></span></button><button class="btn btn-sm text-secondary border px-sm-4 shadow-sm" type="button" data-event="today">Today</button><button class="btn btn-sm border ms-1 shadow-sm" type="button" data-event="next" data-bs-toggle="tooltip" title="Next"><span class="fas fa-chevron-right"></span></button></div><button class="btn btn-sm text-primary border order-md-0 shadow-none" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal"> <span class="fas fa-plus me-2"></span>New Schedule</button>
                        </div>
                      </div><!-- Find the JS file for the following calendar at: src/js/calendar/management-calendar.js--><!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                      <div class="calendar-outline px-3" id="managementAppCalendar" data-calendar-option='{"title":"management-calendar-title","day":"management-calendar-day","events":"management-calendar-events"}'></div>
                    </div>
                    <div class="col-md-5 bg-body-tertiary pt-3">
                      <div class="px-3">
                        <h4 class="mb-0 fs-9 fs-sm-8 fs-lg-7" id="management-calendar-title"></h4>
                        <p class="text-500 mb-0" id="management-calendar-day"></p>
                        <ul class="list-unstyled mt-3 scrollbar management-calendar-events" id="management-calendar-events"></ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="row g-3 mb-3">
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100 ecommerce-card-min-width">
                      <div class="card-header pb-0">
                          <h6 class="mb-0 mt-2 d-flex align-items-center">
                              New Employees This Month
                              <span class="ms-1 text-400" data-bs-toggle="tooltip" data-bs-placement="top" title="Employees who joined this month">
                                  <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                              </span>
                          </h6>
                      </div>
                      <div class="card-body d-flex flex-column justify-content-end">
                          <div class="row">
                              <div class="col">
                                  <p class="font-sans-serif lh-1 mb-1 fs-5">7</p>
                                  <span class="badge badge-subtle-success rounded-pill fs-11">+15%</span>
                              </div>
                              <div class="col-auto ps-0">
                                  <div class="echart-bar-weekly-sales h-100"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100">
                      <div class="card-header pb-0">
                          <h6 class="mb-0 mt-2">Leave Utilization Rate</h6>
                      </div>
                      <div class="card-body d-flex flex-column justify-content-end">
                          <div class="row justify-content-between">
                              <div class="col-auto align-self-end">
                                  <div class="fs-5 fw-normal font-sans-serif text-700 lh-1 mb-1">68%</div>
                                  <span class="badge rounded-pill fs-11 bg-200 text-primary">
                                      <span class="fas fa-caret-up me-1"></span>
                                      5.2%
                                  </span>
                              </div>
                              <div class="col-auto ps-0 mt-n4">
                                  <div class="echart-default-total-order" data-echarts='{"tooltip":{"trigger":"axis","formatter":"{b0} : {c0}"},"xAxis":{"data":["Jan","Feb","Mar","Apr"]},"series":[{"type":"line","data":[60,65,70,68],"smooth":true,"lineStyle":{"width":3}}],"grid":{"bottom":"2%","top":"2%","right":"0","left":"10px"}}' data-echart-responsive="true"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100">
                      <div class="card-body">
                          <div class="row h-100 justify-content-between g-0">
                              <div class="col-5 col-sm-6 col-xxl pe-2">
                                  <h6 class="mt-1">Department Distribution</h6>
                                  <div class="fs-11 mt-3">
                                      <div class="d-flex flex-between-center mb-1">
                                          <div class="d-flex align-items-center">
                                              <span class="dot bg-primary"></span>
                                              <span class="fw-semi-bold">Engineering</span>
                                          </div>
                                          <div class="d-xxl-none">40%</div>
                                      </div>
                                      <div class="d-flex flex-between-center mb-1">
                                          <div class="d-flex align-items-center">
                                              <span class="dot bg-info"></span>
                                              <span class="fw-semi-bold">HR</span>
                                          </div>
                                          <div class="d-xxl-none">25%</div>
                                      </div>
                                      <div class="d-flex flex-between-center mb-1">
                                          <div class="d-flex align-items-center">
                                              <span class="dot bg-300"></span>
                                              <span class="fw-semi-bold">Finance</span>
                                          </div>
                                          <div class="d-xxl-none">20%</div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-auto position-relative">
                                  <div class="echart-market-share"></div>
                                  <div class="position-absolute top-50 start-50 translate-middle text-1100 fs-7">150</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-xxl-3">
                  <div class="card h-md-100">
                      <div class="card-header d-flex flex-between-center pb-0">
                          <h6 class="mb-0">Upcoming Birthdays</h6>
                          <div class="dropdown font-sans-serif btn-reveal-trigger">
                              <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-birthdays" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                  <span class="fas fa-ellipsis-h fs-11"></span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-birthdays">
                                  <a class="dropdown-item" href="#!">View All</a>
                                  <a class="dropdown-item" href="#!">Send Wishes</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#!">Remove</a>
                              </div>
                          </div>
                      </div>
                      <div class="card-body pt-2">
                          <div class="row g-0 h-100 align-items-center">
                              <div class="col">
                                  <div class="d-flex align-items-center">
                                      <img class="me-3" src="assets/img/icons/birthday-icon.png" alt="" height="60"/>
                                      <div>
                                          <h6 class="mb-2">This Week</h6>
                                          <div class="fs-11 fw-semi-bold">
                                              <div class="text-warning">3 Celebrations</div>
                                              John D., Sarah M., Mike R.
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-auto text-center ps-2">
                                  <div class="fs-5 fw-normal font-sans-serif text-primary mb-1 lh-1">3</div>
                                  <div class="fs-10 text-800">This Week</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <h6 class="mb-0">Recent Leave Records</h6>
                    </div>
                    <div class="col-auto">
                      <a href="/leaves" class="btn btn-sm btn-primary">View All</a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-sm mb-0">
                      <thead class="bg-body-tertiary">
                        <tr>
                          <th class="border-0">Employee</th>
                          <th class="border-0">Leave Type</th>
                          <th class="border-0">From Date</th>
                          <th class="border-0">To Date</th>
                          <th class="border-0">Days</th>
                          <th class="border-0">Record Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="avatar avatar-xl me-2">
                                <div class="avatar-name rounded-circle"><span>JD</span></div>
                              </div>
                              <div>
                                <h6 class="mb-0">John Doe</h6>
                                <p class="fs-11 mb-0 text-600">Engineering</p>
                              </div>
                            </div>
                          </td>
                          <td>Annual Leave</td>
                          <td>2026-04-15</td>
                          <td>2026-04-20</td>
                          <td>6</td>
                          <td><span class="badge bg-warning">Awaiting Letter</span></td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="avatar avatar-xl me-2">
                                <div class="avatar-name rounded-circle"><span>SM</span></div>
                              </div>
                              <div>
                                <h6 class="mb-0">Sarah Miller</h6>
                                <p class="fs-11 mb-0 text-600">HR</p>
                              </div>
                            </div>
                          </td>
                          <td>Sick Leave</td>
                          <td>2026-04-10</td>
                          <td>2026-04-12</td>
                          <td>3</td>
                          <td><span class="badge bg-success">Recorded</span></td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="avatar avatar-xl me-2">
                                <div class="avatar-name rounded-circle"><span>MR</span></div>
                              </div>
                              <div>
                                <h6 class="mb-0">Mike Ross</h6>
                                <p class="fs-11 mb-0 text-600">Finance</p>
                              </div>
                            </div>
                          </td>
                          <td>Maternity Leave</td>
                          <td>2026-05-01</td>
                          <td>2026-07-01</td>
                          <td>62</td>
                          <td><span class="badge bg-info">Letter Filed</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row g-3 mb-3">

            <div class="col-xxl-6 col-xl-12">
              <div class="card">
                <div class="card-header">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <h6 class="mb-0">Leave Records Over Time</h6>
                    </div>
                    <div class="col-auto d-flex">
                      <div class="form-check mb-0 d-flex"><input class="form-check-input form-check-input-primary" id="ecommerceLastMonth" type="checkbox" checked="checked" /><label class="form-check-label ps-2 fs-11 text-600 mb-0" for="ecommerceLastMonth">Last Month<span class="text-1100 d-none d-md-inline">: 125 records</span></label></div>
                      <div class="form-check mb-0 d-flex ps-0 ps-md-3"><input class="form-check-input ms-2 form-check-input-warning opacity-75" id="ecommercePrevYear" type="checkbox" checked="checked" /><label class="form-check-label ps-2 fs-11 text-600 mb-0" for="ecommercePrevYear">Prev Year<span class="text-1100 d-none d-md-inline">: 1,450 records</span></label></div>
                    </div>
                    <div class="col-auto">
                      <div class="dropdown font-sans-serif btn-reveal-trigger"><button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-total-sales-ecomm" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs-11"></span></button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-total-sales-ecomm"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                          <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body pe-xxl-0"><!-- Find the JS file for the following chart at: src/js/charts/echarts/total-sales-ecommerce.js--><!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-line-total-sales-ecommerce" data-echart-responsive="true" data-options='{"optionOne":"ecommerceLastMonth","optionTwo":"ecommercePrevYear"}'></div>
                </div>
              </div>
            </div>

          </div> 

          <div class="row g-3 mb-3">

            <div class="col-xxl-6 col-xl-12">
              <div class="card">
                <div class="card-header">
                  <div class="row flex-between-center">
                    <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                      <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Recent Purchases </h5>
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
                        <td class="align-middle white-space-nowrap product">ASUS Chromebook C202SA-YS02 11.6&quot;</td>
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
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-6" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Giovanni Boccaccio</a></td>
                        <td class="align-middle white-space-nowrap email">giovanni@outlook.com</td>
                        <td class="align-middle white-space-nowrap product">Summer Infant Contoured Changing Pad</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-success">Success<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$31</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-6" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-6"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-7" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Oscar Wilde</a></td>
                        <td class="align-middle white-space-nowrap email">oscar@hotmail.com</td>
                        <td class="align-middle white-space-nowrap product">Munchkin 6 Piece Fork and Spoon Set</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-success">Success<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$43</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-7" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-7"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-8" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">John Doe</a></td>
                        <td class="align-middle white-space-nowrap email">doe@gmail.com</td>
                        <td class="align-middle white-space-nowrap product">Falcon - Responsive Dashboard Template</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-success">Success<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$57</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-8" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-8"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-9" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Emma Watson</a></td>
                        <td class="align-middle white-space-nowrap email">emma@gmail.com</td>
                        <td class="align-middle white-space-nowrap product">Apple iPhone XR (64GB)</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-secondary">Blocked<span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$999</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-9" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-9"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-10" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Sylvia Plath</a></td>
                        <td class="align-middle white-space-nowrap email">plath@yahoo.com</td>
                        <td class="align-middle white-space-nowrap product">All-New Fire HD 8 Kids Edition Tablet</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-warning">Pending<span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$199</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-10" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-10"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-11" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Rabindranath Tagore</a></td>
                        <td class="align-middle white-space-nowrap email">Rabindra@gmail.com</td>
                        <td class="align-middle white-space-nowrap product">Apple iPhone XR (64GB)</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-secondary">Blocked<span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$999</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-11" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-11"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-12" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Anila Wilde</a></td>
                        <td class="align-middle white-space-nowrap email">anila@yahoo.com</td>
                        <td class="align-middle white-space-nowrap product">All-New Fire HD 8 Kids Edition Tablet</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-warning">Pending<span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$199</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-12" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-12"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle" style="width: 28px;">
                          <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="simple-pagination-item-13" data-bulk-select-row="data-bulk-select-row" /></div>
                        </td>
                        <td class="align-middle white-space-nowrap fw-semi-bold name"><a href="../../app/e-commerce/customer-details.html">Jack Watson </a></td>
                        <td class="align-middle white-space-nowrap email">Jack@gmail.com</td>
                        <td class="align-middle white-space-nowrap product">Apple iPhone XR (64GB)</td>
                        <td class="align-middle text-center fs-9 white-space-nowrap payment"><span class="badge badge rounded-pill badge-subtle-secondary">Blocked<span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle text-end amount">$999</td>
                        <td class="align-middle white-space-nowrap text-end">
                          <div class="dropstart font-sans-serif position-static d-inline-block"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-simple-pagination-table-item-13" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-simple-pagination-table-item-13"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
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
          
          