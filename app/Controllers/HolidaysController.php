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
}
