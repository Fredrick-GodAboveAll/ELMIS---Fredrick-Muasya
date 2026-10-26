<?php $currentPage = 'employee_design'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/employees">Employees</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
  </ol>
</nav>

<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="card shadow border-0" style="height: 650px;">
      
      <div class="card-body p-0 d-flex flex-column h-100">
        
        <!-- Top Section: Fixed Header & Toolbar -->
        <div class="p-4 border-bottom flex-shrink-0">
          
          <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-4">
            <div>
              <h1 class="h5 fw-bold mb-1">Employee Categories</h1>
              <p class="text-600 fs--1 mb-0">Classify staff by employment terms, status, and organisational grouping.</p>
            </div>
          </div>

          <!-- Filter & Sort Toolbar -->
          <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
            
            <!-- Left Side: Search Box + Choices Single Select -->
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 align-items-center">
              
              <div class="w-100" style="max-width: 250px;">
                <input id="appSearchInput" class="form-control" type="search" placeholder="Search categories..." aria-label="Search" />
              </div>

              <div style="min-width: 180px;">
                <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle" data-options='{"removeItemButton":true,"placeholder":true}'>
                  <option value="">All Categories</option>
                  <option>Employment Terms</option>
                  <option>Employment Status</option>
                  <option>Confirmation Status</option>
                  <option>Gender</option>
                  <option>Special Need</option>
                  <option>Job Group</option>
                  <option>Department</option>
                </select>
              </div>
            </div>

            <!-- Right Side: View Toggle & Sort Button -->
            <div class="d-flex align-items-center gap-2">
              <!-- View Toggle -->
              <div class="btn-group" role="group" aria-label="View toggle">
                <button type="button" class="btn btn-sm btn-falcon-default active" id="btn-card-view" title="Card View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </button>
                <button type="button" class="btn btn-sm btn-falcon-default" id="btn-list-view" title="List View">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </button>
              </div>

              <!-- Sort Button -->
              <button type="button" class="btn btn-sm btn-falcon-default rounded-1 d-flex align-items-center gap-2 px-2">
                <span style="pointer-events: none;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 5H3"></path><path d="M12 19H3"></path><path d="M14 3v4"></path><path d="M16 17v4"></path><path d="M21 12h-9"></path><path d="M21 19h-5"></path><path d="M21 5h-7"></path><path d="M8 10v4"></path><path d="M8 12H3"></path></svg>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"></path></svg>
              </button>
            </div>
          </div>
        </div> <!-- End Fixed Top Section -->

        <!-- Scrollable Bottom Section -->
        <div class="flex-grow-1 overflow-y-auto p-4 d-flex flex-column">
          
          <!-- Cards Container -->
          <div class="row g-3" id="appCardsContainer">
            
            <!-- Card 1: Employment Terms -->
            <div class="col-sm-6 col-lg-4 app-card" data-name="Employment Terms">
              <div class="card h-100 border">
                <div class="card-body p-3 d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center justify-content-center text-body" style="width: 36px; height: 36px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <button class="btn btn-sm btn-falcon-default rounded-1 me-1 mb-1" type="button">Configure</button>
                  </div>
                  <h6 class="fw-bold mb-1">Employment Terms</h6>
                  <p class="text-500 fs--3 lh-base mb-0">Manage contract types.</p>
                  
                  <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                    <span class="badge badge-subtle-info fw-normal">3 employees</span>
                    <button type="button" class="btn border-0 p-0 text-body-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 2: Employment Status -->
            <div class="col-sm-6 col-lg-4 app-card" data-name="Employment Status">
              <div class="card h-100 border">
                <div class="card-body p-3 d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center justify-content-center text-body" style="width: 36px; height: 36px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                    </div>
                    <button class="btn btn-sm btn-falcon-success rounded-1 me-1 mb-1" type="button" disabled>Configured</button>
                  </div>
                  <h6 class="fw-bold mb-1">Employment Status</h6>
                  <p class="text-500 fs--3 lh-base mb-0">Track employee lifecycle.</p>
                  
                  <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                    <span class="badge badge-subtle-info fw-normal">5 employees</span>
                    <button type="button" class="btn border-0 p-0 text-body-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 3: Gender -->
            <div class="col-sm-6 col-lg-4 app-card" data-name="Gender">
              <div class="card h-100 border">
                <div class="card-body p-3 d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center justify-content-center text-body" style="width: 36px; height: 36px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <button class="btn btn-sm btn-falcon-default rounded-1 me-1 mb-1" type="button">Configure</button>
                  </div>
                  <h6 class="fw-bold mb-1">Gender</h6>
                  <p class="text-500 fs--3 lh-base mb-0">Maintain identity options.</p>
                  
                  <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                    <span class="badge badge-subtle-info fw-normal">2 employees</span>
                    <button type="button" class="btn border-0 p-0 text-body-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 4: Special Need -->
            <div class="col-sm-6 col-lg-4 app-card" data-name="Special Need">
              <div class="card h-100 border">
                <div class="card-body p-3 d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center justify-content-center text-body" style="width: 36px; height: 36px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </div>
                    <button class="btn btn-sm btn-falcon-default rounded-1 me-1 mb-1" type="button">Configure</button>
                  </div>
                  <h6 class="fw-bold mb-1">Special Need</h6>
                  <p class="text-500 fs--3 lh-base mb-0">Record accommodations needed.</p>
                  
                  <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                    <span class="badge badge-subtle-info fw-normal">4 employees</span>
                    <button type="button" class="btn border-0 p-0 text-body-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 5: Job Group -->
            <div class="col-sm-6 col-lg-4 app-card" data-name="Job Group">
              <div class="card h-100 border">
                <div class="card-body p-3 d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center justify-content-center text-body" style="width: 36px; height: 36px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    </div>
                    <button class="btn btn-sm btn-falcon-success rounded-1 me-1 mb-1" type="button" disabled>Configured</button>
                  </div>
                  <h6 class="fw-bold mb-1">Job Group</h6>
                  <p class="text-500 fs--3 lh-base mb-0">Organize job groups.</p>
                  
                  <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                    <span class="badge badge-subtle-info fw-normal">6 employees</span>
                    <button type="button" class="btn border-0 p-0 text-body-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 6: Department -->
            <div class="col-sm-6 col-lg-4 app-card" data-name="Department">
              <div class="card h-100 border">
                <div class="card-body p-3 d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center justify-content-center text-body" style="width: 36px; height: 36px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    </div>
                    <button class="btn btn-sm btn-falcon-success rounded-1 me-1 mb-1" type="button" disabled>Configured</button>
                  </div>
                  <h6 class="fw-bold mb-1">Department</h6>
                  <p class="text-500 fs--3 lh-base mb-0">Setup company departments.</p>
                  
                  <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                    <span class="badge badge-subtle-info fw-normal">5 employees</span>
                    <button type="button" class="btn border-0 p-0 text-body-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>

          </div> <!-- End Cards Row -->

          <!-- List View Container (Hidden by default) -->
          <div id="listViewContainer" class="d-none">
            <ul class="list-group list-group-flush" id="listViewBody">
              <!-- List items will be generated by JS -->
            </ul>
          </div>

          <!-- Empty State: Centered -->
          <div id="noResultsMessage" class="text-center flex-grow-1 d-flex flex-column justify-content-center align-items-center d-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-300 mb-3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
            <h5 class="fw-bold text-600">No categories found</h5>
            <p class="text-500 fs--1 mb-0">The search gremlins are hungry. Try a different term!</p>
          </div>

        </div> <!-- End Scrollable Section -->
        
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg mt-6" role="document">
    <div class="modal-content border-0">
      <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body p-0">
        <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
          <h4 class="mb-1" id="staticBackdropLabel">Add a new illustration to the landing page</h4>
          <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p>
        </div>
        <div class="p-4">
          <div class="row">
            <div class="col-lg-9">
              <div class="d-flex"><span class="fa-stack ms-n1 me-3"><i class="fas fa-circle fa-stack-2x text-200"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-tag" data-fa-transform="shrink-2"></i></span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Labels</h5>
                  <div class="d-flex"><span class="badge me-1 py-2 badge-subtle-success">New</span><span class="badge me-1 py-2 badge-subtle-primary">Goal</span><span class="badge me-1 py-2 badge-subtle-info">Enhancement</span>
                    <div class="dropdown dropend"><button class="btn btn-sm btn-secondary px-2 fsp-75 bg-400 border-400 dropdown-toggle dropdown-caret-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-plus"></span></button>
                      <div class="dropdown-menu">
                        <h6 class="dropdown-header py-0 px-3 mb-0">Select Label</h6>
                        <div class="dropdown-divider"></div>
                        <div class="px-3"><button class="badge-subtle-danger dropdown-item rounded-1 mb-2" type="button">New</button><button class="badge-subtle-primary dropdown-item rounded-1 mb-2" type="button">Goal</button><button class="badge-subtle-info dropdown-item rounded-1 mb-2" type="button">Enhancement</button></div>
                        <div class="dropdown-divider"></div>
                        <div class="px-3"><button class="btn btn-sm d-block w-100 btn-outline-secondary border-400">Create Label</button></div>
                      </div>
                    </div>
                  </div>
                  <hr class="my-4" />
                </div>
              </div>
              <div class="d-flex"><span class="fa-stack ms-n1 me-3"><i class="fas fa-circle fa-stack-2x text-200"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-align-left" data-fa-transform="shrink-2"></i></span>
                <div class="flex-1">
                  <h5 class="mb-2 fs-9">Description</h5>
                  <p class="text-break fs-10">The illustration must match to the contrast of the theme. The illustraion must described the concept of the design. To know more about the theme visit the page. </p>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <h6 class="mt-5 mt-lg-0">Add To Card</h6>
              <ul class="nav flex-lg-column fs-10">
                <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details" href="#!"><span class="fas fa-user me-2"></span>Members</a></li>
                <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details" href="#!"><span class="fas fa-tag me-2"></span>Label</a></li>
                <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details" href="#!"><span class="fas fa-paperclip me-2"></span>Attachments</a></li>
                <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details" href="#!"><span class="fa fa-align-left me-2"></span>Description </a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Vanilla JS for Filtering and View Toggling -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('appSearchInput');
    const selectFilter = document.getElementById('organizerSingle');
    const cards = document.querySelectorAll('.app-card');
    const noResultsMessage = document.getElementById('noResultsMessage');
    
    // View Toggling Elements
    const btnCardView = document.getElementById('btn-card-view');
    const btnListView = document.getElementById('btn-list-view');
    const appCardsContainer = document.getElementById('appCardsContainer');
    const listViewContainer = document.getElementById('listViewContainer');
    const listViewBody = document.getElementById('listViewBody');

    // Build List from Cards (Exactly like the screenshot)
    function buildList() {
      listViewBody.innerHTML = '';
      const visibleCards = document.querySelectorAll('.app-card:not(.d-none)');

      visibleCards.forEach(function(card) {
        const iconSVG = card.querySelector('.text-body svg');
        const name = card.querySelector('h6').textContent;
        const desc = card.querySelector('p').textContent;
        const empBadge = card.querySelector('.badge-subtle-info');
        const statusBtn = card.querySelector('button.btn-sm'); // Configure/Configured

        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom';

        li.innerHTML = `
          <div class="d-flex align-items-center">
            <div class="text-body me-3">${iconSVG ? iconSVG.outerHTML : ''}</div>
            <div>
              <h6 class="fw-bold mb-1">${name}</h6>
              <p class="text-500 fs--3 lh-base mb-0">${desc}</p>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <span class="badge badge-subtle-info fw-normal">${empBadge ? empBadge.textContent : '0 employees'}</span>
            <span>${statusBtn ? statusBtn.outerHTML : ''}</span>
            <a href="#" class="text-body-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
          </div>
        `;
        listViewBody.appendChild(li);
      });
    }

    // Toggle View Buttons
    btnListView.addEventListener('click', function() {
      buildList();
      appCardsContainer.classList.add('d-none');
      listViewContainer.classList.remove('d-none');
      btnListView.classList.add('active');
      btnCardView.classList.remove('active');
    });

    btnCardView.addEventListener('click', function() {
      listViewContainer.classList.add('d-none');
      appCardsContainer.classList.remove('d-none');
      btnCardView.classList.add('active');
      btnListView.classList.remove('active');
    });

    // Filter Logic
    function filterApps() {
      const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
      const selectTerm = selectFilter ? selectFilter.value.toLowerCase().trim() : '';
      let hasVisibleCard = false;

      cards.forEach(function(card) {
        const appName = card.getAttribute('data-name').toLowerCase();
        const matchesSearch = appName.includes(searchTerm);
        const matchesSelect = selectTerm === '' || appName.includes(selectTerm);

        if (matchesSearch && matchesSelect) {
          card.classList.remove('d-none');
          hasVisibleCard = true;
        } else {
          card.classList.add('d-none');
        }
      });

      // Handle Empty State and View Visibility
      if (hasVisibleCard) {
        noResultsMessage.classList.add('d-none');
        if (listViewContainer.classList.contains('d-none')) {
          appCardsContainer.classList.remove('d-none');
          listViewContainer.classList.add('d-none');
        } else {
          appCardsContainer.classList.add('d-none');
          listViewContainer.classList.remove('d-none');
          buildList(); // Rebuild list if visible
        }
      } else {
        noResultsMessage.classList.remove('d-none');
        appCardsContainer.classList.add('d-none');
        listViewContainer.classList.add('d-none');
      }
    }

    if (searchInput) {
      searchInput.addEventListener('input', filterApps);
    }
    
    if (selectFilter) {
      selectFilter.addEventListener('change', filterApps);
    }
  });
</script>