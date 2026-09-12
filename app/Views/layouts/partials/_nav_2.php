  <!-- NAV 2  -->
        <nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">
          <script>
            var navbarStyle = localStorage.getItem("navbarStyle");
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
            }
          </script>

          <div class="d-flex align-items-center">
            <div class="toggle-icon-wrapper">
              <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation">
                <span class="navbar-toggle-icon">
                  <span class="toggle-line"></span>
                </span>
              </button>
            </div>

            <a class="navbar-brand" href="index.html">
              <div class="d-flex align-items-center py-3">
                <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="40" />
                <span class="font-sans-serif text-primary">fleave</span>
              </div>
            </a>

          </div>

          <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <div class="navbar-vertical-content scrollbar">
              <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                
                <!-- DASHBOARD  -->
                <li class="nav-item"><!-- parent pages-->
                  
                
                  <a class="nav-link dropdown-indicator 
                  <?php echo (in_array($currentPage, ['dashboard', 'analytics'])) ? '' : 'collapsed'; ?>" href="#dashboard" 
                  role="button" data-bs-toggle="collapse" 
                  aria-expanded="<?php echo (in_array($currentPage, ['dashboard', 'analytics'])) ? 'true' : 'false'; ?>" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Dashboard</span></div>
                  </a>
                  <ul class="nav collapse <?php echo (in_array($currentPage, ['dashboard', 'analytics'])) ? 'show' : ''; ?>" id="dashboard">
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>" href="/dashboard">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Default</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'analytics') ? 'active' : ''; ?>" href="/dashboard/analytics">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Analytics</span></div>
                      </a><!-- more inner pages--></li>

                  </ul>
                </li>

                 <!-- LEAVE  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Leave & Attendance</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->

                  <a class="nav-link <?php echo ($currentPage === 'leave_management') ? 'active' : ''; ?>" href="/leaves" role="button">
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon"><span class="fas fa-plane-departure"></span>
                    </span><span class="nav-link-text ps-1">Leave</span></div>
                  </a><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator <?php echo (in_array($currentPage, 
                    ['holiday_list','leave_types', 'leave_entitlement', 'leave_period', 'leave_policy', 'leave_applications'])) ? '' : 'collapsed'; ?>" href="#leave"
                    role="button" data-bs-toggle="collapse" 
                    aria-expanded="<?php echo (in_array($currentPage, 
                    ['holiday_list','leave_types', 'leave_entitlement', 'leave_period', 'leave_policy', 'leave_applications'])) ? 'true' : 'false'; ?>" aria-controls="user">
                    
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon">
                        <span class="fas fa-database"></span>
                      </span><span class="nav-link-text ps-1">Setup</span></div>
                  </a>
                  <ul class="nav collapse <?php echo (in_array($currentPage, 
                    ['holiday_list', 'leave_types', 'leave_entitlement', 'leave_period', 'leave_policy', 'leave_applications'])) ? 'show' : ''; ?>" id="leave">

                    <li class="nav-item">
                      <a class="nav-link <?php echo ($currentPage === 'holiday_list') ? 'active' : ''; ?>" href="/holiday-list">
                      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">holiday list</span></div>
                    </a><!-- more inner pages--></li>

                    <li class="nav-item">
                      <a class="nav-link <?php echo ($currentPage === 'leave_types') ? 'active' : ''; ?>" href="/leave-types">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave type</span></div>
                      </a><!-- more inner pages--></li>

                    <li class="nav-item">
                      <a class="nav-link <?php echo ($currentPage === 'leave_entitlement') ? 'active' : ''; ?>" href="/leave-entitlements">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave entitlement</span></div>
                      </a><!-- more inner pages--></li>

                      <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'leave_applications') ? 'active' : ''; ?>" href="/leave-applications">
                          <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave applications</span></div>
                        </a><!-- more inner pages--></li>

                    <li class="nav-item">
                      <a class="nav-link <?php echo ($currentPage === 'leave_calculator') ? 'active' : ''; ?>" href="/tools/leave-calculator">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave calculator</span></div>
                      </a><!-- more inner pages--></li>

                      <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'leave_period') ? 'active' : ''; ?>" href="/leave-periods">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave period</span></div>
                      </a><!-- more inner pages--></li>


                      <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'leave_policy') ? 'active' : ''; ?>" href="/leave-policies">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave policy</span></div>
                      </a><!-- more inner pages--></li>

                  </ul><!-- parent pages-->


                  <a class="nav-link <?php echo ($currentPage === 'holidays') ? 'active' : ''; ?>" href="/holidays" role="button">
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon"><span class="far fa-calendar"></span>
                    </span><span class="nav-link-text ps-1">Time Off & Holidays</span></div>
                  </a><!-- parent pages-->

                  
                </li>

                <!-- EMPLOYEES  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">management</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator <?php echo (in_array($currentPage, ['employees'])) ? '' : 'collapsed'; ?>" href="#employees" role="button" data-bs-toggle="collapse" aria-expanded="<?php echo (in_array($currentPage, ['employees'])) ? 'true' : 'false'; ?>" aria-controls="user">
                    <div class="d-flex align-items-center"><span class="nav-link-icon">
                      <span class="fas fa-users"></span></span><span class="nav-link-text ps-1"> Employees </span></div>
                  </a>
                  <ul class="nav collapse <?php echo (in_array($currentPage, ['employees'])) ? 'show' : ''; ?>" id="employees">
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'employees') ? 'active' : ''; ?>" href="/employees">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">employee list</span></div>
                      </a><!-- more inner pages--></li>

                    <!-- <li class="nav-item"><a class="nav-link" href="/employees/detail">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">employee detail</span></div>
                      </a>more inner pages</li>-->
                  </ul>

                  <a class="nav-link <?php echo ($currentPage === 'departments') ? 'active' : ''; ?>" href="/departments" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon">
                      <span class="fas fa-sitemap"></span></span>
                      <span class="nav-link-text ps-1"> Departments </span></div>
                  </a><!-- parent pages-->

                  <a class="nav-link <?php echo ($currentPage === 'reports') ? 'active' : ''; ?>" href="/reports" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon">
                      <span class="fas fa-chart-bar"></span></span>
                      <span class="nav-link-text ps-1">Reports</span></div>
                  </a><!-- parent pages-->
                  
                </li>

                <!-- APPS  -->
                <li class="nav-item"><!-- label-->

                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">App</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->

                  
                  <a class="nav-link <?php echo ($currentPage === 'system_calender') ? 'active' : ''; ?> " href="/system-calender" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar-alt"></span></span>
                    <span class="nav-link-text ps-1">Calendar</span></div>
                  </a><!-- parent pages-->


                  <a class="nav-link <?php echo ($currentPage === 'bulk_leave_actions') ? 'active' : ''; ?> " href="/bulk-actions" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-upload"></span></span>
                    <span class="nav-link-text ps-1">Bulk Upload</span></div>
                  </a><!-- parent pages-->

                </li>

                 <!-- PROFILES  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Profile</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator
                  
                  <?php echo (in_array($currentPage, 
                    ['user_profile','system_settings'])) ? '' : 'collapsed'; ?>" href="#user"
                    role="button" data-bs-toggle="collapse"
                    aria-expanded="<?php echo (in_array($currentPage, 
                    ['user_profile', 'system_settings'])) ? 'true' : 'false'; ?>" aria-expanded="false"
                  aria-controls="user">

                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon"><span class="fas fa-user"></span>
                    </span><span class="nav-link-text ps-1">User</span></div>

                  </a>

                  <ul class="nav collapse <?php echo (in_array($currentPage, 
                    ['user_profile', 'system_settings',])) ? 'show' : ''; ?>" id="user">

                    <li class="nav-item">
                      <a class="nav-link <?php echo ($currentPage === 'user_profile') ? 'active' : ''; ?>" href="/user-profiles">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Profile</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item">
                      <a class="nav-link <?php echo ($currentPage === 'system_settings') ? 'active' : ''; ?>" href="/user/settings">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Settings</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->
                  
                </li>

                <!-- DOCUMENTATION  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Documentation</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages--><a class="nav-link" href="documentation/getting-started.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-rocket"></span></span>
                    <span class="nav-link-text ps-1">Getting started</span></div>
                  </a><!-- parent pages-->
                  
                  <a class="nav-link" href="changelog.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-code-branch"></span></span>
                    <span class="nav-link-text ps-1">Changelog</span></div>
                  </a>
                </li>

              </ul>

              <!-- SETTINGS  -->
              <div class="settings my-3">
                <div class="card shadow-none">
                  <div class="card-body alert mb-0" role="alert">
                    <div class="btn-close-falcon-container"><button class="btn btn-link btn-close-falcon p-0" aria-label="Close" data-bs-dismiss="alert"></button></div>
                    <div class="text-center"><img src="/assets/img/icons/spot-illustrations/navbar-vertical.png" alt="" width="80" />
                      <p class="fs-11 mt-2">Loving what you see? <br />Get your copy of <a href="#!">Fredrick's - LMS</a></p>
                      <div class="d-grid"><a class="btn btn-sm btn-primary" href="#" target="_blank">Purchase</a></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </nav>