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
        // Show the unified bulk import UI.
        // The view `apps/bulk_actions.php` contains the upload forms for employees, leave and allowances.
        $title = 'Bulk Actions';
        // Align current page identifier with the view which uses 'bulk_import'.
        $currentPage = 'bulk_import';
        $content = '../app/Views/apps/bulk_actions.php';
        include '../app/Views/layouts/admin.php';
    }
}
