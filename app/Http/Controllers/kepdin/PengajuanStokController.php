<?php

namespace App\Http\Controllers\kepdin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanStokAtk;
use App\Models\StockTransaction;
use App\Models\AtkItem;
use Illuminate\Http\Request;

class PengajuanStokController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanStokAtk::with(['item','user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.kepdin.pengajuan.index', compact('pengajuan'));
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
}
