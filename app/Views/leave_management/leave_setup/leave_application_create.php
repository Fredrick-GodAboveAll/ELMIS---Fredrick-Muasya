<?php
// Set the active page for the sidebar navigation
$currentPage = 'leave_applications';

// Generate a CSRF token to protect the form from cross-site request forgery
$csrf = \App\Core\Csrf::generate();

// ==========================================
// GENERATE 250 MOCK EMPLOYEES (FOR UI TESTING)
// Remove this block when you connect to the database
// ==========================================
$mockEmployees = [];
$firstNames = ['John', 'Jane', 'Peter', 'Grace', 'Daniel', 'Amina', 'Samuel', 'Fatuma', 'David', 'Lucy', 'Brian', 'Sarah', 'Kevin', 'Esther', 'George', 'Cynthia', 'Dennis', 'Beatrice', 'Victor', 'Mary'];
$lastNames = ['Doe', 'Wanjiku', 'Njoroge', 'Otieno', 'Kibet', 'Hassan', 'Ochieng', 'Ali', 'Mwangi', 'Achieng', 'Kiprop', 'Njeri', 'Omondi', 'Muthoni', 'Maina', 'Chebet', 'Wafula', 'Atieno', 'Mutua', 'Wambui'];

for ($i = 1; $i <= 250; $i++) {
    $fn = $firstNames[array_rand($firstNames)];
    $ln = $lastNames[array_rand($lastNames)];
    $mockEmployees[] = [
        'id' => 'EMP-' . (1000 + $i),
        'name' => "$fn $ln",
        'no' => '2025' . str_pad($i, 6, '0', STR_PAD_LEFT)
    ];
}
?>

<!-- 
  CSS TO LIMIT DROPDOWN HEIGHT AND FORCE SCROLL 
  This shows exactly 5 items (approx 220px). 
  Because we removed the JS limit, ALL 250 records are scrollable.
-->
<style>
  .choices__list--dropdown .choices__list[aria-expanded] {
    max-height: 220px !important; 
    overflow-y: auto !important;  
  }
</style>

<?php if ($error = \App\Core\Session::flash('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if ($success = \App\Core\Session::flash('success')): ?>
  <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dash</a></li>
    <li class="breadcrumb-item"><a href="/leave-applications">Leave Applications</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
  </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="fw-bold mb-1">New Leave Application</h3>
    <p class="text-600 mb-0">Submit a new leave request for an employee.</p>
  </div>
  <a href="/leave-applications" class="btn btn-falcon-default btn-sm">
    <span class="fas fa-arrow-left me-1"></span>Back to list
  </a>
</div>

<div class="row">
  <div class="col-12">
    <div class="card shadow border">
      <div class="card-body p-4 p-md-5">
        <form method="POST" action="/leave-applications/create" id="leaveApplicationForm">
          
          <div class="row g-4">
            
            <!-- Employee Searchable Dropdown -->
            <div class="col-md-6">
              <label class="form-label fw-semi-bold" for="employeeSelect">Employee <span class="text-danger">*</span></label>
              
              <select class="form-select js-choice" id="employeeSelect" name="employee" required 
                      data-options='{"removeItemButton":true, "placeholder":true}'>
                <option value="">Search by name...</option>
                
                <!-- Loop through all 250 mock employees (Names only) -->
                <?php foreach ($mockEmployees as $emp): ?>
                  <option value="<?= htmlspecialchars($emp['id']) ?>">
                    <?= htmlspecialchars($emp['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Leave Type -->
            <div class="col-md-6">
              <label class="form-label fw-semi-bold" for="leave_type">Leave Type <span class="text-danger">*</span></label>
              <select class="form-select js-choice" id="leave_type" name="leave_type" required data-options='{"removeItemButton":true,"placeholder":true}'>
                <option value="">Select leave type...</option>
                <option value="annual_leave">Annual Leave</option>
                <option value="sick_leave">Sick Leave</option>
                <option value="maternity_leave">Maternity Leave</option>
                <option value="study_leave">Study Leave</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semi-bold" for="start_date">Start Date <span class="text-danger">*</span></label>
              <input class="form-control" id="start_date" name="start_date" type="date" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semi-bold" for="end_date">End Date <span class="text-danger">*</span></label>
              <input class="form-control" id="end_date" name="end_date" type="date" required>
            </div>

            <div class="col-12">
              <label class="form-label fw-semi-bold" for="reason">Reason for Leave</label>
              <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Briefly explain the purpose of this leave..."></textarea>
            </div>
          </div>

          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />

          <div class="d-flex justify-content-end align-items-center gap-2 border-top mt-4 pt-4">
            <a href="/leave-applications" class="btn btn-falcon-default">Cancel</a>
            <button type="submit" class="btn btn-falcon-primary">
              <span class="fas fa-paper-plane me-2"></span>Submit Application
            </button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>