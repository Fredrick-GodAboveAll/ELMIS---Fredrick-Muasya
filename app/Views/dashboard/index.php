<?php
$currentPage = 'dashboard';

/*
 * DASHBOARD VIEW — expected variables from DashboardController::index()
 * Every value below has a fallback default via `??=`, so this view renders
 * safely even before the controller is wired up to real queries. Replace
 * the defaults with real data as each feature lands.
 *
 * KPI row 1:   $leaveRecordsThisWeek, $leaveRecordsThisWeekChangePct,
 *              $recordedLeaveEntries, $leaveTypeDistribution (assoc array),
 *              $totalLeaveRecords, $employeesOnLeaveTodayCount,
 *              $employeesOnLeaveTodayAnnual, $employeesOnLeaveTodaySick
 * Stat grid:   $employeeCount, $employeeCountDelta, $employeeCountChangePct,
 *              $departmentCount, $departmentCountDelta, $departmentCountChangePct,
 *              $totalLeaveRecordsYtd, $totalLeaveRecordsYtdDelta, $totalLeaveRecordsYtdChangePct,
 *              $upcomingHolidaysCount, $upcomingHolidaysThisYear,
 *              $employeesOnLeaveMonthCount, $employeesOnLeaveIncoming,
 *              $recordedThisMonth, $recordedLastMonth, $recordedThisMonthChangePct
 * KPI row 3:   $newEmployeesThisMonth, $newEmployeesChangePct,
 *              $leaveUtilizationRate, $leaveUtilizationChangePct,
 *              $departmentDistribution (assoc array), $totalEmployeesForChart,
 *              $upcomingBirthdays (array of names)
 * Tables:      $recentLeaveRecords (array), $employeeDirectory (array)
 * Chart totals: $lastMonthRecordsCount, $prevYearRecordsCount
 */

// --- KPI row 1 ---
$leaveRecordsThisWeek          ??= 15;
$leaveRecordsThisWeekChangePct ??= 5;
$recordedLeaveEntries          ??= 23;
$leaveTypeDistribution         ??= ['Annual Leave' => 45, 'Sick Leave' => 30, 'Maternity Leave' => 15];
$totalLeaveRecords             ??= 156;
$employeesOnLeaveTodayCount    ??= 5;
$employeesOnLeaveTodayAnnual   ??= 3;
$employeesOnLeaveTodaySick     ??= 2;

// --- Stat grid ---
$employeeCount                 ??= 0;
$employeeCountDelta            ??= 2;
$employeeCountChangePct        ??= 21.8;
$departmentCount               ??= 8;
$departmentCountDelta          ??= 1;
$departmentCountChangePct      ??= 12.5;
$totalLeaveRecordsYtd          ??= 78;
$totalLeaveRecordsYtdDelta     ??= 40;
$totalLeaveRecordsYtdChangePct ??= 105.3;
$upcomingHolidaysCount         ??= 12;
$upcomingHolidaysThisYear      ??= 13;
$employeesOnLeaveMonthCount    ??= 9;
$employeesOnLeaveIncoming      ??= 12;
$recordedThisMonth             ??= 45;
$recordedLastMonth             ??= 38;
$recordedThisMonthChangePct    ??= 18.4;

// --- KPI row 3 ---
$newEmployeesThisMonth   ??= 7;
$newEmployeesChangePct   ??= 15;
$leaveUtilizationRate    ??= 68;
$leaveUtilizationChangePct ??= 5.2;
$departmentDistribution  ??= ['Engineering' => 40, 'HR' => 25, 'Finance' => 20];
$totalEmployeesForChart  ??= 150;
$upcomingBirthdays       ??= ['John D.', 'Sarah M.', 'Mike R.'];

// --- Tables ---
$recentLeaveRecords ??= [
    ['name' => 'John Doe', 'department' => 'Engineering', 'type' => 'Annual Leave', 'from' => '2026-04-15', 'to' => '2026-04-20', 'days' => 6, 'status' => 'Awaiting Letter'],
    ['name' => 'Sarah Miller', 'department' => 'HR', 'type' => 'Sick Leave', 'from' => '2026-04-10', 'to' => '2026-04-12', 'days' => 3, 'status' => 'Recorded'],
    ['name' => 'Mike Ross', 'department' => 'Finance', 'type' => 'Maternity Leave', 'from' => '2026-05-01', 'to' => '2026-07-01', 'days' => 62, 'status' => 'Letter Filed'],
];
$leaveStatusBadgeClass = [
    'Awaiting Letter' => 'bg-warning',
    'Recorded'        => 'bg-success',
    'Letter Filed'    => 'bg-info',
];

$lastMonthRecordsCount ??= 125;
$prevYearRecordsCount  ??= 1450;

$employeeDirectory ??= [
    ['name' => 'Grace Wanjiru', 'department' => 'Human Resource Mgmt', 'job_group' => 'K', 'status' => 'Active', 'leave_balance' => 21],
    ['name' => 'Peter Otieno', 'department' => 'Finance', 'job_group' => 'J', 'status' => 'On Leave', 'leave_balance' => 4],
    ['name' => 'Amina Hassan', 'department' => 'ICT', 'job_group' => 'L', 'status' => 'Active', 'leave_balance' => 18],
    ['name' => 'Brian Kiptoo', 'department' => 'Procurement', 'job_group' => 'H', 'status' => 'Active', 'leave_balance' => 25],
    ['name' => 'Faith Achieng', 'department' => 'Legal', 'job_group' => 'K', 'status' => 'Inactive', 'leave_balance' => 0],
    ['name' => 'Samuel Mwangi', 'department' => 'Human Resource Mgmt', 'job_group' => 'J', 'status' => 'Active', 'leave_balance' => 30],
    ['name' => 'Lucy Chebet', 'department' => 'Finance', 'job_group' => 'K', 'status' => 'On Leave', 'leave_balance' => 2],
    ['name' => 'Daniel Kimani', 'department' => 'ICT', 'job_group' => 'H', 'status' => 'Active', 'leave_balance' => 27],
    ['name' => 'Mercy Nduta', 'department' => 'Procurement', 'job_group' => 'L', 'status' => 'Active', 'leave_balance' => 15],
    ['name' => 'Joseph Wafula', 'department' => 'Legal', 'job_group' => 'J', 'status' => 'Active', 'leave_balance' => 22],
];
$directoryStatusBadgeClass = [
    'Active'   => 'bg-success',
    'On Leave' => 'bg-warning',
    'Inactive' => 'bg-secondary',
];

// Shared colour cycle for donut-chart legend dots (Falcon palette only, no custom CSS)
$dotColorCycle = ['bg-primary', 'bg-info', 'bg-300', 'bg-warning', 'bg-secondary'];

/** Build initials like "JD" from a full name for avatar placeholders. No mbstring dependency. */
function elmis_initials(string $name): string
{
    $parts = array_filter(explode(' ', trim($name)));
    $initials = array_map(fn($p) => strtoupper(substr($p, 0, 1)), $parts);
    return implode('', array_slice($initials, 0, 2));
}
?>

<!-- Quick Actions -->
<!-- TODO: confirm these href paths against routes/web.php once routing is finalised -->
<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-body py-2">
        <div class="d-flex flex-wrap gap-2">
          <a href="/leave_management" class="btn btn-falcon-default btn-sm">
            <span class="fas fa-calendar-plus me-1"></span>New Leave Record
          </a>
          <a href="/holidays/new_holiday_list" class="btn btn-falcon-default btn-sm">
            <span class="fas fa-umbrella-beach me-1"></span>New Holiday List
          </a>
          <a href="/employees/add-employee" class="btn btn-falcon-default btn-sm">
            <span class="fas fa-user-plus me-1"></span>Add Employee
          </a>
          <a href="/reports" class="btn btn-falcon-default btn-sm">
            <span class="fas fa-file-export me-1"></span>Reports
          </a>
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
                    Leave Records This Week
                    <span class="ms-1 text-400" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of leave records entered this week">
                        <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
                    </span>
                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-5"><?= $leaveRecordsThisWeek ?></p>
                        <span class="badge <?= $leaveRecordsThisWeekChangePct >= 0 ? 'badge-subtle-success' : 'badge-subtle-danger' ?> rounded-pill fs-11">
                            <?= $leaveRecordsThisWeekChangePct >= 0 ? '+' : '' ?><?= $leaveRecordsThisWeekChangePct ?>%
                        </span>
                    </div>
                    <div class="col-auto ps-0">
                        <!-- Decorative sparkline (shared Falcon chart hook, series data is static demo data) -->
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
                        <div class="fs-5 fw-normal font-sans-serif text-700 lh-1 mb-1"><?= $recordedLeaveEntries ?></div>
                        <span class="badge rounded-pill fs-11 bg-200 text-primary">
                            <span class="fas fa-caret-up me-1"></span>
                            Manual approvals recorded
                        </span>
                    </div>
                    <div class="col-auto ps-0 mt-n4">
                        <!-- Decorative trend line (shared Falcon chart hook, series data is static demo data) -->
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
                            <?php $i = 0; foreach ($leaveTypeDistribution as $label => $pct): ?>
                            <div class="d-flex flex-between-center mb-1">
                                <div class="d-flex align-items-center">
                                    <span class="dot <?= $dotColorCycle[$i % count($dotColorCycle)] ?>"></span>
                                    <span class="fw-semi-bold"><?= htmlspecialchars($label) ?></span>
                                </div>
                                <div class="d-xxl-none"><?= $pct ?>%</div>
                            </div>
                            <?php $i++; endforeach; ?>
                        </div>
                    </div>
                    <div class="col-auto position-relative">
                        <div class="echart-market-share"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-1100 fs-7"><?= $totalLeaveRecords ?></div>
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
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-on-leave-today" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-ellipsis-h fs-11"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-on-leave-today">
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
                                    <div class="text-warning"><?= $employeesOnLeaveTodayCount ?> Active</div>
                                    Annual: <?= $employeesOnLeaveTodayAnnual ?>, Sick: <?= $employeesOnLeaveTodaySick ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-center ps-2">
                        <div class="fs-5 fw-normal font-sans-serif text-primary mb-1 lh-1"><?= $employeesOnLeaveTodayCount ?></div>
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
            <h6 class="pb-1 text-700">Total Employees</h6>
            <p class="font-sans-serif lh-1 mb-1 fs-8"><?= $employeeCount ?></p>
            <div class="d-flex align-items-center">
              <h6 class="fs-11 text-500 mb-0">+<?= $employeeCountDelta ?></h6>
              <h6 class="fs-11 ps-3 mb-0 text-primary"><span class="me-1 fas fa-caret-up"></span><?= $employeeCountChangePct ?>%</h6>
            </div>
          </div>
          <div class="col-6 col-md-4 border-200 border-bottom border-end-md pb-4 ps-3">
            <h6 class="pb-1 text-700">Departments</h6>
            <p class="font-sans-serif lh-1 mb-1 fs-8"><?= $departmentCount ?></p>
            <div class="d-flex align-items-center">
              <h6 class="fs-11 text-500 mb-0">+<?= $departmentCountDelta ?></h6>
              <h6 class="fs-11 ps-3 mb-0 text-warning"><span class="me-1 fas fa-caret-up"></span><?= $departmentCountChangePct ?>%</h6>
            </div>
          </div>
          <div class="col-6 col-md-4 border-200 border-bottom border-end border-end-md-0 pb-4 pt-4 pt-md-0 ps-md-3">
            <h6 class="pb-1 text-700">Total Leave Records</h6>
            <p class="font-sans-serif lh-1 mb-1 fs-8"><?= $totalLeaveRecordsYtd ?></p>
            <div class="d-flex align-items-center">
              <h6 class="fs-11 text-500 mb-0">+<?= $totalLeaveRecordsYtdDelta ?></h6>
              <h6 class="fs-11 ps-3 mb-0 text-success"><span class="me-1 fas fa-caret-up"></span><?= $totalLeaveRecordsYtdChangePct ?>%</h6>
            </div>
          </div>
          <div class="col-6 col-md-4 border-200 border-bottom border-bottom-md-0 border-end-md pt-4 pb-md-0 ps-3 ps-md-0">
            <h6 class="pb-1 text-700">Upcoming Holidays</h6>
            <p class="font-sans-serif lh-1 mb-1 fs-8"><?= $upcomingHolidaysCount ?></p>
            <div class="d-flex align-items-center">
              <h6 class="fs-11 text-500 mb-0">This Year <?= $upcomingHolidaysThisYear ?></h6>
            </div>
          </div>
          <div class="col-6 col-md-4 border-200 border-bottom-md-0 border-end pt-4 pb-md-0 ps-md-3">
            <h6 class="pb-1 text-700">Employees On Leave</h6>
            <p class="font-sans-serif lh-1 mb-1 fs-8"><?= $employeesOnLeaveMonthCount ?></p>
            <div class="d-flex align-items-center">
              <h6 class="fs-11 text-500 mb-0">Incoming <?= $employeesOnLeaveIncoming ?></h6>
            </div>
          </div>
          <div class="col-6 col-md-4 pb-0 pt-4 ps-3">
            <h6 class="pb-1 text-700">Recorded This Month</h6>
            <p class="font-sans-serif lh-1 mb-1 fs-8"><?= $recordedThisMonth ?></p>
            <div class="d-flex align-items-center">
              <h6 class="fs-11 text-500 mb-0">Last Month <?= $recordedLastMonth ?></h6>
              <h6 class="fs-11 ps-3 mb-0 text-info"><span class="me-1 fas fa-caret-up"></span><?= $recordedThisMonthChangePct ?>%</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xxl-6 col-xl-12">
    <div class="card overflow-hidden h-100">
      <!-- Expects #addEventModal, defined in layouts/partials/_calender_modals.php per project docs -->
      <div class="card-body p-0 management-calendar">
        <div class="row g-3">
          <div class="col-md-7">
            <div class="p-x1">
              <div class="d-flex justify-content-between">
                <div class="order-md-1">
                  <button class="btn btn-sm border me-1 shadow-sm" type="button" data-event="prev" data-bs-toggle="tooltip" title="Previous"><span class="fas fa-chevron-left"></span></button>
                  <button class="btn btn-sm text-secondary border px-sm-4 shadow-sm" type="button" data-event="today">Today</button>
                  <button class="btn btn-sm border ms-1 shadow-sm" type="button" data-event="next" data-bs-toggle="tooltip" title="Next"><span class="fas fa-chevron-right"></span></button>
                </div>
                <button class="btn btn-sm text-primary border order-md-0 shadow-none" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal">
                  <span class="fas fa-plus me-2"></span>New Schedule
                </button>
              </div>
            </div>
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
                        <p class="font-sans-serif lh-1 mb-1 fs-5"><?= $newEmployeesThisMonth ?></p>
                        <span class="badge <?= $newEmployeesChangePct >= 0 ? 'badge-subtle-success' : 'badge-subtle-danger' ?> rounded-pill fs-11">
                            <?= $newEmployeesChangePct >= 0 ? '+' : '' ?><?= $newEmployeesChangePct ?>%
                        </span>
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
                        <div class="fs-5 fw-normal font-sans-serif text-700 lh-1 mb-1"><?= $leaveUtilizationRate ?>%</div>
                        <span class="badge rounded-pill fs-11 bg-200 text-primary">
                            <span class="fas fa-caret-up me-1"></span>
                            <?= $leaveUtilizationChangePct ?>%
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
                            <?php $i = 0; foreach ($departmentDistribution as $label => $pct): ?>
                            <div class="d-flex flex-between-center mb-1">
                                <div class="d-flex align-items-center">
                                    <span class="dot <?= $dotColorCycle[$i % count($dotColorCycle)] ?>"></span>
                                    <span class="fw-semi-bold"><?= htmlspecialchars($label) ?></span>
                                </div>
                                <div class="d-xxl-none"><?= $pct ?>%</div>
                            </div>
                            <?php $i++; endforeach; ?>
                        </div>
                    </div>
                    <div class="col-auto position-relative">
                        <div class="echart-market-share"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-1100 fs-7"><?= $totalEmployeesForChart ?></div>
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
                                    <div class="text-warning"><?= count($upcomingBirthdays) ?> Celebrations</div>
                                    <?= htmlspecialchars(implode(', ', $upcomingBirthdays)) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-center ps-2">
                        <div class="fs-5 fw-normal font-sans-serif text-primary mb-1 lh-1"><?= count($upcomingBirthdays) ?></div>
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
              <?php foreach ($recentLeaveRecords as $record): ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2">
                      <div class="avatar-name rounded-circle"><span><?= htmlspecialchars(elmis_initials($record['name'])) ?></span></div>
                    </div>
                    <div>
                      <h6 class="mb-0"><?= htmlspecialchars($record['name']) ?></h6>
                      <p class="fs-11 mb-0 text-600"><?= htmlspecialchars($record['department']) ?></p>
                    </div>
                  </div>
                </td>
                <td><?= htmlspecialchars($record['type']) ?></td>
                <td><?= htmlspecialchars($record['from']) ?></td>
                <td><?= htmlspecialchars($record['to']) ?></td>
                <td><?= (int) $record['days'] ?></td>
                <td><span class="badge <?= $leaveStatusBadgeClass[$record['status']] ?? 'bg-secondary' ?>"><?= htmlspecialchars($record['status']) ?></span></td>
              </tr>
              <?php endforeach; ?>
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
            <div class="form-check mb-0 d-flex">
              <input class="form-check-input form-check-input-primary" id="ecommerceLastMonth" type="checkbox" checked="checked" />
              <label class="form-check-label ps-2 fs-11 text-600 mb-0" for="ecommerceLastMonth">Last Month<span class="text-1100 d-none d-md-inline">: <?= number_format($lastMonthRecordsCount) ?> records</span></label>
            </div>
            <div class="form-check mb-0 d-flex ps-0 ps-md-3">
              <input class="form-check-input ms-2 form-check-input-warning opacity-75" id="ecommercePrevYear" type="checkbox" checked="checked" />
              <label class="form-check-label ps-2 fs-11 text-600 mb-0" for="ecommercePrevYear">Prev Year<span class="text-1100 d-none d-md-inline">: <?= number_format($prevYearRecordsCount) ?> records</span></label>
            </div>
          </div>
          <div class="col-auto">
            <div class="dropdown font-sans-serif btn-reveal-trigger">
              <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-leave-records-over-time" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs-11"></span></button>
              <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-leave-records-over-time">
                <a class="dropdown-item" href="#!">View</a>
                <a class="dropdown-item" href="#!">Export</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#!">Remove</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body pe-xxl-0">
        <!-- Decorative trend line (shared Falcon chart hook, series data is static demo data) -->
        <div class="echart-line-total-sales-ecommerce" data-echart-responsive="true" data-options='{"optionOne":"ecommerceLastMonth","optionTwo":"ecommercePrevYear"}'></div>
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
            <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Employee Directory</h5>
          </div>
          <div class="col-6 col-sm-auto ms-auto text-end ps-0">
            <div class="d-none" id="employee-directory-actions">
              <div class="d-flex">
                <select class="form-select form-select-sm" aria-label="Bulk actions">
                  <option selected="">Bulk actions</option>
                  <option value="Export">Export</option>
                  <option value="Deactivate">Deactivate</option>
                  <option value="Activate">Activate</option>
                </select>
                <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
              </div>
            </div>
            <div id="employee-directory-replace-element">
              <a href="/employees/add-employee" class="btn btn-falcon-default btn-sm"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">New</span></a>
              <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filter</span></button>
              <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Export</span></button>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body px-0 pt-0">
        <table class="table table-sm mb-0 overflow-hidden data-table fs-10" data-datatables='{"responsive":false,"pagingType":"simple","lengthChange":true,"pageLength":10,"searching":true,"bDeferRender":true,"serverSide":false,"language":{"info":"_START_ to _END_ Items of _TOTAL_"}}'>
          <thead class="bg-200">
            <tr>
              <th class="text-900 no-sort white-space-nowrap" data-orderable="false">
                <div class="form-check mb-0 d-flex align-items-center"><input class="form-check-input" id="checkbox-bulk-item-select" type="checkbox" data-bulk-select='{"body":"employee-directory-body","actions":"employee-directory-actions","replacedElement":"employee-directory-replace-element"}' /></div>
              </th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Employee</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap">Job Group</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-center">Status</th>
              <th class="text-900 sort pe-1 align-middle white-space-nowrap text-end">Leave Balance</th>
              <th class="text-900 no-sort pe-1 align-middle data-table-row-action" data-orderable="false"></th>
            </tr>
          </thead>
          <tbody class="list" id="employee-directory-body">
            <?php foreach ($employeeDirectory as $idx => $emp): ?>
            <tr class="btn-reveal-trigger">
              <td class="align-middle" style="width: 28px;">
                <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="employee-directory-item-<?= $idx ?>" data-bulk-select-row="data-bulk-select-row" /></div>
              </td>
              <td class="align-middle white-space-nowrap">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-l me-2">
                    <div class="avatar-name rounded-circle"><span><?= htmlspecialchars(elmis_initials($emp['name'])) ?></span></div>
                  </div>
                  <div>
                    <h6 class="mb-0 fw-semi-bold"><a href="#!" class="text-900"><?= htmlspecialchars($emp['name']) ?></a></h6>
                    <p class="fs-11 mb-0 text-600"><?= htmlspecialchars($emp['department']) ?></p>
                  </div>
                </div>
              </td>
              <td class="align-middle white-space-nowrap"><?= htmlspecialchars($emp['job_group']) ?></td>
              <td class="align-middle text-center white-space-nowrap">
                <span class="badge rounded-pill <?= $directoryStatusBadgeClass[$emp['status']] ?? 'bg-secondary' ?>"><?= htmlspecialchars($emp['status']) ?></span>
              </td>
              <td class="align-middle text-end white-space-nowrap"><?= (int) $emp['leave_balance'] ?> days</td>
              <td class="align-middle white-space-nowrap text-end">
                <div class="dropstart font-sans-serif position-static d-inline-block">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-employee-directory-item-<?= $idx ?>" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-employee-directory-item-<?= $idx ?>">
                    <a class="dropdown-item" href="#!">View</a>
                    <a class="dropdown-item" href="#!">Edit</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-warning" href="#!">Deactivate</a>
                    <a class="dropdown-item text-danger" href="#!">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>