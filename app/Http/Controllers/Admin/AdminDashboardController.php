<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $activeUsers = User::activeUsers();
        $adminUsers = User::adminUsers();

        return View('admin.index', compact('activeUsers', 'adminUsers'));
    }
}
