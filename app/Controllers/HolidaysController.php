<?php
namespace App\Controllers;

class HolidaysController extends Controller
{
    public function index()
    {
        $title = 'Holidays';
        $currentPage = 'holidays';
        $content = '../app/Views/holidays/index.php';
        include '../app/Views/layouts/admin.php';
    }

    public function newHolidayList()
    {
        $title = 'New Holiday List';
        $currentPage = 'holidays';
        $content = '../app/Views/holidays/new_holiday_list.php';
        include '../app/Views/layouts/admin.php';
    }

    public function Hout_list()
    {
        $title = 'List of resources';
        $currentPage = 'HoutPage';
        $content = '../app/Views/holidays/Hout.php';
        include '../app/Views/layouts/admin.php';
    }
}
