<?php

namespace App\Http\Controllers\Admin;

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

        return view('pages.admin.laporan.inventaris', compact('items', 'assetType'));
    }

    public function pdf(Request $request)
    {
        $items = $this->ambilData($request);
        $pdf = PDF::loadView('pages.admin.laporan.inventaris_pdf', compact('items'));
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
            return Assets::all()->map(fn($a) => (object)[
                'jenis' => 'Aset Tetap',
                'nama' => $a->nama,
                'kategori' => $a->kategori,
                'kondisi' => $a->kondisi->nama ?? '-',
                'lokasi' => $a->lokasi->nama ?? '-',
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
            $aset = Assets::all()->map(fn($a) => (object)[
                'jenis' => 'Aset Tetap',
                'nama' => $a->nama,
                'kategori' => $a->kategori,
                'kondisi' => $a->kondisi->nama ?? '-',
                'lokasi' => $a->lokasi->nama ?? '-',
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
