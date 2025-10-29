<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanStokAtk;
use App\Models\StockTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AtkItem;
use Illuminate\Http\Request;

class PengajuanStokController extends Controller
{
    public function index(Request $request)
{
    // Ambil kata kunci pencarian
    $search = $request->input('search');

    // Query dengan relasi dan pencarian
    $pengajuan = \App\Models\PengajuanStokAtk::with(['item', 'user'])
        ->when($search, function ($query, $search) {
            $query->whereHas('item', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhere('keterangan', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10); // 10 data per halaman

    return view('pages.kepdin.pengajuan.index', compact('pengajuan', 'search'));
}

    public function setujui(PengajuanStokAtk $pengajuan)
    {
        $item = $pengajuan->item;

        if ($pengajuan->jenis == 'in') {
            $item->increment('stock', $pengajuan->jumlah);
            $type = 'in';
        } else {
            $item->decrement('stock', $pengajuan->jumlah);
            $type = 'out';
        }

        StockTransaction::create([
            'atk_item_id' => $item->id,
            'type' => $type,
            'quantity' => $pengajuan->jumlah,
            'reference' => $pengajuan->keterangan,
            'user_id' => $pengajuan->user_id,
        ]);

        $pengajuan->update(['status' => 'disetujui']);

        return back()->with('success', 'Pengajuan stok disetujui dan stok berhasil diperbarui.');
    }

    public function tolak(PengajuanStokAtk $pengajuan)
    {
        $pengajuan->update(['status' => 'ditolak']);
        return back()->with('warning', 'Pengajuan stok ditolak.');
    }

    public function pengajuanPdf(Request $request)
{
    $search = $request->input('search');

    $pengajuan = \App\Models\PengajuanStokAtk::with(['item', 'user'])
        ->when($search, function ($query, $search) {
            $query->whereHas('item', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhere('keterangan', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

    $pdf = Pdf::loadView('pages.kepdin.pengajuan.pdf', compact('pengajuan', 'search'))
        ->setPaper('a4', 'landscape');

    return $pdf->stream('Daftar_Pengajuan_Stok_ATK.pdf');
}

}
