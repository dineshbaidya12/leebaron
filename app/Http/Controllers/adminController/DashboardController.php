<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}
