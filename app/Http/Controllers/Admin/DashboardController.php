<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\AtkItem;
use App\Models\KelayakanAssets;
use App\Models\StockTransaction;
use App\Models\RiwayatPerbaikan; // kalau tabel ini belum ada, aman
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard Super Admin
     */
    public function index()
    {
        // === 1️⃣ TOTAL ASET ===
        $total_aset = Assets::count();

        // === 2️⃣ STATUS KELAYAKAN ===
        $aset_layak        = KelayakanAssets::where('status_kelayakan', 'Layak')->count();
        $aset_kurang_layak = KelayakanAssets::where('status_kelayakan', 'Kurang Layak')->count();
        $aset_tidak_layak  = KelayakanAssets::where('status_kelayakan', 'Tidak Layak')->count();

        // === 3️⃣ STOK RENDAH (ATK) ===
        $stok_rendah = AtkItem::whereColumn('stock', '<=', 'low_stock_threshold')->count();

        // === 4️⃣ NOTIFIKASI ASET BERMASALAH ===
        $notif_aset = Assets::whereIn('kondisi', ['rusak', 'cukup', 'kurang baik'])
            ->orderBy('nama')
            ->take(5)
            ->get(['nama', 'kondisi'])
            ->map(function ($a) {
                return [
                    'nama' => $a->nama,
                    'status' => ucfirst($a->kondisi),
                ];
            });

        // === 5️⃣ RIWAYAT PERBAIKAN TERBARU ===
        // $riwayat_perbaikan = [];
        // if (class_exists(RiwayatPerbaikan::class)) {
        //     $riwayat_perbaikan = RiwayatPerbaikan::latest()->take(5)->get();
        // }

        // === 6️⃣ DATA GRAFIK PEMAKAIAN ATK ===
        $grafik_atk = StockTransaction::selectRaw('MONTH(created_at) as bulan, SUM(quantity) as total')
            ->where('type', 'out')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // === KIRIM KE VIEW ===
        return view('pages.admin.dashboard', compact(
            'total_aset',
            'aset_layak',
            'aset_kurang_layak',
            'aset_tidak_layak',
            'stok_rendah',
            'notif_aset',
            // 'riwayat_perbaikan',
            'grafik_atk'
        ));
    }
}
