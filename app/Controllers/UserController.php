<?php
namespace App\Controllers;

class UserController extends Controller
{

    public function index() // Profile page main
    {
        $title = 'profile';
        $currentPage = 'user_profile';
        $content = __DIR__ . '/../Views/user/index.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }

    public function SystemSetting() // setting up some universal setting eg user accounts
    {
        $title = 'Sytem Settings';
        $currentPage = 'system_settings';
        $content = __DIR__ . '/../Views/user/system_settings.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }

}
