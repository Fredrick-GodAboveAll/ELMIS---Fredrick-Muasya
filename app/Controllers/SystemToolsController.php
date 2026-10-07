<?php
namespace App\Controllers;

class SystemToolsController extends Controller
{

    public function SystemCalender() // sence of timing and events calender eg on leave, work etc
    {
        $title = 'Leave Calender';
        $currentPage = 'system_calender';
        $content = __DIR__ . '/../Views/apps/system_calender.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }

    public function SystemBulkUpload()
    {
        // Show the unified bulk import UI.
        // The view `apps/bulk_actions.php` contains the upload forms for employees, leave and allowances.
        $title = 'Bulk Actions';
        // Align current page identifier with the view which uses 'bulk_import'.
        $currentPage = 'bulk_import';
        $content = __DIR__ . '/../Views/apps/bulk_actions.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }
}
