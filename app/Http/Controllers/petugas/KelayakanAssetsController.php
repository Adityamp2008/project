<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\KelayakanAssets;
use App\Models\LaporanKelayakan;
use Illuminate\Http\Request;

class KelayakanAssetsController extends Controller
{
    public function index()
    {
        $kelayakanassets = KelayakanAssets::with('asset')->orderBy('id')->get();
        return view('pages.petugas.kelayakanassets.index', compact('kelayakanassets'));
    }

    public function laporkan(Request $request, $id)
    {
        $kelayakan = KelayakanAssets::findOrFail($id);

        // Cek apakah laporan pending masih ada
        $existing = LaporanKelayakan::where('asset_id', $kelayakan->asset_id)
                    ->where('status', 'pending')
                    ->first();

        if ($existing) {
            return back()->with('warning', 'Aset ini sudah dilaporkan dan menunggu persetujuan.');
        }

        LaporanKelayakan::create([
            'asset_id' => $kelayakan->asset_id,
            'catatan_petugas' => $request->catatan_petugas ?? 'Perlu pemeriksaan oleh Kepdin.'
        ]);

        return back()->with('success', 'Laporan telah dikirim ke Kepdin untuk diperiksa.');
    }
}
