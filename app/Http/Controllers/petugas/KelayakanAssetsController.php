<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\KelayakanAssets;
use App\Models\LaporanKelayakan;
use Illuminate\Http\Request;

class KelayakanAssetsController extends Controller
{
    /**
     * Tampilkan daftar kelayakan aset.
     */
    public function index()
    {
        $kelayakanassets = KelayakanAssets::with(['asset'])
            ->whereIn('status_kelayakan', ['Kurang Layak', 'Tidak Layak'])
            ->get();
        return view('pages.petugas.kelayakanassets.index', compact('kelayakanassets'));
    }

    /**
     * Laporkan aset ke Kepdin.
     * Cek dulu apakah sudah ada laporan pending, jika belum buat laporan baru.
     */
    public function laporkan(Request $request, $id)
    {
        $kelayakan = KelayakanAssets::findOrFail($id);

        // Cek laporan pending
        $existing = LaporanKelayakan::where('asset_id', $kelayakan->asset_id)
                    ->where('status', 'pending')
                    ->first();

        if ($existing) {
            return back()->with('warning', 'Aset ini sudah dilaporkan dan menunggu persetujuan.');
        }

        LaporanKelayakan::create([
            'asset_id' => $kelayakan->asset_id,
            'catatan_petugas' => $request->catatan_petugas ?? 'Perlu pemeriksaan oleh Kepdin.',
            'status' => 'pending', // status default laporan
        ]);

        return back()->with('success', 'Laporan telah dikirim ke Kepdin untuk diperiksa.');
    }
}
