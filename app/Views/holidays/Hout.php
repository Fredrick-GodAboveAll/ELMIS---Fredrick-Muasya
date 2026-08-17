<?php $currentPage = 'HoutPage'; ?>

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
                                    <!-- TODO: replace static links below with a loop over holiday lists once wired to HolidaysController -->
                                    <a href="#!">New Holiday List</a>
                                </div>
                                <div>
                                    <a href="#!">2026 Holiday List</a>
                                </div>
                                <div>
                                    <a href="#!">2025 Holiday List</a>
                                </div>
                                <div>
                                    <a href="#!">Optional Holidays</a>
                                </div>
                                <div>
                                    <a href="#!">Special/Ad-hoc Holidays</a>
                                </div>
                                <div>
                                    <a href="#!">Archived Holiday Lists</a>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>