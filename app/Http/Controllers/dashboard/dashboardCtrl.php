<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class dashboardCtrl extends Controller
{
    //=== Open Home Page Function ===
    public function index()
    {
        return view('dashboard.home');
    }
    //=== End Function ===

}
