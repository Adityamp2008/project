<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\KelayakanAssets;
use App\Models\AtkItem;
use App\Models\StockTransaction;
use App\Models\RiwayatPerbaikan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard petugas
     */
    public function index()
    {
        // =============================
        // 📊 STATISTIK UTAMA
        // =============================
        $total_aset         = Assets::count();
        $aset_layak         = KelayakanAssets::where('status_kelayakan', 'Layak')->count();
        $aset_kurang_layak  = KelayakanAssets::where('status_kelayakan', 'Kurang Layak')->count();
        $aset_tidak_layak   = KelayakanAssets::where('status_kelayakan', 'Tidak Layak')->count();
        $stok_rendah        = AtkItem::whereColumn('stock', '<=', 'low_stock_threshold')->count();

        // =============================
        // 🔔 NOTIFIKASI ASET BERMASALAH
        // =============================
        $notif_aset = KelayakanAssets::with('asset')
            ->whereIn('status_kelayakan', ['Tidak Layak', 'Kurang Layak'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->asset->nama ?? '-',
                    'status' => $item->status_kelayakan,
                ];
            });

        // =============================
        // 🥧 GRAFIK DONUT KELAYAKAN
        // =============================
        $grafik_kelayakan = [
            'Layak' => $aset_layak,
            'Kurang Layak' => $aset_kurang_layak,
            'Tidak Layak' => $aset_tidak_layak,
        ];

        // =============================
        // 📈 GRAFIK PEMAKAIAN ATK PER BULAN
        // =============================
        $grafik_atk = StockTransaction::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(quantity) as total')
            )
            ->where('type', 'out')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Ubah angka bulan → nama bulan (biar lebih enak dibaca di chart)
        $grafik_atk_label = [];
        $grafik_atk_data  = [];
        foreach ($grafik_atk as $bulan => $total) {
            $grafik_atk_label[] = Carbon::create()->month($bulan)->translatedFormat('F');
            $grafik_atk_data[] = $total;
        }

        // =============================
        // 🧰 RIWAYAT PERBAIKAN TERBARU
        // =============================
        $riwayat_perbaikan = RiwayatPerbaikan::with('asset')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($r) {
                return (object)[
                    'nama_aset' => $r->asset->nama ?? '-',
                    'tanggal' => $r->tanggal ? Carbon::parse($r->tanggal)->format('d M Y') : '-',
                    'deskripsi' => $r->deskripsi ?? '-',
                    'biaya' => number_format($r->biaya ?? 0, 0, ',', '.'),
                ];
            });

        // =============================
        // 📦 KIRIM KE VIEW
        // =============================
        return view('pages.petugas.dashboard', compact(
            'total_aset',
            'aset_layak',
            'aset_kurang_layak',
            'aset_tidak_layak',
            'stok_rendah',
            'notif_aset',
            'grafik_kelayakan',
            'grafik_atk_label',
            'grafik_atk_data',
            'riwayat_perbaikan'
        ));
    }
}
