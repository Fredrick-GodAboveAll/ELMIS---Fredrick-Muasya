<?php
namespace App\Controllers;

class SystemToolsController extends Controller
{

    public function SystemCalender() // sence of timing and events calender eg on leave, work etc
    {
        $title = 'Leave Calender';
        $currentPage = 'system_calender';
        $content = '../app/Views/apps/system_calender.php';
        include '../app/Views/layouts/admin.php';
    }

    public function SystemBulkUpload()
    {
        $title = 'Bulk Actions';
        $currentPage = 'bulk_leave_actions';
        $content = '../app/Views/apps/bulk_actions.php';
        include '../app/Views/layouts/admin.php';
    }
}
