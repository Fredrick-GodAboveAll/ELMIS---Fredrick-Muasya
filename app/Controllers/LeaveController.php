<?php
namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Session;
use App\Models\Leave;
use App\Utils\Validator;

class LeaveController extends Controller
{
    protected $leaveModel;

    public function __construct()
    {
        $this->leaveModel = new Leave();
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
        include '../app/Views/layouts/admin.php';
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
        $content = '../app/Views/leave_management/leave_setup/leave_policy.php';
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


