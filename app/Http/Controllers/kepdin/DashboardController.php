<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\Kategori;
use App\Models\KelayakanAssets;
use App\Models\RiwayatPerbaikan;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalAset' => Assets::count(),
            'totalAtk' => Assets::where('kategori_id', 'ATK')->count(),
            'totalLaporanKelayakan' => KelayakanAssets::count(),
            'totalPerbaikan' => RiwayatPerbaikan::count(),
        ];

        $notifikasi = Assets::whereIn('kondisi', ['Rusak', 'Perlu Perbaikan'])
            ->get(['nama', 'kondisi as status'])
            ->map(fn($a) => [
                'nama' => $a->nama,
                'status' => ucfirst($a->status),
            ])
            ->toArray();

        return view('pages.kepdin.dashboard', compact('data', 'notifikasi'));
    }
}
