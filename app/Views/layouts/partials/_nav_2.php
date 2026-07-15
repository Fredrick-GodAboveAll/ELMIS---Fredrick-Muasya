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
                  
                
                  <a class="nav-link dropdown-indicator <?php echo (in_array($currentPage, ['dashboard', 'analytics'])) ? '' : 'collapsed'; ?>" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="<?php echo (in_array($currentPage, ['dashboard', 'analytics'])) ? 'true' : 'false'; ?>" aria-controls="dashboard">
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
                    <div class="col-auto navbar-vertical-label">Attendance</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator <?php echo (in_array($currentPage, ['leave_management', 'leave_types'])) ? '' : 'collapsed'; ?>" href="#leave"
                  role="button" data-bs-toggle="collapse" aria-expanded="<?php echo (in_array($currentPage, ['leave_management', 'leave_types'])) ? 'true' : 'false'; ?>" aria-controls="user">
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon">
                        <span class="fas fa-umbrella-beach"></span>
                      </span><span class="nav-link-text ps-1">Leave</span></div>
                  </a>
                  <ul class="nav collapse <?php echo (in_array($currentPage, ['leave_management', 'leave_types'])) ? 'show' : ''; ?>" id="leave">
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'leave_management') ? 'active' : ''; ?>" href="/leaves">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave Records</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'leave_types') ? 'active' : ''; ?>" href="/leave-types">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave Types</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'leave_management') ? 'active' : ''; ?>" href="/leaves">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave Reports</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'leave_types') ? 'active' : ''; ?>" href="/leave-types">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">leave Policies</span></div>
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
                      <span class="fas fa-users"></span></span><span class="nav-link-text ps-1">Employee Profiles</span></div>
                  </a>
                  <ul class="nav collapse <?php echo (in_array($currentPage, ['employees'])) ? 'show' : ''; ?>" id="employees">
                    <li class="nav-item"><a class="nav-link <?php echo ($currentPage === 'employees') ? 'active' : ''; ?>" href="/employees">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Employees List</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="/employees/detail">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Employee Detail</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->

                  <a class="nav-link <?php echo ($currentPage === 'departments') ? 'active' : ''; ?>" href="/departments" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon">
                      <span class="fas fa-sitemap"></span></span>
                      <span class="nav-link-text ps-1">Departments & Groups</span></div>
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
                  
                  <a class="nav-link" href="app/calendar.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar-alt"></span></span>
                    <span class="nav-link-text ps-1">Calendar</span></div>
                  </a><!-- parent pages-->

                  <a class="nav-link" href="app/calendar.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-upload"></span></span>
                    <span class="nav-link-text ps-1">Bulk Upload</span></div>
                  </a><!-- parent pages-->
                  
                  
                  <a class="nav-link dropdown-indicator" href="#events" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar-day"></span></span><span class="nav-link-text ps-1">Events</span></div>
                  </a>
                  <ul class="nav collapse" id="events">
                    <li class="nav-item"><a class="nav-link" href="app/events/create-an-event.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create an event</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/events/event-detail.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Event detail</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/events/event-list.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Event list</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->

                  
                  <a class="nav-link dropdown-indicator" href="#e-learning" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="e-learning">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-graduation-cap"></span></span><span class="nav-link-text ps-1">E learning</span><span class="badge rounded-pill ms-2 badge-subtle-success">New</span></div>
                  </a>
                  <ul class="nav collapse" id="e-learning">
                    <li class="nav-item"><a class="nav-link dropdown-indicator" href="#course" data-bs-toggle="collapse" aria-expanded="false" aria-controls="e-learning">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course</span></div>
                      </a><!-- more inner pages-->
                      <ul class="nav collapse" id="course">
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/course-list.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course list</span></div>
                          </a><!-- more inner pages--></li>
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/course-grid.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course grid</span></div>
                          </a><!-- more inner pages--></li>
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/course-details.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course details</span></div>
                          </a><!-- more inner pages--></li>
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/create-a-course.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create a course</span></div>
                          </a><!-- more inner pages--></li>
                      </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="app/e-learning/student-overview.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Student overview</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/e-learning/trainer-profile.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Trainer profile</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->
                  
                  
                  <a class="nav-link dropdown-indicator" href="#support-desk" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="support-desk">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-ticket-alt"></span></span><span class="nav-link-text ps-1">Support desk</span></div>
                  </a>
                  <ul class="nav collapse" id="support-desk">
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/table-view.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Table view</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/card-view.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Card view</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/contacts.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Contacts</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/contact-details.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Contact details</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/tickets-preview.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Tickets preview</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/quick-links.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Quick links</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/reports.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Reports</span></div>
                      </a><!-- more inner pages--></li>
                  </ul>

                </li>

                 <!-- PROFILES  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Profile</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator" href="#user" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="user">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user"></span></span><span class="nav-link-text ps-1">User</span></div>
                  </a>
                  <ul class="nav collapse" id="user">
                    <li class="nav-item"><a class="nav-link" href="pages/user/profile.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Profile</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="pages/user/settings.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Settings</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->

                  <a class="nav-link" href="pages/starter.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-flag"></span></span><span class="nav-link-text ps-1">Starter</span></div>
                  </a><!-- parent pages-->
                  
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