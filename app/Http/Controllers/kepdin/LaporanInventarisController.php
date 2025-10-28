<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use App\Models\AtkItem;
use PDF;
use App\Exports\LaporanInventarisExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanInventarisController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->ambilData($request);
        $assetType = $request->asset_type ?? '';

        return view('pages.kepdin.laporan.inventaris', compact('items', 'assetType'));
    }

public function pdf(Request $request)
{
    $items = $this->ambilData($request);
    $assetType = $request->asset_type ?? ''; // ⬅️ tambahkan ini

    $pdf = PDF::loadView('pages.kepdin.laporan.inventaris_pdf', compact('items', 'assetType')); // ⬅️ kirim ke view
    return $pdf->download('laporan_inventaris.pdf');
}


    public function excel(Request $request)
    {
        return Excel::download(new LaporanInventarisExport($request), 'laporan_inventaris.xlsx');
    }

    private function ambilData(Request $request)
    {
        $assetType = $request->asset_type;

        if ($assetType === 'aset_tetap') {
            // ✅ Ambil langsung dari field aset (bukan relasi)
            return Assets::all()->map(fn($a) => (object)[
                'jenis' => 'Aset Tetap',
                'nama' => $a->nama,
                'kategori' => $a->kategori,
                'kondisi' => $a->kondisi ?? '-', 
                'lokasi' => $a->lokasi ?? '-',   
                'stok' => '-'
            ]);

        } elseif ($assetType === 'atk') {
            return AtkItem::all()->map(fn($a) => (object)[
                'jenis' => 'ATK',
                'nama' => $a->name,
                'kategori' => $a->category ?? '-',
                'kondisi' => '-',
                'lokasi' => '-',
                'stok' => $a->stock
            ]);
        } else {
            // ✅ Gabungan dua jenis aset
            $aset = Assets::all()->map(fn($a) => (object)[
                'jenis' => 'Aset Tetap',
                'nama' => $a->nama,
                'kategori' => $a->kategori,
                'kondisi' => $a->kondisi ?? '-',
                'lokasi' => $a->lokasi ?? '-',  
                'stok' => '-'
            ]);

            $atk = AtkItem::all()->map(fn($a) => (object)[
                'jenis' => 'ATK',
                'nama' => $a->name,
                'kategori' => $a->category ?? '-',
                'kondisi' => '-',
                'lokasi' => '-',
                'stok' => $a->stock
            ]);

            return $aset->merge($atk);
        }
    }
}
