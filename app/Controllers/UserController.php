<?php
namespace App\Controllers;

class UserController extends Controller
{

    public function index() // Profile page main
    {
        $title = 'profile';
        $currentPage = 'user_profile';
        $content = '../app/Views/user/index.php';
        include '../app/Views/layouts/admin.php';
    }

    public function SystemSetting() // setting up some universal setting eg user accounts
    {
        $title = 'Sytem Settings';
        $currentPage = 'system_settings';
        $content = '../app/Views/user/system_settings.php';
        include '../app/Views/layouts/admin.php';
    }

}
