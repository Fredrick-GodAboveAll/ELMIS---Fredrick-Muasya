<?php
namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Session;
use App\Models\FinancialYear;
use App\Services\LeaveEntitlementService;
use App\Services\LeavePolicyService;
use App\Services\LeaveTypeService;
use App\Utils\Validator;
use InvalidArgumentException;

class LeaveController extends Controller
{
    protected $leaveModel;
    protected $leaveTypeService;
    protected $leaveEntitlementService;
    protected $leavePolicyService;

    public function __construct()
    {
        $this->leaveModel = new FinancialYear();
        $this->leaveTypeService = new LeaveTypeService();
        $this->leaveEntitlementService = new LeaveEntitlementService();
        $this->leavePolicyService = new LeavePolicyService();
    }

    public function index()
    {
        $title = 'Leaves';
        $currentPage = 'leave_management';
        $content = '../app/Views/leave_management/index.php';
        include '../app/Views/layouts/admin.php';
    }

    public function LeaveType()
    {
        $title = 'Leave Types';
        $currentPage = 'leave_types';
        $content = '../app/Views/leave_management/leave_setup/leave_types.php';
        $leaveTypeService = new \App\Services\LeaveTypeService();
        $leaveTypes = $leaveTypeService->all();
        include '../app/Views/layouts/admin.php';
    }

    public function leaveApplications()
    {
        $title = 'Leave Applications';
        $currentPage = 'leave_applications';
        $content = '../app/Views/leave_management/leave_setup/leave_applications.php';
        include '../app/Views/layouts/admin.php';
    }

    public function LeaveEntitlement()
    {
        $title = 'Leave Entitlement';
        $currentPage = 'leave_entitlement';

        $financialYears = $this->leaveEntitlementService->getFinancialYearConfigurationSummary();
        $financialYearCount = count($financialYears);
        $activeYearCount = count(array_filter($financialYears, fn($year) => isset($year->is_current) && (int) $year->is_current === 1));
        $totalEntitlementRules = array_sum(array_map(fn($year) => (int) ($year->entitlement_rule_count ?? 0), $financialYears));

        $content = '../app/Views/leave_management/leave_setup/leave_entitlement.php';
        include '../app/Views/layouts/admin.php';
    }

    public function LeaveEntitlementDetail()
    {
        $title = 'Leave Entitlement Detail';
        $currentPage = 'leave_entitlement';
        // Authorization is enforced via RoleMiddleware on the route. Require an explicit `year` query parameter.
        $allFinancialYears = $this->leaveEntitlementService->getFinancialYearConfigurationSummary();

        $hasYear = array_key_exists('year', $_GET) && trim((string) ($_GET['year'] ?? '')) !== '';

        // If no explicit year provided, treat as missing resource (404) per new policy.
        if (!$hasYear) {
            (new ErrorController())->notFound();
        }

        $rawYear = (string) ($_GET['year'] ?? '');
        $normalizedYear = $this->normalizeYearLabelLocal($rawYear);

        // Build set of known normalized labels
        $known = [];
        foreach ($allFinancialYears as $fy) {
            $label = (string) ($fy->label ?? '');
            $known[$this->normalizeYearLabelLocal($label)] = true;
        }

        // If explicitly supplied year is not known, return 404 (do not silently fallback)
        if (!isset($known[$normalizedYear])) {
            (new ErrorController())->notFound();
        }

        // Safe to fetch entitlements for the validated year.
        $selectedYear = $normalizedYear;
        $entitlements = $this->leaveEntitlementService->getEntitlementsForYear($selectedYear);
        $csrf = Csrf::generate();

        // Provide eligible leave types (active leave types without an entitlement for this FY)
        $eligibleLeaveTypes = $this->leaveEntitlementService->getAvailableLeaveTypesForYear($selectedYear);

        $content = '../app/Views/leave_management/leave_setup/leave_entitlement_detail.php';
        include '../app/Views/layouts/admin.php';
    }

    public function storeLeaveEntitlement()
    {
        try {
            // Ensure request is POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Session::flash('error', 'Invalid request method.');
                header('Location: /leave-entitlements');
                exit;
            }

            Csrf::validate($_POST['csrf_token'] ?? '');

            $year = $_POST['year'] ?? '';

            // Reject edit attempts in this Add-only action
            $editId = trim((string) ($_POST['edit_id'] ?? ''));
            if ($editId !== '') {
                throw new \InvalidArgumentException('Editing entitlements is not supported in this action.');
            }

            // Validate leave_type input is present and numeric
            if (!isset($_POST['leave_type']) || trim((string) $_POST['leave_type']) === '') {
                throw new \InvalidArgumentException('Please select a leave type.');
            }

            $leaveTypeId = (int) $_POST['leave_type'];
            if ($leaveTypeId <= 0) {
                throw new \InvalidArgumentException('Selected leave type is invalid.');
            }

            // Entitlement days: required, numeric, whole number, >= 0
            if (!isset($_POST['entitlement_days']) || trim((string) $_POST['entitlement_days']) === '') {
                throw new \InvalidArgumentException('Please provide entitlement days.');
            }
            if (!is_numeric($_POST['entitlement_days'])) {
                throw new \InvalidArgumentException('Entitlement must be a whole number.');
            }
            $entitlementDaysRaw = $_POST['entitlement_days'];
            if ((string) ((int) $entitlementDaysRaw) !== (string) (string) $entitlementDaysRaw && (float) $entitlementDaysRaw != (int) $entitlementDaysRaw) {
                // Detect decimals like "1.5" by comparing int cast
                throw new \InvalidArgumentException('Entitlement must be a whole number.');
            }
            $entitlementDays = (int) $entitlementDaysRaw;
            if ($entitlementDays < 0) {
                throw new \InvalidArgumentException('Entitlement must be 0 or greater.');
            }

            // Carry forward must be explicitly 'Yes' or 'No'
            if (!isset($_POST['carry_forward']) || !in_array($_POST['carry_forward'], ['Yes', 'No'], true)) {
                throw new \InvalidArgumentException('Carry Forward selection is required.');
            }
            $carryForwardRaw = $_POST['carry_forward'];
            $carryForward = $carryForwardRaw === 'Yes' ? 1 : 0;

            // Carry forward limit validation
            $carryForwardLimitRaw = $_POST['carry_forward_limit'] ?? '';
            if ($carryForward === 0) {
                // When carry_forward is No, the submitted limit MUST be exactly 0 or empty
                $limitVal = $carryForwardLimitRaw === '' ? 0 : $carryForwardLimitRaw;
                if (!is_numeric($limitVal) || (int) $limitVal !== 0) {
                    throw new \InvalidArgumentException('Maximum carry forward must be 0 when carry forward is disabled.');
                }
                $carryForwardLimit = 0;
            } else {
                // When Yes: required, numeric, whole number, >= 0
                if ($carryForwardLimitRaw === '' || !is_numeric($carryForwardLimitRaw)) {
                    throw new \InvalidArgumentException('Please provide a numeric maximum carry forward value.');
                }
                if ((float) $carryForwardLimitRaw != (int) $carryForwardLimitRaw) {
                    throw new \InvalidArgumentException('Maximum carry forward must be a whole number.');
                }
                $carryForwardLimit = (int) $carryForwardLimitRaw;
                if ($carryForwardLimit < 0) {
                    throw new \InvalidArgumentException('Maximum carry forward must be 0 or greater.');
                }
            }

            $data = [
                'leave_type_id' => $leaveTypeId,
                'entitlement' => $entitlementDays,
                'carry_forward' => $carryForward,
                'carry_forward_limit' => $carryForwardLimit,
            ];

            $createdId = $this->leaveEntitlementService->create((string) $year, $data);

            $leaveTypeService = new \App\Services\LeaveTypeService();
            $lt = $leaveTypeService->findById((int) $data['leave_type_id']);
            $leaveName = $lt ? $lt->name : 'Leave type';

            Session::flash('success', $leaveName . ' entitlement added successfully for FY ' . $year . '.');
            header('Location: /leave-entitlements/detail?year=' . urlencode($year));
            exit;
        } catch (\InvalidArgumentException $e) {
            Session::flash('error', $e->getMessage());
            $year = $_POST['year'] ?? '';
            header('Location: /leave-entitlements/detail?year=' . urlencode((string) $year));
            exit;
        } catch (\Exception $e) {
            Session::flash('error', 'Unable to save entitlement. Please try again.');
            $year = $_POST['year'] ?? '';
            header('Location: /leave-entitlements/detail?year=' . urlencode((string) $year));
            exit;
        }
    }

    /**
     * Local copy of the year-normalization logic used by the service.
     * Kept private and minimal to validate query input consistently.
     */
    private function normalizeYearLabelLocal(string $yearLabel): string
    {
        $value = trim((string) $yearLabel);
        $value = str_replace(' ', '', $value);
        $value = str_replace('–', '/', $value);
        $value = str_replace('—', '/', $value);
        $value = preg_replace('/\s*\/\s*/', '/', $value) ?? $value;

        return $value;
    }

    public function storeLeaveType()
    {
        try {
            Csrf::validate($_POST['csrf_token'] ?? '');

            $data = [
                'name' => $_POST['name'] ?? $_POST['leave_name'] ?? '',
                'calculation_method' => $_POST['calculation_method'] ?? 'working_days',
            ];

            $createdId = $this->leaveTypeService->create($data);

            Session::flash('success', 'Leave type created successfully.');
            header('Location: /leave-types');
            exit;
        } catch (InvalidArgumentException $e) {
            Session::flash('error', $e->getMessage());
            header('Location: /leave-types');
            exit;
        } catch (\Exception $e) {
            Session::flash('error', 'Unable to create leave type. Please try again.');
            header('Location: /leave-types');
            exit;
        }
    }

    public function LeavePeriod()
    {
        $title = 'Leave Periods';
        $currentPage = 'leave_period';
        $periods = $this->leaveModel->all();
        $content = '../app/Views/leave_management/leave_setup/leave_period.php';
        include '../app/Views/layouts/admin.php';
    }

    public function NewLeavePeriod()
    {
        $title = 'New Leave Period';
        $currentPage = 'leave_period';
        $content = '../app/Views/leave_management/leave_setup/new_leave_period.php';
        include '../app/Views/layouts/admin.php';
    }

    public function storeLeavePeriod()
    {
        try {
            Csrf::validate($_POST['csrf_token'] ?? '');
        } catch (\Exception $e) {
            Session::flash('error', 'Security validation failed. Please try again.');
            header('Location: /new-leave-period');
            exit;
        }

        $validator = new Validator();
        $rules = [
            'from_date' => 'required'
        ];

        if (!$validator->validate($_POST, $rules)) {
            Session::flash('error', 'Please provide a valid start date for the financial year.');
            header('Location: /new-leave-period');
            exit;
        }

        $fromDate = $this->parseDate($_POST['from_date']);
        if (!$fromDate) {
            Session::flash('error', 'Please choose a valid start date for the financial year.');
            header('Location: /new-leave-period');
            exit;
        }

        $financialYear = $this->calculateFinancialYear($fromDate);
        $toDate = $financialYear['end_date'];
        $label = $financialYear['label'];

        if ($this->leaveModel->existsForRange($fromDate, $toDate)) {
            Session::flash('error', 'A leave period with this financial year already exists. Please use a different start date or edit the existing record.');
            header('Location: /new-leave-period');
            exit;
        }

        if ($this->leaveModel->existsByLabel($label)) {
            Session::flash('error', 'The financial year label ' . $label . ' already exists.');
            header('Location: /new-leave-period');
            exit;
        }

        $isCurrent = isset($_POST['is_active']) && $_POST['is_active'] == '1' ? 1 : 0;
        if (!in_array($isCurrent, [0, 1], true)) {
            Session::flash('error', 'The active flag is invalid.');
            header('Location: /new-leave-period');
            exit;
        }

        $createdId = $this->leaveModel->create([
            'label' => $label,
            'start_date' => $fromDate,
            'end_date' => $toDate,
            'is_current' => $isCurrent,
        ]);

        if ($createdId === false) {
            Session::flash('error', 'Unable to save the leave period. Please try again.');
            header('Location: /new-leave-period');
            exit;
        }

        if ($isCurrent) {
            $this->leaveModel->setCurrentPeriod((int) $createdId);
        }

        Session::flash('success', 'Leave period saved successfully.');
        header('Location: /new-leave-period');
        exit;
    }

    protected function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        $value = trim($value);
        $date = \DateTime::createFromFormat('d/m/Y', $value);

        if ($date === false) {
            $date = new \DateTime($value);
        }

        if ($date === false || $date->format('Y-m-d') === '1970-01-01') {
            return null;
        }

        return $date->format('Y-m-d');
    }

    protected function calculateFinancialYear($startDate)
    {
        $date = new \DateTime($startDate);
        $year = (int) $date->format('Y');
        $fiscalStartYear = $date->format('n') >= 7 ? $year : $year - 1;
        $fiscalEndYear = $fiscalStartYear + 1;

        $start = new \DateTime(sprintf('%d-07-01', $fiscalStartYear));
        $end = new \DateTime(sprintf('%d-06-30', $fiscalEndYear));

        return [
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'label' => sprintf('%d/%d', $fiscalStartYear, $fiscalEndYear),
        ];
    }

    public function updateLeavePeriodStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Session::flash('error', 'Invalid request method for updating the leave period.');
            header('Location: /leave-periods');
            exit;
        }

        $token = $_POST['csrf_token'] ?? '';
        try {
            Csrf::validate($token);
        } catch (\Exception $e) {
            Session::flash('error', 'Security validation failed. Please try again.');
            header('Location: /leave-periods');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            Session::flash('error', 'A valid leave period is required.');
            header('Location: /leave-periods');
            exit;
        }

        $period = $this->leaveModel->find($id);
        if (!$period) {
            Session::flash('error', 'The leave period could not be found.');
            header('Location: /leave-periods');
            exit;
        }

        $isCurrent = isset($_POST['is_current']) && $_POST['is_current'] == '1' ? 1 : 0;
        $wasCurrent = !empty($period->is_current);

        if ($isCurrent) {
            $this->leaveModel->setCurrentPeriod($id);
            Session::flash('success', 'Leave period marked as active successfully.');
            header('Location: /leave-periods');
            exit;
        }

        if ($wasCurrent) {
            $this->leaveModel->setInactive($id);
            $this->leaveModel->setCurrentPeriodByLatestStartDate();
            Session::flash('success', 'Leave period marked as inactive and the latest available period was set as current.');
        } else {
            $this->leaveModel->setInactive($id);
            Session::flash('success', 'Leave period marked as inactive.');
        }

        header('Location: /leave-periods');
        exit;
    }

    public function deleteLeavePeriod()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Session::flash('error', 'Invalid request method for delete action.');
            header('Location: /leave-periods');
            exit;
        }

        $token = $_POST['csrf_token'] ?? '';
        try {
            Csrf::validate($token);
        } catch (\Exception $e) {
            Session::flash('error', 'Security validation failed. Please try again.');
            header('Location: /leave-periods');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            Session::flash('error', 'A valid leave period is required for deletion.');
            header('Location: /leave-periods');
            exit;
        }

        $period = $this->leaveModel->find($id);
        if (!$period) {
            Session::flash('error', 'The leave period could not be found.');
            header('Location: /leave-periods');
            exit;
        }

        $deleted = $this->leaveModel->delete($id);
        if (!$deleted) {
            Session::flash('error', 'Unable to delete the leave period. Please try again.');
            header('Location: /leave-periods');
            exit;
        }

        if (!empty($period->is_current)) {
            $this->leaveModel->setCurrentPeriodByLatestStartDate();
        }

        Session::flash('success', 'Leave period deleted successfully.');
        header('Location: /leave-periods');
        exit;
    }

    public function LeavePolicy()
    {
        $title = 'Leave Policies';
        $currentPage = 'leave_policy';
        $old = \App\Core\Session::flash('leave_policy_old') ?: [];

        // Resolve current financial year
        $financialYearModel = new \App\Models\FinancialYear();
        $currentFy = $financialYearModel->getCurrentPeriod();
        $currentFyId = $currentFy ? (int) $currentFy->id : null;

        // Load policies with configured counts for the current financial year
        $policies = $this->leavePolicyService->allWithEntitlementCounts($currentFyId);

        // Summary stats
        $totalPolicies = count($policies);
        $activePolicies = count(array_filter($policies, fn($p) => !empty($p->is_active)));
        $inactivePolicies = $totalPolicies - $activePolicies;

        $content = '../app/Views/leave_management/leave_setup/leave_policy.php';
        include '../app/Views/layouts/admin.php';
    }

    public function togglePolicyActive()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Session::flash('error', 'Invalid request method.');
                header('Location: /leave-policies');
                exit;
            }

            Csrf::validate($_POST['csrf_token'] ?? '');

            $id = (int) ($_POST['id'] ?? 0);
            $action = $_POST['action'] ?? '';

            if ($id <= 0 || !in_array($action, ['activate', 'deactivate'], true)) {
                throw new InvalidArgumentException('Invalid request.');
            }

            $isActive = $action === 'activate' ? 1 : 0;

            $this->leavePolicyService->setActive($id, $isActive);

            Session::flash('success', 'Policy updated successfully.');
            header('Location: /leave-policies');
            exit;
        } catch (InvalidArgumentException $e) {
            Session::flash('error', $e->getMessage());
            header('Location: /leave-policies');
            exit;
        } catch (\Exception $e) {
            Session::flash('error', 'Unable to update policy. Please try again.');
            header('Location: /leave-policies');
            exit;
        }
    }

    public function storeLeavePolicy()
    {
        $name = trim((string) ($_POST['name'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $isActive = $this->boolFromCheckbox($_POST, 'is_active');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Session::flash('error', 'Invalid request method.');
                header('Location: /leave-policies');
                exit;
            }

            Csrf::validate($_POST['csrf_token'] ?? '');

            $name = trim((string) ($_POST['name'] ?? ''));
            $description = trim((string) ($_POST['description'] ?? ''));
            $isActive = $this->boolFromCheckbox($_POST, 'is_active');

            if ($name === '') {
                throw new InvalidArgumentException('Policy name is required.');
            }

            $payload = [
                'name' => $name,
                'description' => $description,
                'is_active' => $isActive,
            ];

            $this->leavePolicyService->create($payload);

            Session::flash('success', 'Policy created successfully.');
            header('Location: /leave-policies');
            exit;
        } catch (InvalidArgumentException $e) {
            Session::flash('leave_policy_old', [
                'name' => $name,
                'description' => $description,
                'is_active' => $isActive,
            ]);
            Session::flash('error', $e->getMessage());
            header('Location: /leave-policies');
            exit;
        } catch (\Exception $e) {
            Session::flash('leave_policy_old', [
                'name' => $name,
                'description' => $description,
                'is_active' => $isActive,
            ]);
            Session::flash('error', 'Unable to create policy. Please try again.');
            header('Location: /leave-policies');
            exit;
        }
    }

    public function leavePolicyDetail()
    {
        $title = 'Leave Policy Detail';
        $currentPage = 'leave-policy-detail';
        $csrf = Csrf::generate();

        $policyId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $policy = $this->leavePolicyService->findPolicy($policyId);

        if (!$policy) {
            Session::flash('error', 'Policy not found');
            header('Location: /leave-policies');
            exit;
        }

        $financialYearModel = new \App\Models\FinancialYear();
        $financialYears = $financialYearModel->all();
        $currentFy = $financialYearModel->getCurrentPeriod();

        $requestedFyId = isset($_GET['fy']) ? (int) $_GET['fy'] : 0;
        $validFyIds = array_map(static fn($fy) => (int) $fy->id, $financialYears);

        if ($requestedFyId <= 0 || !in_array($requestedFyId, $validFyIds, true)) {
            $requestedFyId = $currentFy ? (int) $currentFy->id : (int) ($financialYears[0]->id ?? 0);
        }

        $currentFyId = $requestedFyId;
        $currentFy = null;
        foreach ($financialYears as $fy) {
            if ((int) $fy->id === $currentFyId) {
                $currentFy = $fy;
                break;
            }
        }

        $rows = $this->leavePolicyService->getEntitlementsWithDetails($policyId, $currentFyId);

        $content = '../app/Views/leave_management/leave_setup/leave_policy_details.php';
        include '../app/Views/layouts/admin.php';
    }

    public function HolidayList()
    {
        $title = 'Holiday Lists';
        $currentPage = 'holiday_list';
        $content = '../app/Views/leave_management/leave_setup/holiday_list.php';
        include '../app/Views/layouts/admin.php';
    }
}


