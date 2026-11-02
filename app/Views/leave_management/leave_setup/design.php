<?php $currentPage = 'leave_applications_design'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/leaves">Leave</a></li>
    <li class="breadcrumb-item active" aria-current="page">Leave Applications Design</li>
  </ol>
</nav>

<div class="row g-3">

  <!-- ========================================== -->
  <!-- LEFT COLUMN                                -->
  <!-- ========================================== -->
  <div class="col-12 col-xl-7">

    <!-- My Leave (Empty State) Card -->
    <div class="card border-0 shadow">
      <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fs-9 mb-0 fw-bold">My Leave</h5>
        <button class="btn btn-link text-decoration-none text-900 border border-dark rounded-pill btn-sm px-3 py-1 fw-semi-bold" type="button">
          <span data-feather="filter" width="14" height="14" class="me-1" style="margin-top:-2px;"></span>Filter
        </button>
      </div>
      <div class="card-body text-center py-5">
        <div class="text-info mb-3">
          <span data-feather="umbrella" width="54" height="54" style="stroke-width: 1;"></span>
        </div>
        <p class="text-700 mb-1 fs-8 fw-semi-bold">There's no leave to show :(</p>
        <p class="text-500 mb-4 fs-9">Fancy some time off?</p>
        <button class="btn btn-dark rounded-pill btn-sm px-4 py-2" type="button">
          <span data-feather="calendar" width="14" height="14" class="me-2" style="margin-top:-2px;"></span>Book
        </button>
      </div>
    </div>

  </div>

  <!-- ========================================== -->
  <!-- RIGHT COLUMN                               -->
  <!-- ========================================== -->
  <div class="col-12 col-xl-5">

    <!-- The Next 7 Days Card -->
    <div class="card border-0 shadow">
      <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fs-9 mb-0 fw-bold">The Next 7 Days</h5>
        <button class="btn btn-link text-decoration-none text-900 border border-dark rounded-pill btn-sm px-3 py-1 fw-semi-bold" type="button">
          <span data-feather="filter" width="14" height="14" class="me-1" style="margin-top:-2px;"></span>Filter
        </button>
      </div>
      <div class="card-body px-4 pt-2 pb-0">
        
        <!-- Scrollable Container: max-height restricts the height, overflow-y enables scrolling -->
        <div class="scrollbar pe-3 pb-4" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
          <div class="d-flex flex-column gap-3">
            
            <div class="rounded py-2 px-3 fs-10 fw-bold text-uppercase" style="background-color: #e0f2fe; color: #0ea5e9;">
              Sunday 01 Nov 2026
            </div>
            <div class="rounded py-2 px-3 fs-10 fw-bold text-uppercase" style="background-color: #e0f2fe; color: #0ea5e9;">
              Monday 02 Nov 2026
            </div>
            <div class="rounded py-2 px-3 fs-10 fw-bold text-uppercase" style="background-color: #e0f2fe; color: #0ea5e9;">
              Tuesday 03 Nov 2026
            </div>
            <div class="rounded py-2 px-3 fs-10 fw-bold text-uppercase" style="background-color: #e0f2fe; color: #0ea5e9;">
              Wednesday 04 Nov 2026
            </div>
            <div class="rounded py-2 px-3 fs-10 fw-bold text-uppercase" style="background-color: #e0f2fe; color: #0ea5e9;">
              Thursday 05 Nov 2026
            </div>
            <div class="rounded py-2 px-3 fs-10 fw-bold text-uppercase" style="background-color: #e0f2fe; color: #0ea5e9;">
              Friday 06 Nov 2026
            </div>
            <div class="rounded py-2 px-3 fs-10 fw-bold text-uppercase" style="background-color: #e0f2fe; color: #0ea5e9;">
              Saturday 07 Nov 2026
            </div>
            <!-- Add more items here to test the scroll -->

          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- ============================================================ -->
<!-- ORIGINAL TABLE / MODAL BLOCKS — COMMENTED OUT AS REQUESTED   -->
<!-- ============================================================ -->
<!--
<div class="col-md-12 col-xxl-8 mb-3">
  ... (Deal Forecast card) ...
</div>

<div class="col-12 mb-3">
  ... (Recent Applications table) ...
</div>

<div class="card border-0 shadow mb-3">
  ... (Empty entitlements card) ...
</div>

<div class="col-12 mb-3">
  ... (List group card) ...
</div>

<div class="card mb-3">
  ... (Table Example card with tabs) ...
</div>
-->