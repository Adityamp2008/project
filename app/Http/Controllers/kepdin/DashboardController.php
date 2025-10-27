<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AtkItem;
use App\Models\PengajuanPenghapusanAset;
use App\Models\PenghapusanAtk;
use App\Models\LaporanKelayakan;
use App\Models\RiwayatPerbaikan;

class DashboardController extends Controller
{
    public function index()
{
    $data = [
        'totalAset' => Assets::count(),
        'totalAtk' => Assets::where('kategori', 'ATK')->count(),
        'totalLaporanKelayakan' => \App\Models\KelayakanAssets::count(),
        'totalPerbaikan' => \App\Models\RiwayatPerbaikan::count(),
    ];

    // Contoh notifikasi aset rusak / bermasalah
    $notifikasi = Assets::where('kondisi', 'Rusak')
        ->orWhere('kondisi', 'Perlu Perbaikan')
        ->get(['nama', 'kondisi as status'])
        ->map(fn($a) => [
            'nama' => $a->nama,
            'status' => ucfirst($a->status)
        ])
        ->toArray();

    return view('pages.kepdin.dashboard', compact('data', 'notifikasi'));
}

    
}
