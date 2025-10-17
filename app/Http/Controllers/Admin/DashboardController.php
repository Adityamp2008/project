<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    //page login berada pada resources view auth login.blade.php
    public function index(){
        return view('pages.admin.dashboard');
    }
}
