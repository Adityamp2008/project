<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;      // Tambah
use App\Models\Kategori;  // Tambah

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'total_users'     => User::count(),
            'total_admin'     => User::where('role', 'admin')->count(),
            'total_petugas'   => User::where('role', 'petugas')->count(),
            'total_kepdin'    => User::where('role', 'kepdin')->count(),
            'total_rooms'     => Room::count(),
            'total_categories'=> Kategori::count(),
        ]);
    }
}
