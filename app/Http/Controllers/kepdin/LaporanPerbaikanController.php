<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPerbaikan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\LaporanPerbaikanExport;

class LaporanPerbaikanController extends Controller
{
    /**
     * Tampilkan halaman laporan perbaikan
     */
    public function index(Request $request)
    {
        // Ambil semua riwayat perbaikan yang sudah memiliki tanggal perbaikan
        $riwayats = RiwayatPerbaikan::with('asset')
            ->whereNotNull('tanggal_perbaikan')
            ->latest()
            ->get(); // tanpa pagination

        // Ambil semua kategori untuk dropdown filter
        $kategori = Kategori::all();

        // Kirim ke view
        return view('pages.kepdin.laporan.perbaikan', compact('riwayats', 'kategori'));
    }

    /**
     * Export laporan perbaikan ke PDF
     */
    public function laporanPdf()
    {
        $riwayats = RiwayatPerbaikan::with('asset')->latest()->get();

        $pdf = PDF::loadView('pages.kepdin.laporan_pdf', compact('riwayats'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_perbaikan.pdf');
    }

    /**
     * Export laporan perbaikan ke Excel
     */
    public function laporanExcel()
    {
        return Excel::download(new LaporanPerbaikanExport, 'laporan_perbaikan.xlsx');
    }
}
