<?php
namespace App\Controllers;

use App\Services\LeaveCalculator;

class ToolsController
{
    public function leaveCalculator()
    {
        $title = 'Leave Calculator Test';
        // set page key so Nav 2 highlights under Leave → Setup
        $currentPage = 'leave_calculator';
        $result = null;
        $errors = [];

        // Start session so we can use flash messages for PRG
        \App\Core\Session::start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start = $_POST['start_date'] ?? '';
            $leaveType = $_POST['leave_type'] ?? null;
            $numberOfDays = isset($_POST['number_of_days']) && $_POST['number_of_days'] !== '' ? (int) $_POST['number_of_days'] : null;
            $calculator = new LeaveCalculator();

            // save posted input so we can repopulate after redirect
            \App\Core\Session::flash('leave_calc_input', [
                'start_date' => $start,
                'leave_type' => $leaveType,
                'number_of_days' => $_POST['number_of_days'] ?? '',
            ]);

            try {
                if ($leaveType === null || $leaveType === '') {
                    throw new \InvalidArgumentException('Please select a Leave Type.');
                }
                if ($start === '') {
                    throw new \InvalidArgumentException('Please provide a Start Date.');
                }
                if ($numberOfDays === null || $numberOfDays < 1) {
                    throw new \InvalidArgumentException('Please provide a valid Number of Days.');
                }

                // compute end date from start + number of days (let service infer method from leave type)
                $endDate = $calculator->calculateEndDate($start, $numberOfDays, null, $leaveType);
                $returnDate = $calculator->calculateReturnDate($endDate);

                \App\Core\Session::flash('leave_calc_result', $numberOfDays);
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
