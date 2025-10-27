<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPerbaikan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\LaporanPerbaikanExport;

class LaporanPerbaikanController extends Controller
{
    /**
     * Tampilkan halaman laporan perbaikan
     */
    public function laporan(Request $request)
    {
        $riwayats = RiwayatPerbaikan::with('asset')->latest()->get();

        return view('pages.kepdin.laporan.perbaikan', compact('riwayats'));
    }

    /**
     * Export ke PDF
     */
    public function laporanPdf()
    {
        $riwayats = RiwayatPerbaikan::with('asset')->latest()->get();

        $pdf = PDF::loadView('pages.kepdin.laporan_pdf', compact('riwayats'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('perbaikan_pdf');
    }

    /**
     * Export ke Excel
     */
    public function laporanExcel()
    {
        return Excel::download(new LaporanPerbaikanExport, 'laporan_perbaikan.xlsx');
    }
}
