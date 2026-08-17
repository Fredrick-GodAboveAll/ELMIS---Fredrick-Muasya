<?php $currentPage = 'analytics'; ?>


<div class="col-xxl-9">
              <div class="card" id="ticketsTable">
                <div class="card-header border-bottom border-200 px-0">
                  <div class="d-lg-flex justify-content-between">
                    <div class="row flex-between-center gy-2 px-x1">
                      <div class="col-auto pe-0">
                        <h6 class="mb-0">Unsolved Tickets</h6>
                      </div>
                      <div class="col-auto">
                        <form>
                          <div class="input-group input-search-width"><input class="form-control form-control-sm shadow-none" type="search" placeholder="Search  by name" aria-label="search"><button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary"><svg class="svg-inline--fa fa-search fa-w-16 fs-10" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg><!-- <span class="fa fa-search fs-10"></span> Font Awesome fontawesome.com --></button></div>
                        </form>
                      </div>
                    </div>
                    <div class="border-bottom border-200 my-3"></div>
                    <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1"><button class="btn btn-sm btn-falcon-default" type="button"><svg class="svg-inline--fa fa-filter fa-w-16" data-fa-transform="shrink-4 down-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="filter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5625em;"><g transform="translate(256 256)"><g transform="translate(0, 32)  scale(0.75, 0.75)  rotate(0 0 0)"><path fill="currentColor" d="M487.976 0H24.028C2.71 0-8.047 25.866 7.058 40.971L192 225.941V432c0 7.831 3.821 15.17 10.237 19.662l80 55.98C298.02 518.69 320 507.493 320 487.98V225.941l184.947-184.97C520.021 25.896 509.338 0 487.976 0z" transform="translate(-256 -256)"></path></g></g></svg><!-- <span class="fas fa-filter" data-fa-transform="shrink-4 down-1"></span> Font Awesome fontawesome.com --><span class="ms-1 d-none d-sm-inline-block">Filter</span></button>
                      <div class="bg-300 mx-3 d-none d-lg-block" style="width:1px; height:29px"></div>
                      <div class="d-none" id="table-ticket-actions">
                        <div class="d-flex"><select class="form-select form-select-sm" aria-label="Bulk actions">
                            <option selected="">Bulk actions</option>
                            <option value="Refund">Refund</option>
                            <option value="Delete">Delete</option>
                            <option value="Archive">Archive</option>
                          </select><button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button></div>
                      </div>
                      <div class="d-flex align-items-center" id="table-ticket-replace-element">
                        <div class="dropdown"><button class="btn btn-sm btn-falcon-default dropdown-toggle dropdown-caret-none" type="button" id="dashboard-layout" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block me-1 table-layout">Table View</span><svg class="svg-inline--fa fa-chevron-down fa-w-14" data-fa-transform="shrink-3 down-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.5625em;"><g transform="translate(224 256)"><g transform="translate(0, 32)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fas fa-chevron-down" data-fa-transform="shrink-3 down-1"></span> Font Awesome fontawesome.com --></button>
                          <div class="dropdown-menu dropdown-toggle-item dropdown-menu-end border py-2" aria-labelledby="dashboard-layout" role="tablist" style=""><a class="dropdown-item active" id="tableView" data-bs-toggle="tab" href="#table-view" role="tab" aria-controls="table-view" aria-selected="true">Table View</a><a class="dropdown-item" id="cardView" data-bs-toggle="tab" href="#card-view" role="tab" aria-controls="card-view" aria-selected="false" tabindex="-1">Card View</a></div>
                        </div><button class="btn btn-falcon-default btn-sm mx-2" type="button"><svg class="svg-inline--fa fa-plus fa-w-14" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;"><g transform="translate(224 256)"><g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fas fa-plus" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com --><span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">New</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button"><svg class="svg-inline--fa fa-external-link-alt fa-w-16" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="external-link-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;"><g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M432,320H400a16,16,0,0,0-16,16V448H64V128H208a16,16,0,0,0,16-16V80a16,16,0,0,0-16-16H48A48,48,0,0,0,0,112V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V336A16,16,0,0,0,432,320ZM488,0h-128c-21.37,0-32.05,25.91-17,41l35.73,35.73L135,320.37a24,24,0,0,0,0,34L157.67,377a24,24,0,0,0,34,0L435.28,133.32,471,169c15,15,41,4.5,41-17V24A24,24,0,0,0,488,0Z" transform="translate(-256 -256)"></path></g></g></svg><!-- <span class="fas fa-external-link-alt" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com --><span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">Export</span></button>
                        <div class="dropdown font-sans-serif ms-2"><button class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none" type="button" id="preview-dropdown" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><svg class="svg-inline--fa fa-ellipsis-h fa-w-16 fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis-h" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"></path></svg><!-- <span class="fas fa-ellipsis-h fs-11"></span> Font Awesome fontawesome.com --></button>
                          <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="preview-dropdown" style=""><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-content" id="ticketViewContent">
                  <div class="fade tab-pane active show" id="table-view" role="tabpanel" aria-labelledby="tableView" data-list="{&quot;valueNames&quot;:[&quot;client&quot;,&quot;subject&quot;,&quot;status&quot;,&quot;priority&quot;,&quot;agent&quot;],&quot;page&quot;:6,&quot;pagination&quot;:true}">
                    <div class="card-body p-0">
                      <div class="table-responsive scrollbar">
                        <table class="table table-sm mb-0 fs-10 table-view-tickets">
                          <thead class="bg-body-tertiary">
                            <tr>
                              <th class="py-2 fs-9 pe-2" style="width: 28px;">
                                <div class="form-check d-flex align-items-center"><input class="form-check-input" id="checkbox-bulk-table-tickets-select" type="checkbox" data-bulk-select="{&quot;body&quot;:&quot;table-ticket-body&quot;,&quot;actions&quot;:&quot;table-ticket-actions&quot;,&quot;replacedElement&quot;:&quot;table-ticket-replace-element&quot;}"></div>
                              </th>
                              <th class="text-800 sort align-middle ps-2" data-sort="client">Client</th>
                              <th class="text-800 sort align-middle" data-sort="subject" style="min-width:15.625rem">Subject</th>
                              <th class="text-800 sort align-middle" data-sort="status">Status</th>
                              <th class="text-800 sort align-middle" data-sort="priority">Priority</th>
                              <th class="text-800 sort align-middle text-end" data-sort="agent">Agent</th>
                            </tr>
                          </thead>
                          <tbody class="list" id="table-ticket-body"><tr>
                              <td class="align-middle fs-9 py-3">
                                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="table-view-tickets-0" data-bulk-select-row="data-bulk-select-row"></div>
                              </td>
                              <td class="align-middle client white-space-nowrap pe-3 pe-xxl-4 ps-2">
                                <div class="d-flex align-items-center gap-2 position-relative">
                                  <div class="avatar avatar-xl">
                                    <div class="avatar-name rounded-circle"><span>EW</span></div>
                                  </div>
                                  <h6 class="mb-0"><a class="stretched-link text-900" href="../app/support-desk/contact-details.html">Emma Watson</a></h6>
                                </div>
                              </td>
                              <td class="align-middle subject py-2 pe-4"><a class="fw-semi-bold" href="../app/support-desk/tickets-preview.html">Synapse Design #1125</a></td>
                              <td class="align-middle status fs-9 pe-4"><small class="badge rounded badge-subtle-success false">Recent</small></td>
                              <td class="align-middle priority pe-4">
                                <div class="d-flex align-items-center gap-2">
                                  <div style="--falcon-circle-progress-bar:100"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                      <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                      <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#e63757" stroke-width="12"></circle>
                                    </svg></div>
                                  <h6 class="mb-0 text-700">Urgent</h6>
                                </div>
                              </td>
                              <td class="align-middle agent"><select class="form-select form-select-sm w-auto ms-auto" aria-label="agents actions">
                                  <option>Select Agent</option>
                                  <option selected="selected">Anindya</option>
                                  <option>Nowrin</option>
                                  <option>Khalid</option>
                                </select></td>
                            </tr><tr>
                              <td class="align-middle fs-9 py-3">
                                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="table-view-tickets-1" data-bulk-select-row="data-bulk-select-row"></div>
                              </td>
                              <td class="align-middle client white-space-nowrap pe-3 pe-xxl-4 ps-2">
                                <div class="d-flex align-items-center gap-2 position-relative">
                                  <div class="avatar avatar-xl">
                                    <div class="avatar-name rounded-circle"><span>L</span></div>
                                  </div>
                                  <h6 class="mb-0"><a class="stretched-link text-900" href="../app/support-desk/contact-details.html">Luke</a></h6>
                                </div>
                              </td>
                              <td class="align-middle subject py-2 pe-4"><a class="fw-semi-bold" href="../app/support-desk/tickets-preview.html">Change of refund my last buy | Order #125631</a></td>
                              <td class="align-middle status fs-9 pe-4"><small class="badge rounded badge-subtle-danger false">Overdue</small></td>
                              <td class="align-middle priority pe-4">
                                <div class="d-flex align-items-center gap-2">
                                  <div style="--falcon-circle-progress-bar:75"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                      <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                      <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#F68F57" stroke-width="12"></circle>
                                    </svg></div>
                                  <h6 class="mb-0 text-700">High</h6>
                                </div>
                              </td>
                              <td class="align-middle agent"><select class="form-select form-select-sm w-auto ms-auto" aria-label="agents actions">
                                  <option>Select Agent</option>
                                  <option selected="selected">Anindya</option>
                                  <option>Nowrin</option>
                                  <option>Khalid</option>
                                </select></td>
                            </tr><tr>
                              <td class="align-middle fs-9 py-3">
                                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="table-view-tickets-2" data-bulk-select-row="data-bulk-select-row"></div>
                              </td>
                              <td class="align-middle client white-space-nowrap pe-3 pe-xxl-4 ps-2">
                                <div class="d-flex align-items-center gap-2 position-relative">
                                  <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="../assets/img/team/1-thumb.png" alt="">
                                  </div>
                                  <h6 class="mb-0"><a class="stretched-link text-900" href="../app/support-desk/contact-details.html">Finley</a></h6>
                                </div>
                              </td>
                              <td class="align-middle subject py-2 pe-4"><a class="fw-semi-bold" href="../app/support-desk/tickets-preview.html">I need your help #2256</a></td>
                              <td class="align-middle status fs-9 pe-4"><small class="badge rounded badge-subtle-warning false">Remaining</small></td>
                              <td class="align-middle priority pe-4">
                                <div class="d-flex align-items-center gap-2">
                                  <div style="--falcon-circle-progress-bar:50"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                      <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                      <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#2A7BE4" stroke-width="12"></circle>
                                    </svg></div>
                                  <h6 class="mb-0 text-700">Medium</h6>
                                </div>
                              </td>
                              <td class="align-middle agent"><select class="form-select form-select-sm w-auto ms-auto" aria-label="agents actions">
                                  <option>Select Agent</option>
                                  <option>Anindya</option>
                                  <option selected="selected">Nowrin</option>
                                  <option>Khalid</option>
                                </select></td>
                            </tr><tr>
                              <td class="align-middle fs-9 py-3">
                                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="table-view-tickets-3" data-bulk-select-row="data-bulk-select-row"></div>
                              </td>
                              <td class="align-middle client white-space-nowrap pe-3 pe-xxl-4 ps-2">
                                <div class="d-flex align-items-center gap-2 position-relative">
                                  <div class="avatar avatar-xl">
                                    <div class="avatar-name rounded-circle"><span>PG</span></div>
                                  </div>
                                  <h6 class="mb-0"><a class="stretched-link text-900" href="../app/support-desk/contact-details.html">Peter Gill</a></h6>
                                </div>
                              </td>
                              <td class="align-middle subject py-2 pe-4"><a class="fw-semi-bold" href="../app/support-desk/tickets-preview.html">I need your help #2256</a></td>
                              <td class="align-middle status fs-9 pe-4"><small class="badge rounded badge-subtle-info false">Responded</small></td>
                              <td class="align-middle priority pe-4">
                                <div class="d-flex align-items-center gap-2">
                                  <div style="--falcon-circle-progress-bar:25"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                      <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                      <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#00D27B" stroke-width="12"></circle>
                                    </svg></div>
                                  <h6 class="mb-0 text-700">Low</h6>
                                </div>
                              </td>
                              <td class="align-middle agent"><select class="form-select form-select-sm w-auto ms-auto" aria-label="agents actions">
                                  <option>Select Agent</option>
                                  <option>Anindya</option>
                                  <option selected="selected">Nowrin</option>
                                  <option>Khalid</option>
                                </select></td>
                            </tr><tr>
                              <td class="align-middle fs-9 py-3">
                                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="table-view-tickets-4" data-bulk-select-row="data-bulk-select-row"></div>
                              </td>
                              <td class="align-middle client white-space-nowrap pe-3 pe-xxl-4 ps-2">
                                <div class="d-flex align-items-center gap-2 position-relative">
                                  <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="../assets/img/team/25-thumb.png" alt="">
                                  </div>
                                  <h6 class="mb-0"><a class="stretched-link text-900" href="../app/support-desk/contact-details.html">Freya</a></h6>
                                </div>
                              </td>
                              <td class="align-middle subject py-2 pe-4"><a class="fw-semi-bold" href="../app/support-desk/tickets-preview.html">Contact Froms #3264</a></td>
                              <td class="align-middle status fs-9 pe-4"><small class="badge rounded badge-subtle-secondary dark__bg-1000">Closed</small></td>
                              <td class="align-middle priority pe-4">
                                <div class="d-flex align-items-center gap-2">
                                  <div style="--falcon-circle-progress-bar:50"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                      <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                      <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#2A7BE4" stroke-width="12"></circle>
                                    </svg></div>
                                  <h6 class="mb-0 text-700">Medium</h6>
                                </div>
                              </td>
                              <td class="align-middle agent"><select class="form-select form-select-sm w-auto ms-auto" aria-label="agents actions">
                                  <option>Select Agent</option>
                                  <option>Anindya</option>
                                  <option>Nowrin</option>
                                  <option selected="selected">Khalid</option>
                                </select></td>
                            </tr><tr>
                              <td class="align-middle fs-9 py-3">
                                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="table-view-tickets-5" data-bulk-select-row="data-bulk-select-row"></div>
                              </td>
                              <td class="align-middle client white-space-nowrap pe-3 pe-xxl-4 ps-2">
                                <div class="d-flex align-items-center gap-2 position-relative">
                                  <div class="avatar avatar-xl">
                                    <div class="avatar-name rounded-circle"><span>M</span></div>
                                  </div>
                                  <h6 class="mb-0"><a class="stretched-link text-900" href="../app/support-desk/contact-details.html">Morrison</a></h6>
                                </div>
                              </td>
                              <td class="align-middle subject py-2 pe-4"><a class="fw-semi-bold" href="../app/support-desk/tickets-preview.html">I need your help #2256</a></td>
                              <td class="align-middle status fs-9 pe-4"><small class="badge rounded badge-subtle-info false">Responded</small></td>
                              <td class="align-middle priority pe-4">
                                <div class="d-flex align-items-center gap-2">
                                  <div style="--falcon-circle-progress-bar:50"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                      <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                      <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#2A7BE4" stroke-width="12"></circle>
                                    </svg></div>
                                  <h6 class="mb-0 text-700">Medium</h6>
                                </div>
                              </td>
                              <td class="align-middle agent"><select class="form-select form-select-sm w-auto ms-auto" aria-label="agents actions">
                                  <option>Select Agent</option>
                                  <option>Anindya</option>
                                  <option>Nowrin</option>
                                  <option selected="selected">Khalid</option>
                                </select></td>
                            </tr></tbody>
                        </table>
                        <div class="text-center d-none" id="tickets-table-fallback">
                          <p class="fw-bold fs-8 mt-3">No ticket found</p>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="row align-items-center">
                        <div class="pagination d-none"><li class="active"><button class="page" type="button" data-i="1" data-page="6">1</button></li><li><button class="page" type="button" data-i="2" data-page="6">2</button></li></div>
                        <div class="col"><span class="d-none d-sm-inline-block me-2 fs-10" data-list-info="data-list-info">1 to 6 of 12</span></div>
                        <div class="col-auto d-flex"><button class="btn btn-sm btn-primary disabled" type="button" data-list-pagination="prev" disabled=""><span>Previous</span></button>
                          <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="fade tab-pane" id="card-view" role="tabpanel" aria-labelledby="cardView" data-list="{&quot;valueNames&quot;:[&quot;client&quot;,&quot;subject&quot;,&quot;status&quot;,&quot;priority&quot;,&quot;agent&quot;],&quot;page&quot;:4,&quot;pagination&quot;:true}">
                    <div class="card-body p-0">
                      <div class="form-check d-none"><input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox" data-bulk-select="{&quot;body&quot;:&quot;card-ticket-body&quot;,&quot;actions&quot;:&quot;table-ticket-actions&quot;,&quot;replacedElement&quot;:&quot;table-ticket-replace-element&quot;}"></div>
                      <div class="list bg-body-tertiary p-x1 d-flex flex-column gap-3" id="card-ticket-body"><div class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                          <div class="d-flex align-items-start align-items-sm-center">
                            <div class="form-check me-2 me-xxl-3 mb-0"><input class="form-check-input" type="checkbox" id="card-view-tickets-0" data-bulk-select-row="data-bulk-select-row"></div><a class="d-none d-sm-block" href="../app/support-desk/contact-details.html">
                              <div class="avatar avatar-xl avatar-3xl">
                                <div class="avatar-name rounded-circle"><span>EW</span></div>
                              </div>
                            </a>
                            <div class="ms-1 ms-sm-3">
                              <p class="fw-semi-bold mb-3 mb-sm-2"><a href="../app/support-desk/tickets-preview.html">Synapse Design #1125</a></p>
                              <div class="row align-items-center gx-0 gy-2">
                                <div class="col-auto me-2">
                                  <h6 class="client mb-0"><a class="text-800 d-flex align-items-center gap-1" href="../app/support-desk/contact-details.html"><svg class="svg-inline--fa fa-user fa-w-14" data-fa-transform="shrink-3 up-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.4375em;"><g transform="translate(224 256)"><g transform="translate(0, -32)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span> Font Awesome fontawesome.com --><span>Emma Watson</span></a></h6>
                                </div>
                                <div class="col-auto lh-1 me-3"><small class="badge rounded badge-subtle-success false">Recent</small></div>
                                <div class="col-auto">
                                  <h6 class="mb-0 text-500">2d ago</h6>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="border-bottom mt-4 mb-x1"></div>
                          <div class="d-flex justify-content-between ms-auto">
                            <div class="d-flex align-items-center gap-2 ms-md-4 ms-xl-0" style="width:7.5rem;">
                              <div style="--falcon-circle-progress-bar:100"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                  <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                  <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#e63757" stroke-width="12"></circle>
                                </svg></div>
                              <h6 class="mb-0 text-700">Urgent</h6>
                            </div><select class="form-select form-select-sm" aria-label="agents actions" style="width:9.375rem;">
                              <option>Select Agent</option>
                              <option selected="selected">Anindya</option>
                              <option>Nowrin</option>
                              <option>Khalid</option>
                            </select>
                          </div>
                        </div><div class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                          <div class="d-flex align-items-start align-items-sm-center">
                            <div class="form-check me-2 me-xxl-3 mb-0"><input class="form-check-input" type="checkbox" id="card-view-tickets-1" data-bulk-select-row="data-bulk-select-row"></div><a class="d-none d-sm-block" href="../app/support-desk/contact-details.html">
                              <div class="avatar avatar-xl avatar-3xl">
                                <div class="avatar-name rounded-circle"><span>L</span></div>
                              </div>
                            </a>
                            <div class="ms-1 ms-sm-3">
                              <p class="fw-semi-bold mb-3 mb-sm-2"><a href="../app/support-desk/tickets-preview.html">Change of refund my last buy | Order #125631</a></p>
                              <div class="row align-items-center gx-0 gy-2">
                                <div class="col-auto me-2">
                                  <h6 class="client mb-0"><a class="text-800 d-flex align-items-center gap-1" href="../app/support-desk/contact-details.html"><svg class="svg-inline--fa fa-user fa-w-14" data-fa-transform="shrink-3 up-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.4375em;"><g transform="translate(224 256)"><g transform="translate(0, -32)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span> Font Awesome fontawesome.com --><span>Luke</span></a></h6>
                                </div>
                                <div class="col-auto lh-1 me-3"><small class="badge rounded badge-subtle-danger false">Overdue</small></div>
                                <div class="col-auto">
                                  <h6 class="mb-0 text-500">2d ago</h6>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="border-bottom mt-4 mb-x1"></div>
                          <div class="d-flex justify-content-between ms-auto">
                            <div class="d-flex align-items-center gap-2 ms-md-4 ms-xl-0" style="width:7.5rem;">
                              <div style="--falcon-circle-progress-bar:75"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                  <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                  <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#F68F57" stroke-width="12"></circle>
                                </svg></div>
                              <h6 class="mb-0 text-700">High</h6>
                            </div><select class="form-select form-select-sm" aria-label="agents actions" style="width:9.375rem;">
                              <option>Select Agent</option>
                              <option selected="selected">Anindya</option>
                              <option>Nowrin</option>
                              <option>Khalid</option>
                            </select>
                          </div>
                        </div><div class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                          <div class="d-flex align-items-start align-items-sm-center">
                            <div class="form-check me-2 me-xxl-3 mb-0"><input class="form-check-input" type="checkbox" id="card-view-tickets-2" data-bulk-select-row="data-bulk-select-row"></div><a class="d-none d-sm-block" href="../app/support-desk/contact-details.html">
                              <div class="avatar avatar-xl avatar-3xl">
                                <img class="rounded-circle" src="../assets/img/team/1-thumb.png" alt="">
                              </div>
                            </a>
                            <div class="ms-1 ms-sm-3">
                              <p class="fw-semi-bold mb-3 mb-sm-2"><a href="../app/support-desk/tickets-preview.html">I need your help #2256</a></p>
                              <div class="row align-items-center gx-0 gy-2">
                                <div class="col-auto me-2">
                                  <h6 class="client mb-0"><a class="text-800 d-flex align-items-center gap-1" href="../app/support-desk/contact-details.html"><svg class="svg-inline--fa fa-user fa-w-14" data-fa-transform="shrink-3 up-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.4375em;"><g transform="translate(224 256)"><g transform="translate(0, -32)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span> Font Awesome fontawesome.com --><span>Finley</span></a></h6>
                                </div>
                                <div class="col-auto lh-1 me-3"><small class="badge rounded badge-subtle-warning false">Remaining</small></div>
                                <div class="col-auto">
                                  <h6 class="mb-0 text-500">2d ago</h6>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="border-bottom mt-4 mb-x1"></div>
                          <div class="d-flex justify-content-between ms-auto">
                            <div class="d-flex align-items-center gap-2 ms-md-4 ms-xl-0" style="width:7.5rem;">
                              <div style="--falcon-circle-progress-bar:50"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                  <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                  <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#2A7BE4" stroke-width="12"></circle>
                                </svg></div>
                              <h6 class="mb-0 text-700">Medium</h6>
                            </div><select class="form-select form-select-sm" aria-label="agents actions" style="width:9.375rem;">
                              <option>Select Agent</option>
                              <option>Anindya</option>
                              <option selected="selected">Nowrin</option>
                              <option>Khalid</option>
                            </select>
                          </div>
                        </div><div class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                          <div class="d-flex align-items-start align-items-sm-center">
                            <div class="form-check me-2 me-xxl-3 mb-0"><input class="form-check-input" type="checkbox" id="card-view-tickets-3" data-bulk-select-row="data-bulk-select-row"></div><a class="d-none d-sm-block" href="../app/support-desk/contact-details.html">
                              <div class="avatar avatar-xl avatar-3xl">
                                <div class="avatar-name rounded-circle"><span>PG</span></div>
                              </div>
                            </a>
                            <div class="ms-1 ms-sm-3">
                              <p class="fw-semi-bold mb-3 mb-sm-2"><a href="../app/support-desk/tickets-preview.html">I need your help #2256</a></p>
                              <div class="row align-items-center gx-0 gy-2">
                                <div class="col-auto me-2">
                                  <h6 class="client mb-0"><a class="text-800 d-flex align-items-center gap-1" href="../app/support-desk/contact-details.html"><svg class="svg-inline--fa fa-user fa-w-14" data-fa-transform="shrink-3 up-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.4375em;"><g transform="translate(224 256)"><g transform="translate(0, -32)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span> Font Awesome fontawesome.com --><span>Peter Gill</span></a></h6>
                                </div>
                                <div class="col-auto lh-1 me-3"><small class="badge rounded badge-subtle-info false">Responded</small></div>
                                <div class="col-auto">
                                  <h6 class="mb-0 text-500">2d ago</h6>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="border-bottom mt-4 mb-x1"></div>
                          <div class="d-flex justify-content-between ms-auto">
                            <div class="d-flex align-items-center gap-2 ms-md-4 ms-xl-0" style="width:7.5rem;">
                              <div style="--falcon-circle-progress-bar:25"><svg class="circle-progress-svg" width="26" height="26" viewBox="0 0 120 120">
                                  <circle class="progress-bar-rail" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke-width="12"></circle>
                                  <circle class="progress-bar-top" cx="60" cy="60" r="54" fill="none" stroke-linecap="round" stroke="#00D27B" stroke-width="12"></circle>
                                </svg></div>
                              <h6 class="mb-0 text-700">Low</h6>
                            </div><select class="form-select form-select-sm" aria-label="agents actions" style="width:9.375rem;">
                              <option>Select Agent</option>
                              <option>Anindya</option>
                              <option selected="selected">Nowrin</option>
                              <option>Khalid</option>
                            </select>
                          </div>
                        </div></div>
                      <div class="text-center d-none" id="tickets-card-fallback">
                        <p class="fw-bold fs-8 mt-3">No ticket found</p>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="row align-items-center">
                        <div class="pagination d-none"><li class="active"><button class="page" type="button" data-i="1" data-page="4">1</button></li><li><button class="page" type="button" data-i="2" data-page="4">2</button></li></div>
                        <div class="col"><span class="d-none d-sm-inline-block me-2 fs-10" data-list-info="data-list-info">1 to 4 of 8</span></div>
                        <div class="col-auto d-flex"><button class="btn btn-sm btn-primary disabled" type="button" data-list-pagination="prev" disabled=""><span>Previous</span></button>
                          <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
