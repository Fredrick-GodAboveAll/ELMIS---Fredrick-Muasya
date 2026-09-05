<?php
namespace App\Controllers;

use App\Services\LeaveCalculator;
use App\Services\LeavePeriodService;
use App\Services\LeaveTypeService;

class ToolsController
{
    public function leaveCalculator()
    {
        $title = 'Leave Calculator Test';
        // set page key so Nav 2 highlights under Leave → Setup
        $currentPage = 'leave_calculator';
        $result = null;
        $errors = [];
        $leaveTypeService = new LeaveTypeService();
        $leavePeriodService = new LeavePeriodService();
        $leaveTypes = $leaveTypeService->all();

        // Start session so we can use flash messages for PRG
        \App\Core\Session::start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start = $_POST['start_date'] ?? '';
            $leaveTypeId = isset($_POST['leave_type_id']) && $_POST['leave_type_id'] !== '' ? (int) $_POST['leave_type_id'] : null;
            $numberOfDays = isset($_POST['number_of_days']) && $_POST['number_of_days'] !== '' ? (int) $_POST['number_of_days'] : null;
            $calculator = new LeaveCalculator();

            // save posted input so we can repopulate after redirect
            \App\Core\Session::flash('leave_calc_input', [
                'start_date' => $start,
                'leave_type_id' => $leaveTypeId,
                'number_of_days' => $_POST['number_of_days'] ?? '',
            ]);

            try {
                if ($leaveTypeId === null || $leaveTypeId < 1) {
                    throw new \InvalidArgumentException('Please select a Leave Type.');
                }

                $selectedLeaveType = $leaveTypeService->findActiveById($leaveTypeId);
                if (!$selectedLeaveType) {
                    throw new \InvalidArgumentException('The selected Leave Type is not active or could not be found.');
                }

                $calculationMethod = $selectedLeaveType->calculation_method ?? 'working_days';
                if (!in_array($calculationMethod, ['working_days', 'calendar_days'], true)) {
                    throw new \InvalidArgumentException('Invalid calculation method for the selected Leave Type.');
                }

                if ($start === '') {
                    throw new \InvalidArgumentException('Please provide a Start Date.');
                }
                if ($numberOfDays === null || $numberOfDays < 1) {
                    throw new \InvalidArgumentException('Please provide a valid Number of Days.');
                }

                $leavePeriod = $leavePeriodService->resolveForDate($start);
                if (!$leavePeriod) {
                    throw new \InvalidArgumentException('Leave period does not exist for the selected Start Date. Please try again.');
                }

                $leaveTypeService->validateRequestedDaysAgainstEntitlement($leaveTypeId, $numberOfDays);

                $endDate = $calculator->calculateEndDate($start, $numberOfDays, $calculationMethod);
                $returnDate = $calculator->calculateReturnDate($endDate);

                \App\Core\Session::flash('leave_calc_result', $numberOfDays);
                \App\Core\Session::flash('leave_calc_leave_period', $leavePeriod->label);
                \App\Core\Session::flash('leave_calc_end_date', $endDate);
                \App\Core\Session::flash('leave_calc_return_date', $returnDate);
            } catch (\InvalidArgumentException $e) {
                \App\Core\Session::flash('leave_calc_error', $e->getMessage());
            } catch (\Throwable $e) {
                \App\Core\Session::flash('leave_calc_error', 'Could not calculate dates. Please check the values entered.');
            }

            // Redirect to avoid resubmission (POST-Redirect-GET)
            header('Location: /tools/leave-calculator');
            exit;
        }

        // On GET render, read flash values
        $result = \App\Core\Session::flash('leave_calc_result');
        $leavePeriodResult = \App\Core\Session::flash('leave_calc_leave_period');
        $endDateResult = \App\Core\Session::flash('leave_calc_end_date');
        $returnDateResult = \App\Core\Session::flash('leave_calc_return_date');
        $oldInput = \App\Core\Session::flash('leave_calc_input') ?: [];
        if ($err = \App\Core\Session::flash('leave_calc_error')) {
            $errors[] = $err;
        }

        $content = '../app/Views/tools/leave_calculator.php';
        include '../app/Views/layouts/admin.php';
    }
}
