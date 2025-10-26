<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKelayakan;
use Illuminate\Http\Request;

class LaporanKelayakanController extends Controller
{
    public function index()
    {
        $laporan = LaporanKelayakan::with('asset')->orderByDesc('created_at')->get();
        return view('pages.kepdin.laporan.index', compact('laporan'));
    }

    public function approve($id)
    {
        $laporan = LaporanKelayakan::findOrFail($id);
        $laporan->update([
            'status' => 'approved',
            'approved_at' => now(),
            'catatan_kepdin' => 'Laporan di setujui'
        ]);

        return back()->with('success', 'Laporan telah disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $laporan = LaporanKelayakan::findOrFail($id);
        $laporan->update([
            'status' => 'rejected',
            'catatan_kepdin' => $request->catatan_kepdin ?? 'Laporan Ditolak'
        ]);

        return back()->with('error', 'Laporan telah ditolak.');
    }
}
